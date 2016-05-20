@extends('marketing.layout.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>{{ $article['title'] }}</h1>
            {!! $article['full_text'] !!}

            <div class="margin-top-20">
                @if (count($errors) > 0)
                <div class="alert alert-danger fade in">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4>{{ Lang::get('pages.index.error') }}!</h4>
                    @foreach ($errors->all() as $error)
                        <p>{!! $error !!}</p>
                    @endforeach
                </div>
                @endif

                @include('marketing.home._partials.form')
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ asset('assets/plugins/bootstrap3-typeahead/bootstrap3-typeahead.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/index.js') }}"></script>
    <script>
        jQuery(document).ready(function() {
            var itemTitle = '{{ Lang::get('pages.index.form_label') }}';
            var locale = '{{ App::getLocale() }}';
            <?php $c = count(Request::old('targets')); ?>
            Index.initForm({{ $c > 0 ? ($c + 1) : 3 }}, locale, itemTitle);
        });
    </script>
@stop

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') }}">
<!--[if lt IE 9]><link rel="stylesheet" href="assets/plugins/sky-forms-pro/skyforms/css/sky-forms-ie8.css') }}"><![endif]-->
@stop