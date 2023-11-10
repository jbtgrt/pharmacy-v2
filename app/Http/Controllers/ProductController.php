<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->allProducts();

        return response([
            'data' => ProductResource::collection($products)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $saveData = [];

        foreach ($data['records'] as $service) {
            $serviceData = $this->createProduct($service);
            if (isset($service['image_url'])) {
                $relativePath = $this->saveImage($service['image_url']);
                $serviceData['image_url'] = $relativePath;
            } else {
                $serviceData['image_url'] = '';
            }
            $saveData[] = $serviceData;
        }

        $insertedData = [];

        foreach ($saveData as $data) {
            $insertedIds['id'] = DB::table('products')->insertGetId($data);

           // Get a specific supplier by its ID
            $product = Product::find($insertedIds['id']);

            // Access the related products using the "products" method
            $unit = $product->unit;

            $insertedData[] = [
                'id' => $insertedIds['id'],
                'category_id' => DB::table('products')->select('category_id')->where('id', $insertedIds['id'])->first()->category_id,
                'brand_id' => DB::table('products')->select('brand_id')->where('id', $insertedIds['id'])->first()->brand_id,
                'unit_id' => DB::table('products')->select('unit_id')->where('id', $insertedIds['id'])->first()->unit_id,
                'product_name' => DB::table('products')->select('product_name')->where('id', $insertedIds['id'])->first()->product_name,
                'unit_name' => $unit->unit_name
            ];
        }

        $products = $this->allProducts();

        return response([
            'message' => 'The product was successfully added.',
            'data' => ProductResource::collection($products),
            'product_ids' => $insertedData
        ]);

        // $product = Product::find($productId);

        // if (!$product) {
        //     return response()->json(['message' => 'Product not found'], 404);
        // }

        // // Access the associated category using the 'category' relationship
        // $category = $product->category;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $resource = Product::find($id);

        if (!$resource) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product = $this->oneProduct($id);

        return response([
            'status' => 'Updated',
            'current' => ProductResource::collection([$product[0]])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validated();

        $saveData = [];

        foreach ($data['records'] as $service) {
            $serviceData = $this->createProduct($service);
            $serviceData['id'] = $service['id'];
            if (isset($service['image_url'])) {
                $relativePath = $this->saveImage($service['image_url']);
                    $serviceData['image_url'] = $relativePath;

                 // If there is an old image, delete it
                if ($product->image_url) {
                    $absolutePath = public_path($product->image_url);
                    File::delete($absolutePath);
                }
            }
            $saveData[] = $serviceData;
        }

        // $servicemodel = User::findOrFail($saveData[0]->id);
        $updatedData = [];

        foreach ($saveData as $item) {
            $id = $item['id'];

            // Assuming you have an Eloquent model (e.g., DataModel) that corresponds to the data
            $model = Product::find($id);

            if ($model) {
                $model->update($item);
                $updatedData[] = $model;
            }
        }

        $records = $this->allProducts();

        return response([
            'message' => 'The product was successfully updated.',
            'data' => ProductResource::collection($records)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = Product::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Item deleted'], 200);
    }

    private function allProducts(){
        $users = Product::query()
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('units', 'products.unit_id', '=', 'units.id')
            ->orderBy('products.created_at', 'ASC')
            ->get(['products.*', 'categories.category_name as category_name', 'brands.brand_name as brand_name', 'units.unit_name as unit_name']);

        return $users;
    }

    private function oneProduct($id) {
        $product = Product::query()
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('units', 'products.unit_id', '=', 'units.id')
            ->where('products.id', $id)
            ->orderBy('products.created_at', 'ASC')
            ->get(['products.*', 'categories.category_name as category_name', 'brands.brand_name as brand_name', 'units.unit_name as unit_name']);

        return $product;
    }

    /**
     * Create a question and return
     *
     * @param $data
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     * @author Jobet Guarte <jobetguartejg@gmail.com>
     */
    private function createProduct($data)
    {
        $validator = Validator::make($data, [
            'category_id' => 'exists:categories,id',
            'brand_id' => 'exists:brands,id',
            // 'purchase_unit_id' => 'exists:units,id',
            'unit_id' => 'exists:units,id',
            // 'sale_unit_id' => 'exists:units,id',
            'product_name' => 'required|string',
            // 'product_code' => 'required|string',
            // 'product_price' => 'required|numeric',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string'
            // 'expires_at' => 'nullable|date'
        ]);

        return $validator->validated();
    }

    private function saveImage($image)
    {
        // // Check if image is valid base64 string
        // if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
        //     // Take out the base64 encoded text without mime type
        //     $image = substr($image, strpos($image, ',') + 1);
        //     // Get file extension
        //     $type = strtolower($type[1]); // jpg, png, gif

        //     // Check if file is an image
        //     if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
        //         throw new \Exception('invalid image type');
        //     }
        //     $image = str_replace(' ', '+', $image);
        //     $image = base64_decode($image);

        //     if ($image === false) {
        //         throw new \Exception('base64_decode failed');
        //     }
        // } else {
        //     throw new \Exception('did not match data URI with image data');
        // }


        // Check if image is a valid base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            // Take out the base64 encoded text without the MIME type
            $image = substr($image, strpos($image, ',') + 1);
            // Get file extension
            $type = strtolower($type[1]); // jpg, png, gif

            // Check if the file is an image
            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('Invalid image type');
            }

            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);

            if ($image === false) {
                throw new \Exception('base64_decode failed');
            }

            // Check if the file size is within the allowed limit (500KB)
            // $maxFileSize = 500 * 1024; // 500KB in bytes
            // if (strlen($image) > $maxFileSize) {
            //     throw new \Exception('File size exceeds the maximum allowed limit.');
            // }
        } else {
            throw new \Exception('Did not match data URI with image data');
        }


        $dir = 'images/products/';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);

        return $relativePath;
    }
}
