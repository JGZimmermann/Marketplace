<?php

namespace App\Http\Repositories;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressRepository {
    public function getAddressByUser()
    {
        return Address::all()->where('user_id',Auth::id());
    }

    public function getAddressById($id)
    {
        return Address::findOrFail($id);
    }

    public function updateAddress(Address $address, $data)
    {
        return $address->update($data);
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

    public function deleteAddress(Address $address)
    {
        return $address->delete();
    }
}
