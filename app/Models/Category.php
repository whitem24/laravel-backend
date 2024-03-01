<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name','description'      
    ];
    protected $dates= [
        'created_at','updated_at', 'deleted_at'
    ];
    protected $table = "categories";

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

}
