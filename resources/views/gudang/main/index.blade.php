@extends('gudang.layouts.main')

@section('container')
    <div class="grid grid-cols-2 gap-8 mb-8">
        <div class="flex text-3xl font-bold text-gray-700">
            Dashboard
        </div>
    </div>
    <div>
        <div></div>
    </div>
    <div class="border border-gray-300 rounded-lg p-4 overflow-hidden my-4">
        <div class="text-gray-500 font-semibold text-lg mb-4">Status</div>
        <div class="grid grid-cols-4 gap-4 mb-4">
            <div class="flex flex-nowrap items-center">
                <p>Total</p>
            </div>
            <div class="flex items-center">
                <p>Battery</p>
            </div>
            <div class="flex items-center">
                <p>Kios</p>
            </div>
            <div class="flex items-center">
                <p>Repair</p>
            </div>
        </div>
    </div>
@endsection