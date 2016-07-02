{{ Form::open(['method' => 'post', 'autocomplete' => 'off']) }}
    {{ Form::token() }}
    <div class="box-body">

        <div class="form-group">
            <label>Единица расстояния по умолчанию</label>
            <select class="form-control" name="DEFAULT_DISTANCE_UNIT">
                <option value="kilometer" {{ old('DEFAULT_DISTANCE_UNIT', isset($settings) ? $settings['DEFAULT_DISTANCE_UNIT'] : 'kilometer') == 'kilometer' ? 'selected' : '' }}>Километр</option>
                <option value="mile" {{ old('DEFAULT_DISTANCE_UNIT', isset($settings) ? $settings['DEFAULT_DISTANCE_UNIT'] : 'kilometer') == 'mile' ? 'selected' : ''}}>Миля</option>
            </select>
        </div>

        <div class="form-group">
            <label>Единица объёма</label>
            <select class="form-control" name="DEFAULT_VOLUME_UNIT">
                <option value="liter" {{ old('DEFAULT_VOLUME_UNIT', isset($settings) ? $settings['DEFAULT_VOLUME_UNIT'] : 'liter') == 'liter' ? 'selected' : '' }}>Литр</option>
                <option value="us_gallon" {{ old('DEFAULT_VOLUME_UNIT', isset($settings) ? $settings['DEFAULT_VOLUME_UNIT'] == 'us_gallon' : 'liter')  ? 'selected' : '' }}>Американский галлон</option>
                <option value="imp_gallon" {{ old('DEFAULT_VOLUME_UNIT', isset($settings) ? $settings['DEFAULT_VOLUME_UNIT'] == 'imp_gallon' : 'liter') ? 'selected' : '' }}>Английский галлон</option>
            </select>
        </div>

        <div class="form-group">
            <label for="DEFAULT_FUEL_CONSUMPTION">Расход топлива на 100 единиц расстояния</label>
            <input type="text" placeholder="Расход топлива на 100 единиц расстояния" id="DEFAULT_FUEL_CONSUMPTION" name="DEFAULT_FUEL_CONSUMPTION" class="form-control" value="{{ old('DEFAULT_FUEL_CONSUMPTION', isset($settings) ? $settings['DEFAULT_FUEL_CONSUMPTION'] : '') }}">
        </div>

        <div class="form-group">
            <label for="DEFAULT_FUEL_COST">Стоимость 1 единицы объёма топлива</label>
            <input type="text" placeholder="Стоимость 1 единицы объёма топлива" id="DEFAULT_FUEL_COST" name="DEFAULT_FUEL_COST" class="form-control" value="{{ old('DEFAULT_FUEL_COST', isset($settings) ? $settings['DEFAULT_FUEL_COST'] : '') }}">
        </div>

        <div class="form-group">
            <label for="DEFAULT_CURRENCY">Код валюты</label>
            <input type="text" placeholder="Код валюты" id="DEFAULT_CURRENCY" name="DEFAULT_CURRENCY" class="form-control" value="{{ old('DEFAULT_CURRENCY', isset($settings) ? $settings['DEFAULT_CURRENCY'] : '') }}">
            <p class="help-block">Например: <strong>ruble, us_dollar, euro, uah</strong>.</p>
        </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить</button>
    </div>
{{ Form::close() }}