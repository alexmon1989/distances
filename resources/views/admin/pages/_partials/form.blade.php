{{ Form::open(['method' => 'post', 'autocomplete' => 'off']) }}
{{ Form::token() }}
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#russian" aria-expanded="true">Русский</a></li>
        <li class=""><a data-toggle="tab" href="#english" aria-expanded="false">Английский</a></li>
        <li class=""><a data-toggle="tab" href="#ukrainian" aria-expanded="false">Украинский</a></li>
        <li class=""><a data-toggle="tab" href="#polish" aria-expanded="false">Польский</a></li>
        <li class=""><a data-toggle="tab" href="#italian" aria-expanded="false">Итальянский</a></li>
        <li class=""><a data-toggle="tab" href="#french" aria-expanded="false">Французский</a></li>
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

                <div class="form-group">
                    <label for="full_text_ru">Description (рус.)</label>
                    <textarea id="description_ru" name="description_ru" rows="2" cols="80" class="form-control">{{ old('description_ru', isset($pageContent['article_ru']['description']) ? $pageContent['article_ru']['description'] : '') }}</textarea>
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

                <div class="form-group">
                    <label for="description_en">Description (англ.)</label>
                    <textarea id="description_en" name="description_en" rows="2" cols="80" class="form-control">{{ old('description_en', isset($pageContent['article_en']['description']) ? $pageContent['article_en']['description'] : '') }}</textarea>
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
                    <label for="full_text_uk">Текст (укр.)</label>
                    <textarea id="full_text_uk" name="full_text_uk" rows="10" cols="80" class="form-control ckeditor">{{ old('full_text_uk', isset($pageContent) ? $pageContent['article_uk']['full_text'] : '') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="description_uk">Description (укр.)</label>
                    <textarea id="description_uk" name="description_uk" rows="2" cols="80" class="form-control">{{ old('description_uk', isset($pageContent['article_uk']['description']) ? $pageContent['article_uk']['description'] : '') }}</textarea>
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

                <div class="form-group">
                    <label for="description_pl">Description (польск.)</label>
                    <textarea id="description_pl" name="description_pl" rows="2" cols="80" class="form-control">{{ old('description_pl', isset($pageContent['article_pl']['description']) ? $pageContent['article_pl']['description'] : '') }}</textarea>
                </div>
            </div><!-- /.box-body -->
        </div>
        <!-- /.tab-pane -->

        <div id="italian" class="tab-pane">
            <div class="box-body">
                <div class="form-group">
                    <label for="title_it">Title (итал.)</label>
                    <input type="text" placeholder="Title (итал.)" id="title_it" name="title_it" class="form-control" value="{{ old('title_it', isset($pageContent) ? $pageContent['article_it']['title'] : '') }}">
                </div>

                <div class="form-group">
                    <label for="full_text_it">Текст (итал.)</label>
                    <textarea id="full_text_it" name="full_text_it" rows="10" cols="80" class="form-control ckeditor">{{ old('full_text_it', isset($pageContent) ? $pageContent['article_it']['full_text'] : '') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="description_it">Description (итал.)</label>
                    <textarea id="description_it" name="description_it" rows="2" cols="80" class="form-control">{{ old('description_it', isset($pageContent['article_it']['description']) ? $pageContent['article_it']['description'] : '') }}</textarea>
                </div>
            </div><!-- /.box-body -->
        </div>
        <!-- /.tab-pane -->

        <div id="french" class="tab-pane">
            <div class="box-body">
                <div class="form-group">
                    <label for="title_fr">Title (франц.)</label>
                    <input type="text" placeholder="Title (франц.)" id="title_fr" name="title_fr" class="form-control" value="{{ old('title_fr', isset($pageContent) ? $pageContent['article_fr']['title'] : '') }}">
                </div>

                <div class="form-group">
                    <label for="full_text_fr">Текст (франц.)</label>
                    <textarea id="full_text_fr" name="full_text_fr" rows="10" cols="80" class="form-control ckeditor">{{ old('full_text_fr', isset($pageContent) ? $pageContent['article_fr']['full_text'] : '') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="description_fr">Description (франц.)</label>
                    <textarea id="description_fr" name="description_fr" rows="2" cols="80" class="form-control">{{ old('description_fr', isset($pageContent['article_fr']['description']) ? $pageContent['article_fr']['description'] : '') }}</textarea>
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



