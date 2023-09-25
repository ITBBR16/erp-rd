@extends('gudang.layouts.main')

@section('container')
    <div class="flex flex-row justify-between items-center border-b border-gray-400 py-3">
        <div class="flex flex-col my-5 w-2/3">
            <div class="flex flex-row">
                <a href="/gudang/quality-control" class="w-5 mr-3">
                    <span class="material-symbols-outlined text-red-500">arrow_back</span>
                </a>
                <div class="font-semibold mr-4 text-xl text-black">ORDER ID : N.666</div>
            </div>
        </div>
    </div>
    <div class="flex flex-row h-full py-6 relative overflow-auto">
        <div id="" class="text-sm lg:text-lg overflow-y-auto space-y-5 px-0 w-2/3 sm:w-3/4">
            <div class="space-y-5">
                <div class="text-base lg:text-lg">
                    <span class="font-semibold">Detail Order</span>
                </div>
                <div class="flex gap-y-5 flex-row flex-wrap">
                    <span>Ini Nanti form input</span>
                </div>
            </div>
        </div>
        <div class="w-1/6 sm:w-1/4 pl-8 text-sm lg:text-lg border-l overflow-y-auto h-full pb-20 border-gray-300 space-y-5">
            ini nanti keterangan supp tgl dll
        </div>
    </div>
@endsection