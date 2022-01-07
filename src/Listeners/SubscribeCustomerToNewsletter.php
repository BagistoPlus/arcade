<?php

namespace EldoMagan\BagistoArcade\Listeners;

use Illuminate\Support\Facades\Mail;
use Webkul\Core\Repositories\SubscribersListRepository;
use Webkul\Shop\Mail\SubscriptionEmail;

class SubscribeCustomerToNewsletter
{
    /**
     * @var SubscribersListRepository
     */
    protected $subscriptionRepository;

    public function __construct(SubscribersListRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function handle($customer)
    {
        if (! $customer->subscribed_to_news_letter) {
            return;
        }

        $subscription = $this->subscriptionRepository->findOneWhere([
            'email' => $customer->email,
        ]);

        if ($subscription) {
            return $this->subscriptionRepository->update([
                'customer_id' => $customer->id,
            ], $subscription->id);
        }

        $this->subscriptionRepository->create([
            'email' => $customer->email,
            'customer_id' => $customer->id,
            'channel_id' => core()->getCurrentChannel()->id,
            'is_subscribed' => 1,
            'token' => $token = uniqid(),
        ]);

        try {
            Mail::queue(new SubscriptionEmail([
                'email' => $customer->email,
                'token' => $token,
            ]));
        } catch (\Exception $e) {
        }
    }
}
