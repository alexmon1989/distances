{{ Form::open(['method' => 'post', 'autocomplete' => 'off']) }}
    {{ Form::token() }}
    <div class="box-body">
        <div class="callout callout-info">
            <h4>Иноформация!</h4>

            <p>Переменные городов указывайте как <strong>:city1</strong>, <strong>:city2</strong>.</p>
        </div>

        @foreach(['RU' => 'рус.', 'EN' => 'англ.', 'UK' => 'укр.', 'PL' => 'польск.'] as $key => $value)
        <div class="form-group">
            <label for="DISTANCES_PAGE_TITLE_{{ $key }}">Title страницы мершрута ({{ $value }})</label>
            <input type="text" placeholder="Title страницы мершрута ({{ $value }})" id="DISTANCES_PAGE_TITLE_{{ $key }}" name="DISTANCES_PAGE_TITLE_{{ $key }}" class="form-control" value="{{ old('DISTANCES_PAGE_TITLE_'.$key, isset($settings) ? $settings['DISTANCES_PAGE_TITLE_'.$key] : '') }}">
        </div>

        <div class="form-group">
            <label for="DISTANCES_PAGE_DESCRIPTION_{{ $key }}">Description страницы мершрута ({{ $value }})</label>
            <input type="text" placeholder="Description страницы мершрута ({{ $value }})" id="DISTANCES_PAGE_DESCRIPTION_{{ $key }}" name="DISTANCES_PAGE_DESCRIPTION_{{ $key }}" class="form-control" value="{{ old('DISTANCES_PAGE_DESCRIPTION_'.$key, isset($settings) ? $settings['DISTANCES_PAGE_DESCRIPTION_'.$key] : '') }}">
        </div>

        <br/>
        @endforeach
    </div><!-- /.box-body -->

    <div class="box-footer">
        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить</button>
    </div>
{{ Form::close() }}