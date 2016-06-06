@if(isset($city))
{{ Form::open(['route' => ['cities.postedit', $country, $city], 'method' => 'post', 'autocomplete' => 'off']) }}
@else
{{ Form::open(['method' => 'post', 'autocomplete' => 'off']) }}
@endif
    {{ Form::token() }}
    <div class="box-body">
        <div class="form-group">
            <label for="code">Код</label>
            <input type="text" placeholder="Код" id="code" name="code" class="form-control" value="{{ old('code', isset($city) ? $city->code : '') }}">
            <p class="help-block">Например: <strong>moscow, new-york</strong>.</p>
        </div>

        <div class="form-group">
            <label for="name_ru">Название (рус.)</label>
            <input type="text" placeholder="Название (рус.)" id="name_ru" name="name_ru" class="form-control" value="{{ old('name_ru', isset($city) ? $city->translate('ru')->name : '') }}">
        </div>
        <div class="form-group">
            <label for="name_en">Название (англ.)</label>
            <input type="text" placeholder="Название (англ.)" id="name_en" name="name_en" class="form-control" value="{{ old('name_en', isset($city) ? $city->translate('en')->name : '') }}">
        </div>
        <div class="form-group">
            <label for="name_en">Название (укр.)</label>
            <input type="text" placeholder="Название (укр.)" id="name_uk" name="name_uk" class="form-control" value="{{ old('name_uk', isset($city) ? $city->translate('uk')->name : '') }}">
        </div>
        <div class="form-group">
            <label for="name_en">Название (польск.)</label>
            <input type="text" placeholder="Название (польск.)" id="name_pl" name="name_pl" class="form-control" value="{{ old('name_pl', isset($city) ? $city->translate('pl')->name : '') }}">
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="is_enabled" value="1" {{ old('is_enabled', isset($city) ? $city->is_enabled : 0) == 1 ? 'checked=""' : ''  }}> Включено
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="is_offer" value="1" {{ old('is_offer', isset($city) ? $city->is_offer : 0) == 1 ? 'checked=""' : ''  }}> Показывать в предложениях
            </label>
        </div>
    </div><!-- /.box-body -->

    <div class="box-footer">
        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить</button>
    </div>
{{ Form::close() }}