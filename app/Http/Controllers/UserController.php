<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Daftar user
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('dusun', 'like', "%{$search}%");
            });
        }

        // Filter role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Form tambah user
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

        return view('users.create', compact('dusunList'));
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'digits:16', 'unique:users,nik'],
            'dusun' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in(['admin', 'pengguna'])],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        User::create([
            'name' => $validated['name'],
            'nik' => $validated['nik'],
            'dusun' => $validated['dusun'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => 'approved',
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Form edit user
     */
    public function edit(User $user): View
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

        return view('users.edit', compact('user', 'dusunList'));
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'nik' => [
                'required',
                'digits:16',
                Rule::unique('users', 'nik')->ignore($user->id),
            ],

            'dusun' => ['required', 'string', 'max:100'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'role' => [
                'required',
                Rule::in(['admin', 'pengguna']),
            ],

            'password' => [
                'nullable',
                'confirmed',
                'min:8',
            ],
        ]);

        $user->name = $validated['name'];
        $user->nik = $validated['nik'];
        $user->dusun = $validated['dusun'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        // Password hanya diubah jika diisi
        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Setujui user
     */
    public function approve(User $user): RedirectResponse
    {
        $user->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil disetujui.');
    }

    /**
     * Tolak user
     */
    public function reject(User $user): RedirectResponse
    {
        $user->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditolak.');
    }

    /**
     * Hapus user
     */
    public function destroy(User $user): RedirectResponse
    {
        // Jangan izinkan admin menghapus akun sendiri
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
