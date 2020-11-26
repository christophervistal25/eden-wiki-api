<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Repository\SetEffect;
use App\Http\Controllers\Repository\SetPart;
use Illuminate\Http\Request;
use App\Models\Set;
use App\Models\Item;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Cache;


class SetController extends Controller
{

    public const ITEM_PER_PAGE = 10;

    public function list($page = 1, $by = 10)
    {
        $items =  Set::has('items')->with(['items'])
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


    public function searchSet($key, $pageIndex = 1)
    {
        $items = Set::has('items')
            ->with(['items'])
            ->where('name', 'like', '%' . $key . '%')
            ->orWhere('type', 'like', '%' . $key . '%')
            ->get();



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

    public function show($id)
    {
        return Set::with(['items', 'items.sub_category:id,name,category_id', 'items.sub_category.category:id,name'])->find($id);
    }


    public function linkToItem(Request $request)
    {

        Cache::flush();

        $this->validate($request, [
            'name'       => 'required',
            'item_parts' => 'json_item',
            'effects'    => 'json_effect',
        ]);


        $this->setPart = new SetPart();
        $this->setEffect = new SetEffect();

        $parts         = [];
        $effects       = [];

        $items   = json_decode($request->item_parts);
        $effects = json_decode($request->effects);

        $parts   = $this->setPart->createUsingThis($items);
        $effects = $this->setEffect->createUsingThis($effects);
        $type    = $this->setPart->getBaseItem()->sub_category->category->name;


        $set = Set::updateOrCreate([
            'name'    => $request->name,
            'type'    => $type,
            'parts'   => json_encode($parts),
            'effects' => json_encode($effects),
        ]);

        foreach (json_decode($request->item_parts) as $item) {
            $item = Item::find($item->id);
            $item->set_id = $set->id;
            $item->save();
        }

        return response()->json(['success' => true, 'message' => 'Successfully create new set.'], 200);
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name'       => 'required',
            'item_parts' => 'json_item',
            'effects'    => 'json_effect',
        ]);

        Cache::flush();


        $set = Set::with(['items', 'items.sub_category:id,name,category_id', 'items.sub_category.category:id,name'])->find($id);

        $this->setPart = new SetPart();
        $this->setEffect = new SetEffect();


        $parts         = [];
        $effects       = [];



        $items   = json_decode($request->item_parts);
        $effects = json_decode($request->effects);



        $parts   = $this->setPart->createUsingThis($items);
        $effects = $this->setEffect->createUsingThis($effects);
        $type    = $this->setPart->getBaseItem()->sub_category->category->name;

        $set->name    = $request->name;
        $set->type    = $type;
        $set->effects = json_encode($effects);
        $set->parts   = json_encode($parts);
        $set->save();



        foreach ($set->items as $item) {
            $item->set_id = null;
            $item->save();
        }

        foreach (json_decode($request->item_parts) as $item) {
            $item = Item::find($item->id);
            $item->set_id = $set->id;
            $item->save();
        }

        return $set;
    }
}
