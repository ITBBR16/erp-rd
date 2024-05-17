@extends('gudang.layouts.main')

@section('container')
    <div class="mb-4 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="qcTab" data-tabs-toggle="#qcTabContent" role="tablist">
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="qty-tab" data-tabs-target="#qty" type="button" role="tab" aria-controls="qty" aria-selected="false">Cek Quantity</button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="fisik-tab" data-tabs-target="#fisik" type="button" role="tab" aria-controls="fisik" aria-selected="false">Cek Fisik</button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="fungsional-tab" data-tabs-target="#fungsional" type="button" role="tab" aria-controls="fungsional" aria-selected="false">Cek Fungsional</button>
            </li>
        </ul>
    </div>
    <div id="qcTabContent">
        @include('gudang.checkpart.qc.cek_qty')
        @include('gudang.checkpart.qc.cek_fisik')
        @include('gudang.checkpart.qc.cek_fungsional')
    </div>
@endsection