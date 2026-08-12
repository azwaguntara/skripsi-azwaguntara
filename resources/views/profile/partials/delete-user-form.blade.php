<section>

    <h5 class="mb-3 fw-bold text-danger">Hapus Akun</h5>

    <p class="text-muted mb-4">
        Setelah akun dihapus, semua data akan hilang permanen. Pastikan Anda sudah yakin.
    </p>

    <!-- BUTTON -->
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
        <i class="bi bi-trash"></i> Hapus Akun
    </button>

    <!-- MODAL -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <!-- HEADER -->
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">Konfirmasi Hapus Akun</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- BODY -->
                    <div class="modal-body">

                        <p class="text-muted">
                            Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.
                        </p>

                        <div class="mb-3">
                            <label class="form-label">Masukkan Password</label>
                            <input type="password" name="password" class="form-control" required>

                            @error('password', 'userDeletion')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</section>