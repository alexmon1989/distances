{{ Form::open(['method' => 'post', 'autocomplete' => 'off']) }}
    {{ Form::token() }}
    <div class="box-body">

        <div class="form-group">
            <label for="OPENWEATHER_API_KEY">Ключ OpenWeather Api</label>
            <input type="text" placeholder="Ключ Google Maps Api" id="OPENWEATHER_API_KEY" name="OPENWEATHER_API_KEY" class="form-control" value="{{ old('OPENWEATHER_API_KEY', isset($settings) ? $settings['OPENWEATHER_API_KEY'] : '') }}">
        </div>

        <div class="form-group">
            <label for="GOOGLE_MAPS_API_KEY">Ключ Google Maps Api</label>
            <input type="text" placeholder="Ключ Google Maps Api" id="GOOGLE_MAPS_API_KEY" name="GOOGLE_MAPS_API_KEY" class="form-control" value="{{ old('GOOGLE_MAPS_API_KEY', isset($settings) ? $settings['GOOGLE_MAPS_API_KEY'] : '') }}">
        </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить</button>
    </div>
{{ Form::close() }}