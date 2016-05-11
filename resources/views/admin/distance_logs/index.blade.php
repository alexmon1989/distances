@extends('admin.layout.master')

@section('top_content')
    @include('admin.layout._partials.breadcrumbs', [
                'title' => 'Лог запросов',
                'items' => [
                        [ 'title' => 'Начало работы', 'action' => 'Admin\DashboardController@index', 'active' => FALSE ],
                        [ 'title' => 'Лог запросов', 'action' => '', 'active' => TRUE ],
                ]
            ])
@stop

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Лог запросов</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <table id="data" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th width="7%">ID</th>
                    <th>Маршрут</th>
                    <th>Создано</th>
                    <th width="7%">Действия</th>
                </tr>
                </thead>

                <tbody>
                @foreach($logs as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->route }}</td>
                        <td>{{ date('d.m.Y H:i:s', strtotime($item->created_at)) }}</td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-danger btn-sm item-delete" href="{{ route('distance-logs.delete', ['id' => $item->id]) }}" title="Удалить"><i class="fa fa-remove"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div><!-- /.box-body -->
        <div class="box-footer">

        </div><!-- /.box-footer-->
    </div><!-- /.box -->
@stop