<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::all()->where('id', '!=', Auth::id());
        return view('users.index', compact('data'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->is_admin ? $request['is_admin'] = TRUE : $request['is_admin'] = FALSE;

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
        ]);

        $name = $request->old('name');
        $email = $request->old('email');

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        try {
            $user = User::create($input);
            $message = [
                "type" => "success",
                "message" => "Usuário $user->name criado com sucesso!!!"
            ];
        } catch (Exception $e) {
            $message = [
                "type" => "error",
                "message" => $e->getMessage()
            ];
        }
        return redirect()->route('usuarios.index')
            ->with('message', $message);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = User::find($id);
        return view('users.show', compact('usuario'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = User::find($id);
        return view('users.edit', compact('usuario'));
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
        $request->is_admin ? $request['is_admin'] = TRUE : $request['is_admin'] = FALSE;

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirma-senha',
        ]);

        $name = $request->old('name');
        $email = $request->old('email');

        $input = $request->all();

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);

        try {
            $user->update($input);
            $message = [
                "type" => "success",
                "message" => "Usuário $user->name atualizado com sucesso!!!"
            ];
        } catch (Exception $e) {
            $message = [
                "type" => "error",
                "message" => $e->getMessage()
            ];
        }

        return redirect()->route('usuarios.index')
            ->with('message', $message);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $userNome = $user->name;
        try {
            $user->delete();
            $message = [
                "type" => "success",
                "message" => "Usuário $userNome apagado com sucesso!!!"
            ];
        } catch (Exception $e) {
            if (stripos($e->getMessage(), 'FOREIGN KEY')) {
                $message = [
                    "type" => "error",
                    "message" => "Não é possível excluir usuário usado em Ordens de Serviço!!!"
                ];
            } else {
                $message = [
                    "type" => "error",
                    "message" => $e->getMessage()
                ];
            }
        }
        return redirect()->route('usuarios.index')
                ->with('message', $message);
    }
}
