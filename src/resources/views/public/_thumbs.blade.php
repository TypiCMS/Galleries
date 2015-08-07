@if ($model->files->count())
    <div class="row">
    @foreach ($model->files as $file)
        <div class="col-xs-6 col-sm-4 col-md-3">
            @if ($file->type == 'i')
            <a class="fancybox" href="{{ asset($file->path . '/' . $file->file) }}" data-fancybox-group="{{ $model->name }}">
                {!! $file->present()->thumb(370, 370, array(), 'file') !!}
            </a>
            @else
            <a class="file" href="{{ asset($file->path . '/' . $file->file) }}" target="_blank">
                <span class="icon fa fa-file-o fa-2x"></span>
                <span class="filename">{{ $file->file }}</span>
            </a>
            @endif
        </div>
    @endforeach
    </div>
@endif
