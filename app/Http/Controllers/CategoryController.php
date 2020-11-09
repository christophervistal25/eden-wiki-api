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
            $query->select('category_id', 'kind')->distinct();
        }])->get();
    }

    public function show(int $id)
    {
        return Category::with(['sub_category' => function ($query) {
            $query->select('category_id', 'kind')->distinct();
        }])->find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);
        
        return Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $category = Category::find($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return $this->show($category->id);
    }
  
}
