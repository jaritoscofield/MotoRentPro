<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('modules.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'birth_date' => 'nullable|date',
            'bio' => 'nullable|string|max:1000',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'bio' => $request->bio,
        ]);

        return redirect('/perfil')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect('/perfil')->with('success', 'Senha alterada com sucesso!');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            // Remove avatar anterior se existir
            if ($user->avatar && file_exists(public_path('avatars/' . $user->avatar))) {
                unlink(public_path('avatars/' . $user->avatar));
            }

            $file = $request->file('avatar');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            
            // Cria diretório se não existir
            if (!file_exists(public_path('avatars'))) {
                mkdir(public_path('avatars'), 0755, true);
            }

            $file->move(public_path('avatars'), $filename);
            
            $user->update(['avatar' => $filename]);
        }

        return redirect('/perfil')->with('success', 'Avatar atualizado com sucesso!');
    }
} 