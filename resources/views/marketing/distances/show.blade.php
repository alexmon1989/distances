@extends('marketing.layout.master')

@section('page_title'){{ $pageTitle }}@stop

@section('page_description'){{ $pageDescription }}@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>{{ Lang::get('pages.distances.distance') }} {{ $targetsCollection->first()->name }} - {{ $targetsCollection->last()->name }}</h1>

            <div class="margin-top-20 noprint">
                @include('marketing.home._partials.form')
            </div>
        </div>
    </div>

    <div class="row margin-top-20">
        <div class="col-md-8">
            @for($i = 0; $i < $targetsCollection->count() - 1; $i++)
                <h2>
                {{ $i + 1 }}. {{ Lang::get('pages.distances.distance') }}
                <a href="{{ route('cities_show', ['country' => $targetsCollection[$i]->country->code, 'city' => $targetsCollection[$i]->code]) }}">{{ $targetsCollection[$i]->name }}</a>
                -
                <a href="{{ route('cities_show', ['country' => $targetsCollection[$i+1]->country->code, 'city' => $targetsCollection[$i+1]->code]) }}">{{ $targetsCollection[$i+1]->name }}</a>
                </h2>
                <p>{{ Lang::get('pages.distances.distance') }}: <span class="text-bold distance_{{ $i }}">-</span></p>
                <p>{{ Lang::get('pages.distances.time_in_path') }}: <span class="text-bold duration_{{ $i }}">-</span></p>
            @endfor
            <hr/>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-money"></i> {{ Lang::get('pages.distances.travel_cost') }}</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-5">{{ Lang::get('pages.distances.total_distance') }}:</div>
                        <div class="col-md-7"><strong id="total-distance">-</strong></div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">{{ Lang::get('pages.distances.fuel_required') }}:</div>
                        <div class="col-md-7"><strong id="total-fuel-count">-</strong></div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">{{ Lang::get('pages.distances.fuel_price_total') }}:</div>
                        <div class="col-md-7"><strong id="total-price">-</strong></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="help-block" id="total-price-message">&nbsp;</p>
                        </div>
                    </div>
                </div>
            </div>

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
            <h3 class="noprint">{{ Lang::get('pages.distances.map') }}</h3>
            @include('marketing.distances._partials.map')
        </div>
    </div>

    @if($anotherCitiesFirst->count() > 0 || $anotherCitiesLast->count() > 0)
    <div class="row margin-top-20 noprint">
        <div class="col-md-12">
            <h2>{{ Lang::get('pages.distances.distance_between_another') }}</h2>

            <div class="row">
                <div class="col-md-6">
                    <ul class="list-unstyled another-cities">
                        @foreach($anotherCitiesFirst as $anotherCity)
                            <li>
                                <a href="{{ route('distances_index', ['targets' => [$targetsCollection->first()->name . ' (' . $targetsCollection->first()->country->name . ')', $anotherCity->name . ' (' . $anotherCity->country->name . ')']]) }}">{{ $targetsCollection->first()->name }} - {{ $anotherCity->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled another-cities">
                        @foreach($anotherCitiesLast as $anotherCity)
                            <li><a href="{{ route('distances_index', ['targets' => [$anotherCity->name . ' (' . $anotherCity->country->name . ')', $targetsCollection->last()->name . ' (' . $targetsCollection->last()->country->name . ')']]) }}">{{ $anotherCity->name }} - {{ $targetsCollection->last()->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
    @endif

    <div class="row margin-top-20">
        <div id="disqus_thread"></div>
        <script>
            /**
             *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
             *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
             */

            var disqus_config = function () {
                //this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier = {{ $route->id }}; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                this.language = "{{ App::getLocale() }}";
            };

            (function() {  // DON'T EDIT BELOW THIS LINE
                var d = document, s = d.createElement('script');

                s.src = '//findmap365.disqus.com/embed.js';

                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
    </div>
@stop

@section('scripts')
    <script src="{{ asset('assets/plugins/bootstrap3-typeahead/bootstrap3-typeahead.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/index.js') }}"></script>
    <script src="{{ asset('assets/js/pages/page_distance.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?language={{ App::getLocale() }}&key={{ Memory::get('GOOGLE_MAPS_API_KEY', env('GOOGLE_MAPS_API_KEY', 'AIzaSyC8Mxed4trkdkkJjucBbf376lMhYRxIVdE')) }}"></script>
    <script src="{{ asset('assets/plugins/FullScreenControl.js') }}"></script>
    <script>
        jQuery(document).ready(function() {
            // Инициализация формы
            var itemTitle = '{{ Lang::get('pages.index.form_label') }}';
            var locale = '{{ App::getLocale() }}';
            Index.initForm({{ $targetsCollection->count() + 1 }}, locale, itemTitle);

            // Инициализация Google Maps
            var origin = '{{ $targetsCollection->first()->translate()->name }}, {{ $targetsCollection->first()->country->translate()->name }}';
            var destination = '{{ $targetsCollection->last()->translate()->name }}, {{ $targetsCollection->last()->country->translate()->name }}';
            var waypoints = [];
            @foreach($wayPoints as $wayPoint)
            waypoints.push({
                        location: '{{ $wayPoint->code }}',
                        stopover: true
                    });
            @endforeach
            var fullScreenTranslate = '{{ Lang::get('pages.distances.full_screen') }}';
            var fullScreenTranslateExit = '{{ Lang::get('pages.distances.full_screen_exit') }}';
            Distance.initMap(origin, destination, waypoints, locale, fullScreenTranslate, fullScreenTranslateExit);
        });
    </script>

@stop

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') }}">
    <!--[if lt IE 9]><link rel="stylesheet" href="assets/plugins/sky-forms-pro/skyforms/css/sky-forms-ie8.css') }}"><![endif]-->
@stop