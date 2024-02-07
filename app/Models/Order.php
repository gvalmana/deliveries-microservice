<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class Order extends Model
{
    use HasFactory, SoftDeletes;

    public const PENDING_STATUS = 'pending'; // Waiting for ingredients
    public const COOKING_STATUS = 'cooking'; // With all ingredients ready
    public const COMPLETED_STATUS = 'completed'; //Order completed and delivered
    public const CANCELLED_STATUS = 'cancelled'; //Cancelled by any reason

    protected $fillable = [
        'recipe_id',
        'status',
        'is_sent',
        'delivery_date'
    ];
    protected $casts = [
        'status' => 'string',
        'code' => 'string',
        'is_sent' => 'boolean',
        'delivery_date' => 'datetime'
    ];

    protected $hiddens = ['recipe_id','is_sent'];

    public const RELATIONS = ['recipe'];

    public function recipe()
    {
        return $this->belongsTo(FoodRecipe::class, 'recipe_id', 'id');
    }

    public static function booted()
    {
        static::creating(function (Order $model) {
            if (!$model->code) {
                $model->code = Str::uuid()->toString();
            }
        });
    }
}
