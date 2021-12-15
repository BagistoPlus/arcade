<?php

namespace EldoMagan\BagistoArcade\Components;

use Illuminate\View\Component;

class CurrencySwitcher extends Component
{
    public $currencies = [];
    public $currentCurrency;

    public function __construct()
    {
        // @phpstan-ignore-next-line
        $this->currencies = core()->getCurrentChannel()->currencies;
        $this->currentCurrency = core()->getCurrentCurrency();
    }

    public function switchCurrencyUrl($code)
    {
        $query = array_merge(
            request()->query(),
            ['currency' => $code]
        );

        return url()->current() . '?' . http_build_query($query);
    }

    public function hasMultipleCurrencies()
    {
        return $this->currencies->count() > 1;
    }

    public function render()
    {
        return view('shop::components.currency-switcher');
    }
}
