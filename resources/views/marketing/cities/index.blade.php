@extends('marketing.layout.master')

@section('meta')
@if(Request::get('page') > 1)
<meta name="robots" content="noindex">
@endif
@stop

@section('page_title')
{{ Lang::get('pages.cities.list') }} - {{ $country->name }}
@stop

@section('content')
    <div class="row margin-bottom-15">
        <div class="col-md-12">
            <h1>{{ Lang::get('pages.cities.list') }} - {{ $country->name }}</h1>
        </div>
    </div>

    @for($i = 0; $i < count($cities); $i = $i + 3)
        <div class="row">
            <div class="col-md-4">
                @if(isset($cities[$i]))
                <p class="lead"><a href="{{ route('cities_show', ['country' => $country->code, 'code' => $cities[$i]->code]) }}">{{ $cities[$i]->name }}</a></p>
                @endif
            </div>
            <div class="col-md-4">
                @if(isset($cities[$i+1]))
                <p class="lead"><a href="{{ route('cities_show', ['country' => $country->code, 'code' => $cities[$i+1]->code]) }}">{{ $cities[$i+1]->name }}</a></p>
                @endif
            </div>
            <div class="col-md-4">
                @if(isset($cities[$i+2]))
                <p class="lead"><a href="{{ route('cities_show', ['country' => $country->code, 'code' => $cities[$i+2]->code]) }}">{{ $cities[$i+2]->name }}</a></p>
                @endif
            </div>
        </div>
    @endfor

    <div class="text-center">{{ $cities->links() }}</div>
@stop