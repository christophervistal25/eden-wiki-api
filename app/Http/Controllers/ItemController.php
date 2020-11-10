<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use App\Models\SubCategory;


class ItemController extends Controller
{
    public function list()
    {
        return Item::with(['sub_category:id,name,category_id', 'sub_category.category:id,name'])
            ->orderBy('created_at', 'DESC')
            ->get()
            ->take(5);
    }

    public function items(string $main, string $type)
    {

        $items = Item::whereHas('sub_category', function ($query) use ($type) {
            $query->where('name', strtoupper($type));
        })->with('sub_category', 'sub_category.category')->get();


        $noOfItems = (int) ceil($items->count() / 10);

        return [
            'pagination_total' => $noOfItems,
            'items' => $items->take(10),
        ];
    }

    public function paginate(string $main, string $type, string $page)
    {
        $items = Item::whereHas('sub_category', function ($query) use ($type) {
            $query->where('name', strtoupper($type));
        })->with('sub_category', 'sub_category.category')->get();

        $pagination_total = (int) ceil($items->count() / 10);
        $total_items = $items->count();
        $next = null;
        $previous = null;

        if (($page + 1) <= $pagination_total) {
            $next = 'item/' . $main . '/' . $type . '/' . ($page + 1);
        }

        if ($page != 1) {
            $previous = 'item/' . $main . '/' . $type . '/' . ($page - 1);
        }


        if ($page != 1) {
            $paginated = $items->skip(($page - 1) * 10)->take(10);
        } else {
            $paginated = $items->take(10);
        }
        return [
            'pagination_total' => $pagination_total,
            'total_items'      => $total_items,
            'next_link'        => $next,
            'previous_link'    => $previous,
            'items'            => $paginated,
        ];
    }

    public function search($keyword)
    {
        return Item::with(['sub_category', 'sub_category.category'])
            ->where('name', 'like', '%' . $keyword . '%')
            ->get();
    }

    public function show(int $id)
    {
        return Item::with(['sub_category:id,name,category_id', 'sub_category.category:id,name'])->find($id);
    }

    public function store(Request $request)
    {

        $sub_category_ids = SubCategory::get('id')
            ->pluck('id')
            ->toArray();

        $this->validate($request, [
            'name'            => 'required',
            'description'     => 'required',
            'gender'          => 'required|in:' . implode(',', ['MALE', 'FEMALE']),
            'level'           => 'required',
            'sub_category_id' => 'required|in:' . implode(',', $sub_category_ids),
            'job'             => 'required',
        ], [], ['sub_category_id' => 'category / sub - category']);

        $item = Item::create([
            'category_id'     => $request->category_id,
            'name'            => $request->name,
            'description'     => $request->description,
            'gender'          => $request->gender,
            'level'           => $request->level,
            'sub_category_id' => $request->sub_category_id,
            'job'             => $request->job,
        ]);

        return $this->show($item->id);
    }

    public function update(Request $request, int $id)
    {

        $sub_category_ids = SubCategory::get('id')
            ->pluck('id')
            ->toArray();

        $this->validate($request, [
            'name'            => 'required',
            'description'     => 'required',
            'gender'          => 'required|in:' . implode(',', ['MALE', 'FEMALE']),
            'level'           => 'required',
            'sub_category_id' => 'required|in:' . implode(',', $sub_category_ids),
            'job'             => 'required',
        ], [], ['sub_category_id' => 'category / sub - category']);

        $item                  = Item::find($id);
        $item->name            = $request->name;
        $item->description     = $request->description;
        $item->gender          = $request->gender;
        $item->level           = $request->level;
        $item->sub_category_id = $request->sub_category_id;
        $item->job             = $request->job;
        $item->save();

        return $item;
    }
}
