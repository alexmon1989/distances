@extends('admin.layout.master')

@section('top_content')
    @include('admin.layout._partials.breadcrumbs', [
                'title' => 'Настройки сайта',
                'items' => [
                        [ 'title' => 'Начало работы', 'action' => 'Admin\DashboardController@index', 'active' => FALSE ],
                        [ 'title' => 'Настройки сайта', 'action' => '', 'active' => FALSE ],
                ]
            ])
@stop

@section('content')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab_1" aria-expanded="true">Настройки сайта</a></li>
            <li class=""><a data-toggle="tab" href="#tab_2" aria-expanded="false">Настройки калькулятора</a></li>
            <li class=""><a data-toggle="tab" href="#tab_3" aria-expanded="false">Настройки title, description</a></li>
        </ul>
        <div class="tab-content">
            <div id="tab_1" class="tab-pane active">
                @include('admin.settings._partials.form_site_settings')
            </div>
            <!-- /.tab-pane -->

            <div id="tab_2" class="tab-pane">
                @include('admin.settings._partials.form_calculator_settings')
            </div>
            <!-- /.tab-pane -->

            <div id="tab_3" class="tab-pane">
                @include('admin.settings._partials.form_title_description_settings')
            </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
    </div>
@stop