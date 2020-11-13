<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Category extends Model
{
    public static $statuses = ['active', 'in-active'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'description', 'status'
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
