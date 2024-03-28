<?php

namespace App\Http\Controllers\Manager;

use App\Models\Products;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Product', [
            'products' => Products::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Inertia::render('CreateProduct');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $product)
    {
        //
    }
}
