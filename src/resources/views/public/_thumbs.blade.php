@if ($model->files->count())
    <ul class="gallery-list">
    @foreach ($model->files as $file)
        <li class="gallery-file">
            @if ($file->type == 'i')
            <a class="gallery-image fancybox" href="{!! $file->present()->thumbSrc(1200, 1200, array('resize'), 'file') !!}" data-fancybox-group="{{ $model->slug }}">
                <img class="gallery-image-thumb" src="{!! $file->present()->thumbSrc(370, 370, array(), 'file') !!}" alt="{{ $file->alt_attribute }}">
            </a>
            @else
            <a class="gallery-document" href="{{ asset($file->path . '/' . $file->file) }}" target="_blank">
                <span class="gallery-document-icon fa fa-file-o fa-3x"></span>
                <span class="gallery-document-filename">{{ $file->file }}</span> <small class="gallery-document-filesize">({{ $file->present()->filesize }})</small>
            </a>
            @endif
        </li>
    @endforeach
    </ul>
@endif
