{{ Form::open(['method' => 'post', 'autocomplete' => 'off']) }}
    {{ Form::token() }}
    <div class="box-body">
        <div class="callout callout-info">
            <h4>Иноформация!</h4>

            <p>Переменные городов указывайте как <strong>:city1</strong>, <strong>:city2</strong>, а расстояния - <strong>:km, :mi</strong>.</p>
        </div>

        @foreach(['RU' => 'рус.', 'EN' => 'англ.', 'UK' => 'укр.', 'PL' => 'польск.', 'IT' => 'итал.', 'FR' => 'франц.'] as $key => $value)
        <div class="form-group">
            <label for="DISTANCES_PAGE_TITLE_{{ $key }}">Title страницы маршрута ({{ $value }})</label>
            <input type="text" placeholder="Title страницы мершрута ({{ $value }})" id="DISTANCES_PAGE_TITLE_{{ $key }}" name="DISTANCES_PAGE_TITLE_{{ $key }}" class="form-control" value="{{ old('DISTANCES_PAGE_TITLE_'.$key, isset($settings) ? $settings['DISTANCES_PAGE_TITLE_'.$key] : '') }}">
        </div>

        <div class="form-group">
            <label for="DISTANCES_PAGE_DESCRIPTION_{{ $key }}">Description страницы маршрута ({{ $value }})</label>
            <input type="text" placeholder="Description страницы мершрута ({{ $value }})" id="DISTANCES_PAGE_DESCRIPTION_{{ $key }}" name="DISTANCES_PAGE_DESCRIPTION_{{ $key }}" class="form-control" value="{{ old('DISTANCES_PAGE_DESCRIPTION_'.$key, isset($settings) ? $settings['DISTANCES_PAGE_DESCRIPTION_'.$key] : '') }}">
        </div>

        <div class="form-group">
            <label for="DISTANCES_PAGE_TEXT_{{ $key }}">Текстовый блок на странице маршрута ({{ $value }})</label>
            <textarea class="form-control" name="DISTANCES_PAGE_TEXT_{{ $key }}" id="DISTANCES_PAGE_TEXT_{{ $key }}" cols="30" rows="3">{{ old('DISTANCES_PAGE_DESCRIPTION_'.$key, isset($settings) ? $settings['DISTANCES_PAGE_TEXT_'.$key] : '') }}</textarea>
        </div>

        @if ($key == 'RU')
        <div class="form-group">
            <label for="CITY1_CASE">Падеж :city1</label>
            <select class="form-control" name="DISTANCES_CITY1_CASE" id="DISTANCES_CITY1_CASE">
                <option value="ИМ" {{ old('DISTANCES_CITY1_CASE', isset($settings['DISTANCES_CITY1_CASE']) ? $settings['DISTANCES_CITY1_CASE'] : '') == 'ИМ' ? 'selected' : '' }}>Именительный</option>
                <option value="РД" {{ old('DISTANCES_CITY1_CASE', isset($settings['DISTANCES_CITY1_CASE']) ? $settings['DISTANCES_CITY1_CASE'] : '') == 'РД' ? 'selected' : '' }}>Родительный</option>
                <option value="ВН" {{ old('DISTANCES_CITY1_CASE', isset($settings['DISTANCES_CITY1_CASE']) ? $settings['DISTANCES_CITY1_CASE'] : '') == 'ВН' ? 'selected' : '' }}>Винительный</option>
                <option value="ДТ" {{ old('DISTANCES_CITY1_CASE', isset($settings['DISTANCES_CITY1_CASE']) ? $settings['DISTANCES_CITY1_CASE'] : '') == 'ДТ' ? 'selected' : '' }}>Дательный</option>
                <option value="ТВ" {{ old('DISTANCES_CITY1_CASE', isset($settings['DISTANCES_CITY1_CASE']) ? $settings['DISTANCES_CITY1_CASE'] : '') == 'ТВ' ? 'selected' : '' }}>Творительный</option>
                <option value="ПР" {{ old('DISTANCES_CITY1_CASE', isset($settings['DISTANCES_CITY1_CASE']) ? $settings['DISTANCES_CITY1_CASE'] : '') == 'ПР' ? 'selected' : '' }}>Предложный</option>
            </select>
        </div>

         <div class="form-group">
            <label for="CITY2_CASE">Падеж :city2</label>
            <select class="form-control" name="DISTANCES_CITY2_CASE" id="DISTANCES_CITY2_CASE">
                <option value="ИМ" {{ old('DISTANCES_CITY2_CASE', isset($settings['DISTANCES_CITY2_CASE']) ? $settings['DISTANCES_CITY2_CASE'] : '') == 'ИМ' ? 'selected' : '' }}>Именительный</option>
                <option value="РД" {{ old('DISTANCES_CITY2_CASE', isset($settings['DISTANCES_CITY2_CASE']) ? $settings['DISTANCES_CITY2_CASE'] : '') == 'РД' ? 'selected' : '' }}>Родительный</option>
                <option value="ВН" {{ old('DISTANCES_CITY2_CASE', isset($settings['DISTANCES_CITY2_CASE']) ? $settings['DISTANCES_CITY2_CASE'] : '') == 'ВН' ? 'selected' : '' }}>Винительный</option>
                <option value="ДТ" {{ old('DISTANCES_CITY2_CASE', isset($settings['DISTANCES_CITY2_CASE']) ? $settings['DISTANCES_CITY2_CASE'] : '') == 'ДТ' ? 'selected' : '' }}>Дательный</option>
                <option value="ТВ" {{ old('DISTANCES_CITY2_CASE', isset($settings['DISTANCES_CITY2_CASE']) ? $settings['DISTANCES_CITY2_CASE'] : '') == 'ТВ' ? 'selected' : '' }}>Творительный</option>
                <option value="ПР" {{ old('DISTANCES_CITY2_CASE', isset($settings['DISTANCES_CITY2_CASE']) ? $settings['DISTANCES_CITY2_CASE'] : '') == 'ПР' ? 'selected' : '' }}>Предложный</option>
            </select>
         </div>
        @endif

        <br/>
        @endforeach
    </div><!-- /.box-body -->

    <div class="box-footer">
        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить</button>
    </div>
{{ Form::close() }}