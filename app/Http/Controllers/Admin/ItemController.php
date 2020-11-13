<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Cache;


class ItemController extends Controller
{
    public function list($page = 1, $by = 10)
    {
        $items = Cache::rememberForever('items', function () {
            return Item::with(['sub_category:id,name,category_id', 'sub_category.category:id,name'])
                ->orderBy('created_at', 'DESC')
                ->get();
        });

        $total_items      = $items->count();
        $pagination_total = (int) ceil($total_items / $by);
        $previous         = null;
        $next             = null;

        if ($page != 1) {
            $paginated = $items->skip(($page - 1) * $by)->take($by);
        } else {
            $paginated = $items->take($by);
        }

        if (($page + 1) <= $pagination_total) {
            $next =  (int) ($page + 1);
        }

        if ($page != 1) {
            $previous =  (int) ($page - 1);
        }

        return [
            'total_items'      => $total_items,
            'pagination_total' => $pagination_total,
            'items'            => $paginated,
            'next'             => $next,
            'previous'         => $previous,
        ];
    }

    public function noOfItems()
    {
        return Item::count();
    }

    public function search(string $name)
    {
        $items = Item::with(['sub_category:id,name,category_id', 'sub_category.category:id,name'])
            ->orderBy('created_at', 'DESC')
            ->where('name', 'like', '%' . $name . '%')
            ->get();

        return ['items' => $items];
    }

    private function show(int $id)
    {
        return Item::with(['sub_category:id,name,category_id', 'sub_category.category:id,name'])->find($id);
    }

    public function store(Request $request)
    {
        Cache::flush();

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
        Cache::flush();

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

        return $this->show($item->id);
    }
}
