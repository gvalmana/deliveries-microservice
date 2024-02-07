<?php

namespace Database\Seeders;

use App\Models\FoodRecipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class FoodRecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Ensalada de Pollo y Aguacate',
                'description' => 'Una deliciosa ensalada con trozos de pollo a la parrilla, aguacate, tomate, y hojas verdes. Aderezada con una vinagreta de limón y miel.'
            ],
            [
                'id' => 2,
                'name' => 'Tacos de Salmón con Salsa de Mango',
                'description' => 'Tacos de salmón fresco con una salsa de mango picante. La combinación de sabores dulces y picantes es irresistible.'
            ],
            [
                'id' => 3,
                'name'=>'Pizza de Champiñones y Espinacas',
                'description'=>'Una pizza vegetariana con champiñones salteados, espinacas frescas, tomate y queso mozzarella derretido sobre una masa crujiente.'
            ],
            [
                'id'=>4,
                'name'=>'Sopa de Lentejas con Tocino',
                'description'=>'Una sopa reconfortante con lentejas, tocino crujiente, zanahorias y cebollas. Perfecta para los días fríos de invierno.'
            ],
            [
                'id'=>5,
                'name'=>'Rollitos de Primavera Vegetarianos',
                'description'=>'Rollitos de primavera rellenos de fideos de arroz, zanahorias ralladas, col china y cilantro fresco. Se sirven con una salsa de cacahuate.'
            ],
            [
                'id'=>6,
                'name'=>'Sopa de Cebolla con Camaron',
                'description'=>'Una ensalada refrescante con trozos de piña, mango, kiwi y fresas. Aderezada con un toque de menta fresca y jugo de lima.'
            ]
        ];

        foreach ($data as $item) {
            FoodRecipe::updateOrCreate(['id' => $item['id']], $item);
        }
    }
}
