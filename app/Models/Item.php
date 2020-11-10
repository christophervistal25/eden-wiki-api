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
        'id', 'equip_id', 'name', 'description', 'gender', 'level', 'sub_category_id', 'job'
    ];

    public function sub_category()
    {
        return $this->belongsTo('App\Models\SubCategory');
    }
}
