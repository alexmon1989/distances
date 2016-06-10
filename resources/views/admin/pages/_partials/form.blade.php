{{ Form::open(['method' => 'post', 'autocomplete' => 'off']) }}
{{ Form::token() }}
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#russian" aria-expanded="true">Русский</a></li>
        <li class=""><a data-toggle="tab" href="#english" aria-expanded="false">Английский</a></li>
        <li class=""><a data-toggle="tab" href="#ukrainian" aria-expanded="false">Украинский</a></li>
        <li class=""><a data-toggle="tab" href="#polish" aria-expanded="false">Польский</a></li>
        <li class="pull-right"><a class="text-muted" href="#"><i class="fa fa-gear"></i></a></li>
    </ul>
    <div class="tab-content">
        <div id="russian" class="tab-pane active">
            <div class="box-body">
                <div class="form-group">
                    <label for="title_ru">Title (рус.)</label>
                    <input type="text" placeholder="Title (рус.)" id="title_ru" name="title_ru" class="form-control" value="{{ old('title_ru', isset($pageContent) ? $pageContent['article_ru']['title'] : '') }}">
                </div>

                <div class="form-group">
                    <label for="full_text_ru">Текст (рус.)</label>
                    <textarea id="full_text_ru" name="full_text_ru" rows="10" cols="80" class="form-control ckeditor">{{ old('full_text_ru', isset($pageContent) ? $pageContent['article_ru']['full_text'] : '') }}</textarea>
                </div>
            </div><!-- /.box-body -->
        </div>
        <!-- /.tab-pane -->

        <div id="english" class="tab-pane">
            <div class="box-body">
                <div class="form-group">
                    <label for="title_en">Title (англ.)</label>
                    <input type="text" placeholder="Title (рус.)" id="title_en" name="title_en" class="form-control" value="{{ old('title_en', isset($pageContent) ? $pageContent['article_en']['title'] : '') }}">
                </div>

                <div class="form-group">
                    <label for="full_text_en">Текст (англ.)</label>
                    <textarea id="full_text_en" name="full_text_en" rows="10" cols="80" class="form-control ckeditor">{{ old('full_text_en', isset($pageContent) ? $pageContent['article_en']['full_text'] : '') }}</textarea>
                </div>
            </div><!-- /.box-body -->
        </div>
        <!-- /.tab-pane -->

        <div id="ukrainian" class="tab-pane">
            <div class="box-body">
                <div class="form-group">
                    <label for="title_uk">Title (укр.)</label>
                    <input type="text" placeholder="Title (укр.)" id="title_uk" name="title_uk" class="form-control" value="{{ old('title_uk', isset($pageContent) ? $pageContent['article_uk']['title'] : '') }}">
                </div>

                <div class="form-group">
                    <label for="full_text_uk">Текст (англ.)</label>
                    <textarea id="full_text_uk" name="full_text_uk" rows="10" cols="80" class="form-control ckeditor">{{ old('full_text_uk', isset($pageContent) ? $pageContent['article_uk']['full_text'] : '') }}</textarea>
                </div>
            </div><!-- /.box-body -->
        </div>
        <!-- /.tab-pane -->

        <div id="polish" class="tab-pane">
            <div class="box-body">
                <div class="form-group">
                    <label for="title_pl">Title (польск.)</label>
                    <input type="text" placeholder="Title (польск.)" id="title_pl" name="title_pl" class="form-control" value="{{ old('title_pl', isset($pageContent) ? $pageContent['article_pl']['title'] : '') }}">
                </div>

                <div class="form-group">
                    <label for="full_text_pl">Текст (польск.)</label>
                    <textarea id="full_text_pl" name="full_text_pl" rows="10" cols="80" class="form-control ckeditor">{{ old('full_text_pl', isset($pageContent) ? $pageContent['article_pl']['full_text'] : '') }}</textarea>
                </div>
            </div><!-- /.box-body -->
        </div>
        <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
</div>
<div class="box-footer">
    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить</button>
</div>
{{ Form::close() }}



