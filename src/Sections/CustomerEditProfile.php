<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\Actions\UpdateCustomer;

class CustomerEditProfile extends LivewireSection
{
    public static $view = 'shop::sections.customer-edit-profile';

    public $firstName = '';
    public $lastName = '';
    public $gender = '';
    public $dateOfBirth = '';
    public $email = '';
    public $phone = '';
    public $oldPassword = '';
    public $password = '';
    public $passwordConfirmation = '';
    public $subscribedToNewsletter = false;

    public function booted()
    {
        if ($this->firstName) {
            return;
        }

        $customer = $this->context['customer'];

        $this->firstName = $customer->first_name;
        $this->lastName = $customer->last_name;
        $this->gender = $customer->gender;
        $this->dateOfBirth = $customer->date_of_birth;
        $this->email = $customer->email;
        $this->phone = $customer->phone;

        if ($customer->subscription) {
            $this->subscribedToNewsletter = $customer->subscription->is_subscribed;
        }
    }

    public function submit(UpdateCustomer $updateCustomer)
    {
        return ($updateCustomer)([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'gender' => $this->gender,
            'email' => $this->email,
            'phone' => $this->phone,
            'date_of_birth' => $this->dateOfBirth ?? '',
            'oldpassword' => $this->oldPassword,
            'password' => $this->password,
            'password_confirmation' => $this->passwordConfirmation,
            'subscribed_to_newsletter' => $this->subscribedToNewsletter
        ]);
    }
}
