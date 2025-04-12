<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produit extends Model
{
    protected $fillable = [
        'name',
        'prix',
        'quantity',
        'description',
        'user_id'  
    ];


    protected $appends = ['current_stock'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function outputs()
    {
        return $this->hasMany(Output::class);
    }

    public function getCurrentStockAttribute()
    {
        $totalEntries = $this->entries()->sum('quantity');
        $totalOutputs = $this->outputs()->sum('quantity');
        return $totalEntries - $totalOutputs;
    }

  

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'produits';

    //public function categorie()
    //{
      //  return $this->belongsTo(Categorie::class);
    //}
}
