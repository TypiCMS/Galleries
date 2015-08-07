    @foreach ($model->galleries as $gallery)
    <div class="gallery">
        @if($gallery->title)
        <h3>{{ $gallery->title }}</h3>
        @endif
        {!! $gallery->present()->body !!}
        @include('galleries::public._thumbs', ['model' => $gallery])
    </div>
    @endforeach
