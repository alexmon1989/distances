@extends('marketing.layout.master')

@section('page_title')
{{ Lang::get('pages.distances.calculation_distance_from') }} {{ $genitiveFromCity }} {{ Lang::get('pages.distances.to') }} {{ $dativeToCity }}
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>{{ Lang::get('pages.distances.distance') }} {{ $targets->first()->name }} - {{ $targets->last()->name }}</h1>

            <div class="margin-top-20">
                @include('marketing.home._partials.form')
            </div>
        </div>
    </div>

    <div class="row margin-top-20">
        <div class="col-md-8">
            @for($i = 0; $i < $targets->count() - 1; $i++)
                <h2>
                {{ $i + 1 }}. {{ Lang::get('pages.distances.distance') }}
                <a href="{{ route('cities_show', ['country' => $targets[$i]->country->code, 'city' => $targets[$i]->code]) }}">{{ $targets[$i]->name }}</a>
                -
                <a href="{{ route('cities_show', ['country' => $targets[$i+1]->country->code, 'city' => $targets[$i+1]->code]) }}">{{ $targets[$i+1]->name }}</a>
                </h2>
                <p>{{ Lang::get('pages.distances.distance') }}: <span class="text-bold distance_{{ $i }}"></span></p>
                <p>{{ Lang::get('pages.distances.time_in_path') }}: <span class="text-bold duration_{{ $i }}"></span></p>
            @endfor
        </div>

        <div class="col-md-4">
            @foreach($weathers as $weather)
            <div class="panel panel-blue">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-sun-o"></i> {{ Lang::get('pages.distances.weather_in') }} <strong>{{ $weather['city_name'] }}</strong></h3>
                </div>
                <div class="panel-body">
                    @if($weather['weather'])
                    <dl class="dl-horizontal">
                        <dt>{{ Lang::get('pages.distances.sky') }}:</dt>
                        <dd>{{ $weather['weather']->weather }}</dd>
                        <dt>{{ Lang::get('pages.distances.temperature') }}:</dt>
                        <dd>{{ (int) $weather['weather']->temperature->getValue() . ' ' . $weather['weather']->temperature->getUnit() }}</dd>
                        <dt>{{ Lang::get('pages.distances.wind_speed') }}:</dt>
                        <dd>{{ (int) $weather['weather']->wind->speed->getValue() }} {{ Lang::get('pages.distances.m_s') }}</dd>
                        <dt>{{ Lang::get('pages.distances.pressure') }}:</dt>
                        <dd>{{ (int) ($weather['weather']->pressure->getValue() / 1.333) }} {{ Lang::get('pages.distances.mmhg') }}</dd>
                        <dt>{{ Lang::get('pages.distances.humidity') }}:</dt>
                        <dd>{{ $weather['weather']->humidity }}</dd>
                    </dl>
                    @else
                        <p class="text-center">{{ Lang::get('pages.distances.weather_error') }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="row margin-top-20">
        <div class="col-md-12">
            <h3>{{ Lang::get('pages.distances.map') }}</h3>
            @include('marketing.distances._partials.map')
        </div>
    </div>

    @if($anotherCitiesFirst->count() > 0 || $anotherCitiesLast->count() > 0)
    <div class="row margin-top-20">
        <div class="col-md-12">
            <h2>{{ Lang::get('pages.distances.distance_between_another') }}</h2>

            <div class="row">
                <div class="col-md-6">
                    <ul class="list-unstyled another-cities">
                        @foreach($anotherCitiesFirst as $anotherCity)
                            <li>
                                <a href="{{ route('distances_index', ['targets' => [$targets->first()->name . ' (' . $targets->first()->country->name . ')', $anotherCity->name . ' (' . $anotherCity->country->name . ')']]) }}">{{ $targets->first()->name }} - {{ $anotherCity->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled another-cities">
                        @foreach($anotherCitiesLast as $anotherCity)
                            <li><a href="{{ route('distances_index', ['targets' => [$anotherCity->name . ' (' . $anotherCity->country->name . ')', $targets->last()->name . ' (' . $targets->last()->country->name . ')']]) }}">{{ $anotherCity->name }} - {{ $targets->last()->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
    @endif
@stop

@section('scripts')
    <script src="{{ asset('assets/plugins/bootstrap3-typeahead/bootstrap3-typeahead.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/index.js') }}"></script>
    <script src="{{ asset('assets/js/pages/page_distance.js') }}"></script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{ Memory::get('GOOGLE_MAPS_API_KEY', env('GOOGLE_MAPS_API_KEY', 'AIzaSyC8Mxed4trkdkkJjucBbf376lMhYRxIVdE')) }}">
    </script>
    <script>
        jQuery(document).ready(function() {
            // Инициализация формы
            var itemTitle = '{{ Lang::get('pages.index.form_label') }}';
            var locale = '{{ App::getLocale() }}';
            Index.initForm({{ $targets->count() + 1 }}, locale, itemTitle);

            // Инициализация Google Maps
            var origin = '{{ $targets->first()->code }}, {{ $targets->first()->country->code }}';
            var destination = '{{ $targets->last()->code }}, {{ $targets->last()->country->code }}';
            var waypoints = [];
            @foreach($wayPoints as $wayPoint)
            waypoints.push({
                        location: '{{ $wayPoint->code }}',
                        stopover: true
                    });
            @endforeach
            Distance.initMap(origin, destination, waypoints);
        });
    </script>

@stop

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') }}">
    <!--[if lt IE 9]><link rel="stylesheet" href="assets/plugins/sky-forms-pro/skyforms/css/sky-forms-ie8.css') }}"><![endif]-->
@stop