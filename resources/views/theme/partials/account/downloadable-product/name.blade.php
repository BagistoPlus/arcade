@if($row->status == 'pending' || $row->status == 'expired' || $row->invoice_state !== 'paid')
  {{ $value }}
@else
  <span>{{ $value }}</span>
  <a href="{{ route('customer.downloadable_products.download', $row->id) }}" target="_blank" class="text-primary">
    {{ $row->name }}
  </a>
@endif
