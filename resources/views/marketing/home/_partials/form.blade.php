{!! Form::open(['method' => 'get', 'route' => 'distances_index', 'class' => 'sky-form', 'autocomplete' => 'off']) !!}
    <header>{{ Lang::get('pages.index.form_title') }}</header>

    <fieldset>

        <section>
            <label class="label">{{ Lang::get('pages.index.form_label') }} 1</label>
            <label class="input">
                <input type="text" class="target-typeahead" name="targets[0]" id="target_1" value="{{ isset($targetsArr) ? $targetsArr[0] : Request::old('targets')[0] }}" placeholder="{{ Lang::get('pages.index.form_label') }} 1">
            </label>
        </section>

        <section>
            <label class="label">{{ Lang::get('pages.index.form_label') }} 2</label>
            <label class="input">
                <input type="text" class="target-typeahead" name="targets[1]" id="target_2" value="{{ isset($targetsArr) ? $targetsArr[1] : Request::old('targets')[1] }}" placeholder="{{ Lang::get('pages.index.form_label') }} 2">
            </label>
        </section>

        @if(isset($targetsArr))
            @for($i = 2; $i < count($targetsArr); $i++)
                <section>
                    <label class="label">{{ Lang::get('pages.index.form_label') }} {{ $i+1 }}</label>
                    <label class="input">
                        <input type="text" class="target-typeahead" name="targets[{{ $i }}]" id="target_{{ $i+1 }}" value="{{ $targetsArr[$i] }}" placeholder="{{ Lang::get('pages.index.form_label') }} {{ $i+1 }}">
                    </label>
                </section>
            @endfor
        @endif



        <div class="added-targets"></div>

        <section>
            <a id="add-target" href="#"><i class="fa fa-plus"></i> {{ Lang::get('pages.index.add_item') }}</a>
        </section>

    </fieldset>

    <footer>
        <button class="btn-u" type="submit">{{ Lang::get('pages.index.calculate') }}</button>
    </footer>
{!! Form::close() !!}