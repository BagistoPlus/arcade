<?php

namespace EldoMagan\BagistoArcade\Actions;

use EldoMagan\BagistoArcade\Contracts\CreateCustomer as CreateCustomerContract;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Webkul\Customer\Repositories\CustomerGroupRepository;
use Webkul\Customer\Repositories\CustomerRepository;

class CreateCustomer implements CreateCustomerContract
{
    /**
     * Customer repository instance.
     *
     * @var \Webkul\Customer\Repositories\CustomerRepository
     */
    protected $customerRepository;

    /**
     * Customer group repository instance.
     *
     * @var \Webkul\Customer\Repositories\CustomerGroupRepository
     */
    protected $customerGroupRepository;

    public function __construct(CustomerRepository $customerRepository, CustomerGroupRepository $customerGroupRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->customerGroupRepository = $customerGroupRepository;
    }

    public function create(array $data)
    {
        $data = array_merge($data, [
            'password' => Hash::make($data['password']),
            'api_token' => Str::random(80),
            'is_verified' => core()->getConfigData('customer.settings.email.verification') ? 0 : 1,
            'customer_group_id' => $this->customerGroupRepository->findOneWhere(['code' => 'general'])->id,
            'token' => md5(uniqid(rand(), true)),
        ]);

        Event::dispatch('customer.registration.before');

        $customer = $this->customerRepository->create($data);

        Event::dispatch('customer.registration.after', $customer);

        return $customer;
    }
}
