<li class="galleries-item">
    <a class="galleries-item-link" href="{{ route($lang.'::gallery', $gallery->slug) }}">
        <div class="galleries-item-info">
            <div class="galleries-item-title">{{ $gallery->title }}</div>
            <div class="galleries-item-summary">{{ $gallery->summary }}</div>
        </div>
    </a>
</li>
