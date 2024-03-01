<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'name','description','price','stock','category_id'
    ];
    protected $dates= [
        'created_at','updated_at', 'deleted_at'
    ];
    protected $table = "products";

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);


    }
}
