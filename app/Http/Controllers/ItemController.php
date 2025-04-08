<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(){
        return view('items');
    }

    public function fetchItems() {
        $items = Item::all();
        $totalSum = 0;

        // Calculate the total value for each item (quantity * price)
        foreach ($items as $item) {
            $item->totalvalue = $item->quantity * $item->price;
            $totalSum += $item->totalvalue;
        }

        return response()->json([
            'items' => $items,
            'total' => $totalSum
        ]);
    }

    public function store(Request $request)
    {
        $item = Item::create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return response()->json($item);
    }
    public function update(Request $request, $id){
        $item = Item::find($id);
        $item -> update($request->all());
        return response()->json($item);
    }
}
