<?php

namespace EldoMagan\BagistoArcade\Actions;

use Webkul\Customer\Http\Controllers\CustomerController;

class UpdateCustomer
{
    protected CustomerController $customerController;

    public function __construct(CustomerController $customerController)
    {
        $this->customerController = $customerController;
    }

    public function __invoke(array $data)
    {
        // We replace request body with $data to discard custom livewire inputs
        $originalRequestData = request()->request->all();
        request()->request->replace($data);

        try {
            $response = $this->customerController->update();

            // and then we restore livewire request data to prevent ignition crash
            // we should probably move this logic to some livewire middleware
            request()->request->replace($originalRequestData);
            return $response;
        } catch (\ErrorException $e) {
            return redirect()->route('customer.profile.index');
        }
    }
}
