{{ Form::open(['method' => 'post', 'autocomplete' => 'nope']) }}
    {{ Form::token() }}
    <div class="box-body">
        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" placeholder="Имя" id="name" name="name" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}">
        </div>
        <div class="form-group">
            <label for="email">E-Mail</label>
            <input type="text" placeholder="E-Mail" id="email" name="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}">
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" placeholder="Пароль" id="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="password_confirmation">Подтверждение пароля</label>
            <input type="password" placeholder="Подтверждение пароля" id="password_confirmation" name="password_confirmation" class="form-control">
        </div>
    </div><!-- /.box-body -->

    <div class="box-footer">
        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить</button>
    </div>
{{ Form::close() }}