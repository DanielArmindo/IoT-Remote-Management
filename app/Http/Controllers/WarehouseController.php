<?php

namespace App\Http\Controllers;

use App\Http\Controllers\api\SensorController;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WarehouseController extends Controller
{
    public function index(Request $request): View
    {
        // API Endpoint: api/sensor/data
        $controllerAPI = new SensorController();

        $temperatura = $controllerAPI->index(new Request(['nome' => 'temperatura_armazem']))->getData(true);

        $humidade = $controllerAPI->index(new Request(['nome' => 'sensorHumidade_armazem']))->getData(true);

        $fumo = $controllerAPI->index(new Request(['nome' => 'sensorFumo_armazem']))->getData(true);

        $luminosidade = $controllerAPI->index(new Request(['nome' => 'sensorLuz_armazem']))->getData(true);

        $nivel_luminosidade = $controllerAPI->index(new Request(['nome' => 'brilho_led_armazem']))->getData(true);

        $porta_descargas = $controllerAPI->index(new Request(['nome' => 'porta_descargas']))->getData(true);

        $porta_funcionarios = $controllerAPI->index(new Request(['nome' => 'porta_principal']))->getData(true);

        $corrente = $controllerAPI->index(new Request(['nome' => 'corrente_ups']))->getData(true);

        $disclaimer = $controllerAPI->index(new Request(['nome' => 'disclaimer']))->getData(true);

        return view('warehouse', [
            'temperatura' => $temperatura,
            'humidade' => $humidade,
            'fumo' => $fumo,
            'luminosidade' => $luminosidade,
            'nivel_luminosidade' => $nivel_luminosidade,
            'porta_descargas' => $porta_descargas,
            'porta_funcionarios' => $porta_funcionarios,
            'corrente' => $corrente,
            'disclaimer' => $disclaimer
        ]);
    }

    public function reception(Request $request)
    {
        // API Endpoint: api/sensor/data
        $controllerAPI = new SensorController();

        $temperatura = $controllerAPI->index(new Request(['nome' => 'temperatura_rececao']))->getData(true);

        $luz = $controllerAPI->index(new Request(['nome' => 'luz_rececao']))->getData(true);

        return view('reception', ['temperatura' => $temperatura, 'luz' => $luz]);
    }

    public function bath(Request $request): View
    {
        // API Endpoint: api/sensor/data
        $controllerAPI = new SensorController();

        $movimento = $controllerAPI->index(new Request(['nome' => 'sensor_movimento']))->getData(true);

        $agua = $controllerAPI->index(new Request(['nome' => 'nivel_agua']))->getData(true);

        return view('bath', ['movimento' => $movimento, 'agua' => $agua]);
    }

    public function history(Request $request, $name)
    {
        $controllerAPI = new SensorController();

        $available = [
            'temperatura_armazem' => 'Temperatura do Armazem',
            'sensorHumidade_armazem' => 'Humidade do Armazem',
            'sensorFumo_armazem' => 'Fumo do Armazem',
            'brilho_led_armazem' => 'Luminosidade do Armazem',
            'sensorLuz_armazem' => 'Estado Luz do Armazem',
            'porta_descargas' => 'Porta Descargas',
            'porta_principal' => 'Porta Funcionarios',
            'corrente_ups' => 'Corrente do Armazem',
            'disclaimer' => 'Disclaimer',
            'sensor_movimento' => 'Movimento na Casa de Banho',
            'nivel_agua' => 'Nivel de Agua na Casa de Banho',
            'temperatura_rececao' => 'Temperatura na Receção',
            'luz_rececao' => 'Estado Luz da Receção'
        ];

        if (!array_key_exists($name, $available)) {
            return redirect()->route('dashboard');
        }

        // API Endpoint: api/sensor/log
        $data = $controllerAPI->getLog(new Request(['tabela' => $name]));

        $data = empty($data) ? '' : explode("|", $data);

        // API Endpoint: api/chart
        $data_chart = $controllerAPI->getChart(new Request(['sensor' => $name]))->getData(true);
        $data_chart_anterior = $controllerAPI->getChart(new Request(['sensor' => $name, 'mes_anterior' => 1]))->getData(true);

        $array_meses = [
            1 => "Janeiro",
            2 => "Fevereiro",
            3 => "Março",
            4 => "Abril",
            5 => "Maio",
            6 => "Junho",
            7 => "Julho",
            8 => "Agosto",
            9 => "Setembro",
            10 => "Outubro",
            11 => "Novembro",
            12 => "Dezembro",
        ];

        $mes_atual = $array_meses[date('n')];
        $mes_anterior = $array_meses[date('n') - 1];

        return view('history', [
            'name' => $name,
            'sensor' => $available[$name],
            'description' => $this->descricao_graficos($name),
            'data' => $data,
            'data_chart' => $data_chart,
            'data_chart_anterior' => $data_chart_anterior,
            'mes_atual' => $mes_atual,
            'mes_anterior' => $mes_anterior
        ]);
    }


    private function descricao_graficos($sensor)
    {
        switch ($sensor) {
            case 'temperatura_armazem':
            case 'temperatura_rececao':
                return 'Os valores apresentados relativamente à temperatura são demonstrados em graus celsius(ºC)';

            case 'sensorLuz_armazem':
            case 'luz_rececao':
                return 'Valores <b>iguais a 0</b> indica que a <b>luz está desligada</b><br>Valores <b>diferentes de 0</b> indica que a <b>luz está acesa</b>';

            case 'sensor_movimento':
                return 'Valores <b>iguais a 0</b> indica que <b>não deteta movimento</b><br>Valores <b>diferentes de 0</b> indica que a <b>detetou movimento</b>';

            case 'nivel_agua':
                return 'Os valores apresentados relativamente à ao nivel da água são demonstrados em centimetros(cm)';

            case 'sensorHumidade_armazem':
                return 'Os valores apresentados relativamente à humidade no ar são apresentados em percentagem(%)';

            case 'sensorFumo_armazem':
                return 'Os valores apresentados relativamente ao fumo no ar são apresentados em percentagem(%)';

            case 'brilho_led_armazem':
                return 'Os valores apresentados relativamente ao brilho do led são apresentados de uma escala de 0 a 1024<br>Para saber a percentagem da luz do led multiplicamos o valor por 100 e de seguida dividimos por 1024';

            case 'corrente_ups':
                return 'Os valores apresentados relativamente à corrente são apresentados em amperes(A)';

            case 'porta_descargas':
            case 'porta_principal':
                return 'Valores <b>iguais a 0</b> indica que a <b>porta está fechada</b><br>Valores <b>diferentes de 0</b> indica que a <b>porta está aberta</b>';
        }
    }

    public function disclaimer(Request $request)
    {
        // API Endpoint: api/sensor/data
        $controllerAPI = new SensorController();

        $disclaimer = $controllerAPI->index(new Request(['nome' => 'disclaimer']))->getData(true);

        $linhas = explode("\\n", $disclaimer['valor']);

        $line01 = $linhas[0];
        $line02 = $linhas[1];

        return view('disclaimer', [
            'line01' => $line01,
            'line02' => $line02
        ]);
    }

    public function store_disclaimer(Request $request)
    {
        $controllerAPI = new SensorController();

        // API Endpoint: api/sensor/data
        $disclaimer = $controllerAPI->index(new Request(['nome' => 'disclaimer']))->getData(true);

        $linhas = explode("\\n", $disclaimer['valor']);

        $line01 = $linhas[0];
        $line02 = $linhas[1];


        $request_line01 = request()->input('line01');

        $request_line02 = request()->input('line02');

        if ($line01 === $request_line01 && $line02 === $request_line02) {
            return redirect()->route('warehouse.disclaimer')->with('status', 'Disclaimer Not Updated, values are the same');
        }

        // API Endpoint: api/sensor
        $response = $controllerAPI->store(new Request(['disclaimer' => 1, 'linha1' => $request_line01, 'linha2' => $request_line02]));

        if (!$response->getStatusCode() == 200) {
            return redirect()->route('warehouse.disclaimer')->with('status', 'Disclaimer Not Updated, error to update');
        }

        return redirect()->route('warehouse.disclaimer')->with('status', 'Disclaimer Updated');
    }

    public function store(Request $request)
    {
        $controllerAPI = new SensorController();

        $available = [
            'porta_descargas',
            'porta_principal'
        ];

        $value = $request->input('sensor');

        if (!in_array($value, $available)) {
            return redirect()->route('warehouse')->with('status', 'Error To Updated')->with('who', 'all');
        }

        // API Endpoint: api/sensor/data
        $sensor = $controllerAPI->index(new Request(['nome' => $value]))->getData(true);

        // API Endpoint: api/sensor
        $response = $controllerAPI->store(new Request([
            $value === 'porta_principal' ? 'porta_funcionarios' : $value => 1,
            $sensor['valor'] === 1 ? 'fechar' : 'abrir' => 1
        ]));

        if (!$response->getStatusCode() == 200) {
            return redirect()->route('warehouse')->with('status', 'Error To Updated')->with('who', 'all');
        }

        return redirect()->route('warehouse')->with('status', 'State Updated')->with('who', $value);
    }

    public function store_sensors(Request $request)
    {
        $controllerAPI = new SensorController();

        //Clean Sensors
        if ($request->has('sensores')) {
            // API Endpoint: api/cache
            $response = $controllerAPI->updateCache(new Request(['sensores' => 1]));

            if (!$response->getStatusCode() == 200) {
                return redirect()->route('dashboard')->with('cache', 'Error to Clean Cache');
            }
        }
        //Clean Images
        elseif ($request->has('imagens')) {
            $imagens = Sensor::where('nome', 'imagens_armazem')->first();
            $count = 1;
            $log_to_save = "";
            $log = [];
            $log_to_delete = [];
            $url_delete = 'public/pictures/';

            if ($imagens->valor !== 0) {
                $log = rtrim($imagens->log, '|');
                $log = explode('|', $log);
                $log_to_delete = array_slice($log, 0, -20);

                $log = array_slice($log, -20);

                //Delete from storage old pictures
                foreach ($log_to_delete as $key => $value) {
                    $picture = explode(';', $value)[1];
                    Storage::delete($url_delete . $picture);
                }

                // Create log to save and change picture's name
                foreach ($log as $item) {
                    $values = explode(';', $item);
                    $picture = $count . ".jpg";
                    $log_to_save .=  $values[0] . ";" . $picture . "|";
                    $count += 1;

                    Storage::move($url_delete . $values[1], $url_delete . $picture);
                }

                $log_to_save = ltrim($log_to_save, "\n");

                $imagens->valor = $count - 1;
                $imagens->data_hora = null;
                $imagens->log = $log_to_save;
                $imagens->save();
            } else {
                return redirect()->route('dashboard')->with('cache', 'Error to Clean Cache');
            }
        }

        return redirect()->route('dashboard')->with('cache', 'Cache Cleaned');
    }

    public function index_pictures(): View
    {
        $imagens = Sensor::where('nome', 'imagens_armazem')->first();
        $count = $imagens->valor;
        $now = "";
        $imgs = [];
        $log = [];

        if ($count !== 0) {
            $log = rtrim($imagens->log, '|');
            $log = explode('|', $log);

            $log = array_reverse($log);

            foreach (array_slice($log, 0, 11) as $item) {
                $values = explode(';', $item);
                $imgs[] = $values[1] ?? null;
            }

            $now = $imgs[0];

            array_shift($imgs);
        }

        return view('pictures', [
            'count' => $count,
            'now' => $now,
            'imgs' => $imgs,
            'log' => $log
        ]);
    }

    public function store_picture()
    {
        //Dont forget to run script python in mode get 'capturaWebcamOpenCV'
        $sensor = Sensor::where('nome', 'trigger')->first();
        $sensor->valor = 1;
        $sensor->save();

        return redirect()->route('dashboard');
    }
}
