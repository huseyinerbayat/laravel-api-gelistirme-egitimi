<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request){
        $perPage = $request->get('perPage', 5);
        $items = Item::paginate($perPage);

        return ItemResource::collection($items);
    }

    public function show($id) {
        $item = Item::find($id);
        return ItemResource::make($item);
    }

    public function store(Request $request) {
        $data = $request->only('name', 'qty', 'color', 'price', 'weight');
        $item = Item::create($data);
        return ItemResource::make($item);
    }

    public function update(Request $request, $id) {
        $data = $request->only('name', 'qty', 'color', 'price', 'weight');
        $item = Item::find($id);
        $item->update($data);

        return ItemResource::make($item);
    }

    public function destroy($id) {
        $item =Item::find($id);
        $item->delete();

        return response()->json(['statu' => 'success']);
    }

    public function restore($id) {
        $item = Item::withTrashed()->find($id);
        $item->restore();

        return ItemResource::make($item);
    }
}
