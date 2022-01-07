<?php

namespace EldoMagan\BagistoArcade\Components;

use EldoMagan\BagistoArcade\Contracts\CreateCustomer;
use Illuminate\Support\Facades\Validator;

;
use Livewire\Component;

class RegisterCustomer extends Component
{
    public $state = [];

    public function rules()
    {
        return array_merge([
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => 'email|required|unique:customers,email',
            'password' => 'confirmed|min:6|required',
        ], arcade()->customerRegistrationValidation());
    }

    public function submit(CreateCustomer $creator)
    {
        Validator::make($this->state, $this->rules())->validate();

        $creator->create($this->state);

        return redirect()->route('customer.session.index');
    }

    public function render()
    {
        return view('shop::components.register-customer');
    }
}
