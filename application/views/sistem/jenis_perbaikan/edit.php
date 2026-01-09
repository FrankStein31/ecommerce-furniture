<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
        <span class="card-title">Edit Jenis Perbaikan</span>
      </div>
      <div class="card-body">
        <form method="post" action="<?= base_url('jenis_perbaikan/edit/'.$jenis->id) ?>">
          
          <div class="form-group">
            <label>Kategori Perbaikan <span class="text-danger">*</span></label>
            <select name="id_kategori" class="form-control <?= form_error('id_kategori') ? 'is-invalid' : '' ?>" required>
              <option value="">-- Pilih Kategori --</option>
              <?php foreach($kategori_list as $id => $nama): ?>
                <option value="<?= $id ?>" 
                        <?= set_select('id_kategori', $id, $jenis->id_kategori == $id) ?>>
                  <?= $nama ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?php if(form_error('id_kategori')): ?>
              <div class="invalid-feedback">
                <?= form_error('id_kategori') ?>
              </div>
            <?php endif; ?>
          </div>
          
          <div class="form-group">
            <label>Nama Jenis Perbaikan <span class="text-danger">*</span></label>
            <input type="text" 
                   name="nama_jenis_perbaikan" 
                   class="form-control <?= form_error('nama_jenis_perbaikan') ? 'is-invalid' : '' ?>" 
                   placeholder="Contoh: Sofa Kulit, Kursi Kayu, dll"
                   value="<?= set_value('nama_jenis_perbaikan', $jenis->nama_jenis_perbaikan) ?>" 
                   required>
            <?php if(form_error('nama_jenis_perbaikan')): ?>
              <div class="invalid-feedback">
                <?= form_error('nama_jenis_perbaikan') ?>
              </div>
            <?php endif; ?>
          </div>
          
          <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" 
                      class="form-control <?= form_error('deskripsi') ? 'is-invalid' : '' ?>" 
                      rows="4" 
                      placeholder="Deskripsi atau keterangan tambahan (opsional)"><?= set_value('deskripsi', $jenis->deskripsi) ?></textarea>
            <?php if(form_error('deskripsi')): ?>
              <div class="invalid-feedback">
                <?= form_error('deskripsi') ?>
              </div>
            <?php endif; ?>
          </div>
          
          <div class="form-group">
            <label>Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control <?= form_error('status') ? 'is-invalid' : '' ?>" required>
              <option value="1" <?= set_select('status', '1', $jenis->status == '1') ?>>Aktif</option>
              <option value="0" <?= set_select('status', '0', $jenis->status == '0') ?>>Nonaktif</option>
            </select>
            <?php if(form_error('status')): ?>
              <div class="invalid-feedback">
                <?= form_error('status') ?>
              </div>
            <?php endif; ?>
            <small class="form-text text-muted">
              <span class="badge badge-success">Aktif</span> = Data akan muncul di sistem rekomendasi<br>
              <span class="badge badge-secondary">Nonaktif</span> = Data tidak akan muncul di sistem rekomendasi
            </small>
          </div>
          
          <div class="form-group mt-4">
            <button type="submit" class="btn btn-success">
              <i class="fa fa-save"></i> Update
            </button>
            <a href="<?= base_url('jenis_perbaikan') ?>" class="btn btn-secondary">
              <i class="fa fa-arrow-left"></i> Kembali
            </a>
          </div>
          
        </form>
        
        <!-- Info Timestamp -->
        <div class="card bg-light mt-3">
          <div class="card-body">
            <small class="text-muted">
              <i class="fa fa-info-circle"></i> 
              <strong>Dibuat:</strong> <?= date('d-m-Y H:i:s', strtotime($jenis->created_at)) ?> 
              <?php if($jenis->updated_at): ?>
                | <strong>Terakhir Diupdate:</strong> <?= date('d-m-Y H:i:s', strtotime($jenis->updated_at)) ?>
              <?php endif; ?>
            </small>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>
