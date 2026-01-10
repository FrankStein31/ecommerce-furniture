<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
        <span class="card-title">Edit Rekomendasi Perbaikan</span>
      </div>
      <div class="card-body">
        <form method="post" action="<?= base_url('rekomendasi_perbaikan/edit/'.$rekomendasi->id) ?>">
          
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Kode Rekomendasi <span class="text-danger">*</span></label>
                <input type="text" 
                       name="kode_rekomendasi" 
                       class="form-control" 
                       value="<?= $rekomendasi->kode_rekomendasi ?>" 
                       readonly
                       style="background-color: #e9ecef; cursor: not-allowed;">
                <small class="form-text text-muted">
                  <i class="fa fa-lock"></i> Kode tidak dapat diubah
                </small>
              </div>
            </div>
            
            <div class="col-md-9">
              <div class="form-group">
                <label>Nama Rekomendasi Perbaikan <span class="text-danger">*</span></label>
                <input type="text" 
                       name="nama_rekomendasi" 
                       class="form-control <?= form_error('nama_rekomendasi') ? 'is-invalid' : '' ?>" 
                       placeholder="Contoh: Ganti jok furniture baru"
                       value="<?= set_value('nama_rekomendasi', $rekomendasi->nama_rekomendasi) ?>" 
                       required>
                <?php if(form_error('nama_rekomendasi')): ?>
                  <div class="invalid-feedback">
                    <?= form_error('nama_rekomendasi') ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label>Deskripsi Rekomendasi</label>
            <textarea name="deskripsi_rekomendasi" 
                      class="form-control" 
                      rows="3" 
                      placeholder="Penjelasan detail mengenai rekomendasi perbaikan ini"><?= set_value('deskripsi_rekomendasi', $rekomendasi->deskripsi_rekomendasi) ?></textarea>
          </div>
          
          <!-- CERTAINTY FACTOR: MB dan MD -->
          <div class="card bg-light mb-3">
            <div class="card-header bg-info text-white">
              <i class="fa fa-calculator"></i> <strong>Certainty Factor (CF)</strong>
              <small class="float-right">CF = MB - MD</small>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>MB (Measure of Belief) <span class="text-danger">*</span></label>
                    <input type="number" 
                           name="mb_value" 
                           id="mb_value"
                           class="form-control <?= form_error('mb_value') ? 'is-invalid' : '' ?>" 
                           placeholder="0.00"
                           value="<?= set_value('mb_value', $rekomendasi->mb_value) ?>" 
                           step="0.01"
                           min="0"
                           max="1"
                           required
                           onchange="calculateCF()">
                    <small class="form-text text-muted">
                      <i class="fa fa-info-circle"></i> Ukuran kepercayaan (0.00 - 1.00)
                    </small>
                    <?php if(form_error('mb_value')): ?>
                      <div class="invalid-feedback">
                        <?= form_error('mb_value') ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="form-group">
                    <label>MD (Measure of Disbelief) <span class="text-danger">*</span></label>
                    <input type="number" 
                           name="md_value" 
                           id="md_value"
                           class="form-control <?= form_error('md_value') ? 'is-invalid' : '' ?>" 
                           placeholder="0.00"
                           value="<?= set_value('md_value', $rekomendasi->md_value) ?>" 
                           step="0.01"
                           min="0"
                           max="1"
                           required
                           onchange="calculateCF()">
                    <small class="form-text text-muted">
                      <i class="fa fa-info-circle"></i> Ukuran ketidakpercayaan (0.00 - 1.00)
                    </small>
                    <?php if(form_error('md_value')): ?>
                      <div class="invalid-feedback">
                        <?= form_error('md_value') ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="form-group">
                    <label>CF (Certainty Factor)</label>
                    <input type="text" 
                           id="cf_result"
                           class="form-control font-weight-bold" 
                           value="<?= number_format($rekomendasi->cf_value, 2) ?>"
                           readonly
                           style="background-color: #d1ecf1; font-size: 18px;">
                    <small class="form-text text-muted">
                      <i class="fa fa-calculator"></i> Hasil: MB - MD
                    </small>
                  </div>
                </div>
              </div>
              
              <div class="alert alert-warning mb-0">
                <i class="fa fa-exclamation-triangle"></i> 
                <strong>Penting:</strong> Total MB + MD tidak boleh lebih dari 1.00
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label>Solusi Perbaikan Detail</label>
            <textarea name="solusi_perbaikan" 
                      class="form-control" 
                      rows="4" 
                      placeholder="Langkah-langkah detail untuk melakukan perbaikan..."><?= set_value('solusi_perbaikan', $rekomendasi->solusi_perbaikan) ?></textarea>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Jenis Kerusakan Terkait</label>
                <select name="jenis_kerusakan[]" 
                        class="form-control select2" 
                        multiple="multiple" 
                        data-placeholder="Pilih jenis kerusakan yang ditangani rekomendasi ini">
                  <?php foreach($kerusakan_list as $id => $nama): ?>
                    <option value="<?= $id ?>" 
                            <?= in_array($id, $selected_kerusakan) ? 'selected' : '' ?>>
                      <?= $nama ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <small class="form-text text-muted">
                  <i class="fa fa-info-circle"></i> Pilih kerusakan yang dapat diperbaiki dengan rekomendasi ini
                </small>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label>Tingkat Prioritas <span class="text-danger">*</span></label>
                <select name="tingkat_prioritas" 
                        class="form-control <?= form_error('tingkat_prioritas') ? 'is-invalid' : '' ?>" 
                        required>
                  <option value="">-- Pilih Prioritas --</option>
                  <option value="rendah" 
                          <?= set_select('tingkat_prioritas', 'rendah', $rekomendasi->tingkat_prioritas == 'rendah') ?>>
                    Rendah
                  </option>
                  <option value="sedang" 
                          <?= set_select('tingkat_prioritas', 'sedang', $rekomendasi->tingkat_prioritas == 'sedang') ?>>
                    Sedang
                  </option>
                  <option value="tinggi" 
                          <?= set_select('tingkat_prioritas', 'tinggi', $rekomendasi->tingkat_prioritas == 'tinggi') ?>>
                    Tinggi
                  </option>
                </select>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Estimasi Biaya (Rp)</label>
                <input type="number" 
                       name="biaya_estimasi" 
                       class="form-control" 
                       placeholder="0"
                       value="<?= set_value('biaya_estimasi', $rekomendasi->biaya_estimasi) ?>" 
                       min="0">
                <small class="form-text text-muted">
                  <i class="fa fa-money"></i> Perkiraan biaya perbaikan
                </small>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label>Durasi Perbaikan (Hari)</label>
                <input type="number" 
                       name="durasi_perbaikan" 
                       class="form-control" 
                       placeholder="0"
                       value="<?= set_value('durasi_perbaikan', $rekomendasi->durasi_perbaikan) ?>" 
                       min="0">
                <small class="form-text text-muted">
                  <i class="fa fa-clock-o"></i> Perkiraan waktu pengerjaan
                </small>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label>Status <span class="text-danger">*</span></label>
                <select name="status" 
                        class="form-control <?= form_error('status') ? 'is-invalid' : '' ?>" 
                        required>
                  <option value="1" <?= set_select('status', '1', $rekomendasi->status == '1') ?>>Aktif</option>
                  <option value="0" <?= set_select('status', '0', $rekomendasi->status == '0') ?>>Nonaktif</option>
                </select>
              </div>
            </div>
          </div>
          
          <div class="form-group mt-4">
            <button type="submit" class="btn btn-success">
              <i class="fa fa-save"></i> Update
            </button>
            <a href="<?= base_url('rekomendasi_perbaikan') ?>" class="btn btn-secondary">
              <i class="fa fa-arrow-left"></i> Kembali
            </a>
          </div>
          
        </form>
        
        <!-- Info Timestamp -->
        <div class="card bg-light mt-3">
          <div class="card-body">
            <small class="text-muted">
              <i class="fa fa-info-circle"></i> 
              <strong>Dibuat:</strong> <?= date('d-m-Y H:i:s', strtotime($rekomendasi->created_at)) ?> 
              <?php if($rekomendasi->updated_at): ?>
                | <strong>Terakhir Diupdate:</strong> <?= date('d-m-Y H:i:s', strtotime($rekomendasi->updated_at)) ?>
              <?php endif; ?>
            </small>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  $('.select2').select2({
    width: '100%',
    placeholder: 'Pilih jenis kerusakan yang ditangani rekomendasi ini',
    allowClear: true
  });
  
  // Initial calculation
  calculateCF();
});

function calculateCF() {
  var mb = parseFloat($('#mb_value').val()) || 0;
  var md = parseFloat($('#md_value').val()) || 0;
  var cf = mb - md;
  var total = mb + md;
  
  $('#cf_result').val(cf.toFixed(2));
  
  // Change color based on CF value
  if (cf >= 0.7) {
    $('#cf_result').css('background-color', '#d4edda').css('color', '#155724');
  } else if (cf >= 0.4) {
    $('#cf_result').css('background-color', '#cce5ff').css('color', '#004085');
  } else if (cf >= 0) {
    $('#cf_result').css('background-color', '#d1ecf1').css('color', '#0c5460');
  } else {
    $('#cf_result').css('background-color', '#f8d7da').css('color', '#721c24');
  }
  
  // Validation warning
  if (total > 1.00) {
    $('#mb_value, #md_value').addClass('is-invalid');
    Swal.fire({
      icon: 'error',
      title: 'Validasi Gagal!',
      html: 'Total <strong>MB + MD</strong> tidak boleh lebih dari 1.00<br>Saat ini: <strong>' + total.toFixed(2) + '</strong>',
      confirmButtonText: 'OK'
    });
  } else {
    $('#mb_value, #md_value').removeClass('is-invalid');
  }
}
</script>
