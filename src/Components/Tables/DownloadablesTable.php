<?php

namespace EldoMagan\BagistoArcade\Components\Tables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters;
use Webkul\Sales\Models\DownloadableLinkPurchased;

class DownloadablesTable extends DataTableComponent
{
    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function builder(): Builder
    {
        return DownloadableLinkPurchased::query()
            ->distinct()
            ->leftJoin('orders', 'downloadable_link_purchased.order_id', '=', 'orders.id')
            ->leftJoin('invoices', 'downloadable_link_purchased.order_id', '=', 'invoices.order_id')
            ->addSelect(
                'downloadable_link_purchased.*',
                'invoices.state as invoice_state',
                'orders.increment_id'
            )
            ->addSelect(DB::raw('(' . DB::getTablePrefix() . 'downloadable_link_purchased.download_bought - ' . DB::getTablePrefix() . 'downloadable_link_purchased.download_canceled - ' . DB::getTablePrefix() . 'downloadable_link_purchased.download_used) as remaining_downloads'))
            ->where('downloadable_link_purchased.customer_id', auth()->guard('customer')->user()->id)
        ;
    }

    public function columns(): array
    {
        return [
            Column::make(__('shop::app.customer.account.downloadable_products.order-id'), 'order_id')
                ->sortable(),

            Column::make(__('shop::app.customer.account.downloadable_products.name'), 'product_name')
                ->sortable()
                ->searchable()
                ->view('shop::partials.account.downloadable-product.name'),

            Column::make(__('shop::app.customer.account.downloadable_products.date'), 'created_at')
                ->sortable(),

            Column::make(__('shop::app.customer.account.downloadable_products.status'), 'status')
                ->sortable()
                ->format(function ($value) {
                    return __('shop::app.customer.account.downloadable_products.' . $value);
                }),

            Column::make(__('shop::app.customer.account.downloadable_products.remaining-downloads'), 'id')
                ->sortable()
                ->format(function ($remaining_downloads, $row) {
                    if (! $row->download_bought) {
                        return trans('shop::app.customer.account.downloadable_products.unlimited');
                    }

                    return $row->remaining_downloads;
                }),
        ];
    }

    public function filters(): array
    {
        return [
            Filters\TextFilter::make(__('shop::app.customer.account.downloadable_products.order-id'))
                ->filter(function (Builder $query, $value) {
                    $query->where('orders.increment_id', $value);
                }),
            Filters\SelectFilter::make(__('shop::app.customer.account.downloadable_products.status'), 'status')
                ->options([
                    '' => 'All',
                    'pending' => __('shop::app.customer.account.downloadable_products.pending'),
                    'available' => __('shop::app.customer.account.downloadable_products.available'),
                    'expired' => __('shop::app.customer.account.downloadable_products.expired'),
                ])
                ->filter(function (Builder $query, $value) {
                    if ($value) {
                        $query->where('downloadable_link_purchased.status', $value);
                    }
                }),
        ];
    }
}
