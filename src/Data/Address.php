<?php

namespace EldoMagan\BagistoArcade\Data;

use Livewire\Wireable;

class Address implements Wireable
{
    public $address_id = '';
    public $company_name = '';
    public $email = '';
    public $first_name = '';
    public $last_name = '';
    public $address1 = [];
    public $city = '';
    public $country = '';
    public $state = '';
    public $postcode = '';
    public $phone = '';
    public $use_for_shipping = true;
    public $save_as_address = false;

    public function toArray()
    {
        return [
            'address_id' => $this->address_id,
            'company_name' => $this->company_name,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'address1' => $this->address1,
            'city' => $this->city,
            'country' => $this->country,
            'state' => $this->state,
            'postcode' => $this->postcode,
            'phone' => $this->phone,
            'use_for_shipping' => $this->use_for_shipping,
            'save_as_address' => $this->save_as_address,
        ];
    }

    public function toExpectedArray()
    {
        if ($this->address_id) {
            return [
                'address_id' => $this->address_id,
                'use_for_shipping' => $this->use_for_shipping,
                'save_as_address' => $this->save_as_address,
            ];
        }

        return $this->toArray();
    }

    public function toLivewire()
    {
        return $this->toArray();
    }

    public static function fromLivewire($value)
    {
        $address = new static;

        $address->address_id = $value['address_id'];
        $address->company_name = $value['company_name'];
        $address->email = $value['email'];
        $address->first_name = $value['first_name'];
        $address->last_name = $value['last_name'];
        $address->address1 = $value['address1'];
        $address->city = $value['city'];
        $address->country = $value['country'];
        $address->state = $value['state'];
        $address->postcode = $value['postcode'];
        $address->phone = $value['phone'];
        $address->use_for_shipping = $value['use_for_shipping'];
        $address->save_as_address = $value['save_as_address'];

        return $address;
    }
}
