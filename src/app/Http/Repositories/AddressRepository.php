<?php

namespace App\Http\Repositories;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressRepository {
    public function getAddressByUser()
    {
        return Address::all()->where('user_id',Auth::id());
    }

    public function findAddressById($id)
    {
        $address = $this->getAddressById($id);
        if($address->user_id == Auth::id() || Auth::user()->role == "ADMIN"){
            return response()->json($address);
        } else{
            return response()->json([
                'message' => 'Sem autorização para acessar o endereço!'
            ]);
        }
    }

    public function getAddressById($id)
    {
        return Address::findOrFail($id);
    }

    public function updateAddress(Address $address, $data)
    {
        if($address->user_id == Auth::id() || Auth::user()->role == "ADMIN"){
            $address->update($data);
            return response()->json([
                'message' => 'Endereço atualizado com sucesso!'
            ]);
        } else{
            return response()->json([
                'message' => 'Sem autorização para atualizar o endereço!'
            ]);
        }
    }

    public function storeAddress($data)
    {
        return Address::create([
            'user_id' => Auth::id(),
            'street' => $data['street'],
            'number' => $data['number'],
            'zip' => $data['zip'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country']
        ]);
    }

    public function deleteAddress($id)
    {
        $address = $this->getAddressById($id);
        if($address->user_id == Auth::id() || Auth::user()->role == "ADMIN") {
            $address->delete();
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
