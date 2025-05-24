@php
    $isEdit = !empty($data);
@endphp

<div class="modal fade" id="form-modal-inventory" tabindex="-1" aria-labelledby="form-modal-inventory-label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="form-modal-inventory-label">
          {{ $isEdit ? 'Edit' : 'Tambah' }} Inventory
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <form id="form-inventory" action="/inventory{{ $isEdit ? '/edit?id=' . $data['id'] : '/create' }}" method="POST">
        <div class="modal-body">
            <input type="text" hidden name="id">
          <div class="row g-3">
            <div class="col-md-6">
              <label>Kode Barang</label>
              <input type="text" name="kode_barang" value="{{ $data['kode_barang'] ?? '' }}" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>Nama Barang</label>
              <input type="text" name="nama_barang" value="{{ $data['nama_barang'] ?? '' }}" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label>Jumlah</label>
              <input type="number" name="jumlah_barang" value="{{ $data['jumlah_barang'] ?? '' }}" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label>Satuan</label>
              <select name="satuan_barang" class="form-select" required>
                @foreach (['kg', 'pcs', 'liter', 'meter'] as $satuan)
                  <option value="{{ $satuan }}" {{ ($data['satuan_barang'] ?? '') == $satuan ? 'selected' : '' }}>
                    {{ $satuan }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label>Harga Beli</label>
              <input type="number" name="harga_beli" value="{{ $data['harga_beli'] ?? '' }}" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>Status</label>
              <select name="status_barang" class="form-select" required>
                <option value="1" {{ ($data['status_barang'] ?? '') == 1 ? 'selected' : '' }}>Tersedia</option>
                <option value="0" {{ ($data['status_barang'] ?? '') === 0 ? 'selected' : '' }}>Tidak Tersedia</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
