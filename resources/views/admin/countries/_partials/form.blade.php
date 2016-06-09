{{ Form::open(['method' => 'post', 'autocomplete' => 'off']) }}
    {{ Form::token() }}
    <div class="box-body">

        <div class="checkbox">
            <label>
                <input type="checkbox" name="is_enabled" value="1" {{ old('is_enabled', isset($country) ? $country->is_enabled : 0) == 1 ? 'checked=""' : ''  }}> Включено
            </label>
        </div>

        <div class="form-group">
            <label for="code">Код</label>
            <input type="text" placeholder="Код" id="code" name="code" class="form-control" value="{{ old('code', isset($country) ? $country->code : '') }}">
            <p class="help-block">Например: <strong>ru, usa</strong>.</p>
        </div>

        <div class="form-group">
            <label for="name_ru">Название (рус.)</label>
            <input type="text" placeholder="Название (рус.)" id="name_ru" name="name_ru" class="form-control" value="{{ old('name_ru', isset($country) ? $country->translate('ru')->name : '') }}">
        </div>
        <div class="form-group">
            <label for="name_en">Название (англ.)</label>
            <input type="text" placeholder="Название (англ.)" id="name_en" name="name_en" class="form-control" value="{{ old('name_en', isset($country) ? $country->translate('en')->name : '') }}">
        </div>
        <div class="form-group">
            <label for="name_en">Название (укр.)</label>
            <input type="text" placeholder="Название (укр.)" id="name_uk" name="name_uk" class="form-control" value="{{ old('name_uk', isset($country) ? $country->translate('uk')->name : '') }}">
        </div>
        <div class="form-group">
            <label for="name_en">Название (польск.)</label>
            <input type="text" placeholder="Название (польск.)" id="name_pl" name="name_pl" class="form-control" value="{{ old('name_pl', isset($country) ? $country->translate('pl')->name : '') }}">
        </div>

        <div class="callout callout-info">
            <h4><i class="icon fa fa-info"></i> Информация</h4>
            <p>Поля ниже предусмотрены для расчёта стоимости поездки постетелей сайта из этой страны.</p>
        </div>

        <div class="form-group">
            <label>Единица расстояния</label>
            <select class="form-control" name="distance_unit">
                <option value="kilometer" {{ old('distance_unit', isset($country) ? $country->distance_unit : 'kilometer') == 'kilometer' ? 'selected' : '' }}>Километр</option>
                <option value="mile" {{ old('distance_unit', isset($country) ? $country->distance_unit : 'kilometer') == 'mile' ? 'selected' : '' }}>Миля</option>
            </select>
        </div>

        <div class="form-group">
            <label>Единица объёма</label>
            <select class="form-control" name="volume_unit">
                <option value="liter" {{ old('volume_unit', isset($country) ? $country->volume_unit : 'liter') == 'liter' ? 'selected' : '' }}>Литр</option>
                <option value="us_gallon" {{ old('volume_unit', isset($country) ? $country->volume_unit : 'liter') == 'us_gallon' ? 'selected' : '' }}>Американский галлон</option>
                <option value="imp_gallon" {{ old('volume_unit', isset($country) ? $country->volume_unit : 'liter') == 'imp_gallon' ? 'selected' : '' }}>Английский галлон</option>
            </select>
        </div>

        <div class="form-group">
            <label for="fuel_consumption">Расход топлива на 100 единиц расстояния</label>
            <input type="text" placeholder="Расход топлива на 100 единиц расстояния" id="fuel_consumption" name="fuel_consumption" class="form-control" value="{{ old('fuel_consumption', isset($country) ? $country->fuel_consumption : '') }}">
        </div>

        <div class="form-group">
            <label for="fuel_cost">Стоимость 1 единицы объёма топлива</label>
            <input type="text" placeholder="Стоимость 1 единицы объёма топлива" id="fuel_cost" name="fuel_cost" class="form-control" value="{{ old('fuel_cost', isset($country) ? $country->fuel_cost : '') }}">
        </div>

        <div class="form-group">
            <label for="currency">Код валюты</label>
            <input type="text" placeholder="Код валюты" id="currency" name="currency" class="form-control" value="{{ old('currency', isset($country) ? $country->currency : '') }}">
            <p class="help-block">Например: <strong>ruble, us_dollar, euro, uah</strong>.</p>
        </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить</button>
    </div>
{{ Form::close() }}