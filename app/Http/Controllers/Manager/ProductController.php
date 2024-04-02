<?php

namespace App\Http\Controllers\Manager;

use App\Models\Products;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ProductImages;
use App\Models\Stocks;
use App\Models\TemporaryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::with('productImages', 'stock')->get();
        // dd([
        //     'data' => $products
        // ]);
        return Inertia::render('Product', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('CreateProduct');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {

        try {
            DB::beginTransaction();

            $product =  Products::create($request->validated());
            Stocks::create([
                'product_id' => $product->id,
                'amount' => $request->stock,
            ]);
            $temporaryImages = TemporaryImage::whereIn('folder', $request->images)->get();

            foreach ($temporaryImages as $temporaryImage) {
                Storage::copy('images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file, 'public/images/' . $temporaryImage->folder . '/' . $temporaryImage->file);
                ProductImages::create([
                    'product_id' => $product->id,
                    'image_name' => $temporaryImage->file,
                    'url' => $temporaryImage->folder . '/' . $temporaryImage->file
                ]);
                Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }

            DB::commit();
        }catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Error while creating company : ' . $th->getMessage()]);
        }


        return Redirect::route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $product)
    {
        $product->load('productImages', 'stock')->get();

        return Inertia::render('EditProduct', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Products $product)
    {
        try {
            DB::beginTransaction();

            $product->update($request->all());

            if ($request->has('stock')) {
                $product->stock->update([
                    'amount' => $request->stock,
                ]);
            }

            $temporaryImages = TemporaryImage::whereIn('folder', $request->images)->get();

            foreach ($temporaryImages as $temporaryImage) {
                Storage::copy('images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file, 'public/images/' . $temporaryImage->folder . '/' . $temporaryImage->file);

                ProductImages::create([
                    'product_id' => $product->id,
                    'image_name' => $temporaryImage->file,
                    'url' => $temporaryImage->folder . '/' . $temporaryImage->file
                ]);

                // $product->productImages->update([
                //     'image_name' => $temporaryImage->file,
                //     'url' => $temporaryImage->folder . '/' . $temporaryImage->file,
                // ]);
                Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }

            DB::commit();
        }catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Error while creating company : ' . $th->getMessage()]);
        }

        return Redirect::route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $product)
    {
        $product->delete();
    }
}
