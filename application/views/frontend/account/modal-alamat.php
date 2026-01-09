<div class="modal fade" id="modal-alamat" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleAdd" style="display:none;">Tambah Alamat</h5>
        <h5 class="modal-title" id="modalTitleEdit" style="display:none;">Edit Alamat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form-alamat" action="" method="POST">
        <div class="modal-body">
          <input type="hidden" name="modeform" id="modeform">
          <input type="hidden" class="form-control" id="id_alamat" name="id_alamat" value="<?= isset($data) ? $data['id'] : '' ?>"></input>
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" name="alamat" id="alamat" rows="2" placeholder="Alamat" required><?= isset($data) ? $data['alamat'] : '' ?></textarea>
          </div>
          <div class="form-group">
            <label for="kode_pos">No Telepon</label>
            <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="No Telepon" value="<?= isset($data) ? $data['no_telp'] : '' ?>" required>
          </div>
          <div class="form-group">
            <label for="kode_pos">Kode Pos</label>
            <input type="text" class="form-control" id="kode_pos" name="kode_pos" placeholder="Kode Pos" value="<?= isset($data) ? $data['kode_pos'] : '' ?>" required>
          </div>
          <div class="form-group">
            <label for="penerima">Penerima</label>
            <input type="text" class="form-control" id="penerima" name="penerima" placeholder="Nama Penerima" value="<?= isset($data) ? $data['penerima'] : '' ?>" required>
          </div>
          <div class="form-group">
            <label for="keterangan">keterangan</label>
            <textarea class="form-control" name="keterangan" id="keterangan" rows="2" placeholder="Keterangan"><?= isset($data) ? $data['keterangan'] : '' ?></textarea>
          </div>
          <!-- <span>Alamat Utama</span> -->
          <div class="form-group">
            <input type="checkbox" name="is_utama" value="1"
              <?php if(isset($data)){
                if($data['is_utama']=='1'){
                  echo " checked";
                }
              } ?>
            >
            <label for="utama">Alamat Utama</label>
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