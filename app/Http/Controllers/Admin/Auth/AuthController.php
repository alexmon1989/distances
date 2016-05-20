<?php

namespace App\Http\Controllers\Admin\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';
    protected $loginView = 'admin.auth.login';
    protected $redirectAfterLogout = 'admin/login';
    protected $registerView = 'admin.auth.register';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Показывает страницу со списком пользователей.
     */
    public function getList()
    {
        $users = User::all();
        return view('admin.auth.list', compact('users'));
    }

    /**
     * Обработчик запроса на создание пользователя
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails())
        {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $user = $this->create($request->all());
        return redirect()->route('users.edit', ['user' => $user])
            ->with('success', 'Пользователь успешно создан.');
    }

    /**
     * Показывает страницу редактирования пользователя
     */
    public function getEdit(User $user)
    {
        return view('admin.auth.edit', compact('user'));
    }

    /**
     * Обработчик запроса на редактирование данных пользователя
     */
    public function postEdit(User $user, Request $request)
    {
        // Валидация
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'password' => 'confirmed|min:6',
        ]);
        // Изменяем данные и сохраняем
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        if ($request->get('password'))
        {
            $user->password = bcrypt($request->get('password'));
        }
        $user->save();
        return redirect()->route('users.edit', ['user' => $user])
            ->with('success', 'Пользователь успешно отредактирован.');

    }

    /**
     * Удаление пользователя
     */
    public function getDelete(User $user)
    {
        // TODO: запрет удаления самого себя
        $user->delete();

        return redirect()->route('users')
            ->with('success', 'Пользователь успешно удалён.');
    }
}
