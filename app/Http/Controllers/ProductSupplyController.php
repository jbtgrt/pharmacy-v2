<?php

namespace App\Http\Controllers;

use App\Models\ProductSupply;
use App\Http\Requests\StoreProductSupplyRequest;
use App\Http\Requests\UpdateProductSupplyRequest;
use App\Http\Resources\ProductSupplyResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;

class ProductSupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->allSupplies();

        return response([
            'data' => ProductSupplyResource::collection($products)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductSupplyRequest $request)
    {
        $data = $request->validated();

        $saveData = [];

        foreach ($data['records'] as $supply) {
            $validatedData = $this->createProductSupply($supply);
            $saveData[] = $validatedData;
        }

        ProductSupply::insert($saveData);

        $supplies = $this->allSupplies();

        return response([
            'message' => 'The supply was successfully added.',
            'data' => ProductSupplyResource::collection($supplies)
        ]);
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

    /**
     * Create a question and return
     *
     * @param $data
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     * @author Jobet Guarte <jobetguartejg@gmail.com>
     */
    private function createProductSupply($data)
    {
        $validator = Validator::make($data, [
            'product_id' => 'exists:products,id',
            'category_id' => 'exists:categories,id',
            'brand_id' => 'exists:brands,id',
            'unit_id' => 'exists:units,id',
            'product_code' => 'required|string',
            'product_cost' => 'required|numeric',
            'quantity' => 'nullable|numeric',
            'expires_at' => 'nullable|date',
            'description' => 'nullable|string'
        ]);

        return $validator->validated();
    }

    private function allSupplies(){
        $users = ProductSupply::query()
            ->join('products', 'product_supplies.product_id', '=', 'products.id')
            ->join('categories', 'product_supplies.category_id', '=', 'categories.id')
            ->join('brands', 'product_supplies.brand_id', '=', 'brands.id')
            ->join('units', 'product_supplies.unit_id', '=', 'units.id')
            ->orderBy('product_supplies.created_at', 'ASC')
            ->get([
                    'product_supplies.*', 
                    'categories.category_name', 
                    'brands.brand_name', 
                    'units.unit_name', 
                    'products.product_name', 
                    'products.description as product_description', 
                    'products.image_url',
                    'products.status'
                ]);

        return $users;
    }

    // private function oneProduct($id) {
    //     $product = Product::query()
    //         ->join('categories', 'products.category_id', '=', 'categories.id')
    //         ->join('brands', 'products.brand_id', '=', 'brands.id')
    //         ->join('units', 'products.unit_id', '=', 'units.id')
    //         ->where('products.id', $id)
    //         ->orderBy('products.created_at', 'ASC')
    //         ->get(['products.*', 'categories.category_name as category_name', 'brands.brand_name as brand_name', 'units.unit_name as unit_name']);

    //     return $product;
    // }
}
