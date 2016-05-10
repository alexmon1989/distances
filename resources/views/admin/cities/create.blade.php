@extends('admin.layout.master')

@section('top_content')
@include('admin.layout._partials.breadcrumbs', [
            'title' => 'Редактирование страницы "Список городов"',
            'items' => [
                    [ 'title' => 'Начало работы', 'action' => 'Admin\DashboardController@index', 'active' => FALSE ],
                    [ 'title' => 'Редактирование страницы "Список городов"', 'action' => '', 'active' => FALSE ],
                    [ 'title' => 'Создание города в стране ' . $country->name, 'action' => '', 'active' => TRUE ],
            ]
        ])
@stop

@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Создание города в стране {{ $country->name }}</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        @include('admin.cities._partials.form')
    </div><!-- /.box-body -->
    <div class="box-footer">
        <a href="{{ route('cities.index', ['country' => $country]) }}">Назад ко всем городам</a>
    </div><!-- /.box-footer-->
</div><!-- /.box -->
@stop