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
        $address = $this->addressRepository->getAddressById($id);
        return response()->json($address);
    }

    public function updateAddress($id,$data)
    {
        $address = $this->addressRepository->getAddressById($id);
        $this->addressRepository->updateAddress($address, $data);
        return response()->json([
            'message' => 'Endereço atualizado com sucesso!'
        ]);
    }

    public function deleteAddress($id)
    {
        $address = $this->addressRepository->getAddressById($id);
        $this->addressRepository->deleteAddress($address);
        return response()->json([
            'message' => 'Endereço deletado com sucesso!'
        ],204);
    }
}
