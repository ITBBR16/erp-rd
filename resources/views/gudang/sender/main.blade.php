@extends('gudang.layouts.main')

@section('container')
    <div class="mb-4 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="senderTab" data-tabs-toggle="#senderTabContent" role="tablist">
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="part-tab" data-tabs-target="#part" type="button" role="tab" aria-controls="part" aria-selected="false">Sender Part</button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="battery-tab" data-tabs-target="#battery" type="button" role="tab" aria-controls="battery" aria-selected="false">Sender Batt</button>
            </li>
        </ul>
    </div>
    <div id="senderTabContent">
        @include('gudang.sender.send_part')
        @include('gudang.sender.send_batt')
    </div>
@endsection