{!! Form::open(['method' => 'get', 'route' => 'distances_index', 'class' => 'sky-form', 'autocomplete' => 'off']) !!}
    <header>{{ Lang::get('pages.index.form_title') }}</header>

    <fieldset>

        <section>
            <label class="label">{{ Lang::get('pages.index.form_label') }} 1</label>
            <label class="input">
                <input type="text" class="target-typeahead" name="targets[0]" id="target_1" value="{{ isset($targets) ? $targets[0]->name . ' (' . $targets[0]->country->name . ')' : Request::old('targets')[0] }}" placeholder="{{ Lang::get('pages.index.form_label') }} 1">
            </label>
        </section>

        <section>
            <label class="label">{{ Lang::get('pages.index.form_label') }} 2</label>
            <label class="input">
                <input type="text" class="target-typeahead" name="targets[1]" id="target_2" value="{{ isset($targets) ? $targets[1]->name . ' (' . $targets[1]->country->name . ')' : Request::old('targets')[1] }}" placeholder="{{ Lang::get('pages.index.form_label') }} 2">
            </label>
        </section>

        @if(isset($targets))
            @for($i = 2; $i < count($targets); $i++)
                <section>
                    <label class="label">{{ Lang::get('pages.index.form_label') }} {{ $i+1 }}</label>
                    <label class="input">
                        <div class="input-group">
                            <input type="text" class="form-control target-typeahead" name="targets[{{ $i }}]" id="target_{{ $i+1 }}" value="{{ $targets[$i]->name . ' (' . $targets[$i]->country->name . ')' }}" placeholder="{{ Lang::get('pages.index.form_label') }} {{ $i+1 }}">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-danger remove-target"><i class="fa fa-times" aria-hidden="true"></i></button>
                            </span>
                        </div>
                    </label>
                </section>
            @endfor
        @else
            @for($i = 2; $i < count(Request::old('targets')); $i++)
                <section>
                    <label class="label">{{ Lang::get('pages.index.form_label') }} {{ $i+1 }}</label>
                    <label class="input">
                        <div class="input-group">
                            <input type="text" class="form-control target-typeahead" name="targets[{{ $i }}]" id="target_{{ $i+1 }}" value="{{ Request::old('targets')[$i] }}" placeholder="{{ Lang::get('pages.index.form_label') }} {{ $i+1 }}">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-danger remove-target"><i class="fa fa-times" aria-hidden="true"></i></button>
                            </span>
                        </div>
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