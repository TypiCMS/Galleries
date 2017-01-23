<ul class="galleries-list">
    @foreach ($items as $gallery)
    @include('galleries::public._list-item')
    @endforeach
</ul>
