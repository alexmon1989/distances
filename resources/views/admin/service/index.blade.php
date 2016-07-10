@extends('admin.layout.master')

@section('top_content')
    @include('admin.layout._partials.breadcrumbs', [
                'title' => 'Сервис',
                'items' => [
                        [ 'title' => 'Начало работы', 'action' => 'Admin\DashboardController@index', 'active' => FALSE ],
                        [ 'title' => 'Сервис', 'action' => '', 'active' => FALSE ],
                ]
            ])
@stop

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Сервис</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <p><button class="btn btn-primary" type="button" id="clear-doubles">Очистка дублей городов (Россия)</button>
            <img id="loading-spinner" style="display: none" width="40" src="{{ asset('assets/img/loading_spinner.gif') }}" alt="">
            (последний раз: <strong id="clear-doubles-date">{{ $lastClearDoubles ? date('d.m.Y H:i:s', strtotime($lastClearDoubles)) : 'никогда' }}</strong>)</p>
            <p style="display: none" class="text-green" id="success-block">Text green to emphasize success</p>
            <p style="display: none" class="text-red" id="error-block">Text red to emphasize danger</p>
        </div><!-- /.box-body -->
        <div class="box-footer">

        </div><!-- /.box-footer-->
    </div><!-- /.box -->
@stop