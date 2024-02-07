<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodRecipe extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'food_recipes';

    protected $fillable = [
        'name',
        'description'
    ];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function ingredients()
    {
        return $this->hasMany(RecipeItem::class, 'recipe_id', 'id');
    }
}
