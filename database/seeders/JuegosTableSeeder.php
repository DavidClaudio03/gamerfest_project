<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JuegosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $juegos = [
            ['DOTA2', 'MOBA', 25.00, '2023-06-05', 'grupo','dota2'],
            ['League of Legends', 'MOBA', 25.00, '2023-06-05', 'grupo','lol'],
            ['Valorant', 'FPS', 25.00, '2023-06-05', 'grupo', 'valorant'],
            ['Fornite', 'Battle Royale', 25.00, '2023-06-05', 'grupo','fortnite'],
            ['Just Dance', 'Baile', 3.00, '2023-06-05', 'individual','just_dance'],
            ['FIFA', 'Sports', 3.00, '2023-06-05', 'individual','fifa'],
            ['Mario Kart', 'Carreras', 3.00, '2023-06-05', 'individual','mario_kart'],
            ['Mortal Kombat', 'Peleas', 3.00, '2023-06-05', 'individual','mortal_kombat'],
            ['Free Fire', 'Battle Royale', 3.00, '2023-06-05', 'individual','free_fire'],
            ['Free Fire Escuadras', 'Battle Royale', 8.00, '2023-06-05', 'grupo','free_fire'],
            ['Clash Royale', 'Estrategia', 3.00, '2023-06-05', 'individual','clash_royale'],
            ['Dragon Ball', 'Peleas', 3.00, '2023-06-05', 'individual','dragon_ball'],
            ['Concurso de Videojuego', 'ESPE', 0.00, '2023-06-05', 'individual','con_videojuegos'],
            ['Concurso de Cosplay', 'ESPE', 0.00, '2023-06-05', 'individual','con_cosplay'],

        ];

        foreach ($juegos as $juego) {
            DB::table('juegos')->insert([
                'nombre' => $juego[0],
                'genero' => $juego[1],
                'costo_inscripcion' => $juego[2],
                'fecha_limite_inscripcion' => $juego[3],
                'modalidad' => $juego[4],
                'img_id' => $juego[5],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
