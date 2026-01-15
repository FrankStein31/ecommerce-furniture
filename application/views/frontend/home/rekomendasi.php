<?php 
$current_step = $current_step ?? 1;
$diagnosis_data = $this->session->userdata('diagnosis_data') ?? array();
?>

<style>
  .diagnosis-wizard {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    padding: 25px;
    margin: 20px 0;
  }
  
  .step-indicator {
    display: flex;
    justify-content: space-between;
    margin-bottom: 25px;
    position: relative;
  }
  
  .step-item {
    flex: 1;
    text-align: center;
    position: relative;
    z-index: 1;
  }
  
  .step-item:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 15px;
    left: 50%;
    width: 100%;
    height: 2px;
    background: #e0e0e0;
    z-index: -1;
  }
  
  .step-item.completed:not(:last-child)::after {
    background: #28a745;
  }
  
  .step-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #e0e0e0;
    color: #666;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-bottom: 5px;
    font-size: 14px;
  }
  
  .step-item.active .step-circle {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
  }
  
  .step-item.completed .step-circle {
    background: #28a745;
    color: white;
  }
  
  .step-label {
    font-size: 11px;
    color: #666;
    font-weight: 500;
  }
  
  .step-item.active .step-label {
    color: #667eea;
    font-weight: bold;
  }
  
  .option-card {
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    padding: 12px 15px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: all 0.2s;
    background: white;
    display: block;
  }
  
  .option-card:hover {
    border-color: #667eea;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
    transform: translateY(-1px);
  }
  
  .option-card.selected {
    border-color: #667eea;
    background: #f8f9ff;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
  }
  
  .question-card {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 12px;
    background: #fafafa;
  }
  
  .cf-options {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 6px;
    margin-top: 10px;
  }
  
  .cf-option {
    padding: 6px 4px;
    border: 2px solid #e0e0e0;
    border-radius: 6px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 10px;
  }
  
  .cf-option:hover {
    border-color: #667eea;
  }
  
  .cf-option.selected {
    border-color: #667eea;
    background: #f8f9ff;
    font-weight: bold;
  }
  
  .btn-wizard {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 8px 20px;
    font-size: 14px;
    border-radius: 20px;
    transition: all 0.2s;
  }
  
  .btn-wizard:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(102, 126, 234, 0.3);
    color: white;
  }
  
  .result-card {
    border: 2px solid #28a745;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 12px;
    background: linear-gradient(135deg, #f8fff9 0%, #e8f5e9 100%);
  }
  
  .result-rank {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: bold;
    margin-right: 15px;
    flex-shrink: 0;
  }
  
  .form-check-inline {
    margin-right: 15px;
  }
  
  .form-check-input {
    cursor: pointer;
  }
  
  .form-check-label {
    cursor: pointer;
    font-size: 14px;
  }
  
  /* Reasoning Timeline Styles */
  .reasoning-timeline {
    position: relative;
  }
  
  .reasoning-step {
    animation: fadeInLeft 0.3s ease-out;
  }
  
  @keyframes fadeInLeft {
    from {
      opacity: 0;
      transform: translateX(-20px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }
  
  .accordion .card-header:hover {
    opacity: 0.9;
  }
  
  details summary::-webkit-details-marker {
    display: none;
  }
  
  details summary {
    list-style: none;
    outline: none;
  }
  
  details summary::before {
    content: '▶ ';
    font-size: 10px;
    margin-right: 4px;
    transition: transform 0.2s;
    display: inline-block;
  }
  
  details[open] summary::before {
    transform: rotate(90deg);
  }
  
  details[open] summary {
    margin-bottom: 8px;
  }
  
  /* Syntax highlighting for code */
  code {
    background: #f5f5f5;
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 11px;
    color: #d63384;
    font-family: 'Courier New', monospace;
  }
  
  /* Table styling */
  .table-sm {
    margin-bottom: 0;
  }
  
  .table-sm td, .table-sm th {
    padding: 6px 8px;
    vertical-align: middle;
    line-height: 1.4;
  }
  
  .table-bordered {
    border: 1px solid #dee2e6;
  }
  
  .table-bordered td,
  .table-bordered th {
    border: 1px solid #dee2e6;
  }
  
  /* Scrollbar styling */
  ::-webkit-scrollbar {
    width: 8px;
    height: 8px;
  }
  
  ::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
  }
  
  ::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
  }
  
  ::-webkit-scrollbar-thumb:hover {
    background: #555;
  }
  
  /* Pre styling for JSON data */
  pre {
    white-space: pre-wrap;
    word-wrap: break-word;
    margin-bottom: 0;
  }
  
  /* Badge improvements */
  .badge {
    font-weight: 600;
    letter-spacing: 0.3px;
    padding: 4px 8px;
    font-size: 11px;
    vertical-align: middle;
    white-space: nowrap;
    display: inline-block;
    margin: 2px;
  }
  
  /* Card improvements */
  .card {
    transition: box-shadow 0.2s;
    margin-bottom: 15px;
    overflow: hidden;
  }
  
  .card:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }
  
  .card-header {
    padding: 12px 15px;
  }
  
  .card-body {
    padding: 15px;
  }
  
  /* Accordion collapse spacing - prevent overlap */
  .accordion .card {
    margin-bottom: 10px;
  }
  
  .collapse {
    transition: height 0.35s ease;
  }
  
  .collapse.show .card-body {
    padding-top: 15px;
  }
  
  /* Result card spacing improvements */
  .result-card {
    margin-bottom: 20px;
    page-break-inside: avoid;
  }
  
  .result-card .row {
    margin-left: -5px;
    margin-right: -5px;
  }
  
  .result-card [class*="col-"] {
    padding-left: 5px;
    padding-right: 5px;
    margin-bottom: 8px;
  }
  
  /* Details/Summary spacing */
  details {
    margin-bottom: 12px;
  }
  
  details summary {
    padding: 8px 0;
    margin-bottom: 0;
  }
  
  details[open] summary {
    margin-bottom: 10px;
    padding-bottom: 8px;
    border-bottom: 1px solid #e0e0e0;
  }
  
  /* Trace box improvements */
  .trace-box, 
  details > div {
    word-wrap: break-word;
    overflow-wrap: break-word;
    hyphens: auto;
  }
  
  /* Table responsive fix */
  .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }
  
  /* Prevent text overflow in small containers */
  .text-break {
    word-wrap: break-word;
    overflow-wrap: break-word;
    word-break: break-word;
  }
  
  /* Responsive improvements */
  @media (max-width: 768px) {
    .card-body {
      padding: 12px;
    }
    
    .card-header {
      padding: 10px 12px;
    }
    
    .result-card [class*="col-"] {
      margin-bottom: 10px;
    }
    
    .table-sm {
      font-size: 10px;
    }
    
    .table-sm td, 
    .table-sm th {
      padding: 6px !important;
    }
    
    .badge {
      font-size: 10px;
      padding: 3px 6px;
    }
  }
  
  /* Button spacing fix */
  .btn {
    margin: 3px;
  }
  
  .btn-group .btn {
    margin: 0;
  }
  
  /* Details summary improvements */
  details summary {
    transition: color 0.2s;
  }
  
  details summary:hover {
    color: #764ba2 !important;
  }
