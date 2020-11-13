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
            ->get();

        $items = Item::with(['sub_category:id,name,category_id', 'sub_category.category:id,name'])
            ->orderBy('created_at', 'DESC')
            ->get();

        $total_items = $items->count();
        $pagination_total = (int) ceil($total_items / 10);

        if ($page != 1) {
            $paginated = $items->skip(($page - 1) * 10)->take(10);
        } else {
            $paginated = $items->take(10);
        }

        return [
            'total_items'      => $total_items,
            'pagination_total' => $pagination_total,
            'items'            => $paginated,
        ];
    }

    public function items(string $main, string $type)
    {

        $items = Item::whereHas('sub_category', function ($query) use ($type) {
            $query->where('name', strtoupper($type));
        })->with('sub_category', 'sub_category.category')->get();


        $noOfItems = (int) ceil($items->count() / 12);

        return [
            'pagination_total' => $noOfItems,
            'items' => $items->take(12),
        ];
    }

    public function paginate(string $main, string $type, string $page)
    {
        $items = Item::whereHas('sub_category', function ($query) use ($type) {
            $query->where('name', strtoupper($type));
        })->with('sub_category', 'sub_category.category')->get();

        $pagination_total = (int) ceil($items->count() / 12);
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
            $paginated = $items->skip(($page - 1) * 12)->take(12);
        } else {
            $paginated = $items->take(12);
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
}
