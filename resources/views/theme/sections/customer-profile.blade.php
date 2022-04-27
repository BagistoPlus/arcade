<x-account-layout :title="__('shop::app.customer.account.profile.index.title')">
  <div class="table w-full max-w-3xl">
    <div class="table-row">
      <div class="table-cell py-2">Prénoms</div>
      <div class="table-cell py-2">{{ $customer->first_name }}</div>
    </div>
    <div class="table-row">
      <div class="table-cell py-2">Nom</div>
      <div class="table-cell py-2">{{ $customer->last_name }}</div>
    </div>
    <div class="table-row">
      <div class="table-cell py-2">Genre</div>
      <div class="table-cell py-2">{{ __($customer->gender) }}</div>
    </div>
    <div class="table-row">
      <div class="table-cell py-2">Date de naissance</div>
      <div class="table-cell py-2">{{ $customer->date_of_birth }}</div>
    </div>
    <div class="table-row">
      <div class="table-cell py-2">Adresse E-mail</div>
      <div class="table-cell py-2">{{ $customer->email }}</div>
    </div>
  </div>

  <div class="mt-6 mb-4">
    <a href="{{ route('customer.profile.edit') }}" class="px-4 py-3 font-medium border cursor-pointer border-primary text-primary">
      Modifier
    </a>

    <a href="#" class="px-4 py-3 ml-4 font-medium border cursor-pointer border-gray-500 hover:bg-gray-100">
      Supprimer
    </a>
  </div>
</x-account-layout>
