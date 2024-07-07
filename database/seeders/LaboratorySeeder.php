<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Laboratory;




class LaboratorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Logique pour insérer les laboratoires dans la base de données
        Laboratory::factory()->count(10)->create();
    }
}
