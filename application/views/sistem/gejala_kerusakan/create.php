<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
        <span class="card-title">Tambah Gejala Kerusakan</span>
      </div>
      <div class="card-body">
        <form method="post" action="<?= base_url('gejala_kerusakan/create') ?>">
          
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Kode Gejala <span class="text-danger">*</span></label>
                <input type="text" 
                       name="kode_gejala" 
                       class="form-control" 
                       value="<?= $next_kode ?>" 
                       readonly
                       style="background-color: #e9ecef; cursor: not-allowed;">
                <small class="form-text text-muted">
                  <i class="fa fa-lock"></i> Kode otomatis dari sistem
                </small>
              </div>
            </div>
            
            <div class="col-md-8">
              <div class="form-group">
                <label>Nama Gejala Kerusakan <span class="text-danger">*</span></label>
                <input type="text" 
                       name="nama_gejala" 
                       class="form-control <?= form_error('nama_gejala') ? 'is-invalid' : '' ?>" 
                       placeholder="Contoh: Permukaan kusam dan pudar"
                       value="<?= set_value('nama_gejala') ?>" 
                       required>
                <?php if(form_error('nama_gejala')): ?>
                  <div class="invalid-feedback">
                    <?= form_error('nama_gejala') ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label>Deskripsi Gejala</label>
            <textarea name="deskripsi" 
                      class="form-control <?= form_error('deskripsi') ? 'is-invalid' : '' ?>" 
                      rows="3" 
                      placeholder="Deskripsi detail gejala kerusakan (opsional)"><?= set_value('deskripsi') ?></textarea>
            <?php if(form_error('deskripsi')): ?>
              <div class="invalid-feedback">
                <?= form_error('deskripsi') ?>
              </div>
            <?php endif; ?>
          </div>
          
          <div class="form-group">
            <label>Pertanyaan untuk Diagnosis</label>
            <textarea name="pertanyaan" 
                      class="form-control <?= form_error('pertanyaan') ? 'is-invalid' : '' ?>" 
                      rows="2" 
                      placeholder="Contoh: Apakah furniture Anda mengalami gejala ini?"><?= set_value('pertanyaan') ?></textarea>
            <?php if(form_error('pertanyaan')): ?>
              <div class="invalid-feedback">
                <?= form_error('pertanyaan') ?>
              </div>
            <?php endif; ?>
            <small class="form-text text-muted">
              <i class="fa fa-info-circle"></i> Pertanyaan yang akan ditampilkan saat customer melakukan diagnosis
            </small>
          </div>
          
          <div class="form-group">
            <label>Jenis Perbaikan Terkait</label>
            <select name="jenis_perbaikan[]" 
                    class="form-control select2" 
                    multiple="multiple" 
                    data-placeholder="Pilih jenis perbaikan terkait (bisa lebih dari 1)">
              <?php foreach($jenis_list as $id => $nama): ?>
                <option value="<?= $id ?>" <?= set_select('jenis_perbaikan[]', $id) ?>>
                  <?= $nama ?>
                </option>
              <?php endforeach; ?>
            </select>
            <small class="form-text text-muted">
              <i class="fa fa-info-circle"></i> Pilih jenis perbaikan furniture yang mungkin mengalami gejala ini
            </small>
          </div>
          
          <div class="form-group">
            <label>Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control <?= form_error('status') ? 'is-invalid' : '' ?>" required>
              <option value="1" <?= set_select('status', '1', true) ?>>Aktif</option>
              <option value="0" <?= set_select('status', '0') ?>>Nonaktif</option>
            </select>
            <?php if(form_error('status')): ?>
              <div class="invalid-feedback">
                <?= form_error('status') ?>
              </div>
            <?php endif; ?>
            <small class="form-text text-muted">
              <span class="badge badge-success">Aktif</span> = Gejala akan muncul di diagnosis<br>
              <span class="badge badge-secondary">Nonaktif</span> = Gejala tidak akan muncul di diagnosis
            </small>
          </div>
          
          <div class="form-group mt-4">
            <button type="submit" class="btn btn-success">
              <i class="fa fa-save"></i> Simpan
            </button>
            <a href="<?= base_url('gejala_kerusakan') ?>" class="btn btn-secondary">
              <i class="fa fa-arrow-left"></i> Kembali
            </a>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  // Initialize Select2 for multiple select
  $('.select2').select2({
    width: '100%',
    placeholder: 'Pilih jenis perbaikan terkait (bisa lebih dari 1)',
    allowClear: true
  });
});
</script>
