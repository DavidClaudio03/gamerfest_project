<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as FacadesDB;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sponsors = [
            ['Amaterasu','https://www.facebook.com/groups/342552252423013/?locale=es_LA','amaterasu'],
            ['RV Importaciones','https://www.facebook.com/RvImportacionesEc/?locale=es_LA','rv'],
            ['Nidavellir','https://www.facebook.com/NidavellirEc/','nidavelir'],
            ['CompuCredito','https://compucredito.com/','compucredito'],
            ['EnergyNova','https://www.facebook.com/people/EnergyNova/100064095150917/','energy_nova'],
            ['Speedy','https://speedy.com.ec/','speedy'],
            ['California Express','https://www.facebook.com/p/California-Express-100063694142687/','california_express'],
            ['Papitas ESPE','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRObXUo6xIerYBjisQvsMMNrOgimbr2SeSZ9ceyabP4aQ&s','papitas_espe'],
            ['Terraza Restobar','https://www.facebook.com/TerrazaRestoBarLatacunga/','terraza']
        ];

        foreach ($sponsors as $sponsor) {
            FacadesDB::table('sponsors')->insert([
                'nombre' => $sponsor[0],
                'url_pagina' => $sponsor[1],
                'url_imagen' => $sponsor[2]
            ]);
        }
    }
}
