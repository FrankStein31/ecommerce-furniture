<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
        <span class="card-title">Tambah Jenis Kerusakan</span>
      </div>
      <div class="card-body">
        <form method="post" action="<?= base_url('jenis_kerusakan/create') ?>" enctype="multipart/form-data">
          
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Kode Kerusakan <span class="text-danger">*</span></label>
                <input type="text" 
                       name="kode_kerusakan" 
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
                <label>Nama Jenis Kerusakan <span class="text-danger">*</span></label>
                <input type="text" 
                       name="nama_jenis_kerusakan" 
                       class="form-control <?= form_error('nama_jenis_kerusakan') ? 'is-invalid' : '' ?>" 
                       placeholder="Contoh: Sarung jok robek"
                       value="<?= set_value('nama_jenis_kerusakan') ?>" 
                       required>
                <?php if(form_error('nama_jenis_kerusakan')): ?>
                  <div class="invalid-feedback">
                    <?= form_error('nama_jenis_kerusakan') ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label>Detail Kerusakan</label>
            <textarea name="detail_kerusakan" 
                      class="form-control" 
                      rows="3" 
                      placeholder="Penjelasan detail mengenai jenis kerusakan ini (opsional)"><?= set_value('detail_kerusakan') ?></textarea>
          </div>
          
          <div class="form-group">
            <label>Pertanyaan untuk Diagnosis</label>
            <textarea name="pertanyaan" 
                      class="form-control" 
                      rows="2" 
                      placeholder="Contoh: Apakah furniture Anda mengalami kerusakan ini?"><?= set_value('pertanyaan') ?></textarea>
            <small class="form-text text-muted">
              <i class="fa fa-info-circle"></i> Pertanyaan yang akan ditampilkan saat customer melakukan diagnosis
            </small>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Gejala Kerusakan Terkait</label>
                <select name="gejala_kerusakan[]" 
                        class="form-control select2" 
                        multiple="multiple" 
                        data-placeholder="Pilih gejala yang menunjukkan kerusakan ini">
                  <?php foreach($gejala_list as $id => $nama): ?>
                    <option value="<?= $id ?>" <?= set_select('gejala_kerusakan[]', $id) ?>>
                      <?= $nama ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <small class="form-text text-muted">
                  <i class="fa fa-info-circle"></i> Pilih gejala-gejala yang mengindikasikan kerusakan ini
                </small>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label>Ilustrasi Gambar</label>
                <input type="file" 
                       name="ilustrasi_gambar" 
                       class="form-control" 
                       accept="image/*">
                <small class="form-text text-muted">
                  <i class="fa fa-image"></i> Format: JPG, PNG, GIF. Maks 2MB
                </small>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Tingkat Kerusakan <span class="text-danger">*</span></label>
                <select name="tingkat_kerusakan" 
                        class="form-control <?= form_error('tingkat_kerusakan') ? 'is-invalid' : '' ?>" 
                        required>
                  <option value="">-- Pilih Tingkat --</option>
                  <option value="ringan" <?= set_select('tingkat_kerusakan', 'ringan') ?>>
                    Ringan
                  </option>
                  <option value="sedang" <?= set_select('tingkat_kerusakan', 'sedang') ?>>
                    Sedang
                  </option>
                  <option value="berat" <?= set_select('tingkat_kerusakan', 'berat') ?>>
                    Berat
                  </option>
                </select>
                <?php if(form_error('tingkat_kerusakan')): ?>
                  <div class="invalid-feedback">
                    <?= form_error('tingkat_kerusakan') ?>
                  </div>
                <?php endif; ?>
                <small class="form-text text-muted">
                  Tingkat keparahan kerusakan furniture
                </small>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label>Status <span class="text-danger">*</span></label>
                <select name="status" 
                        class="form-control <?= form_error('status') ? 'is-invalid' : '' ?>" 
                        required>
                  <option value="1" <?= set_select('status', '1', true) ?>>Aktif</option>
                  <option value="0" <?= set_select('status', '0') ?>>Nonaktif</option>
                </select>
                <?php if(form_error('status')): ?>
                  <div class="invalid-feedback">
                    <?= form_error('status') ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          
          <div class="form-group mt-4">
            <button type="submit" class="btn btn-success">
              <i class="fa fa-save"></i> Simpan
            </button>
            <a href="<?= base_url('jenis_kerusakan') ?>" class="btn btn-secondary">
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
  $('.select2').select2({
    width: '100%',
    placeholder: 'Pilih gejala yang menunjukkan kerusakan ini',
    allowClear: true
  });
});
</script>
