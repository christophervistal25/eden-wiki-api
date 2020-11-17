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
        'id', 'name', 'description', 'gender', 'level', 'sub_category_id', 'job', 'icon', 'ability_max', 'ability_min', 'effect_1', 'effect_2', 'effect_3', 'handed'
    ];

    public function sub_category()
    {
        return $this->belongsTo('App\Models\SubCategory', 'sub_category_id', 'id');
    }
}
