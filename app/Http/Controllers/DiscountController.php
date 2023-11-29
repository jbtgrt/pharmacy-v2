<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Http\Requests\StoreRecordRequest;
use App\Http\Requests\UpdateRecordRequest;
use App\Http\Resources\DiscountResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discounts = Discount::all();

        return response([
            'data' => DiscountResource::collection($discounts)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecordRequest $request)
    {
        $data = $request->validated();

        $saveData = [];

        foreach ($data['records'] as $service) {
            $serviceData = $this->storeValidate($service);

            $saveData[] = $serviceData;
        }

        Discount::insert($saveData);

        $discount = Discount::all();

        return response([
            'message' => 'The discount was successfully added.',
            'data' => DiscountResource::collection($discount)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $resource = Discount::find($id);

        if (!$resource) {
            return response()->json(['message' => 'Discount not found'], 404);
        }

        return response([
            'status' => 'Updated',
            'current' => new DiscountResource($resource)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecordRequest $request, $id)
    {

        $data = $request->validated();

        $saveData = [];

        foreach ($data['records'] as $service) {
            $serviceData = $this->updateValidate($service, $id);
            $serviceData['id'] = $service['id'];

            $saveData[] = $serviceData;
        }

        foreach ($saveData as $item) {
            $id = $item['id'];

            // Assuming you have an Eloquent model (e.g., DataModel) that corresponds to the data
            $model = Discount::find($id);

            if ($model) {
                $model->update($item);
            }
        }

        $discounts = Discount::all();

        return response([
            'data' => DiscountResource::collection($discounts)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        //
    }

    private function storeValidate($data)
    {
        $validator = Validator::make($data, [
            'label' => 'required|string|unique:discounts,label',
            'type' => 'required|string',
            'amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'purchase_quantity' => 'required|numeric',
            'purchase_amount' => 'required|numeric',
        ]);

        return $validator->validated();
    }

    private function updateValidate($data, $id)
    {
        $validator = Validator::make($data, [
            'label' => 'required|string|unique:discounts,label,'.$id,
            'type' => 'required|string',
            'amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'purchase_quantity' => 'required|numeric',
            'purchase_amount' => 'required|numeric',
        ]);

        return $validator->validated();
    }
}