</style>

<div class="section">
  <div class="container">
    <div class="diagnosis-wizard">
      
      <!-- Step Indicator -->
      <div class="step-indicator">
        <div class="step-item <?= $current_step >= 1 ? ($current_step == 1 ? 'active' : 'completed') : '' ?>">
          <div class="step-circle"><?= $current_step > 1 ? '<i class="fa fa-check"></i>' : '1' ?></div>
          <div class="step-label">Kategori</div>
        </div>
        <div class="step-item <?= $current_step >= 2 ? ($current_step == 2 ? 'active' : 'completed') : '' ?>">
          <div class="step-circle"><?= $current_step > 2 ? '<i class="fa fa-check"></i>' : '2' ?></div>
          <div class="step-label">Jenis Perbaikan</div>
        </div>
        <div class="step-item <?= $current_step >= 3 ? ($current_step == 3 ? 'active' : 'completed') : '' ?>">
          <div class="step-circle"><?= $current_step > 3 ? '<i class="fa fa-check"></i>' : '3' ?></div>
          <div class="step-label">Gejala</div>
        </div>
        <div class="step-item <?= $current_step >= 4 ? ($current_step == 4 ? 'active' : 'completed') : '' ?>">
          <div class="step-circle"><?= $current_step > 4 ? '<i class="fa fa-check"></i>' : '4' ?></div>
          <div class="step-label">Kerusakan</div>
        </div>
        <div class="step-item <?= $current_step == 5 ? 'active' : '' ?>">
          <div class="step-circle">5</div>
          <div class="step-label">Hasil</div>
        </div>
      </div>

      <!-- Step Content -->
      <?php if ($current_step == 1): ?>
        <!-- STEP 1: PILIH KATEGORI -->
        <div class="text-center mb-3">
          <h4><i class="fa fa-couch"></i> Pilih Kategori Furniture</h4>
          <p class="text-muted mb-3" style="font-size: 13px;">Silakan pilih jenis furniture yang mengalami kerusakan</p>
        </div>

        <!-- Search Box -->
        <div class="mb-3">
          <form method="get" action="<?= base_url('home/rekomendasi') ?>" id="form-search-kategori">
            <input type="hidden" name="step" value="1">
            <div class="input-group">
              <input type="text" class="form-control" name="search_kategori" 
                     placeholder="Cari kategori furniture..." 
                     value="<?= isset($search_kategori) ? $search_kategori : '' ?>"
                     style="border-radius: 20px 0 0 20px;">
              <div class="input-group-append">
                <button class="btn btn-wizard" type="submit" style="border-radius: 0 20px 20px 0; padding: 8px 20px;">
                  <i class="fa fa-search"></i> Cari
                </button>
              </div>
            </div>
          </form>
        </div>

        <form method="post" action="<?= base_url('home/rekomendasi?step=1') ?>" id="form-kategori">
          <div class="row">
            <?php if(!empty($kategori_list)): ?>
              <?php foreach($kategori_list as $id => $nama): ?>
                <div class="col-md-6">
                  <label class="option-card">
                    <input type="radio" name="id_kategori" value="<?= $id ?>" required style="display: none;">
                    <div class="d-flex align-items-center">
                      <div style="font-size: 28px; margin-right: 12px; color: #667eea;">
                        <i class="fa fa-couch"></i>
                      </div>
                      <div>
                        <h6 class="mb-0"><?= $nama ?></h6>
                        <small class="text-muted" style="font-size: 11px;">Klik untuk memilih</small>
                      </div>
                    </div>
                  </label>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="col-12">
                <div class="alert alert-warning mb-0">
                  <i class="fa fa-exclamation-triangle"></i> <?= isset($search_kategori) && $search_kategori ? 'Tidak ada kategori yang cocok dengan pencarian' : 'Belum ada kategori tersedia' ?>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </form>

      <?php elseif ($current_step == 2): ?>
        <!-- STEP 2: PILIH JENIS PERBAIKAN -->
        <div class="text-center mb-3">
          <h4><i class="fa fa-wrench"></i> Pilih Jenis Perbaikan</h4>
          <?php if (isset($kategori_selected) && $kategori_selected): ?>
            <div class="alert alert-info py-2 mb-3" style="font-size: 12px;">
              <i class="fa fa-info-circle"></i> Kategori: <strong><?= $kategori_selected->nama_kategori ?></strong>
            </div>
          <?php endif; ?>
          <p class="text-muted mb-2" style="font-size: 13px;">Pilih jenis perbaikan yang sesuai dengan kebutuhan</p>
          <?php if (isset($total_rows)): ?>
            <small class="text-muted">Menampilkan <?= count($jenis_perbaikan_list) ?> dari <?= $total_rows ?> jenis perbaikan</small>
          <?php endif; ?>
        </div>

        <!-- Search Box -->
        <div class="mb-3">
          <form method="get" action="<?= base_url('home/rekomendasi') ?>" id="form-search-jenis">
            <input type="hidden" name="step" value="2">
            <div class="input-group">
              <input type="text" class="form-control" name="search_jenis" 
                     placeholder="Cari jenis perbaikan..." 
                     value="<?= isset($search_jenis) ? $search_jenis : '' ?>"
                     style="border-radius: 20px 0 0 20px;">
              <div class="input-group-append">
                <button class="btn btn-wizard" type="submit" style="border-radius: 0 20px 20px 0; padding: 8px 20px;">
                  <i class="fa fa-search"></i> Cari
                </button>
              </div>
            </div>
          </form>
        </div>

        <form method="post" action="<?= base_url('home/rekomendasi?step=2') ?>" id="form-jenis-perbaikan">
          <div class="row">
            <?php if(!empty($jenis_perbaikan_list)): ?>
              <?php foreach($jenis_perbaikan_list as $item): ?>
                <div class="col-md-6">
                  <label class="option-card">
                    <input type="radio" name="id_jenis_perbaikan" value="<?= $item->id ?>" required style="display: none;">
                    <div class="d-flex align-items-center">
                      <div style="font-size: 24px; margin-right: 10px; color: #667eea;">
                        <i class="fa fa-tools"></i>
                      </div>
                      <div style="flex: 1;">
                        <div style="font-size: 14px; font-weight: 600;"><?= $item->nama_jenis_perbaikan ?></div>
                        <?php if (!empty($item->deskripsi)): ?>
                          <small class="text-muted" style="font-size: 11px;"><?= substr($item->deskripsi, 0, 50) . (strlen($item->deskripsi) > 50 ? '...' : '') ?></small>
                        <?php endif; ?>
                      </div>
                    </div>
                  </label>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="col-12">
                <div class="alert alert-warning mb-0">
                  <i class="fa fa-exclamation-triangle"></i> <?= isset($search_jenis) && $search_jenis ? 'Tidak ada jenis perbaikan yang cocok' : 'Belum ada jenis perbaikan untuk kategori ini' ?>
                </div>
              </div>
            <?php endif; ?>
          </div>
          
          <!-- Pagination -->
          <?php if (isset($total_pages) && $total_pages > 1): ?>
            <div class="text-center mt-3 mb-3">
              <div class="btn-group" role="group">
                <?php if ($current_page > 1): ?>
                  <a href="<?= base_url('home/rekomendasi?step=2&page=' . ($current_page - 1) . (isset($search_jenis) ? '&search_jenis=' . urlencode($search_jenis) : '')) ?>" 
                     class="btn btn-sm btn-outline-secondary">
                    <i class="fa fa-chevron-left"></i> Prev
                  </a>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                  <a href="<?= base_url('home/rekomendasi?step=2&page=' . $i . (isset($search_jenis) ? '&search_jenis=' . urlencode($search_jenis) : '')) ?>" 
                     class="btn btn-sm <?= $i == $current_page ? 'btn-wizard' : 'btn-outline-secondary' ?>">
                    <?= $i ?>
                  </a>
                <?php endfor; ?>
                
                <?php if ($current_page < $total_pages): ?>
                  <a href="<?= base_url('home/rekomendasi?step=2&page=' . ($current_page + 1) . (isset($search_jenis) ? '&search_jenis=' . urlencode($search_jenis) : '')) ?>" 
                     class="btn btn-sm btn-outline-secondary">
                    Next <i class="fa fa-chevron-right"></i>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>
          
          <div class="text-center mt-3">
            <a href="<?= base_url('home/rekomendasi?step=1') ?>" class="btn btn-secondary btn-sm mr-2">
              <i class="fa fa-arrow-left"></i> Kembali
            </a>
          </div>
        </form>

      <?php elseif ($current_step == 3): ?>
        <!-- STEP 3: PERTANYAAN GEJALA (SATU PER SATU) -->
        <div class="text-center mb-4">
          <h4><i class="fa fa-question-circle"></i> Pertanyaan Gejala Kerusakan</h4>
          <p class="text-muted mb-2" style="font-size: 13px;">Jawab pertanyaan berikut sesuai kondisi furniture Anda</p>
        </div>

        <?php if ($current_gejala): ?>
          <form method="post" action="<?= base_url('home/rekomendasi?step=3') ?>" id="form-gejala-single">
            <input type="hidden" name="id_gejala" value="<?= $current_gejala->id ?>">
            <input type="hidden" name="selesai" id="selesai_gejala" value="0">
            
            <div class="question-card" style="padding: 20px;">
              <div class="text-center mb-3">
                <span class="badge badge-primary" style="font-size: 12px; padding: 8px 12px;">
                  <?= $current_gejala->kode_gejala ?>
                </span>
              </div>
              
              <h5 class="text-center mb-3" style="font-size: 16px; font-weight: 600;">
                <?= $current_gejala->pertanyaan ?: $current_gejala->nama_gejala ?>
              </h5>
              
              <?php if ($current_gejala->deskripsi_gejala): ?>
                <p class="text-muted text-center mb-4" style="font-size: 13px;">
                  <i class="fa fa-info-circle"></i> <?= $current_gejala->deskripsi_gejala ?>
                </p>
              <?php endif; ?>
              
              <div class="text-center mb-3">
                <div class="btn-group" role="group">
                  <button type="button" class="btn btn-outline-success btn-jawab" data-jawaban="ya" style="min-width: 80px; padding: 8px 20px; border-radius: 20px 0 0 20px;">
                    <i class="fa fa-check"></i> Ya
                  </button>
                  <button type="button" class="btn btn-outline-danger btn-jawab" data-jawaban="tidak" style="min-width: 80px; padding: 8px 20px; border-radius: 0 20px 20px 0;">
                    <i class="fa fa-times"></i> Tidak
                  </button>
                </div>
                <input type="hidden" name="jawaban" id="jawaban_value" required>
              </div>
              
              <div id="cf-section" style="display: none; margin-top: 20px; padding-top: 20px; border-top: 2px solid #eee;">
                <label class="d-block text-center mb-3" style="font-size: 14px; font-weight: 600;">
                  <i class="fa fa-sliders-h"></i> Tingkat Keyakinan Anda:
                </label>
                <div class="cf-options">
                  <label class="cf-option">
                    <input type="radio" name="cf_value" value="0.2" style="display: none;">
                    <div style="font-weight: 600; font-size: 11px;">Sangat Ragu</div>
                    <small class="text-muted" style="font-size: 10px;">20%</small>
                  </label>
                  <label class="cf-option">
                    <input type="radio" name="cf_value" value="0.4" style="display: none;">
                    <div style="font-weight: 600; font-size: 11px;">Tidak Yakin</div>
                    <small class="text-muted" style="font-size: 10px;">40%</small>
                  </label>
                  <label class="cf-option">
                    <input type="radio" name="cf_value" value="0.6" style="display: none;" checked>
                    <div style="font-weight: 600; font-size: 11px;">Cukup Yakin</div>
                    <small class="text-muted" style="font-size: 10px;">60%</small>
                  </label>
                  <label class="cf-option">
                    <input type="radio" name="cf_value" value="0.8" style="display: none;">
                    <div style="font-weight: 600; font-size: 11px;">Yakin</div>
                    <small class="text-muted" style="font-size: 10px;">80%</small>
                  </label>
                  <label class="cf-option">
                    <input type="radio" name="cf_value" value="1.0" style="display: none;">
                    <div style="font-weight: 600; font-size: 11px;">Sangat Yakin</div>
                    <small class="text-muted" style="font-size: 10px;">100%</small>
                  </label>
                </div>
              </div>
            </div>
            
            <div class="text-center mt-4">
              <a href="<?= base_url('home/rekomendasi?step=2') ?>" class="btn btn-secondary btn-sm mr-2">
                <i class="fa fa-arrow-left"></i> Kembali
              </a>
              <button type="submit" class="btn btn-wizard" id="btn-next-gejala" disabled>
                <?= $current_index < $total_gejala ? 'Lanjut' : 'Selesai' ?> <i class="fa fa-arrow-right ml-1"></i>
              </button>
            </div>
          </form>
        <?php else: ?>
          <!-- Semua gejala sudah dijawab -->
          <div class="alert alert-success text-center">
            <i class="fa fa-check-circle fa-3x mb-3"></i>
            <h5>Pertanyaan Gejala Selesai!</h5>
            <p class="mb-3">Anda telah menjawab <?= count($jawaban_gejala) ?> pertanyaan gejala.</p>
            <a href="<?= base_url('home/rekomendasi?step=4') ?>" class="btn btn-wizard">
              Lanjut ke Pertanyaan Kerusakan <i class="fa fa-arrow-right ml-1"></i>
            </a>
          </div>
        <?php endif; ?>

      <?php elseif ($current_step == 4): ?>
        <!-- STEP 4: PERTANYAAN KERUSAKAN (SATU PER SATU) -->
        <div class="text-center mb-4">
          <h4><i class="fa fa-exclamation-triangle"></i> Pertanyaan Jenis Kerusakan</h4>
          <p class="text-muted mb-2" style="font-size: 13px;">Identifikasi jenis kerusakan yang dialami</p>
        </div>

        <?php if ($current_kerusakan): ?>
          <form method="post" action="<?= base_url('home/rekomendasi?step=4') ?>" id="form-kerusakan-single">
            <input type="hidden" name="id_kerusakan" value="<?= $current_kerusakan->id ?>">
            <input type="hidden" name="selesai" id="selesai_kerusakan" value="0">
            
            <div class="question-card" style="padding: 20px;">
              <div class="text-center mb-3">
                <?php if($current_kerusakan->ilustrasi_gambar): ?>
                  <img src="<?= base_url($current_kerusakan->ilustrasi_gambar) ?>" 
                       alt="<?= $current_kerusakan->nama_jenis_kerusakan ?>" 
                       style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px; margin-bottom: 10px;">
                <?php endif; ?>
                <div>
                  <span class="badge badge-danger" style="font-size: 12px; padding: 8px 12px;">
                    <?= $current_kerusakan->kode_kerusakan ?>
                  </span>
                  <span class="badge badge-<?= $current_kerusakan->tingkat_kerusakan == 'berat' ? 'danger' : ($current_kerusakan->tingkat_kerusakan == 'sedang' ? 'warning' : 'info') ?> ml-1" style="font-size: 12px; padding: 8px 12px;">
                    <?= ucfirst($current_kerusakan->tingkat_kerusakan) ?>
                  </span>
                </div>
              </div>
              
              <h5 class="text-center mb-3" style="font-size: 16px; font-weight: 600;">
                <?= $current_kerusakan->pertanyaan ?: 'Apakah furniture mengalami: '.$current_kerusakan->nama_jenis_kerusakan.'?' ?>
              </h5>
              
              <?php if ($current_kerusakan->detail_kerusakan): ?>
                <p class="text-muted text-center mb-4" style="font-size: 13px;">
                  <i class="fa fa-info-circle"></i> <?= $current_kerusakan->detail_kerusakan ?>
                </p>
              <?php endif; ?>
              
              <div class="text-center mb-3">
                <div class="btn-group" role="group">
                  <button type="button" class="btn btn-outline-success btn-jawab-kerusakan" data-jawaban="ya" style="min-width: 80px; padding: 8px 20px; border-radius: 20px 0 0 20px;">
                    <i class="fa fa-check"></i> Ya
                  </button>
                  <button type="button" class="btn btn-outline-danger btn-jawab-kerusakan" data-jawaban="tidak" style="min-width: 80px; padding: 8px 20px; border-radius: 0 20px 20px 0;">
                    <i class="fa fa-times"></i> Tidak
                  </button>
                </div>
                <input type="hidden" name="jawaban" id="jawaban_kerusakan_value" required>
              </div>
              
              <div id="cf-section-kerusakan" style="display: none; margin-top: 20px; padding-top: 20px; border-top: 2px solid #eee;">
                <label class="d-block text-center mb-3" style="font-size: 14px; font-weight: 600;">
                  <i class="fa fa-sliders-h"></i> Tingkat Keyakinan Anda:
                </label>
                <div class="cf-options">
                  <label class="cf-option">
                    <input type="radio" name="cf_value" value="0.2" style="display: none;">
                    <div style="font-weight: 600; font-size: 11px;">Sangat Ragu</div>
                    <small class="text-muted" style="font-size: 10px;">20%</small>
                  </label>
                  <label class="cf-option">
                    <input type="radio" name="cf_value" value="0.4" style="display: none;">
                    <div style="font-weight: 600; font-size: 11px;">Tidak Yakin</div>
                    <small class="text-muted" style="font-size: 10px;">40%</small>
                  </label>
                  <label class="cf-option">
                    <input type="radio" name="cf_value" value="0.6" style="display: none;" checked>
                    <div style="font-weight: 600; font-size: 11px;">Cukup Yakin</div>
                    <small class="text-muted" style="font-size: 10px;">60%</small>
                  </label>
                  <label class="cf-option">
                    <input type="radio" name="cf_value" value="0.8" style="display: none;">
                    <div style="font-weight: 600; font-size: 11px;">Yakin</div>
                    <small class="text-muted" style="font-size: 10px;">80%</small>
                  </label>
                  <label class="cf-option">
                    <input type="radio" name="cf_value" value="1.0" style="display: none;">
                    <div style="font-weight: 600; font-size: 11px;">Sangat Yakin</div>
                    <small class="text-muted" style="font-size: 10px;">100%</small>
                  </label>
                </div>
              </div>
            </div>
            
            <div class="text-center mt-4">
              <a href="<?= base_url('home/rekomendasi?step=3') ?>" class="btn btn-secondary btn-sm mr-2">
                <i class="fa fa-arrow-left"></i> Kembali
              </a>
              <button type="submit" class="btn btn-wizard" id="btn-next-kerusakan" disabled>
                <?= $current_index < $total_kerusakan ? 'Lanjut' : 'Lihat Hasil' ?> <i class="fa fa-<?= $current_index < $total_kerusakan ? 'arrow-right' : 'check' ?> ml-1"></i>
              </button>
            </div>
          </form>
        <?php else: ?>
          <!-- Tidak ada kerusakan atau semua sudah dijawab -->
          <div class="alert alert-<?= empty($jawaban_kerusakan) ? 'info' : 'success' ?> text-center">
            <i class="fa fa-<?= empty($jawaban_kerusakan) ? 'info-circle' : 'check-circle' ?> fa-3x mb-3"></i>
            <?php if (empty($jawaban_kerusakan)): ?>
              <h5>Tidak Ada Kerusakan Terdeteksi</h5>
              <p class="mb-3">Berdasarkan gejala yang Anda pilih, tidak ditemukan kerusakan yang relevan.</p>
              <a href="<?= base_url('home/rekomendasi?step=3') ?>" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali ke Gejala
              </a>
            <?php else: ?>
              <h5>Pertanyaan Kerusakan Selesai!</h5>
              <p class="mb-3">Anda telah menjawab <?= count($jawaban_kerusakan) ?> pertanyaan kerusakan.</p>
              <a href="<?= base_url('home/rekomendasi?step=5') ?>" class="btn btn-wizard">
                Lihat Hasil Diagnosis <i class="fa fa-check ml-1"></i>
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>

      <?php elseif ($current_step == 5): ?>
        <!-- STEP 5: HASIL DIAGNOSIS -->
        <div class="text-center mb-4">
          <h4><i class="fa fa-trophy"></i> Hasil Diagnosis & Rekomendasi</h4>
          <p class="text-muted mb-3" style="font-size: 13px;">Berikut adalah hasil diagnosis lengkap untuk furniture Anda</p>
        </div>

        <!-- RIWAYAT DIAGNOSIS -->
        <div style="background: white; border-radius: 8px; padding: 15px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
          <h5 style="font-size: 15px; font-weight: 700; margin-bottom: 15px; color: #333;">
            <i class="fa fa-clipboard-list"></i> Riwayat Diagnosis
          </h5>
          
          <!-- Kategori -->
          <div class="mb-3 pb-3" style="border-bottom: 1px solid #eee;">
            <div class="d-flex align-items-start">
              <div style="min-width: 140px;">
                <strong style="font-size: 13px;"><i class="fa fa-tag text-primary"></i> Kategori:</strong>
              </div>
              <div>
                <span style="font-size: 13px;"><?= isset($kategori) ? $kategori->nama_kategori : '-' ?></span>
              </div>
            </div>
          </div>
          
          <!-- Jenis Perbaikan -->
          <div class="mb-3 pb-3" style="border-bottom: 1px solid #eee;">
            <div class="d-flex align-items-start">
              <div style="min-width: 140px;">
                <strong style="font-size: 13px;"><i class="fa fa-wrench text-info"></i> Jenis Perbaikan:</strong>
              </div>
              <div>
                <span style="font-size: 13px;"><?= isset($jenis_perbaikan) ? $jenis_perbaikan->nama_jenis_perbaikan : '-' ?></span>
              </div>
            </div>
          </div>
          
          <!-- Gejala -->
          <div class="mb-3 pb-3" style="border-bottom: 1px solid #eee;">
            <div class="d-flex align-items-start">
              <div style="min-width: 140px;">
                <strong style="font-size: 13px;"><i class="fa fa-question-circle text-warning"></i> Gejala Dipilih:</strong>
              </div>
              <div class="flex-grow-1">
                <?php if(isset($gejala_dipilih) && !empty($gejala_dipilih)): ?>
                  <?php foreach($gejala_dipilih as $g): ?>
                    <div class="mb-2" style="font-size: 12px;">
                      <span class="badge badge-warning" style="font-size: 10px;"><?= $g['data']->kode_gejala ?></span>
                      <span><?= $g['data']->nama_gejala ?></span>
                      <span class="badge badge-light ml-1" style="font-size: 10px;">CF: <?= number_format($g['cf_persen'], 0) ?>%</span>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <span class="text-muted" style="font-size: 12px;">Tidak ada</span>
                <?php endif; ?>
              </div>
            </div>
          </div>
          
          <!-- Kerusakan -->
          <div class="mb-0">
            <div class="d-flex align-items-start">
              <div style="min-width: 140px;">
                <strong style="font-size: 13px;"><i class="fa fa-exclamation-triangle text-danger"></i> Kerusakan Terdeteksi:</strong>
              </div>
              <div class="flex-grow-1">
                <?php if(isset($kerusakan_dipilih) && !empty($kerusakan_dipilih)): ?>
                  <?php foreach($kerusakan_dipilih as $k): ?>
                    <div class="mb-2" style="font-size: 12px;">
                      <span class="badge badge-danger" style="font-size: 10px;"><?= $k['data']->kode_kerusakan ?></span>
                      <span><?= $k['data']->nama_jenis_kerusakan ?></span>
                      <span class="badge badge-light ml-1" style="font-size: 10px;">CF: <?= number_format($k['cf_persen'], 0) ?>%</span>
                      <span class="badge badge-<?= $k['data']->tingkat_kerusakan == 'berat' ? 'danger' : ($k['data']->tingkat_kerusakan == 'sedang' ? 'warning' : 'info') ?> ml-1" style="font-size: 10px;">
                        <?= ucfirst($k['data']->tingkat_kerusakan) ?>
                      </span>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <span class="text-muted" style="font-size: 12px;">Tidak ada</span>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <!-- REKOMENDASI PERBAIKAN -->
        <div style="background: white; border-radius: 8px; padding: 15px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
          <h5 style="font-size: 15px; font-weight: 700; margin-bottom: 15px; color: #333;">
            <i class="fa fa-lightbulb-o"></i> Rekomendasi Perbaikan
          </h5>
          
          <?php if(!empty($hasil_cf)): ?>
            <!-- REASONING PROCESS VISUALIZATION -->
            <?php 
              $reasoning_log = $this->session->userdata('reasoning_log');
              $rule_conflicts = $this->session->userdata('rule_conflicts');
              $redundant_rules = $this->session->userdata('redundant_rules');
            ?>
            
            <div class="accordion mb-4" id="reasoningAccordion" style="clear: both;">
              <div class="card" style="border: 2px solid #667eea; border-radius: 8px; margin-bottom: 15px; overflow: hidden;">
                <div class="card-header" id="reasoningHeader" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); cursor: pointer; border-radius: 6px 6px 0 0; padding: 12px 15px;" data-toggle="collapse" data-target="#reasoningCollapse">
                  <h6 class="mb-0" style="color: white;">
                    <i class="fa fa-brain"></i> <strong>Proses Reasoning Sistem Pakar</strong>
                    <span class="float-right"><i class="fa fa-chevron-down"></i></span>
                  </h6>
                  <small style="color: #e0e0e0; font-size: 11px;">
                    Forward Chaining · Certainty Factor · Rule-based Inference
                  </small>
                </div>
                <div id="reasoningCollapse" class="collapse" data-parent="#reasoningAccordion">
                  <div class="card-body" style="max-height: 500px; overflow-y: auto; font-size: 12px; background: #fafafa; padding: 15px;">
                    
                    <?php if ($reasoning_log): ?>
                      <div class="reasoning-timeline" style="position: relative;">
                        <?php foreach ($reasoning_log as $idx => $log): ?>
                          <div class="reasoning-step mb-3 pb-3" style="border-left: 3px solid <?= 
                            ($log['type'] ?? 'info') == 'success' ? '#28a745' : 
                            (($log['type'] ?? 'info') == 'error' ? '#dc3545' : 
                            (($log['type'] ?? 'info') == 'warning' ? '#ffc107' : '#667eea')) 
                          ?>; padding-left: 15px; position: relative; background: white; border-radius: 0 6px 6px 0; margin-left: 10px; padding: 12px 15px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                            
                            <div style="position: absolute; left: -8px; top: 12px; width: 14px; height: 14px; border-radius: 50%; background: <?= 
                              ($log['type'] ?? 'info') == 'success' ? '#28a745' : 
                              (($log['type'] ?? 'info') == 'error' ? '#dc3545' : 
                              (($log['type'] ?? 'info') == 'warning' ? '#ffc107' : '#667eea')) 
                            ?>; border: 3px solid white; box-shadow: 0 0 0 2px #fafafa;"></div>
                            
                            <div style="font-weight: 600; color: #333; margin-bottom: 8px;">
                              <span class="badge badge-<?= 
                                ($log['type'] ?? 'info') == 'success' ? 'success' : 
                                (($log['type'] ?? 'info') == 'error' ? 'danger' : 
                                (($log['type'] ?? 'info') == 'warning' ? 'warning' : 'primary')) 
                              ?>" style="font-size: 9px; padding: 4px 8px;">
                                STEP <?= $idx + 1 ?>
                              </span>
                              <span style="font-size: 11px; text-transform: uppercase; color: #666; margin-left: 5px;">
                                <?= str_replace('_', ' ', $log['step']) ?>
                              </span>
                            </div>
                            
                            <div style="color: #555; line-height: 1.6; font-size: 12px; margin-bottom: 8px;">
                              <?= $log['message'] ?>
                            </div>
                            
                            <?php if (!empty($log['data']) && !isset($log['data']['trace'])): ?>
                              <details style="margin-top: 8px;">
                                <summary style="cursor: pointer; color: #667eea; font-size: 11px; font-weight: 600; padding: 4px 0;">
                                  <i class="fa fa-code"></i> Detail Data
                                </summary>
                                <pre style="background: #f8f9fa; padding: 10px; border-radius: 4px; font-size: 10px; margin-top: 8px; max-height: 150px; overflow: auto; border: 1px solid #e0e0e0;"><?= json_encode($log['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?></pre>
                              </details>
                            <?php endif; ?>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    <?php endif; ?>
                    
                    <!-- KNOWLEDGE BASE QUALITY METRICS -->
                    <div class="mt-3 p-3" style="background: white; border-radius: 6px; border: 1px solid #e0e0e0;">
                      <h6 style="font-size: 13px; font-weight: 700; margin-bottom: 12px; color: #333;">
                        <i class="fa fa-chart-bar"></i> Quality Metrics Knowledge Base
                      </h6>
                      <div class="row" style="margin-left: -5px; margin-right: -5px;">
                        <div class="col-md-4 mb-3" style="padding-left: 5px; padding-right: 5px;">
                          <div class="text-center p-3" style="background: #fafafa; border-radius: 6px; border: 1px solid #e0e0e0; height: 100%; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-size: 24px; font-weight: 700; color: <?= empty($rule_conflicts) ? '#28a745' : '#ffc107' ?>;">
                              <?= empty($rule_conflicts) ? '0' : count($rule_conflicts) ?>
                            </div>
                            <div style="font-size: 11px; color: #666; margin-top: 4px;">Rule Conflicts</div>
                            <div style="font-size: 9px; color: #999; margin-top: 2px;">
                              <?= empty($rule_conflicts) ? '✓ Excellent' : '⚠ Needs Review' ?>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4 mb-3" style="padding-left: 5px; padding-right: 5px;">
                          <div class="text-center p-3" style="background: #fafafa; border-radius: 6px; border: 1px solid #e0e0e0; height: 100%; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-size: 24px; font-weight: 700; color: <?= empty($redundant_rules) ? '#28a745' : '#ffc107' ?>;">
                              <?= empty($redundant_rules) ? '0' : count($redundant_rules) ?>
                            </div>
                            <div style="font-size: 11px; color: #666; margin-top: 4px;">Redundancies</div>
                            <div style="font-size: 9px; color: #999; margin-top: 2px;">
                              <?= empty($redundant_rules) ? '✓ Optimized' : '⚠ Can Optimize' ?>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4 mb-3" style="padding-left: 5px; padding-right: 5px;">
                          <div class="text-center p-3" style="background: #fafafa; border-radius: 6px; border: 1px solid #e0e0e0; height: 100%; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-size: 24px; font-weight: 700; color: #667eea;">
                              <?= count($hasil_cf) ?>
                            </div>
                            <div style="font-size: 11px; color: #666; margin-top: 4px;">Rules Fired</div>
                            <div style="font-size: 9px; color: #999; margin-top: 2px;">
                              ✓ Active
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
            <!-- TOTAL BIAYA ESTIMASI -->
            <?php 
              $total_biaya = 0;
              foreach($hasil_cf as $item) {
                $total_biaya += $item['rekomendasi']->biaya_estimasi;
              }
            ?>
            <div class="alert alert-info mb-3" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border: none;">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <strong style="font-size: 14px;"><i class="fa fa-calculator"></i> Total Estimasi Biaya:</strong>
                  <p class="mb-0 mt-1" style="font-size: 12px; color: #555;">
                    Dari <?= count($hasil_cf) ?> rekomendasi perbaikan yang sesuai
                  </p>
                </div>
                <div>
                  <h4 class="mb-0" style="color: #1976d2; font-weight: 700;">
                    Rp <?= number_format($total_biaya, 0, ',', '.') ?>
                  </h4>
                </div>
              </div>
            </div>
            
            <?php foreach($hasil_cf as $index => $item): ?>
              <div class="result-card" style="background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 15px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); overflow: hidden;">
                <div class="d-flex align-items-start" style="flex-wrap: wrap;">
                  <div class="result-rank" style="flex-shrink: 0;"><?= $index + 1 ?></div>
                  <div class="flex-grow-1" style="min-width: 0;">
                    <div class="d-flex justify-content-between align-items-start mb-2" style="flex-wrap: wrap; gap: 8px;">
                      <h5 style="font-size: 16px; margin-bottom: 0; flex: 1; min-width: 200px;"><?= $item['rekomendasi']->nama_rekomendasi ?></h5>
                      <div style="flex-shrink: 0;">
                        <span class="badge badge-success" style="font-size: 12px; padding: 5px 10px;">
                          <i class="fa fa-chart-line"></i> <?= number_format($item['confidence'], 1) ?>%
                        </span>
                      </div>
                    </div>
                    
                    <p class="text-muted mb-3" style="font-size: 13px; line-height: 1.5;"><?= $item['rekomendasi']->deskripsi_rekomendasi ?></p>
                    
                    <div class="row mb-2">
                      <div class="col-md-4 mb-2">
                        <div style="font-size: 12px;">
                          <i class="fa fa-money-bill-wave text-primary"></i>
                          <strong>Biaya:</strong>
                          <div class="mt-1">
                            <span class="badge badge-primary">Rp <?= number_format($item['rekomendasi']->biaya_estimasi, 0, ',', '.') ?></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 mb-2">
                        <div style="font-size: 12px;">
                          <i class="fa fa-clock text-warning"></i>
                          <strong>Durasi:</strong>
                          <div class="mt-1">
                            <span class="badge badge-warning"><?= $item['rekomendasi']->durasi_perbaikan ?> hari</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 mb-2">
                        <div style="font-size: 12px;">
                          <i class="fa fa-flag text-info"></i>
                          <strong>Prioritas:</strong>
                          <div class="mt-1">
                            <span class="badge badge-<?= $item['rekomendasi']->tingkat_prioritas == 'tinggi' ? 'danger' : ($item['rekomendasi']->tingkat_prioritas == 'sedang' ? 'warning' : 'info') ?>">
                              <?= ucfirst($item['rekomendasi']->tingkat_prioritas) ?>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <?php if($item['rekomendasi']->solusi_perbaikan): ?>
                      <div class="mt-3 p-3" style="background: #f8f9fa; border-left: 3px solid #007bff; border-radius: 4px; clear: both;">
                        <strong style="font-size: 13px;"><i class="fa fa-tools"></i> Langkah Perbaikan:</strong>
                        <p class="mb-0 mt-1" style="font-size: 12px; line-height: 1.6;"><?= nl2br($item['rekomendasi']->solusi_perbaikan) ?></p>
                      </div>
                    <?php endif; ?>
                    
                    <!-- ENHANCED CF CALCULATION DETAILS -->
                    <div class="mt-3" style="clear: both;">
                      <div class="accordion" id="cfAccordion<?= $index ?>">
                        <div class="card" style="border: 1px solid #e0e0e0; margin-bottom: 10px;">
                          <div class="card-header py-2" style="background: #f8f9fa; cursor: pointer; position: relative;" data-toggle="collapse" data-target="#cfDetails<?= $index ?>">
                            <small style="font-size: 11px; font-weight: 600; display: block; padding-right: 20px;">
                              <i class="fa fa-calculator text-primary"></i> Detail CF
                            </small>
                            <span style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);"><i class="fa fa-chevron-down"></i></span>
                          </div>
                          <div id="cfDetails<?= $index ?>" class="collapse" data-parent="#cfAccordion<?= $index ?>">
                            <div class="card-body py-3 px-3" style="font-size: 11px; background: #fafafa;">
                              
                              <!-- Formula Visualization -->
                              <div class="mb-3 p-2" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border-radius: 6px; border: 1px solid #90caf9;">
                                <strong style="color: #1565c0; font-size: 11px;">
                                  <i class="fa fa-calculator"></i> Rumus CF Hypothesis:
                                </strong><br>
                                <code style="font-size: 10px; background: white; padding: 4px 8px; border-radius: 4px; display: inline-block; margin-top: 4px; border: 1px solid #90caf9;">
                                  CF(H,E) = CF(H) × [CF(E₁) × W₁ + CF(E₂) × W₂] + Bonus
                                </code>
                              </div>
                              
                              <div class="table-responsive" style="clear: both; margin-bottom: 15px;">
                                <table class="table table-sm table-bordered mb-0" style="font-size: 11px; background: white;">
                                  <thead style="background: #f8f9fa;">
                                    <tr>
                                      <th style="width: 35%; padding: 8px;">Komponen</th>
                                      <th style="width: 20%; padding: 8px; text-align: center;">Nilai</th>
                                      <th style="width: 45%; padding: 8px;">Penjelasan</th>
                                    </tr>
                                  </thead>
                                <tbody>
                                  <tr>
                                    <td style="padding: 8px; font-weight: 600;">CF Expert</td>
                                    <td style="padding: 8px; text-align: center;">
                                      <span class="badge badge-info" style="font-size: 11px;"><?= number_format($item['cf_expert'], 3) ?></span>
                                    </td>
                                    <td style="padding: 8px; color: #666;">Kepercayaan pakar pada rule ini</td>
                                  </tr>
                                  <tr>
                                    <td style="padding: 8px; font-weight: 600;">CF Gejala</td>
                                    <td style="padding: 8px; text-align: center;">
                                      <span class="badge badge-warning" style="font-size: 11px;"><?= number_format($item['cf_gejala'], 3) ?></span>
                                    </td>
                                    <td style="padding: 8px; color: #666;">Kombinasi dari <?= count($item['gejala_trace']) ?> gejala (bobot 30%)</td>
                                  </tr>
                                  <tr>
                                    <td style="padding: 8px; font-weight: 600;">CF Kerusakan</td>
                                    <td style="padding: 8px; text-align: center;">
                                      <span class="badge badge-danger" style="font-size: 11px;"><?= number_format($item['cf_kerusakan'], 3) ?></span>
                                    </td>
                                    <td style="padding: 8px; color: #666;">Kombinasi dari <?= count($item['kerusakan_trace']) ?> kerusakan (bobot 70%)</td>
                                  </tr>
                                  <tr style="background: #f0f8ff;">
                                    <td style="padding: 8px; font-weight: 600;">CF Evidence</td>
                                    <td style="padding: 8px; text-align: center;">
                                      <span class="badge badge-primary" style="font-size: 11px;"><?= number_format($item['cf_evidence'], 3) ?></span>
                                    </td>
                                    <td style="padding: 8px; color: #666; font-size: 10px;">
                                      = (<?= number_format($item['cf_kerusakan'], 2) ?> × 0.7) + (<?= number_format($item['cf_gejala'], 2) ?> × 0.3)
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="padding: 8px; font-weight: 600;">Match Rate</td>
                                    <td style="padding: 8px; text-align: center;">
                                      <span class="badge badge-success" style="font-size: 11px;"><?= number_format($item['match_percentage'], 1) ?>%</span>
                                    </td>
                                    <td style="padding: 8px; color: #666;"><?= $item['match_count'] ?> kerusakan user match dengan rule</td>
                                  </tr>
                                  <tr style="background: #e8f5e9;">
                                    <td style="padding: 8px;"><strong style="color: #2e7d32;">CF Final</strong></td>
                                    <td style="padding: 8px; text-align: center;">
                                      <span class="badge badge-success" style="font-size: 12px; padding: 5px 10px;"><?= number_format($item['cf_score'], 3) ?></span>
                                    </td>
                                    <td style="padding: 8px;"><strong style="color: #2e7d32;">Hasil akhir dengan bonus match rate</strong></td>
                                  </tr>
                                </tbody>
                                </table>
                              </div>
                              
                              <!-- Trace Gejala -->
                              <?php if (!empty($item['gejala_trace'])): ?>
                                <details class="mb-3" style="clear: both;">
                                  <summary style="cursor: pointer; color: #667eea; font-weight: 600; font-size: 11px; padding: 6px 0;">
                                    <i class="fa fa-question-circle"></i> Trace CF Gejala (<?= count($item['gejala_trace']) ?> evidence)
                                  </summary>
                                  <div class="mt-2" style="background: #fffde7; padding: 10px; border-radius: 4px; max-height: 200px; overflow-y: auto; border: 1px solid #fff9c4;">
                                    <?php foreach ($item['gejala_trace'] as $idx => $trace): ?>
                                      <div class="mb-2 pb-2" style="border-bottom: 1px solid #fff9c4; font-size: 10px;">
                                        <div style="margin-bottom: 4px;">
                                          <strong style="color: #f57c00;">Evidence <?= $idx + 1 ?>:</strong>
                                          <span class="badge badge-warning" style="font-size: 9px; margin-left: 4px;"><?= $trace['kode'] ?></span>
                                        </div>
                                        <div style="color: #555; margin-bottom: 4px; line-height: 1.4;">
                                          <?= $trace['nama'] ?>
                                        </div>
                                        <div style="color: #666; font-family: 'Courier New', monospace; background: white; padding: 4px 6px; border-radius: 3px; font-size: 9px;">
                                          <?= $trace['formula'] ?>
                                        </div>
                                      </div>
                                    <?php endforeach; ?>
                                  </div>
                                </details>
                              <?php endif; ?>
                              
                              <!-- Trace Kerusakan -->
                              <?php if (!empty($item['kerusakan_trace'])): ?>
                                <details class="mb-3" style="clear: both;">
                                  <summary style="cursor: pointer; color: #667eea; font-weight: 600; font-size: 11px; padding: 6px 0;">
                                    <i class="fa fa-exclamation-triangle"></i> Trace CF Kerusakan (<?= count($item['kerusakan_trace']) ?> evidence)
                                  </summary>
                                  <div class="mt-2" style="background: #fce4ec; padding: 10px; border-radius: 4px; max-height: 200px; overflow-y: auto; border: 1px solid #f8bbd0;">
                                    <?php foreach ($item['kerusakan_trace'] as $idx => $trace): ?>
                                      <div class="mb-2 pb-2" style="border-bottom: 1px solid #f8bbd0; font-size: 10px;">
                                        <div style="margin-bottom: 4px;">
                                          <strong style="color: #c62828;">Evidence <?= $idx + 1 ?>:</strong>
                                          <span class="badge badge-danger" style="font-size: 9px; margin-left: 4px;"><?= $trace['kode'] ?></span>
                                          <?php if ($trace['is_match']): ?>
                                            <span class="badge badge-success" style="font-size: 9px; margin-left: 4px;">✓ Match Rule</span>
                                          <?php endif; ?>
                                        </div>
                                        <div style="color: #555; margin-bottom: 4px; line-height: 1.4;">
                                          <?= $trace['nama'] ?>
                                        </div>
                                        <div style="color: #666; font-family: 'Courier New', monospace; background: white; padding: 4px 6px; border-radius: 3px; font-size: 9px;">
                                          <?= $trace['formula'] ?>
                                        </div>
                                      </div>
                                    <?php endforeach; ?>
                                  </div>
                                </details>
                              <?php endif; ?>
                              
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="alert alert-warning mb-0">
              <i class="fa fa-exclamation-triangle"></i> Tidak ditemukan rekomendasi yang sesuai dengan gejala dan kerusakan yang dipilih.
              <br><small>Silakan diagnosis ulang atau pilih opsi lain.</small>
            </div>
          <?php endif; ?>
        </div>
        
        <div class="text-center mt-3">
          <a href="<?= base_url('home/rekomendasi?reset=1') ?>" class="btn btn-wizard">
            <i class="fa fa-refresh"></i> Diagnosis Baru
          </a>
        </div>

      <?php endif; ?>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  // Auto-submit untuk step 1 dan 2 (pilihan kategori dan jenis perbaikan)
  $('#form-kategori .option-card').click(function() {
    var $form = $(this).closest('form');
    $form.find('.option-card').removeClass('selected');
    $(this).addClass('selected');
    $(this).find('input[type="radio"]').prop('checked', true);
    
    setTimeout(function() {
      $form.submit();
    }, 300);
  });
  
  $('#form-jenis-perbaikan .option-card').click(function() {
    var $form = $(this).closest('form');
    $form.find('.option-card').removeClass('selected');
    $(this).addClass('selected');
    $(this).find('input[type="radio"]').prop('checked', true);
    
    setTimeout(function() {
      $form.submit();
    }, 300);
  });
  
  // === STEP 3: PERTANYAAN GEJALA SATU PER SATU ===
  $('.btn-jawab').click(function() {
    var jawaban = $(this).data('jawaban');
    $('#jawaban_value').val(jawaban);
    
    $('.btn-jawab').removeClass('btn-success btn-danger').addClass('btn-outline-success btn-outline-danger');
    
    if (jawaban == 'ya') {
      $(this).removeClass('btn-outline-success').addClass('btn-success');
      $('#cf-section').slideDown(300);
      $('.cf-option:eq(2)').click(); // Default cukup yakin (60%)
      $('#btn-next-gejala').prop('disabled', false);
    } else {
      $(this).removeClass('btn-outline-danger').addClass('btn-danger');
      $('#cf-section').slideUp(300);
      $('#btn-next-gejala').prop('disabled', false);
    }
  });
  
  // === STEP 4: PERTANYAAN KERUSAKAN SATU PER SATU ===
  $('.btn-jawab-kerusakan').click(function() {
    var jawaban = $(this).data('jawaban');
    $('#jawaban_kerusakan_value').val(jawaban);
    
    $('.btn-jawab-kerusakan').removeClass('btn-success btn-danger').addClass('btn-outline-success btn-outline-danger');
    
    if (jawaban == 'ya') {
      $(this).removeClass('btn-outline-success').addClass('btn-success');
      $('#cf-section-kerusakan').slideDown(300);
      $('.cf-option:eq(2)').click(); // Default cukup yakin (60%)
      $('#btn-next-kerusakan').prop('disabled', false);
    } else {
      $(this).removeClass('btn-outline-danger').addClass('btn-danger');
      $('#cf-section-kerusakan').slideUp(300);
      $('#btn-next-kerusakan').prop('disabled', false);
    }
  });
  
  // CF option selection
  $('.cf-option').click(function() {
    $(this).closest('.cf-options').find('.cf-option').removeClass('selected');
    $(this).addClass('selected');
    $(this).find('input[type="radio"]').prop('checked', true);
  });
  
  // Submit form gejala
  $('#form-gejala-single').submit(function(e) {
    var currentIndex = <?= isset($current_index) ? $current_index : 0 ?>;
    var totalGejala = <?= isset($total_gejala) ? $total_gejala : 0 ?>;
    
    if (currentIndex >= totalGejala) {
      $('#selesai_gejala').val('1');
    }
  });
  
  // Submit form kerusakan
  $('#form-kerusakan-single').submit(function(e) {
    var currentIndex = <?= isset($current_index) ? $current_index : 0 ?>;
    var totalKerusakan = <?= isset($total_kerusakan) ? $total_kerusakan : 0 ?>;
    
    if (currentIndex >= totalKerusakan) {
      $('#selesai_kerusakan').val('1');
    }
  });
  
  // Highlight radio yang dipilih
  $('input[type="radio"]').change(function() {
    var name = $(this).attr('name');
    $('input[name="' + name + '"]').parent().removeClass('active');
    $(this).parent().addClass('active');
  });
});
</script>
