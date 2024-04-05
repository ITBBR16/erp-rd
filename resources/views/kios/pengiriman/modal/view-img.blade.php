@foreach ($dataIncoming as $item)
    <div id="view-img-penerimaan{{ $item->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        @foreach ($item->penerimaan as $prm)
            <div class="flex items-center justify-center w-full max-w-md">
                @php
                    $imageLink = $prm->link_img_paket ?? "";
                    preg_match('/\/file\/d\/(.*?)\/view/', $imageLink, $matches);
                    $fileId = isset($matches[1]) ? $matches[1] : null;
                @endphp
                @if (!empty($imageLink))
                    <img src="https://drive.google.com/thumbnail?id={{ $fileId }}" class="max-w-4xl" alt="File Paket" loading="lazy">
                @endif
            </div>
        @endforeach
    </div>
@endforeach
