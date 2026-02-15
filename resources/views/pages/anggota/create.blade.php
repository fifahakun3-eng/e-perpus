<!-- Modal Tambah Anggota -->
<div class="modal fade" id="tambahAnggotaModal" tabindex="-1" aria-labelledby="tambahAnggotaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahAnggotaModalLabel">
                    <i class="bi bi-person-plus me-2"></i>Tambah Anggota Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Foto Anggota -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Foto Anggota</label>
                            <input type="file" class="form-control" name="foto" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, maksimal 2MB</small>
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <!-- NIM -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">NIM <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nim" placeholder="Masukkan NIM" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" placeholder="contoh@student.ac.id" required>
                        </div>

                        <!-- No. Telepon -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">No. Telepon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="telepon" placeholder="08xxxxxxxxxx" required>
                        </div>

                        <!-- Jurusan -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Jurusan <span class="text-danger">*</span></label>
                            <select class="form-select" name="jurusan" required>
                                <option value="">Pilih Jurusan</option>
                                <option value="Teknik Informatika">Teknik Informatika</option>
                                <option value="Teknik Sipil">Teknik Sipil</option>
                                <option value="Teknik Elektro">Teknik Elektro</option>
                                <option value="Teknik Mesin">Teknik Mesin</option>
                                <option value="Teknik Industri">Teknik Industri</option>
                            </select>
                        </div>

                        <!-- Angkatan -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Angkatan <span class="text-danger">*</span></label>
                            <select class="form-select" name="angkatan" required>
                                <option value="">Pilih Angkatan</option>
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                                <option value="2022">2022</option>
                                <option value="2021">2021</option>
                                <option value="2020">2020</option>
                                <option value="2019">2019</option>
                            </select>
                        </div>

                        <!-- Alamat -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Alamat</label>
                            <textarea class="form-control" name="alamat" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                        </div>

                        <!-- Status -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Non-Aktif">Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-add">
                        <i class="bi bi-check-circle me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>