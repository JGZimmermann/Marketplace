<?php

namespace App\Http\Services;

use App\Http\Repositories\AddressRepository;

class AddressService{
    public function __construct(protected AddressRepository $addressRepository)
    {
    }

    public function getAddressByUser()
    {
        return $this->addressRepository->getAddressByUser();
    }

    public function storeAddress($data)
    {
        return $this->addressRepository->storeAddress($data);
    }

    public function getAddressById($id)
    {
        return $this->addressRepository->findAddressById($id);
    }

    public function updateAddress($id,$data)
    {
        $address = $this->addressRepository->getAddressById($id);
        return $this->addressRepository->updateAddress($address,$data);
    }

    public function deleteAddress($id)
    {
         return $this->addressRepository->deleteAddress($id);
    }
}
