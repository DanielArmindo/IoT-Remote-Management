<?php

namespace Database\Seeders;

use App\Models\Produto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            [
                'cod_produto' => 1,
                'nome' => 'SSD 120GB Kingston',
                'quantidade' => 50,
                'preco' => 15.99,
                'img' => 'ssd.jpg',
                'descricao' => '500 MB/s Leitura, 350 MB/s Escrita, 90,000 IOPS Leitura, 25,000 IOPS Escrita, SATA 6 Gb/s',
            ],
            [
                'cod_produto' => 2,
                'nome' => 'Switch TP-Link 5 Portas',
                'quantidade' => 10,
                'preco' => 9.99,
                'img' => 'switch.jpg',
                'descricao' => 'Switch com 5 Portas RJ45 de Autonegociacao 10/100/1000Mbps',
            ],
            [
                'cod_produto' => 3,
                'nome' => 'Hub Usb Type C',
                'quantidade' => 10,
                'preco' => 11.99,
                'img' => 'hub.jpg',
                'descricao' => 'Hub com 3 portas usb 3.0, porta RJ45 e porta de audio jack 3.5mm',
            ],
            [
                'cod_produto' => 4,
                'nome' => 'Amplificador Estéreo Audiocom A40 Bluetooth 60W',
                'quantidade' => 5,
                'preco' => 45.57,
                'img' => 'amplificador.jpg',
                'descricao' => 'O A40 e um amplificador de 60W bluetooth com um tamanho e peso ultra reduzido para incorporar nas suas pequenas e medias instalacoes que permite que o instale onde lhe for mais conveniente podendo ser instalado em parede, teto falso ou balcão para optimização de espaco e uma decoracao inalterada. Tire partido da conexao Bluetooth para sonorizar os seus espacos de forma comoda e pratica. O A40 pode ser usado ate uma impedancia minima de 4Ω.',
            ],
            [
                'cod_produto' => 5,
                'nome' => 'Raspberry Pi Sense Hat',
                'quantidade' => 5,
                'preco' => 23.99,
                'img' => 'raspberry_pi_sense_hat.jpg',
                'descricao' => 'O Sense HAT e um complemento do Raspberry Pi, feito especialmente para a missão Astro Pi.',

            ],
        ];

        foreach ($array as $value) {
            Produto::create($value);
        }
    }
}
