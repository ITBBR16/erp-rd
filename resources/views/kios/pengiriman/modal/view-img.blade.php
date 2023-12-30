@foreach ($dataIncoming as $item)
    <div id="view-img-penerimaan{{ $item->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        @foreach ($item->penerimaan as $prm)
            @php
                preg_match('/\/file\/d\/(.*?)\/view/', $prm->link_img, $matches);
                $fileId = isset($matches[1]) ? $matches[1] : null;
            @endphp
            <iframe src="https://drive.google.com/file/d/{{ $fileId }}/preview" class="absolute" frameborder="0"></iframe>
        @endforeach
    </div>
    
@endforeach