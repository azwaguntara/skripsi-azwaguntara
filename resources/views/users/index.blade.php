@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Manajemen User</h4>
        <p class="text-muted mb-0">
            Kelola akun pengguna yang terdaftar pada sistem.
        </p>
    </div>

    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus"></i> Tambah User
    </a>
</div>

{{-- SUCCESS --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="bi bi-check-circle"></i>
    {{ session('success') }}

    <button type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>
</div>
@endif

{{-- ERROR --}}
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    <i class="bi bi-exclamation-circle"></i>
    {{ session('error') }}

    <button type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>
</div>
@endif


{{-- FILTER --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">

        <form method="GET" action="{{ route('users.index') }}">
            <div class="row g-3 align-items-end">

                {{-- SEARCH --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Cari User
                    </label>

                    <input type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Nama, NIK, email, atau dusun">
                </div>

                {{-- ROLE --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        Role
                    </label>

                    <select name="role" class="form-select">
                        <option value="">-- Semua Role --</option>

                        <option value="admin"
                            {{ request('role') == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                        <option value="pengguna"
                            {{ request('role') == 'pengguna' ? 'selected' : '' }}>
                            Pengguna
                        </option>
                    </select>
                </div>

                {{-- BUTTON --}}
                <div class="col-md-3 d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Cari
                    </button>

                    <a href="{{ route('users.index') }}"
                        class="btn btn-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>

                </div>

            </div>
        </form>

    </div>
</div>


{{-- TABLE --}}
<div class="card shadow-sm">
    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead style="background:#1f2d3d; color:white;">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Asal Dusun</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($users as $user)

                    <tr>

                        <td>
                            {{ $users->firstItem() + $loop->index }}
                        </td>

                        <td class="fw-semibold">
                            {{ $user->name }}
                        </td>

                        <td>
                            {{ $user->nik ?? '-' }}
                        </td>

                        <td>
                            {{ $user->dusun ?? '-' }}
                        </td>

                        <td>
                            {{ $user->email }}
                        </td>

                        <td>

                            @if($user->role == 'admin')

                            <span class="badge bg-primary">
                                Admin
                            </span>

                            @else

                            <span class="badge bg-secondary">
                                Pengguna
                            </span>

                            @endif

                        </td>

                        <td>
                            @if($user->status === 'pending')

                            <span class="badge bg-warning text-dark">
                                Menunggu
                            </span>

                            @elseif($user->status === 'approved')

                            <span class="badge bg-success">
                                Disetujui
                            </span>

                            @elseif($user->status === 'rejected')

                            <span class="badge bg-danger">
                                Ditolak
                            </span>

                            @endif
                        </td>

                        <td>

                            <div class="d-flex gap-1 flex-wrap">

                                {{-- SETUJUI --}}
                                @if($user->status === 'pending')

                                <form method="POST"
                                    action="{{ route('users.approve', $user->id) }}"
                                    onsubmit="return confirm('Yakin ingin menyetujui user ini?')">

                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="btn btn-success btn-sm"
                                        title="Setujui">

                                        <i class="bi bi-check-lg"></i>
                                    </button>

                                </form>

                                {{-- TOLAK --}}
                                <form method="POST"
                                    action="{{ route('users.reject', $user->id) }}"
                                    onsubmit="return confirm('Yakin ingin menolak user ini?')">

                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        title="Tolak">

                                        <i class="bi bi-x-lg"></i>
                                    </button>

                                </form>

                                @endif

                                {{-- EDIT --}}
                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="btn btn-warning btn-sm"
                                    title="Edit">

                                    <i class="bi bi-pencil"></i>
                                </a>

                                {{-- HAPUS --}}
                                @if($user->id != auth()->id())

                                <form method="POST"
                                    action="{{ route('users.destroy', $user->id) }}"
                                    onsubmit="return confirm('Yakin ingin menghapus user ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        title="Hapus">

                                        <i class="bi bi-trash"></i>
                                    </button>

                                </form>

                                @endif

                            </div>
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">

                            <i class="bi bi-people fs-3 d-block mb-2"></i>

                            Belum ada data user.

                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($users->hasPages())
        <div class="mt-4">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
        @endif

    </div>
</div>

@endsection