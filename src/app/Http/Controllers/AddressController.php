<?php

namespace App\Http\Controllers;

use App\Http\Services\AddressService;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;

class AddressController extends Controller
{
    public function __construct(protected AddressService $addressService)
    {
    }

    public function show($id)
    {
        return response()->json($this->addressService->getAddressById($id));
    }

    public function store(StoreAddressRequest $request)
    {
        return response()->json($this->addressService->storeAddress($request),201);
    }

    public function showByUser()
    {
        return response()->json($this->addressService->getAddressByUser());
    }

    public function update(UpdateAddressRequest $request,$id)
    {
        return response()->json($this->addressService->updateAddress($id,$request->validated()));
    }

    public function delete($id)
    {
        return response()->json($this->addressService->deleteAddress($id),204);
    }
}
