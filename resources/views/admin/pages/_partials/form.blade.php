{{ Form::open(['method' => 'post', 'autocomplete' => 'off']) }}
    {{ Form::token() }}
    <div class="box-body">
        <div class="form-group">
            <label for="title_ru">Title (рус.)</label>
            <input type="text" placeholder="Title (рус.)" id="title_ru" name="title_ru" class="form-control" value="{{ old('title_ru', isset($pageContent) ? $pageContent['article_ru']['title'] : '') }}">
        </div>

        <div class="form-group">
            <label for="full_text_ru">Текст (рус.)</label>
            <textarea id="full_text_ru" name="full_text_ru" rows="10" cols="80" class="form-control ckeditor">{{ old('full_text_ru', isset($pageContent) ? $pageContent['article_ru']['full_text'] : '') }}</textarea>
        </div>

        <div class="form-group">
            <label for="title_en">Title (англ.)</label>
            <input type="text" placeholder="Title (рус.)" id="title_en" name="title_en" class="form-control" value="{{ old('title_en', isset($pageContent) ? $pageContent['article_en']['title'] : '') }}">
        </div>

        <div class="form-group">
            <label for="full_text_en">Текст (англ.)</label>
            <textarea id="full_text_en" name="full_text_en" rows="10" cols="80" class="form-control ckeditor">{{ old('full_text_en', isset($pageContent) ? $pageContent['article_en']['full_text'] : '') }}</textarea>
        </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить</button>
    </div>
{{ Form::close() }}