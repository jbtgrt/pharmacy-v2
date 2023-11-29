<?php

namespace App\Http\Controllers;

use App\Models\ProductSupply;
use App\Http\Requests\StoreProductSupplyRequest;
use App\Http\Requests\UpdateProductSupplyRequest;
use App\Http\Resources\ProductSupplyResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
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
            $validatedData['staff_id'] = $request->user()->id;
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
    public function show($id)
    {
        $resource = ProductSupply::find($id);

        if (!$resource) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product = $this->oneProduct($id);

        return response([
            'status' => 'Updated',
            'current' => ProductSupplyResource::collection([$product[0]])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductSupplyRequest $request, $id)
    {
        $product = ProductSupply::findOrFail($id);

        $data = $request->validated();

        $saveData = [];

        foreach ($data['records'] as $supply) {
            $validatedData = $this->createProductSupply($supply);
            $validatedData['id'] = $supply['id'];
            $validatedData['staff_id'] = $request->user()->id;
            $saveData[] = $validatedData;

        }

        $updatedData = [];

        foreach ($saveData as $item) {
            $id = $item['id'];

            // Assuming you have an Eloquent model (e.g., DataModel) that corresponds to the data
            $model = ProductSupply::find($id);

            if ($model) {
                $model->update($item);
                $updatedData[] = $model;
            }
        }

        $supplies = $this->allSupplies();

        return response([
            'message' => 'The supply was successfully added.',
            'data' => ProductSupplyResource::collection($supplies)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSupply $productSupply)
    {
        $item = ProductSupply::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Item deleted'], 200);
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
            'supplier_id' => 'exists:users,id',
            'batch_no' => 'required|numeric',
            'unit_quantity' => 'required|numeric',
            'quantity_per_unit' => 'required|numeric',
            'unit_cost' => 'required|numeric',
            
            'total_cost' => 'required|numeric',
            'batch_stocks' => 'required|numeric',
            'cost_per_piece' => 'required|numeric',

            'date_received' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'storage_location' => 'nullable|numeric',
            'notes' => 'nullable|string'
        ]);

        return $validator->validated();
    }

    private function allSupplies(){
        $product = ProductSupply::query()
            ->join('users as staff', 'product_supplies.staff_id', '=', 'staff.id')
            ->join('users as supplier', 'product_supplies.supplier_id', '=', 'supplier.id')
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
                'products.status',
                'staff.first_name as staff_fname', 
                'staff.last_name as staff_lname', 
                'supplier.first_name as supplier_fname',
                'supplier.last_name as supplier_lname'
            ]);
    
        return $product;
    }

    private function oneProduct($id) {
        $product = ProductSupply::query()
            ->join('users as staff', 'product_supplies.staff_id', '=', 'staff.id')
            ->join('users as supplier', 'product_supplies.supplier_id', '=', 'supplier.id')
            ->join('products', 'product_supplies.product_id', '=', 'products.id')
            ->join('categories', 'product_supplies.category_id', '=', 'categories.id')
            ->join('brands', 'product_supplies.brand_id', '=', 'brands.id')
            ->join('units', 'product_supplies.unit_id', '=', 'units.id')
            ->where('product_supplies.id', $id)
            ->orderBy('product_supplies.created_at', 'ASC')
            ->get([
                'product_supplies.*', 
                'categories.category_name', 
                'brands.brand_name',
                'units.unit_name',  
                'products.product_name', 
                'products.description as product_description', 
                'products.image_url',
                'products.status',
                'staff.first_name as staff_fname', 
                'staff.last_name as staff_lname', 
                'supplier.first_name as supplier_fname',
                'supplier.last_name as supplier_lname'
            ]);
    
        return $product;
    }
    
}
