<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class PautasInternetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pautas_internet')->insert([
            [
                'fec_pauta' => '2023-01-12',
                'des_titular' => 'Titular ejemplo',
                'des_resumen' => 'Resumen ejemplo',
                'des_ruta_web' => 'www.ejemplo.com',
                'des_ruta_imagen' => 'imagenes/ejemplo.jpg',
                'des_ruta_video' => 'videos/ejemplo.mp4'
            ],
            [
                'fec_pauta' => '2023-01-12',
                'des_titular' => 'Titular ejemplo 2',
                'des_resumen' => 'Resumen ejemplo 2',
                'des_ruta_web' => 'www.ejemplo2.com',
                'des_ruta_imagen' => 'imagenes/ejemplo2.jpg',
                'des_ruta_video' => 'videos/ejemplo2.mp4'
            ],
            [
                'fec_pauta' => '2023-01-12',
                'des_titular' => 'Titular ejemplo 3',
                'des_resumen' => 'Resumen ejemplo 3',
                'des_ruta_web' => 'www.ejemplo3.com',
                'des_ruta_imagen' => 'imagenes/ejemplo3.jpg',
                'des_ruta_video' => 'videos/ejemplo3.mp4'
            ],
            [
                'fec_pauta' => '2023-01-12',
                'des_titular' => 'Titular ejemplo 4',
                'des_resumen' => 'Resumen ejemplo 4',
                'des_ruta_web' => 'www.ejemplo4.com',
                'des_ruta_imagen' => 'imagenes/ejemplo4.jpg',
                'des_ruta_video' => 'videos/ejemplo4.mp4'
            ],
            // agrega más registros si es necesario
        ]);

    }
}
