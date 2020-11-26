<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'type', 'parts', 'effects'
    ];

    public function items()
    {
        return $this->hasMany('App\Models\Item', 'set_id', 'id');
    }
}
