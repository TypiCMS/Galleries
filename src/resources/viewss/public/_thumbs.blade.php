@if ($model->files->count())
    <div class="row">
    @foreach ($model->files as $image)
        <div class="col-xs-4 col-sm-3 col-md-2">
            <div class="thumbnail">
                <a class="fancybox" href="{{ asset($image->path . $image->file) }}" data-fancybox-group="{{ $model->slug }}">
                    {!! $image->present()->thumb(200, 200, array(), 'file') !!}
                </a>
            </div>
        </div>
    @endforeach
    </div>
@endif
