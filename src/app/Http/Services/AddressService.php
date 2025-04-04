<?php

namespace App\Http\Services;

use App\Http\Repositories\AddressRepository;
use Illuminate\Support\Facades\Auth;

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
        if($address->user_id == Auth::id() || Auth::user()->role == "ADMIN"){
            return response()->json($address);
        } else{
            return response()->json([
                'message' => 'Sem autorização para acessar o endereço!'
            ]);
        }
    }

    public function updateAddress($id,$data)
    {
        $address = $this->addressRepository->getAddressById($id);
        if($address->user_id == Auth::id() || Auth::user()->role == "ADMIN"){
            $this->addressRepository->updateAddress($address, $data);
            return response()->json([
                'message' => 'Endereço atualizado com sucesso!'
            ]);
        } else{
            return response()->json([
                'message' => 'Sem autorização para atualizar o endereço!'
            ]);
        }
    }

    public function deleteAddress($id)
    {
        $address = $this->addressRepository->getAddressById($id);
        if($address->user_id == Auth::id() || Auth::user()->role == "ADMIN") {
            $this->addressRepository->deleteAddress($address);
            return response()->json([
                'message' => 'Endereço deletado com sucesso!'
            ]);
        } else {
            return response()->json([
                'message' => 'Sem autorização para excluir o endereço!'
            ]);
        }
    }
}
