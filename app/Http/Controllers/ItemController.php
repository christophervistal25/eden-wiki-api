<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;


class ItemController extends Controller
{
    public function items(string $main, string $type)
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
        
    }

    public function paginate(string $main, string $type, string $page)
    {
        $items = Item::with(['category' => function ($query) use($main) {
            $query->select('id', 'name', 'description')->where('name', $main);
        }])->where('kind', 'IK3_' . strtoupper($type))
            ->get();

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
        }  else {
            $paginated = $items->take(10);
        }
        return [
            'pagination_total' => $pagination_total,
            'total_items' => $total_items,
            'next_link' => $next,
            'previous_link' => $previous,
            'items' => $paginated, 
        ];
    }

    public function search($keyword)
    {
        return Item::with(['category' => function ($query) use($keyword) {
            $query->select('id', 'name', 'description');
        }])
        ->where('name', 'like', '%' . $keyword. '%')
        ->get();
    }

    public function show(int $id)
    {
        return Item::with('category')->find($id);
    }

    public function store(Request $request)
    {
        
        $categoryIds = Category::get('id')->pluck('id')->toArray();
        
        /*$this->validate($request, [
            'category_id' => 'required|in:' . implode(',', $categoryIds),
            'name' => 'required',
            'description' => 'required',
            'gender' => 'required',
            'level' => 'required',
            'kind' => 'required',
            'job' => 'required',
        ]);*/

        $item = Item::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'gender' => $request->gender,
            'level' => $request->level,
            'kind' => $request->kind,
            'job' => $request->job,
        ]);

        return $item;
    }

    public function update(Request $request, int $id)
    {
        
        $categoryIds = Category::get('id')->pluck('id')->toArray();
        
        /*$this->validate($request, [
            'category_id' => 'required|in:' . implode(',', $categoryIds),
            'name' => 'required',
            'description' => 'required',
            'gender' => 'required',
            'level' => 'required',
            'kind' => 'required',
            'job' => 'required',
        ]);*/
        $item = Item::find($id);
        $item->category_id = $request->category_id;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->gender = $request->gender;
        $item->level = $request->level;
        $item->kind = $request->kind;
        $item->job = $request->job;
        $item->save();

        return $item;
    }
}
