<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SensorController extends Controller
{
    public function index(Request $request)
    {
        $nome = $request->input('nome');

        if ($nome == 'disclaimer') {
            return $this->getDisclaimerData();
        }

        return $this->getSensorData($nome);
    }


    private function getDisclaimerData()
    {
        $sensor = Sensor::where('nome', 'disclaimer')->first();

        if (!$sensor) {
            return response()->json(['error' => 'Sensor não encontrado'], 500);
        }

        $log = explode("|", $sensor->log);
        $quantidade = count($log) - 2;
        $valor = explode(";", $log[$quantidade]);

        return response()->json([
            'data_hora' => $sensor->data_hora,
            'valor' => $valor[1]
        ]);
    }

    private function getSensorData($nome)
    {
        $sensor = Sensor::where('nome', $nome)->first();

        if (!$sensor) {
            if ($nome == "imagens_armazem") {
                return '0';
            }

            return response()->json(['error' => 'Sensor não encontrado'], 500);
        }

        if ($nome == "imagens_armazem") {
            return response()->json([
                'valor' => $sensor->valor
            ]);
        } else {
            return response()->json([
                'data_hora' => $sensor->data_hora,
                'valor' => $sensor->valor
            ]);
        }
    }

    public function getLog(Request $request)
    {
        $nome = $request->input('tabela');

        $sensor = Sensor::where('nome', $nome)->first();

        if (!$sensor) {
            return response()->json(['error' => 'Sensor não encontrado'], 500);
        }

        return $sensor->log;
    }

    public function store(Request $request)
    {
        if ($request->filled('disclaimer')) {
            //curl -X POST http://seu-domínio.com/api/sensor -d "disclaimer=1&linha1=Valor da linha 1&linha2=Valor da linha 2"
            return $this->handleDisclaimerPost($request);
        } elseif ($request->filled('porta_descargas')) {
            //curl -X POST http://seu-domínio.com/api/sensor -d "porta_descargas=1&abrir=1"
            return $this->handlePortaPost($request, 'porta_descargas');
        } elseif ($request->filled('porta_funcionarios')) {
            //curl -X POST http://seu-domínio.com/api/sensor -d "porta_funcionarios=1&fechar=1"
            return $this->handlePortaPost($request, 'porta_principal');
        } else {
            return response()->json(['error' => 'Parâmetros inválidos'], 400);
        }
    }

    private function handleDisclaimerPost(Request $request)
    {
        $valor = $request->input('linha2') ? $request->input('linha1') . "\\n" . $request->input('linha2') : $request->input('linha1');
        $nome = "disclaimer";
        $semvalor = 0;
        $today = now();
        $today = $today->format('Y/m/d H:i:s');

        $sensor = Sensor::where('nome', $nome)->first();

        if (!$sensor) {
            $log = $today . ";" . $valor . "|";
            $sensor = new Sensor();
            $sensor->nome = $nome;
            $sensor->valor = $semvalor;
            $sensor->data_hora = $today;
            $sensor->log = $log;
            $sensor->save();
        } else {
            $log = $sensor->log . "\n" . $today . ";" . $valor . "|";
            $sensor->valor = $semvalor;
            $sensor->data_hora = $today;
            $sensor->log = $log;
            $sensor->save();
        }

        return response()->json(['message' => 'Dados enviados com sucesso']);
    }

    private function handlePortaPost(Request $request, $nome)
    {
        $valor = $request->filled('abrir') ? 1 : ($request->filled('fechar') ? 0 : null);

        if ($valor === null) {
            return response()->json(['error' => 'Requisição inválida'], 400);
        }

        $today = now();
        $today = $today->format('Y/m/d H:i:s');

        $sensor = Sensor::where('nome', $nome)->first();

        if ($sensor && $sensor->valor == $valor) {
            return response()->json(['error' => 'Valor já definido'], 500);
        }

        $log = $sensor ? $sensor->log . "\n" : '';
        $log .= $today . ";" . $valor . "|";

        if (!$sensor) {
            $sensor = new Sensor();
            $sensor->nome = $nome;
        }

        $sensor->valor = $valor;
        $sensor->data_hora = $today;
        $sensor->log = $log;
        $sensor->save();


        return response()->json(['message' => 'Dados enviados com sucesso']);
    }

    public function storeCisco(Request $request)
    {
        if ($request->has('divisoes')) {
            $valores = [
                'temperatura_rececao' => $request->input('temperatura'),
                'sensor_movimento' => $request->input('movimento'),
                'nivel_agua' => $request->input('agua'),
                'corrente_ups' => $request->input('corrente_ups')
            ];
        } elseif ($request->has('armazem')) {
            $valores = [
                'sensorLuz_armazem' => $request->input('luz'),
                'temperatura_armazem' => $request->input('temperatura'),
                'sensorFumo_armazem' => $request->input('fumo'),
                'sensorHumidade_armazem' => $request->input('humidade')
            ];
        } elseif ($request->has('botao')) {
            $valores = [
                'luz_rececao' => $request->input('luz_rececao')
            ];
        } elseif ($request->has('int_luz_armazem')) {
            $valores = [
                'brilho_led_armazem' => $request->input('brilho_led_armazem')
            ];
        } elseif ($request->has('luz_rececao_py')) {
            $valores = [
                $request->input('nome') => $request->input('valor')
            ];
        } elseif ($request->has('atuar_porta_py')) {
            $valores = [
                $request->input('nome') => $request->input('valor')
            ];
        } elseif ($request->has('atuar_disclaimer_py')) {
            $valores = [
                $request->input('nome') => $request->input('valor')
            ];
        } else {
            return response('Inserção de dados inválida', 403);
        }

        foreach ($valores as $key => $value) {
            $sensor = Sensor::where('nome', $key)->first();
            if (!$sensor) {
                $sensor = new Sensor();
                $sensor->nome = $key;
            }
            $log = $sensor->log ? $sensor->log . "\n" : '';
            $log .= $request->input('data_hora') . ";" . $value . "|";
            $sensor->valor = ($key == "disclaimer") ? 0 : $value;
            $sensor->data_hora = $request->input('data_hora');
            $sensor->log = $log;
            $sensor->save();
        }
        return response('Dados inseridos com sucesso', 200);
    }

    public function estadoSistema(Request $request)
    {
        $url = explode('api', $request->url());
        $url = $url[0] . "api/sensor/data";
        if ($request->filled('alarme')) {
            return $this->verificarEstadoAlarme($url);
        } elseif ($request->filled('porta_descargas')) {
            return $this->verificarEstadoPortaDescargas($url);
        } elseif ($request->filled('porta_funcionarios')) {
            return $this->verificarEstadoPortaFuncionarios($url);
        } else {
            return response()->json(['error' => 'Operação inválida'], 400);
        }
    }

    private function verificarEstadoAlarme($url)
    {
        /*
            curl --location --request GET 'http://tiproject.test/api/estado' \
            --header 'Content-Type: application/json' \
            --data '{
                "alarme":1
            }'
        */
        $temperatura = Http::get($url, [
            'nome' => "temperatura_armazem"
        ])->json();
        $fumo = Http::get($url, ['nome' => "sensorFumo_armazem"])->json();
        $humidade = Http::get($url, ['nome' => "sensorHumidade_armazem"])->json();

        if (intval($temperatura['valor']) > 33 || intval($fumo['valor']) > 34 || intval($humidade['valor']) > 40) {
            return response()->json(['alarme' => 'sim']);
        } else {
            return response()->json(['alarme' => 'nao']);
        }
    }

    private function verificarEstadoPortaDescargas($url)
    {
        /*
            curl --location --request GET 'http://tiproject.test/api/estado' \
            --header 'Content-Type: application/json' \
            --data '{
                "porta_descargas":1
            }'
        */
        $porta_descargas = Http::get($url, ['nome' => "porta_descargas"])->json();

        if (intval($porta_descargas['valor']) == 0) {
            return response()->json(['estado' => 'nao']);
        } else {
            return response()->json(['estado' => 'sim']);
        }
    }

    private function verificarEstadoPortaFuncionarios($url)
    {
        /*
            curl --location --request GET 'http://tiproject.test/api/estado' \
            --header 'Content-Type: application/json' \
            --data '{
                "porta_funcionarios":1
            }'
        */
        $porta_funcionarios = Http::get($url, ['nome' => "porta_principal"])->json();

        if (intval($porta_funcionarios['valor']) == 0) {
            return response()->json(['estado' => 'nao']);
        } else {
            return response()->json(['estado' => 'sim', "res" => $porta_funcionarios]);
        }
    }


    public function indexCisco(Request $request)
    {
        /*
            curl --location --request GET 'http://tiproject.test/api/sensor' \
            --header 'Content-Type: application/json' \
            --data '{
                "armazem":1
            }'
        */
        if ($request->has('divisoes')) {
            $valores = ['temperatura_rececao', 'luz_rececao', 'sensor_movimento', 'nivel_agua'];
        } elseif ($request->has('armazem')) {
            $valores = ['sensorLuz_armazem', 'temperatura_armazem', 'sensorFumo_armazem', 'porta_descargas', 'porta_principal', 'sensorHumidade_armazem', 'disclaimer'];
        } elseif ($request->has('rececao')) {
            $valores = ['temperatura_rececao', 'luz_rececao'];
        } elseif ($request->has('casa_banho')) {
            $valores = ['sensor_movimento', 'nivel_agua'];
        } elseif ($request->has('portoes_disclaimer')) {
            $valores = ['porta_descargas', 'porta_principal', 'disclaimer'];
        } elseif ($request->has('imagens_armazem')) {
            $valores = ['imagens_armazem'];
        } else {
            return response()->json(['error' => 'Inserção de dados inválida'], 403);
        }
        $response = "";

        foreach ($valores as $key) {
            $sensor = Sensor::where('nome', $key)->first();
            if ($sensor) {
                if ($key == "disclaimer") {
                    $valor = explode("|", $sensor->log);
                    $quantidade = count($valor) - 2;
                    $valor = explode(";", $valor[$quantidade]);
                    $response .= $valor[1] . "|";
                } else {
                    $response .= $sensor->valor . "|";
                }
            }
        }

        return response($response);
    }

    public function getChart(Request $request)
    {
        /*
            curl --location --request GET 'http://tiproject.test/api/chart' \
            --header 'Content-Type: application/json' \
            --data '{
                "sensor":"sensorLuz_armazem"
            }'
        */
        try {
            if (!$request->has('sensor') || empty($request->input('sensor'))) {
                return response()->json(['error' => 'Parâmetros inválidos'], 400);
            }

            $sensorNome = $request->input('sensor');

            $sensor = Sensor::where('nome', $sensorNome)->first();

            if ($sensor) {
                $log = $sensor->log;
                $log = explode("|", $log);
                $maximo = count($log) - 1;
                $array_dados = [];

                $curYear = date('Y');
                $curMonth = date('m');
                $curMonth = (int)$curMonth;

                if ($request->has('mes_anterior')) {
                    $curMonth = $curMonth - 1;
                }

                $ciclo = true;
                $contador = 0;

                while ($ciclo && $contador < $maximo) {
                    $valor = explode(";", $log[$contador]);
                    $data_hora = explode(" ", $log[$contador]);
                    $data = explode("/", $data_hora[0]);

                    if ((int)$data[0] == (int)$curYear && (int)$data[1] == $curMonth) {
                        $horaAtual = $data_hora[1];
                        $horaAnterior = isset($hora[(int)$data[2]]) ? $hora[(int)$data[2]] : null;

                        if ($horaAnterior === null || $horaAtual > $horaAnterior) {
                            $array_dados[(int)$data[2]] = (float)$valor[1];
                            $hora[(int)$data[2]] = $horaAtual;
                        }
                    }

                    $contador++;
                }

                ksort($array_dados);
                return response()->json($array_dados);
            } else {
                return response()->json(['error' => 'Sensor não encontrado'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Ocorreu um erro ao processar a requisição'], 500);
        }
    }


    public function updateCache(Request $request)
    {
        if ($request->has('sensores')) {
            $sensores = [
                "temperatura_rececao",
                "luz_rececao",
                "sensor_movimento",
                "nivel_agua",
                "sensorLuz_armazem",
                "temperatura_armazem",
                "sensorFumo_armazem",
                "brilho_led_armazem",
                "porta_descargas",
                "porta_principal",
                "corrente_ups",
                "sensorHumidade_armazem",
                "disclaimer",
            ];

            foreach ($sensores as $key) {
                $sensor = Sensor::where('nome', $key)->first();

                if ($sensor) {
                    $log = explode("|", $sensor->log);
                    $log = array_slice($log, 1, 100);
                    $log = implode("|", $log);
                    $log = ltrim($log, "\n");
                    $sensor->log = $log;
                    $sensor->save();
                } else {
                    return response()->json(['error' => 'Sensor não encontrado'], 404);
                }
            }

            return response()->json(['message' => 'Cache atualizado com sucesso'], 200);
        } elseif ($request->has('imagens')) {
            $imagens = "imagens_armazem";
            $sensor = Sensor::where('nome', $imagens)->first();

            if ($sensor) {
                $path = public_path('img/armazem_imgs/');
                file_put_contents($path . "alert.txt", "0");
                array_map('unlink', glob($path . "*.jpg"));

                $sensor->valor = 0;
                $sensor->data_hora = "";
                $sensor->log = "";
                $sensor->save();
            } else {
                return response()->json(['error' => 'Sensor de imagens não encontrado'], 404);
            }

            return response()->json(['message' => 'Cache de imagens atualizado com sucesso'], 200);
        } else {
            return response()->json(['error' => 'Parâmetros inválidos'], 400);
        }
    }

    public function store_picture(Request $request)
    {

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {

            $sensor = Sensor::where('nome', 'imagens_armazem')->first();
            $count = $sensor->valor + 1;
            $today = now();
            $today = $today->format('Y/m/d H:i:s');

            $nomeImagem = $count . '.' . $request->imagem->extension();

            //Store Metadata
            $log = $sensor ? $sensor->log . "\n" : '';
            $log .= $today . ";" . $nomeImagem . "|";

            //Store Image
            $request->imagem->storeAs('public/pictures', $nomeImagem);

            $sensor->valor += 1;
            $sensor->data_hora = $today;
            $sensor->log = $log;
            $sensor->save();

            return response()->json(['message' => "Imagem Armazenada"], 201);
        }

        return response()->json(['error' => 'Nenhuma imagem válida encontrada'], 400);
    }

    public function index_trigger() {
        $value = Sensor::where('nome','trigger')->value('valor');
        return $value;
    }

    public function store_trigger() {
        $sensor = Sensor::where('nome','trigger')->first();

        $sensor->valor = $sensor->valor === 1 ? 0 : 1;
        $sensor->save();

        return response()->json(['message' => "Trigger Atualizado"], 200);
    }
}
