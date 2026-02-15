<div class="modal fade" id="tambahBukuModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-book me-2"></i>Tambah Buku Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Judul Buku</label>
                            <input type="text" class="form-control" placeholder="Masukkan judul buku">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Penulis</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama penulis">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Penerbit</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama penerbit">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">ISBN</label>
                            <input type="text" class="form-control" placeholder="ISBN">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Tahun Terbit</label>
                            <input type="number" class="form-control" placeholder="2024">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Jumlah Halaman</label>
                            <input type="number" class="form-control" placeholder="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Kategori</label>
                            <select class="form-select">
                                <option value="">Pilih Kategori</option>
                                <option value="novel">Novel</option>
                                <option value="pelajaran">Buku Pelajaran</option>
                                <option value="teknologi">Teknologi</option>
                                <option value="agama">Agama</option>
                                <option value="sejarah">Sejarah</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Rak</label>
                            <select class="form-select">
                                <option value="">Pilih Rak</option>
                                <option value="A1">A1</option>
                                <option value="A2">A2</option>
                                <option value="B1">B1</option>
                                <option value="B2">B2</option>
                                <option value="C1">C1</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Stok</label>
                            <input type="number" class="form-control" placeholder="0" min="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea class="form-control" rows="3" placeholder="Masukkan deskripsi buku"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Cover Buku</label>
                        <input type="file" class="form-control" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, maksimal 2MB</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-add">
                    <i class="bi bi-save me-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>