<section class="content-header">
    <h1>{{ $title }}</h1>
    <ol class="breadcrumb">
        @foreach($items as $item)
            <li class="{{ $item['active'] == TRUE ? 'active' : '' }}">
                @if ($item['action'] != '')
                    <a href="{{ action($item['action'], isset($item['action_params']) ? $item['action_params'] : NULL) }}">{{ $item['title'] }}</a>
                @else
                    {{ $item['title'] }}
                @endif
            </li>
        @endforeach
    </ol>
</section>