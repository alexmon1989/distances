@extends('marketing.layout.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>{{ $article['title'] }}</h1>
            {!! $article['full_text'] !!}
        </div>
    </div>
@stop