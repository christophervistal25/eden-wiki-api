<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;
use App\Models\Item;


class CategoryController extends Controller
{

    public function categories()
    {
        // return Cache::rememberForever('user_category', function () {
        return Category::with(['sub_category' => function ($query) {
            $query->select('category_id', 'name')->where('status', 'active');
        }])->where('status', 'active')
            ->get(['id', 'name', 'description', 'status', 'created_at']);
        // });
    }

    public function categoriesWithItems($category, $page = 1)
    {
        // $items = Cache::rememberForever('user_category_items_' . $category, function () use ($category) {
        return Category::with(['sub_category' => function ($query) {
            $query->where('status', 'active');
        }, 'sub_category.items' => function ($query) {
            $query->where('status', 'active');
        }])->find($category);
        // });
        // return $items;

        // $total_items      = $items->count();
        // $pagination_total = (int) ceil($total_items / 12);
        // $previous         = null;
        // $next             = null;

        // if ($page != 1) {
        //     $paginated = $items->skip(($page - 1) * 12)->take(12);
        // } else {
        //     $paginated = $items->take(12);
        // }

        // if (($page + 1) <= $pagination_total) {
        //     $next =  (int) ($page + 1);
        // }

        // if ($page != 1) {
        //     $previous =  (int) ($page - 1);
        // }

        // return [
        //     'total_items'      => $total_items,
        //     'pagination_total' => $pagination_total,
        //     'items'            => $paginated,
        //     'next'             => $next,
        //     'previous'         => $previous,
        // ];
    }
}
