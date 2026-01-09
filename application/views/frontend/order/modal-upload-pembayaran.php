<div class="modal fade" id="modal-bukti-bayar" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload Bukti Pembayaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form-upload" action="" method="POST">
        <div class="modal-body">
          <div class="form-group">
            <label for="file_upload">File</label>
            <input class="form-control" type="file" accept="image/*,.pdf" name="file_upload" id="file_upload" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>