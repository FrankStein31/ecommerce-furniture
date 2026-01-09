<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
        <span class="card-title">Edit Kategori Jenis Perbaikan</span>
      </div>
      <div class="card-body">
        <?php if($this->session->flashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-triangle"></i> <?= $this->session->flashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>
        
        <form action="<?= base_url('kategori_perbaikan/edit/'.$kategori->id) ?>" method="POST" id="form-kategori">
          <div class="row">
            <div class="col-md-9">
              <div class="form-group">
                <label for="nama_kategori">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control" 
                       id="nama_kategori" 
                       name="nama_kategori" 
                       placeholder="Contoh: Sofa, Kursi Kantor, Springbed"
                       value="<?= set_value('nama_kategori', $kategori->nama_kategori) ?>"
                       required>
                <small class="form-text text-muted">Nama kategori jenis perbaikan mebel</small>
              </div>
              
              <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" 
                          id="deskripsi" 
                          name="deskripsi" 
                          rows="4" 
                          placeholder="Deskripsi singkat tentang kategori ini..."><?= set_value('deskripsi', $kategori->deskripsi) ?></textarea>
                <small class="form-text text-muted">Penjelasan tentang kategori (opsional)</small>
              </div>
            </div>
            
            <div class="col-md-3">
              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                  <option value="1" <?= set_select('status', '1', $kategori->status == '1') ?>>Aktif</option>
                  <option value="0" <?= set_select('status', '0', $kategori->status == '0') ?>>Nonaktif</option>
                </select>
                <small class="form-text text-muted">Status aktif/nonaktif kategori</small>
              </div>
              
              <div class="card bg-light mt-3">
                <div class="card-body p-2">
                  <small class="text-muted">
                    <strong>Dibuat:</strong><br>
                    <?= date('d M Y H:i', strtotime($kategori->created_at)) ?><br>
                    <strong>Diupdate:</strong><br>
                    <?= date('d M Y H:i', strtotime($kategori->updated_at)) ?>
                  </small>
                </div>
              </div>
            </div>
          </div>
          
          <hr>
          
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Update
              </button>
              <a href="<?= base_url('kategori_perbaikan') ?>" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
