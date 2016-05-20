@extends('admin.layout.master')

@section('top_content')
    @include('admin.layout._partials.breadcrumbs', [
                'title' => 'Начало работы',
                'items' => [
                        [ 'title' => 'Начало работы', 'action' => 'Admin\DashboardController@index', 'active' => TRUE ],
                ]
            ])
@stop

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Добро пожаловать!</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            Вы попали в панель управления сайтом. В меню слева вы найдёте всё для редактирования его содержимого.
        </div><!-- /.box-body -->
        <div class="box-footer">

        </div><!-- /.box-footer-->
    </div><!-- /.box -->
@stop