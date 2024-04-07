<?php

namespace App\Http\Controllers\Manager;

use App\Models\StockDetail;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStockRequest;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = StockDetail::with('stock')->paginate(10);
        return Inertia::render('Stock', [
            'stocks' => $stocks->items(),
            'paginates' => $stocks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return Inertia::render('CreateStock', [
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockRequest $request)
    {
        try {
            DB::beginTransaction();

            $product = Product::find($request->product['id']);

            $product->load('stock');

            $product->stock->update([
                'amount' => $product->stock->amount + $request->quantity,
            ]);

            StockDetail::create([
                'stock_id' => $product->stock->id,
                'product_name' => $product->name,
                'quantity' => $request->quantity,
            ]);

            DB::commit();
        }catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Error while adding stock : ' . $th->getMessage()]);
        }


        return Redirect::route('stocks.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(StockDetail $stockDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockDetail $stockDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockDetail $stockDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        try {
            DB::beginTransaction();

            $stockDetail = StockDetail::find($id);

            $stock = Stock::find($stockDetail->stock_id);

            $newAmount = $stock->amount - $stockDetail->quantity;

            if ($newAmount <= 0) {
                $stock->update([
                    'amount' => 0,
                ]);
            }else{
                $stock->update([
                    'amount' => $newAmount,
                ]);
            }

            $stockDetail->delete();

            DB::commit();
        }catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Error while deleting stock : ' . $th->getMessage()]);
        }

    }
}
