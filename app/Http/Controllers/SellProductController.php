<?php

namespace App\Http\Controllers;

use App\Models\SellProduct;
use App\Http\Requests\StoreSellProductRequest;
use App\Http\Requests\UpdateSellProductRequest;
use App\Http\Resources\SellProductResource;
use App\Http\Resources\EditSellProductResource;
use Illuminate\Support\Facades\Validator;
use DB;

class SellProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        $products = $this->allProducts();

        foreach ($products as $key => $data) {
            $arrDiscount = json_decode($data['discount']);
            $count = count($arrDiscount);
            $newDiscount = $count >= 1 ? $count.' Available Discount' : 'No Available Discount';
    
            $discountData = [];
            foreach ($arrDiscount as $key2 => $item) {
                $discount = DB::table('discounts')->where("id", $item)->first();
                $discountData[$key2]['label'] = $discount->label;
                $discountData[$key2]['amount'] = $discount->amount;
                $discountData[$key2]['type'] = $discount->type;
                $discountData[$key2]['purchase_quantity'] = $discount->purchase_quantity;
            } 
            $products[$key]['discount_label'] = $newDiscount;
            $products[$key]['discount_data'] = $discountData;
        }

        $productStocks = $this->getSupplies($products);



        return response([
            'data' => SellProductResource::collection($productStocks)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSellProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
     public function show($id)
    {
        $resource = SellProduct::find($id);

        if (!$resource) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product = $this->oneProduct($id);

        foreach ($product as $key => $data) {
            $supply = DB::table('product_supplies')
                ->where('product_id', $data['product_id'])
                ->where('batch_stocks', '>', 0)
                ->where('product_status', '=', 'stock')
                ->orderBy('batch_no') // Orders by batch number ascending
                ->first(); // Retrieves the first matching record

            if ($supply) {
                $product[$key]['cost_per_piece'] = $supply->cost_per_piece;
            } else {
                // If no supply with stocks > 0, retrieve the next batch with zero stocks
                $nextSupply = DB::table('product_supplies')
                    ->where('product_id', $data['product_id'])
                    ->where('product_status', '=', 'stock')
                    ->orderBy('batch_no') // Orders by batch number ascending
                    ->first(); // Retrieves the first matching record

                if ($nextSupply) {
                    $product[$key]['cost_per_piece'] = $supply->cost_per_piece;
                } else {
                    // If no further batches exist, set values to indicate no available supply
                    $product[$key]['cost_per_piece'] = null;
                }
            }
        }

        return response([
            'status' => 'Updated',
            'current' => EditSellProductResource::collection([$product[0]])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSellProductRequest $request, $id)
    {
        $product = SellProduct::findOrFail($id);

        $data = $request->validated();

        $saveData = [];

        foreach ($data['records'] as $service) {
            $serviceData = $this->updateProduct($service);
            $serviceData['id'] = $service['id'];

            $discountData = $service['discount'];

            if (is_array($discountData)) {
                $discountData = json_encode($discountData);
            }

            $serviceData['discount'] = $discountData;

            $saveData[] = $serviceData;
        }

        foreach ($saveData as $item) {
            $id = $item['id'];

            // Assuming you have an Eloquent model (e.g., DataModel) that corresponds to the data
            $model = SellProduct::find($id);

            if ($model) {
                $model->update($item);
            }
        }

        $products = $this->allProducts();

        $productStocks = $this->getSupplies($products);

        return response([
            'data' => SellProductResource::collection($productStocks)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SellProduct $sellProduct)
    {
        //
    }

    private function allProducts(){
        $results = SellProduct::query()
            ->join('products', 'sell_products.product_id', '=', 'products.id')
            ->orderBy('sell_products.created_at', 'ASC')
            ->get(['sell_products.*', 
                'products.product_name as product_name',
                'products.category_id as category_id',
                'products.image_url as image',
            ]);

        return $results;
    }

    private function oneProduct($id){
        $results = SellProduct::query()
            ->join('products', 'sell_products.product_id', '=', 'products.id')
            ->where('sell_products.id', $id)
            ->get(['sell_products.*', 
                'products.product_name as product_name',
                'products.category_id as category_id',
                'products.image_url as image',
            ]);

        return $results;
    }

    private function updateProduct($data)
    {
        $validator = Validator::make($data, [
            'original_price' => 'required|numeric',
            'discount' => 'present|array',
        ]);

        return $validator->validated();
    }


    private function getSupplies($products)
    {
        foreach ($products as $key => $data) {
            $supply = DB::table('product_supplies')
                ->where('product_id', $data['product_id'])
                ->where('batch_stocks', '>', 0)
                ->where('product_status', '=', 'stock')
                ->orderBy('batch_no') // Orders by batch number ascending
                ->first(); // Retrieves the first matching record

            if ($supply) {
                $products[$key]['supply_id'] = $supply->id;
                $products[$key]['unit_cost'] = $supply->unit_cost;
                $products[$key]['batch_no'] = $supply->batch_no;
                $products[$key]['batch_stocks'] = $supply->batch_stocks;
            } else {
                // If no supply with stocks > 0, retrieve the next batch with zero stocks
                $nextSupply = DB::table('product_supplies')
                    ->where('product_id', $data['product_id'])
                    ->where('product_status', '=', 'stock')
                    ->orderBy('batch_no') // Orders by batch number ascending
                    ->first(); // Retrieves the first matching record

                if ($nextSupply) {
                    $products[$key]['supply_id'] = $nextSupply->id;
                    $products[$key]['unit_cost'] = $supply->unit_cost;
                    $products[$key]['batch_no'] = $nextSupply->batch_no;
                    $products[$key]['batch_stocks'] = $nextSupply->batch_stocks;
                } else {
                    // If no further batches exist, set values to indicate no available supply
                    $products[$key]['supply_id'] = null;
                    $products[$key]['unit_cost'] = null;
                    $products[$key]['batch_no'] = null;
                    $products[$key]['batch_stocks'] = 0; // Or set as needed
                }
            }
        }

        return $products;
    }
}
