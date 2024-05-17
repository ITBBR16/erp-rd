@extends('gudang.layouts.main')

@section('container')
    <div class="mb-4 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="shopTab" data-tabs-toggle="#shopTabContent" role="tablist">
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="dbl-tab" data-tabs-target="#dbl" type="button" role="tab" aria-controls="dbl" aria-selected="false">Detail Belanja</button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="belanja-tab" data-tabs-target="#belanja" type="button" role="tab" aria-controls="belanja" aria-selected="false">Belanja Part</button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="additional-tab" data-tabs-target="#additional" type="button" role="tab" aria-controls="additional" aria-selected="false">Additional Payment</button>
            </li>
        </ul>
    </div>
    <div id="shopTabContent">
        @include('gudang.shop.belanja.detail_belanja')
        @include('gudang.shop.belanja.input_belanja')
        @include('gudang.shop.belanja.additional')
    </div>
@endsection