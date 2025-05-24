<div class="modal fade" id="delete-modal-inventory" tabindex="-1" aria-labelledby="delete-modal-inventory-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <input type="hidden" name="id" id="delete-id">
        
        <div class="modal-header">
          <h5 class="modal-title" id="delete-modal-inventory-label">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <p>Apakah Anda yakin ingin menghapus item ini?</p>
        </div>

        <div class="modal-footer d-flex justify-content-end gap-1">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>
