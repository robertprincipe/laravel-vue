<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|unique:users|max:255|min:5',
            'password' => 'required|string|min:8',
        ];

        $messages = [
            'name.required' => 'El nombre es requerido',
            'email.required' => 'El correo electronico es requerido',
            'email.unique' => 'El correo electronico ya esta en uso',
            'email.min' => 'El correo electronico debe tener minimo 5 caracteres',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener minimo 8 caracteres',
        ];

        $this->validate($request, $rules, $messages);

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'bio' => $request['bio'],
            'photo' => $request['photo'],
            'password' => Hash::make($request['password'])
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|min:5|unique:users,email,'.$user->id,
            'password' => 'string|min:8',
        ];

        $messages = [
            'name.required' => 'El nombre es requerido',
            'email.required' => 'El correo electronico es requerido',
            'email.min' => 'El correo electronico debe tener minimo 5 caracteres',
            'password.min' => 'La contraseña debe tener minimo 8 caracteres',
        ];

        $this->validate($request, $rules, $messages);

        $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'bio' => $request['bio'],
            'photo' => $request['photo'],
            'password' => Hash::make($request['password'])
        ]);

        return ['message' => 'La información del usuario fue actualizada'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $userName = $user->name;

        $user->delete();

        return ['message' => 'El usuario '.$userName.' fue eliminado'];
    }
}
