@extends('admin.layout.master')

@section('top_content')
@include('admin.layout._partials.breadcrumbs', [
            'title' => 'Список пользователей (администраторов)',
            'items' => [
                    [ 'title' => 'Начало работы', 'action' => 'Admin\DashboardController@index', 'active' => FALSE ],
                    [ 'title' => 'Список пользователей (администраторов)', 'action' => 'Admin\Auth\AuthController@getList', 'active' => FALSE ],
                    [ 'title' => 'Редактирование пользователя', 'action' => '', 'active' => TRUE ],
            ]
        ])
@stop

@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Редактирование пользователя</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        @include('admin.auth._form')
    </div><!-- /.box-body -->
    <div class="box-footer">
        <a href="{{ route('users') }}">Назад ко всем пользователям</a>
    </div><!-- /.box-footer-->
</div><!-- /.box -->
@stop