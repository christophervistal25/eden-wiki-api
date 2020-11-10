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

    public function show(int $id)
    {
        return Category::with(['sub_category' => function ($query) {
            $query->select('category_id', 'name')->distinct();
        }])->find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'        => 'required|unique:categories',
            'description' => 'required',
            'status'      => 'required|in:' . implode(',', Category::$statuses),
        ]);

        return Category::create([
            'name'        => $request->name,
            'description' => $request->description,
            'status'      => $request->status,
        ]);
    }

    public function update(Request $request, int $id)
    {

        $this->validate($request, [
            'name'        => 'required|unique:categories,name,' . $id,
            'description' => 'required',
            'status'      => 'required|in:' . implode(',', Category::$statuses),
        ]);

        $category              = Category::find($id);
        $category->name        = $request->name;
        $category->description = $request->description;
        $category->status      = $request->status;
        $category->save();

        return $this->show($category->id);
    }
}
