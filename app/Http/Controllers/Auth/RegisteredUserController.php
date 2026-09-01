<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $dusunList = [
            "Dusun Titi Belanga Sentosa",
            "Dusun Titi Belanga Sejahtera",
            "Dusun Titi Belanga",
            "Dusun Puji Dadi I",
            "Dusun Puji Dadi II",
            "Dusun Puji Dadi III",
            "Dusun Puji Dadi IV",
            "Dusun Sumber Rejo Utara",
            "Dusun Sumber Rejo Selatan",
            "Dusun Jati Mulyo",
            "Dusun Jati Mulyo Makmur",
            "Dusun Sido Mulyo",
            "Dusun Tahun X Utara",
            "Dusun Tahun X Selatan",
            "Dusun Benteng Teladan",
            "Dusun Klonie I",
            "Dusun Tahun XI",
        ];

        return view('auth.register', compact('dusunList'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'nik' => [
                'required',
                'digits:16',
                'unique:users,nik',
            ],

            'dusun' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class,
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'dusun' => $request->dusun,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'pending',
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with(
            'status',
            'Registrasi berhasil! Silakan login menggunakan akun yang telah didaftarkan.'
        );
    }
}
