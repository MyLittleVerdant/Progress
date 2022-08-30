<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    @if (count($breadcrumbs))
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && !$loop->last)
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ $breadcrumb->url }}" class="nav-link">{{ $breadcrumb->title }}</a>
                </li>
            @else
                <li class="nav-item d-none d-sm-inline-block">
                    <span class="nav-link active">{{ $breadcrumb->title }}</span>
                </li>
            @endif
        @endforeach
    @endif
</ul>
