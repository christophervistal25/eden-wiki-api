<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;


class CategoryController extends Controller
{

    public function categories()
    {
        return Category::with(['sub_category' => function ($query) {
            $query->select('category_id', 'name')->where('status', 'active')->distinct();
        }])->get();
    }
}
