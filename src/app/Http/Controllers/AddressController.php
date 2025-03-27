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
        return $this->addressService->getAddressById($id);
    }

    public function store(StoreAddressRequest $request)
    {
        return $this->addressService->storeAddress($request);
    }

    public function showByUser()
    {
        return $this->addressService->getAddressByUser();
    }

    public function update(UpdateAddressRequest $request,$id)
    {
        return $this->addressService->updateAddress($id,$request);
    }

    public function delete($id)
    {
        return $this->addressService->deleteAddress($id);
    }
}
