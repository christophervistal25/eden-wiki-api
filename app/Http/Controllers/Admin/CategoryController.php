<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
    public function categories()
    {
        return Category::withCount(['sub_category'])
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function categoriesWithSub()
    {
        return Category::with(['sub_category' => function ($query) {
            $query->select('category_id', 'name');
        }])
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name'        => 'required|unique:categories',
            'description' => 'required',
            'type'        => 'required',
        ]);

        return Category::create([
            'name'        => $request->name,
            'description' => $request->description,
            'content'     => $request->content,
            'status'      => 'active',
            'type'        => $request->type,
        ]);
    }

    private function show(int $id)
    {
        return Category::with(['sub_category' => function ($query) {
            $query->select('category_id', 'name')->distinct();
        }])->find($id);
    }

    public function edit(int $id)
    {
        return Category::find($id);
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
        $category->content     = $request->content;
        $category->status      = $request->status;
        $category->type        = $request->type;
        $category->save();

        return $this->show($category->id);
    }
}
