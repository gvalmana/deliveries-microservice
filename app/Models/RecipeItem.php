<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecipeItem extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'recipe_id',
        'ingredient_id',
        'quantity'
    ];

    public const RELATIONS = ['recipe','product'];

    public function recipe()
    {
        return $this->belongsTo(FoodRecipe::class);
    }

    public function product()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id','id');
    }
}
