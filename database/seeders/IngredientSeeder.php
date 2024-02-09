<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data= [];
        foreach (Ingredient::getNamesConstants() as $key => $value) {
            $data['name'] = $value;
            Ingredient::updateOrCreate($data,$data);
        }
    }
}
