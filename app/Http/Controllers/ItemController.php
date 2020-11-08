<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;


class ItemController extends Controller
{
    public function show(string $main, string $type)
    {
        $items = Item::with(['category' => function ($query) use($main) {
            $query->select('id', 'name', 'description')->where('name', $main);
        }])->where('kind', 'IK3_' . strtoupper($type))
            ->get();
        $noOfItems = (int) ceil($items->count() / 10);
        return [
            'pagination_total' => $noOfItems,
            'items' => $items->take(10), 
        ];
        // return $items->take(10);
    }
}
