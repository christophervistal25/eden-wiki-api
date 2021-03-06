<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class SubCategoryController extends Controller
{

    public function subCategories()
    {
        // return Cache::rememberForever('sub_categories', function () {
        return SubCategory::with(['category'])->withCount('items')->orderBy('created_at', 'DESC')->get();
        // });
    }

    // For administrator edit sub-category with type of article
    public function edit(int $id): SubCategory
    {
        return SubCategory::find($id);
    }

    // Update article type of sub-category
    public function updateArticle(Request $request, int $id): SubCategory
    {
        $categoryIds = Category::get(['id'])->pluck('id')->toArray();
        $this->validate($request, [
            'name'        => 'required',
            'category_id' => 'required|in:' . implode(',', $categoryIds),
            'description' => 'required',
            'content'     => 'required',
            'status'      => 'required|in:' . implode(',', SubCategory::$statuses),
        ], [], ['category_id' => 'category']);

        $sub_category = SubCategory::find($id);

        $sub_category->name        = $request->name;
        $sub_category->category_id = $request->category_id;
        $sub_category->status      = $request->status;
        $sub_category->description = $request->description;
        $sub_category->content     = $request->content;

        $sub_category->save();

        return $sub_category;
    }

    public function show(int $id): SubCategory
    {
        return SubCategory::with('category')->withCount('items')->find($id);
    }

    public function store(Request $request): SubCategory
    {
        // Cache::flush();
        $categoryIds = Category::get(['id'])
            ->pluck('id')
            ->toArray();

        $this->validate($request, [
            'name'        => 'required|unique:sub_categories',
            'category_id' => 'required|in:' . implode(',', $categoryIds),
        ], [], ['category_id' => 'category']);

        $sub_category = SubCategory::create([
            'name'        => $request->name,
            'category_id' => $request->category_id,
            'content'     => $request->content,
            'type'        => $request->type,
        ]);

        return $this->show($sub_category->id);
    }

    public function update(Request $request, int $id): SubCategory
    {
        // Cache::flush();
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
