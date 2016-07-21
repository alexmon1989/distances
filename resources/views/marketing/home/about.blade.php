@extends('marketing.layout.master')

@section('page_title')
{{ Lang::get('pages.about.title') }}
@stop

@section('page_description'){{ isset($article['description']) ? $article['description'] : '' }}@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>{{ $article['title'] }}</h1>
            {!! $article['full_text'] !!}
        </div>
    </div>
@stop