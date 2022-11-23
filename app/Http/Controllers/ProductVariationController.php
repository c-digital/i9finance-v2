<?php

namespace App\Http\Controllers;

use App\Models\ProductVariation;
use Illuminate\Http\Request;

class ProductVariationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $variations = ProductVariation::get();

        return view('product-variation.index', compact('variations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product-variation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $variation = new ProductVariation();
        $variation->name = $request->name;
        $variation->parameters = $request->parameters;
        $variation->save();

        return redirect('/product-variation');
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\ProductStock $productStock
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ProductStock $productStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ProductStock $productStock
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $variation = ProductVariation::find($id);
        return view('product-variation.edit', compact('variation'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductStock $productStock
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $variation = ProductVariation::find($id);
        $variation->name = $request->name;
        $variation->parameters = $request->parameters;
        $variation->save();

        return redirect('/product-variation');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ProductStock $productStock
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $variation = ProductVariation::find($id);
        $variation->delete();

        return redirect('/product-variation');
    }
}
