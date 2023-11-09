<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = Category::all();

        return response([
            'data' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        $saveData = [];

        foreach ($data['records'] as $service) {
            $serviceData = $this->createCategory($service);

            $saveData[] = $serviceData;
        }

        Category::insert($saveData);

        $category = Category::all();

        return response([
            'message' => 'The category was successfully added.',
            'data' => $category
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $resource = Category::find($id);

        if (!$resource) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response([
            'status' => 'Updated',
            'current' => new CategoryResource($resource)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        $saveData = [];

        foreach ($data['records'] as $service) {
            $serviceData = $this->createCategory($service);
            $serviceData['id'] = $service['id'];
            $optionsData = [];
            $saveData[] = $serviceData;
        }

        // $servicemodel = User::findOrFail($saveData[0]->id);
        $updatedData = [];

        foreach ($saveData as $item) {
            $id = $item['id'];

            // Assuming you have an Eloquent model (e.g., DataModel) that corresponds to the data
            $model = Category::find($id);

            if ($model) {
                $model->update($item);
                $updatedData[] = $model;
            }
        }

        $services = Category::all();

        return response([
            'message' => 'The service was successfully updated.',
            'data' => CategoryResource::collection($services)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = Category::find($id);

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
    private function createCategory($data)
    {
        $validator = Validator::make($data, [
            'category_name' => 'required|string',
            'description' => 'nullable|string'
        ]);

        return $validator->validated();
    }
}
