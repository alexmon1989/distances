@extends('marketing.layout.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>{{ $city->name }}</h1>
            <p><a href="{{ route('cities_index') }}">{{ Lang::get('pages.cities.back') }}</a></p>

            <div class="row">
                <div class="col-md-6">
                    <ul class="list-unstyled another-cities">
                    @foreach($anotherCities as $anotherCity)
                        <li><a href="{{ route('distances_index', ['targets' => [$city->name, $anotherCity->name]]) }}">{{ Lang::get('pages.cities.distance') }} {{ $city->name }} - {{ $anotherCity->name }}</a></li>
                    @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled another-cities">
                    @foreach($anotherCities as $anotherCity)
                        <li><a href="{{ route('distances_index', ['targets' => [$anotherCity->name, $city->name]]) }}">{{ Lang::get('pages.cities.distance') }} {{ $anotherCity->name }} - {{ $city->name }}</a></li>
                    @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
@stop