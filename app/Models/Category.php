<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Category extends Model
{
    public static $statuses = ['active', 'in-active'];
    public static $types = [1 => 'Menu', 0 => 'Page'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'description', 'status', 'type', 'content'
    ];

    //  public function sub_category()
    //{
    //  return $this->hasMany('App\Models\Item');
    //}

    public function scopeOnlyActive($query)
    {
        return $query->where('status', 'active');
    }

    public function sub_category()
    {
        return $this->hasMany('App\Models\SubCategory');
    }
}
