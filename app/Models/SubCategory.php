<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    public static $statuses = ['active', 'in-active'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }
}
