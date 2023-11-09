<?php

namespace App\Http\Controllers;

use App\Models\ProductSupply;
use App\Http\Requests\StoreProductSupplyRequest;
use App\Http\Requests\UpdateProductSupplyRequest;

class ProductSupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $products = $this->allProducts();

        // return response([
            // 'data' => ProductSupplyResource::collection($products)
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductSupplyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductSupply $productSupply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductSupplyRequest $request, ProductSupply $productSupply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSupply $productSupply)
    {
        //
    }
}
