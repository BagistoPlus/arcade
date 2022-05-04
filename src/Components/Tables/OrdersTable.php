<?php

namespace EldoMagan\BagistoArcade\Components\Tables;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Webkul\Sales\Models\Order;

class OrdersTable extends DataTableComponent
{
    protected $model = Order::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableRowUrl(function ($row) {
                return route('customer.orders.view', ['id' => $row->increment_id]);
            })
        ;
    }

    public function columns(): array
    {
        return [
            Column::make(__('shop::app.customer.account.order.index.order_id'), 'increment_id')
                ->sortable(),

            Column::make(__('shop::app.customer.account.order.index.date'), 'created_at')
                ->searchable()
                ->sortable(),

            Column::make(__('shop::app.customer.account.order.index.total'), 'grand_total')
                ->searchable()
                ->sortable()
                ->format(function ($value) {
                    return core()->currency($value);
                })
                ->html(),

            Column::make(__('shop::app.customer.account.order.index.status'), 'status')
                ->searchable()
                ->sortable()
                ->view('shop::partials.account.order-status'),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make(__('shop::app.customer.account.order.index.status'), 'status')
                ->options([
                    '' => 'All',
                    'pending' => __('shop::app.customer.account.order.index.pending'),
                    'pending_payment' => __('shop::app.customer.account.order.index.pending-payment'),
                    'processing' => __('shop::app.customer.account.order.index.processing'),
                    'completed' => __('shop::app.customer.account.order.index.completed'),
                    'canceled' => __('shop::app.customer.account.order.index.canceled'),
                    'closed' => __('shop::app.customer.account.order.index.closed'),
                    'fraud' => __('shop::app.customer.account.order.index.fraud'),
                ])
                ->filter(function (Builder $query, $value) {
                    if ($value) {
                        $query->where('status', $value);
                    }
                }),

            DateFilter::make(__('shop::app.customer.account.order.index.date'), 'created_at')
                ->filter(function (Builder $query, $value) {
                    if ($value) {
                        $query->whereDate('created_at', $value);
                    }
                }),
        ];
    }
}
