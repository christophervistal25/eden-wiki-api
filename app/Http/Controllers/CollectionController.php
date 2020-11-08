<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;


class CollectionController extends Controller
{
    public function index()
    {
        return Category::with(['sub_category' => function ($query) {
            $query->select('category_id', 'kind')->distinct();
        }])->get();
        
    }
}
