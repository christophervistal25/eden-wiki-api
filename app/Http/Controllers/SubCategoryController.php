<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use App\Models\SubCategory;


class SubCategoryController extends Controller
{
    public function subCategories()
    {
        return SubCategory::with(['category'])->withCount('items')->orderBy('created_at', 'DESC')->get();
    }


    public function show(int $id): SubCategory
    {
        return SubCategory::with('category')->find($id);
    }

    public function store(Request $request): SubCategory
    {
        $categoryIds = Category::get(['id'])->pluck('id')->toArray();
        $this->validate($request, [
            'name'        => 'required|unique:sub_categories',
            'description' => 'required',
            'category_id' => 'required|in:' . implode(',', $categoryIds),
            'status'      => 'required|in:' . implode(',', SubCategory::$statuses),
        ], [], ['category_id' => 'category']);

        $sub_category = SubCategory::create([
            'name'        => $request->name,
            'category_id' => $request->category_id,
        ]);

        return $this->show($sub_category->id);
    }

    public function update(Request $request, int $id): SubCategory
    {
        $categoryIds = Category::get(['id'])->pluck('id')->toArray();
        $this->validate($request, [
            'name'        => 'required',
            'category_id' => 'required|in:' . implode(',', $categoryIds),
            'status'      => 'required|in:' . implode(',', SubCategory::$statuses),
        ], [], ['category_id' => 'category']);

        $sub_category = SubCategory::find($id);

        $sub_category->name        = $request->name;
        $sub_category->category_id = $request->category_id;
        $sub_category->status      = $request->status;
        $sub_category->save();

        return $this->show($sub_category->id);
    }
}
