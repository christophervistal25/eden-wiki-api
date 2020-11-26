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
            $query->select('id', 'category_id', 'name', 'status', 'type')->where('status', 'active');
        }])->where('status', 'active')
            ->orderBy('name', 'ASC')
            // ->orderBy('name')
            ->get();
        // });
    }

    public function showArticle(int $id): Category
    {
        return Category::find($id);
    }

    public function show(string $name, $page = 1)
    {
        $category = Category::where('name', 'like', '%' . $name . '%')
            ->where('status', 'active')
            ->first();

        if ($category) {
            $items = Item::whereHas('sub_category', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })->with('sub_category:id,name')
                ->orderBy('level')
                ->where('status', 'active')
                ->get();


            $total_items      = $items->count();
            $pagination_total = (int) ceil($total_items / 12);
            $previous         = null;
            $next             = null;

            if ($page != 1) {
                $paginated = $items->skip(($page - 1) * 12)->take(12);
            } else {
                $paginated = $items->take(12);
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
        } else {
            return response()->json([], 404);
        }
    }

    public function categoriesWithItems($category, $page = 1)
    {
        // $items = Cache::rememberForever('user_category_items_' . $category, function () use ($category) {
        return Category::with(['sub_category' => function ($query) {
            $query->where('status', 'active');
        }, 'sub_category.items' => function ($query) {
            $query->where('status', 'active')->orderBy('level');
        }])->find($category);
        // });
        return $items;

        $total_items      = $items->count();
        $pagination_total = (int) ceil($total_items / 12);
        $previous         = null;
        $next             = null;

        if ($page != 1) {
            $paginated = $items->skip(($page - 1) * 12)->take(12);
        } else {
            $paginated = $items->take(12);
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
}
