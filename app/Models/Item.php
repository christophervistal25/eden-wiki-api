<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model 
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'category_id', 'equip_id', 'name', 'description', 'gender', 'level', 'kind', 'job'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

   
}
