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
    private const ITEM_PER_PAGE = 10;

    public function list($page = 1, $by = 10)
    {
        Cache::flush();
        // $items = Cache::rememberForever('items', function () {
        $items = Item::with(['sub_category:id,name,category_id', 'sub_category.category:id,name'])
            ->orderBy('created_at', 'DESC')
            ->get();
        // });

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

    public function listForSet($page = 1, $by = 10)
    {

        $items = Item::whereHas('sub_category.category', function ($query) {
            $query->where('name', 'armor')->orWhere('name', 'fashion')->orWhere('name', 'accesories');
        })->whereHas('sub_category', function ($query) {
            $query->where('name', '!=', 'box')->where('name', '!=', 'sets');
        })->with(['sub_category:id,name,category_id', 'sub_category.category:id,name'])
            ->where('set_id', null)
            ->orderBy('created_at', 'DESC')
            ->get();

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

    public function searchItemForSetList($key, $pageIndex = 1)
    {
        $items = Item::whereHas('sub_category.category', function ($query) {
            $query->where('name', 'armor')->orWhere('name', 'fashion')->orWhere('name', 'accesories');
        })->whereHas('sub_category', function ($query) {
            $query->where('name', '!=', 'box')->where('name', '!=', 'sets');
        })->with(['sub_category:id,name,category_id', 'sub_category.category:id,name', 'set'])
            ->where('name', 'like', '%' . $key . '%')->get();

        $total_items      = $items->count();

        $pagination_total = (int) ceil($total_items / self::ITEM_PER_PAGE);

        $previous         = null;
        $next             = null;


        if ($pageIndex !== 1) {
            $skip = ($pageIndex * self::ITEM_PER_PAGE) - self::ITEM_PER_PAGE;
        } else {
            $skip = 0;
        }


        if (($pageIndex + 1) <= $pagination_total) {
            $next =  (int) ($pageIndex + 1);
        }

        if ($pageIndex != 1) {
            $previous =  (int) ($pageIndex - 1);
        }


        return [
            'total_items'      => $total_items,
            'pagination_total' => $pagination_total,
            'items'            => $items->skip($skip)->take(self::ITEM_PER_PAGE),
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
            // 'gender'          => 'required|in:' . implode(',', ['MALE', 'FEMALE']),
            // 'level'           => 'required',
            'sub_category_id' => 'required|in:' . implode(',', $sub_category_ids),
            // 'job'             => 'required',
            'icon'            => 'required',
        ], [], ['sub_category_id' => 'category / sub - category']);

        $destination = rtrim(app()->basePath('public/images'), '/');
        $name = $request->file('icon')->getClientOriginalName();
        $request->file('icon')->move($destination, $name);

        $item = Item::create([
            'name'            => $request->name,
            'description'     => $request->description,
            'gender'          => $request->gender ?? '',
            'level'           => $request->level ?? 0,
            'sub_category_id' => $request->sub_category_id,
            'job'             => $request->job ?? '',
            'effect_1'        => $request->item_effect_1 ?? '',
            'effect_2'        => $request->item_effect_2 ?? '',
            'effect_3'        => $request->item_effect_3 ?? '',
            'handed'          => $request->handed,
            'icon'            => $name,
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
            // 'gender'          => 'required|in:' . implode(',', ['MALE', 'FEMALE']),
            // 'level'           => 'required',
            'sub_category_id' => 'required|in:' . implode(',', $sub_category_ids),
            // 'job'             => 'required',
        ], [], ['sub_category_id' => 'category / sub - category']);

        Cache::flush();

        if ($request->hasFile('icon')) {
            $destination = rtrim(app()->basePath('public/images'), '/');
            $name        = $request->file('icon')->getClientOriginalName();
            $request->file('icon')->move($destination, $name);
        } else {
            $name = null;
        }



        $item                  = Item::find($id);
        $item->name            = $request->name;
        $item->description     = $request->description;
        $item->gender          = $request->gender;
        $item->level           = $request->level;
        $item->sub_category_id = $request->sub_category_id;
        $item->job             = $request->job;
        $item->effect_2        = $request->item_effect_2 ?? '';
        $item->effect_1        = $request->item_effect_1 ?? '';
        $item->effect_3        = $request->item_effect_3 ?? '';
        $item->handed          = $request->handed;
        $item->icon            = $name ?? $item->icon;
        $item->status          = $request->status;
        $item->save();



        return $this->show($item->id);
    }
}
