@extends('admin.layout.master')

@section('top_content')
    @include('admin.layout._partials.breadcrumbs', [
                'title' => 'Редактирование страницы',
                'items' => [
                        [ 'title' => 'Начало работы', 'action' => 'Admin\DashboardController@index', 'active' => FALSE ],
                ]
            ])
@stop

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Внесите необходимые правки</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            @include('admin.pages._partials.form')
        </div><!-- /.box-body -->
        <div class="box-footer">

        </div><!-- /.box-footer-->
    </div><!-- /.box -->
@stop

@section('script')
<!-- CKEDITOR -->
<script src="{{ asset('assets/plugins/adminlte/plugins/ckeditor/ckeditor.js') }}"></script>
@stop