<div class="section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="heading_s1 text-center mb-4">
          <h2>Rekomendasi Perbaikan Furniture</h2>
          <p>Dapatkan rekomendasi perbaikan berdasarkan kerusakan furniture Anda</p>
        </div>

        <div class="card shadow-sm">
          <div class="card-body p-4">
            <form id="rekomendasi-form">
              <div class="form-group mb-3">
                <label for="gejala_kerusakan" class="form-label">Gejala Kerusakan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="gejala_kerusakan" name="gejala_kerusakan" 
                       placeholder="Contoh: Kurang nyaman di duduki" required>
              </div>

              <div class="form-group mb-3">
                <label for="jenis_kerusakan" class="form-label">Jenis Kerusakan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="jenis_kerusakan" name="jenis_kerusakan" 
                       placeholder="Contoh: Karet dan pirnya putus" required>
              </div>

              <div class="form-group mb-3">
                <label for="jenis_perbaikan" class="form-label">Jenis Perbaikan <span class="text-danger">*</span></label>
                <select class="form-control" id="jenis_perbaikan" name="jenis_perbaikan" required>
                  <option value="">-- Pilih Jenis Perbaikan --</option>
                </select>
                <small class="form-text text-muted">
                  <i class="fas fa-spinner fa-spin" id="loading-jenis"></i> Memuat data...
                </small>
              </div>

              <div class="text-center mt-4">
                <button type="submit" class="btn btn-fill-out btn-lg" id="btn-submit">
                  <i class="fas fa-search"></i> Cari Rekomendasi
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Result Section -->
        <div id="result-section" class="mt-4" style="display: none;">
          <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-success text-white py-3">
              <h5 class="mb-0"><i class="fas fa-check-circle"></i> Hasil Rekomendasi Perbaikan</h5>
            </div>
            <div class="card-body p-4">
              <!-- Input Summary -->
              <div class="mb-4">
                <h6 class="text-primary mb-3"><i class="fas fa-clipboard-list"></i> <strong>Data Input</strong></h6>
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <tbody>
                      <tr>
                        <td width="30%" class="bg-light"><strong><i class="fas fa-exclamation-circle text-warning"></i> Gejala Kerusakan</strong></td>
                        <td id="result-gejala" class="font-weight-medium"></td>
                      </tr>
                      <tr>
                        <td class="bg-light"><strong><i class="fas fa-tools text-danger"></i> Jenis Kerusakan</strong></td>
                        <td id="result-jenis" class="font-weight-medium"></td>
                      </tr>
                      <tr>
                        <td class="bg-light"><strong><i class="fas fa-couch text-info"></i> Jenis Perbaikan</strong></td>
                        <td id="result-perbaikan" class="font-weight-medium"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- Main Results -->
              <div class="mb-4">
                <div class="card border-primary shadow-sm">
                  <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-star"></i> Rekomendasi Utama</h6>
                  </div>
                  <div class="card-body">
                    <div class="mb-2">
                      <small class="text-muted">Metode Terpilih:</small>
                      <h6 class="text-primary font-weight-bold" id="result-method"></h6>
                    </div>
                    <div class="alert alert-info mb-0">
                      <h5 class="mb-0"><i class="fas fa-wrench"></i> <span id="result-rekomendasi" class="font-weight-bold"></span></h5>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Cost and Time Estimation -->
              <div class="row mb-4">
                <div class="col-md-6 mb-3">
                  <div class="card border-success shadow-sm h-100">
                    <div class="card-body text-center p-4">
                      <i class="fas fa-money-bill-wave fa-3x text-success mb-3"></i>
                      <h6 class="text-muted mb-2">Estimasi Biaya</h6>
                      <h3 class="text-success font-weight-bold mb-0" id="result-biaya"></h3>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="card border-info shadow-sm h-100">
                    <div class="card-body text-center p-4">
                      <i class="fas fa-clock fa-3x text-info mb-3"></i>
                      <h6 class="text-muted mb-2">Estimasi Waktu</h6>
                      <h3 class="text-info font-weight-bold mb-0" id="result-waktu"></h3>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Confidence Score -->
              <div class="mb-4">
                <div class="card border-warning shadow-sm">
                  <div class="card-body">
                    <h6 class="text-primary mb-3"><i class="fas fa-chart-line"></i> <strong>Tingkat Kepercayaan (Confidence Score)</strong></h6>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="text-muted">Akurasi Rekomendasi</span>
                      <span id="confidence-text-label" class="font-weight-bold h5 mb-0"></span>
                    </div>
                    <div class="progress" style="height: 35px; border-radius: 20px;">
                      <div id="confidence-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%; font-size: 16px; line-height: 35px;">
                        <span id="confidence-text" class="font-weight-bold"></span>
                      </div>
                    </div>
                    <div class="mt-2 text-center">
                      <small class="text-muted" id="confidence-description"></small>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Method Comparison -->
              <div class="mb-4">
                <h6 class="text-primary mb-3 text-center"><i class="fas fa-balance-scale"></i> <strong>Perbandingan Metode Algoritma</strong></h6>
                
                <div class="row">
                  <!-- Forward Chaining -->
                  <div class="col-lg-6 mb-3">
                    <div class="card border-primary shadow h-100">
                      <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                          <div>
                            <i class="fas fa-project-diagram"></i> <strong>Forward Chaining</strong>
                            <div><small>Pelacakan Maju</small></div>
                          </div>
                          <span class="badge badge-light badge-lg" id="fc-confidence-badge" style="font-size: 16px;">0%</span>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="mb-3">
                          <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong>Status:</strong>
                            <span id="fc-status" class="badge badge-success"></span>
                          </div>
                        </div>

                        <div class="mb-3">
                          <strong><i class="fas fa-lightbulb text-warning"></i> Rekomendasi:</strong>
                          <div class="alert alert-info mt-2 mb-0">
                            <p class="mb-0 font-weight-medium" id="fc-rekomendasi"></p>
                          </div>
                        </div>
                        
                        <div class="mb-3">
                          <strong>Tingkat Kepercayaan:</strong>
                          <div class="progress mt-2" style="height: 30px;">
                            <div id="fc-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%; font-size: 15px; line-height: 30px;">
                              <span id="fc-progress-text"></span>
                            </div>
                          </div>
                        </div>

                        <!-- FC Calculation Details -->
                        <div class="card bg-light border-0">
                          <div class="card-body">
                            <h6 class="text-primary mb-3"><i class="fas fa-calculator"></i> Detail Perhitungan</h6>
                            <div id="fc-calculation-details"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Certainty Factor -->
                  <div class="col-lg-6 mb-3">
                    <div class="card border-info shadow h-100">
                      <div class="card-header bg-info text-white">
                        <div class="d-flex justify-content-between align-items-center">
                          <div>
                            <i class="fas fa-percentage"></i> <strong>Certainty Factor</strong>
                            <div><small>Faktor Kepastian</small></div>
                          </div>
                          <span class="badge badge-light badge-lg" id="cf-confidence-badge" style="font-size: 16px;">0%</span>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="mb-3">
                          <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong>Status:</strong>
                            <span id="cf-status" class="badge badge-success"></span>
                          </div>
                        </div>

                        <div class="mb-3">
                          <strong><i class="fas fa-lightbulb text-warning"></i> Rekomendasi:</strong>
                          <div class="alert alert-info mt-2 mb-0">
                            <p class="mb-0 font-weight-medium" id="cf-rekomendasi"></p>
                          </div>
                        </div>
                        
                        <div class="mb-3">
                          <strong>Tingkat Kepercayaan:</strong>
                          <div class="progress mt-2" style="height: 30px;">
                            <div id="cf-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%; font-size: 15px; line-height: 30px;">
                              <span id="cf-progress-text"></span>
                            </div>
                          </div>
                        </div>

                        <!-- CF Calculation Details -->
                        <div class="card bg-light border-0">
                          <div class="card-body">
                            <h6 class="text-primary mb-3"><i class="fas fa-calculator"></i> Detail Perhitungan</h6>
                            <div id="cf-calculation-details"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Statistics -->
              <div class="card border-secondary shadow-sm">
                <div class="card-body">
                  <div class="row text-center">
                    <div class="col-md-4 mb-2">
                      <i class="fas fa-database fa-2x text-secondary mb-2"></i>
                      <h6 class="text-muted mb-1">Data Ditemukan</h6>
                      <h4 class="font-weight-bold" id="result-filtered">0</h4>
                    </div>
                    <div class="col-md-4 mb-2">
                      <i class="fas fa-code-branch fa-2x text-primary mb-2"></i>
                      <h6 class="text-muted mb-1">Metode Digunakan</h6>
                      <h4 class="font-weight-bold">2</h4>
                    </div>
                    <div class="col-md-4 mb-2">
                      <i class="fas fa-check-double fa-2x text-success mb-2"></i>
                      <h6 class="text-muted mb-1">Status Kecocokan</h6>
                      <h4 class="font-weight-bold" id="result-match-status">Match</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Error Section -->
        <div id="error-section" class="mt-4" style="display: none;">
          <div class="alert alert-danger">
            <h6><i class="fas fa-exclamation-triangle"></i> Error</h6>
            <p id="error-message" class="mb-0"></p>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Load jenis perbaikan data on page load
    loadJenisPerbaikan();

    $('#rekomendasi-form').on('submit', function(e) {
      e.preventDefault();
      getRekomendasiPerbaikan();
    });
  });

  // Function to load jenis perbaikan from API
  function loadJenisPerbaikan() {
    $.ajax({
      url: '<?= site_url("Home/get_jenis_perbaikan") ?>',
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        const selectElement = $('#jenis_perbaikan');
        
        // Clear existing options except the first one
        selectElement.find('option:not(:first)').remove();
        
        // Populate dropdown with data
        if (response.status === 'success' && response.data && response.data.length > 0) {
          response.data.forEach(function(item) {
            selectElement.append($('<option>', {
              value: item,
              text: item
            }));
          });
          
          // Hide loading indicator
          $('#loading-jenis').parent().hide();
        } else {
          $('#loading-jenis').parent().html('<i class="fas fa-exclamation-triangle text-warning"></i> Tidak ada data tersedia');
        }
      },
      error: function(xhr, status, error) {
        console.error('Error loading jenis perbaikan:', error);
        $('#loading-jenis').parent().html('<i class="fas fa-exclamation-triangle text-danger"></i> Gagal memuat data');
      }
    });
  }

  function getRekomendasiPerbaikan() {
    const formData = {
      gejala_kerusakan: $('#gejala_kerusakan').val(),
      jenis_kerusakan: $('#jenis_kerusakan').val(),
      jenis_perbaikan: $('#jenis_perbaikan').val()
    };

    // Hide previous results
    $('#result-section').hide();
    $('#error-section').hide();

    // Disable submit button
    $('#btn-submit').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memproses...');

    $.ajax({
      url: '<?= site_url("Home/get_rekomendasi") ?>',
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: function(response) {
        if (response.status === 'success') {
          displayResult(response.data);
        } else {
          displayError(response.message);
        }
      },
      error: function(xhr, status, error) {
        displayError('Terjadi kesalahan saat menghubungi server: ' + error);
      },
      complete: function() {
        // Enable submit button
        $('#btn-submit').prop('disabled', false).html('<i class="fas fa-search"></i> Cari Rekomendasi');
      }
    });
  }

  function displayResult(data) {
    // Display input data
    $('#result-gejala').text(data.input.gejala_kerusakan);
    $('#result-jenis').text(data.input.jenis_kerusakan);
    $('#result-perbaikan').text(data.input.jenis_perbaikan);

    // Display main results
    $('#result-method').text(data.primary_method);
    $('#result-rekomendasi').text(data.rekomendasi_perbaikan);
    
    // Format currency for biaya
    const biaya = new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0
    }).format(data.estimasi_biaya);
    $('#result-biaya').text(biaya);
    
    $('#result-waktu').text(data.estimasi_waktu || '-');
    $('#result-filtered').text(data.filtered_data_count);

    // Display confidence score
    const confidenceScore = parseFloat(data.confidence_score);
    $('#confidence-bar').css('width', confidenceScore + '%');
    $('#confidence-text').text(confidenceScore.toFixed(2) + '%');
    $('#confidence-text-label').text(confidenceScore.toFixed(2) + '%');

    // Set confidence color and description
    if (confidenceScore >= 90) {
      $('#confidence-bar').removeClass('bg-warning bg-danger bg-info').addClass('bg-success');
      $('#confidence-description').html('<i class="fas fa-star text-warning"></i> Sangat Tinggi - Rekomendasi sangat akurat');
    } else if (confidenceScore >= 75) {
      $('#confidence-bar').removeClass('bg-success bg-danger bg-info').addClass('bg-primary');
      $('#confidence-description').html('<i class="fas fa-thumbs-up text-primary"></i> Tinggi - Rekomendasi cukup akurat');
    } else if (confidenceScore >= 50) {
      $('#confidence-bar').removeClass('bg-success bg-danger bg-primary').addClass('bg-warning');
      $('#confidence-description').html('<i class="fas fa-exclamation-circle text-warning"></i> Sedang - Pertimbangkan konsultasi lebih lanjut');
    } else {
      $('#confidence-bar').removeClass('bg-success bg-warning bg-primary').addClass('bg-danger');
      $('#confidence-description').html('<i class="fas fa-times-circle text-danger"></i> Rendah - Disarankan konsultasi dengan teknisi');
    }

    // Display Forward Chaining method comparison
    if (data.methods_comparison.forward_chaining) {
      const fc = data.methods_comparison.forward_chaining;
      const fcConfidence = parseFloat(fc.confidence);
      
      $('#fc-rekomendasi').text(fc.rekomendasi);
      $('#fc-confidence').text(fcConfidence.toFixed(2));
      $('#fc-status').text(fc.status);
      
      // Display badge percentage
      $('#fc-confidence-badge').text(fcConfidence.toFixed(2) + '%');
      
      // Display progress bar
      $('#fc-progress-bar').css('width', fcConfidence + '%');
      $('#fc-progress-text').text(fcConfidence.toFixed(2) + '%');
      
      // Set color based on confidence
      if (fcConfidence >= 80) {
        $('#fc-progress-bar').removeClass('bg-warning bg-danger bg-info').addClass('bg-success');
      } else if (fcConfidence >= 50) {
        $('#fc-progress-bar').removeClass('bg-success bg-danger bg-info').addClass('bg-warning');
      } else {
        $('#fc-progress-bar').removeClass('bg-success bg-warning bg-info').addClass('bg-danger');
      }

      // Display FC calculation details
      if (fc.calculation_details) {
        let fcDetailsHtml = '';
        
        // Input phrases
        if (fc.calculation_details.input_phrases) {
          fcDetailsHtml += '<div class="mb-3">';
          fcDetailsHtml += '<strong class="d-block mb-2"><i class="fas fa-tag text-info"></i> Kata Kunci Input (' + fc.calculation_details.input_phrases.length + '):</strong>';
          fcDetailsHtml += '<div class="d-flex flex-wrap gap-2">';
          fc.calculation_details.input_phrases.forEach(phrase => {
            fcDetailsHtml += '<span class="badge badge-info mr-1 mb-1">' + phrase + '</span>';
          });
          fcDetailsHtml += '</div></div>';
        }

        // Selected rule details
        if (fc.calculation_details.selected_rule) {
          const rule = fc.calculation_details.selected_rule;
          fcDetailsHtml += '<div class="alert alert-success mb-3">';
          fcDetailsHtml += '<strong><i class="fas fa-crown text-warning"></i> Rule Terpilih:</strong><br>';
          fcDetailsHtml += '<small class="text-muted">' + rule.selection_criteria + '</small><br>';
          fcDetailsHtml += '<div class="mt-2">';
          fcDetailsHtml += '<span class="badge badge-success mr-2">Matched: ' + rule.matched_count + ' keyword</span>';
          fcDetailsHtml += '<span class="badge badge-primary mr-2">Overlap: ' + (rule.overlap_percentage || (rule.overlap_ratio * 100).toFixed(2)) + '%</span>';
          fcDetailsHtml += '</div>';
          fcDetailsHtml += '</div>';
        }

        // Candidates
        if (fc.calculation_details.candidates && fc.calculation_details.candidates.length > 0) {
          fcDetailsHtml += '<div class="mb-2">';
          fcDetailsHtml += '<strong class="d-block mb-2"><i class="fas fa-list-ol text-primary"></i> Kandidat Rekomendasi (' + fc.calculation_details.total_candidates + '):</strong>';
          
          fc.calculation_details.candidates.forEach((candidate, index) => {
            const isSelected = candidate.is_selected;
            const cardClass = isSelected ? 'border-success' : 'border-secondary';
            
            fcDetailsHtml += '<div class="card ' + cardClass + ' mb-2">';
            fcDetailsHtml += '<div class="card-body p-2">';
            fcDetailsHtml += '<div class="d-flex justify-content-between align-items-start">';
            fcDetailsHtml += '<div class="flex-grow-1">';
            fcDetailsHtml += '<strong class="text-dark">' + (index + 1) + '. ' + candidate.rekomendasi + '</strong>';
            if (isSelected) {
              fcDetailsHtml += ' <span class="badge badge-success ml-1"><i class="fas fa-check"></i> Dipilih</span>';
            }
            fcDetailsHtml += '<div class="mt-1">';
            fcDetailsHtml += '<small class="text-muted">Keywords Cocok: ' + candidate.matched_count + ' / ' + candidate.rule_total_keywords + '</small>';
            fcDetailsHtml += ' <span class="badge badge-light">' + (candidate.overlap_percentage || (candidate.overlap_ratio * 100).toFixed(2)) + '% overlap</span>';
            fcDetailsHtml += '</div>';
            
            // Matched keywords
            if (candidate.matched_keywords && candidate.matched_keywords.length > 0) {
              fcDetailsHtml += '<div class="mt-2">';
              fcDetailsHtml += '<small class="text-muted d-block mb-1">Keyword yang cocok:</small>';
              fcDetailsHtml += '<div class="d-flex flex-wrap">';
              candidate.matched_keywords.forEach(kw => {
                fcDetailsHtml += '<span class="badge badge-success mr-1 mb-1" style="font-size: 10px;">' + kw + '</span>';
              });
              fcDetailsHtml += '</div></div>';
            }
            fcDetailsHtml += '</div></div></div></div>';
          });
          fcDetailsHtml += '</div>';
        }

        $('#fc-calculation-details').html(fcDetailsHtml);
      }
    }

    // Display Certainty Factor method comparison
    if (data.methods_comparison.certainty_factor) {
      const cf = data.methods_comparison.certainty_factor;
      const cfConfidence = parseFloat(cf.confidence);
      
      $('#cf-rekomendasi').text(cf.rekomendasi);
      $('#cf-confidence').text(cfConfidence.toFixed(2));
      $('#cf-status').text(cf.status);
      
      // Display badge percentage
      $('#cf-confidence-badge').text(cfConfidence.toFixed(2) + '%');
      
      // Display progress bar
      $('#cf-progress-bar').css('width', cfConfidence + '%');
      $('#cf-progress-text').text(cfConfidence.toFixed(2) + '%');
      
      // Set color based on confidence
      if (cfConfidence >= 80) {
        $('#cf-progress-bar').removeClass('bg-warning bg-danger bg-primary').addClass('bg-success');
      } else if (cfConfidence >= 50) {
        $('#cf-progress-bar').removeClass('bg-success bg-danger bg-primary').addClass('bg-warning');
      } else {
        $('#cf-progress-bar').removeClass('bg-success bg-warning bg-primary').addClass('bg-danger');
      }

      // Display CF calculation details
      if (cf.calculation_details) {
        let cfDetailsHtml = '';
        
        // Overview
        cfDetailsHtml += '<div class="row mb-3">';
        cfDetailsHtml += '<div class="col-md-6">';
        cfDetailsHtml += '<div class="card border-info">';
        cfDetailsHtml += '<div class="card-body p-2 text-center">';
        cfDetailsHtml += '<small class="text-muted d-block">Gejala Cocok</small>';
        cfDetailsHtml += '<h5 class="mb-0 text-info">' + cf.calculation_details.gejala_matched + ' / ' + cf.calculation_details.gejala_total + '</h5>';
        cfDetailsHtml += '</div></div></div>';
        cfDetailsHtml += '<div class="col-md-6">';
        cfDetailsHtml += '<div class="card border-warning">';
        cfDetailsHtml += '<div class="card-body p-2 text-center">';
        cfDetailsHtml += '<small class="text-muted d-block">Overlap Ratio</small>';
        cfDetailsHtml += '<h5 class="mb-0 text-warning">' + (cf.calculation_details.overlap_ratio * 100).toFixed(1) + '%</h5>';
        cfDetailsHtml += '</div></div></div>';
        cfDetailsHtml += '</div>';

        // Gejala details
        if (cf.calculation_details.gejala_details && cf.calculation_details.gejala_details.length > 0) {
          cfDetailsHtml += '<div class="mb-3">';
          cfDetailsHtml += '<strong class="d-block mb-2"><i class="fas fa-clipboard-check text-success"></i> Detail Gejala Cocok (' + cf.calculation_details.gejala_details.length + '):</strong>';
          
          cf.calculation_details.gejala_details.forEach((gejala, index) => {
            cfDetailsHtml += '<div class="card border-success mb-2">';
            cfDetailsHtml += '<div class="card-body p-2">';
            cfDetailsHtml += '<div class="d-flex justify-content-between align-items-center">';
            cfDetailsHtml += '<div>';
            cfDetailsHtml += '<strong class="text-dark">' + gejala.kode + ':</strong> ' + gejala.gejala;
            cfDetailsHtml += '<div class="mt-1">';
            cfDetailsHtml += '<small class="text-muted">CF Expert: ' + gejala.cf_expert + ' | CF User: ' + gejala.cf_user + '</small>';
            cfDetailsHtml += '</div>';
            cfDetailsHtml += '<div class="mt-1">';
            cfDetailsHtml += '<code style="font-size: 11px; background: #f8f9fa; padding: 2px 6px; border-radius: 3px;">' + gejala.formula + '</code>';
            cfDetailsHtml += '</div>';
            cfDetailsHtml += '</div>';
            cfDetailsHtml += '<div class="text-right">';
            cfDetailsHtml += '<span class="badge badge-success" style="font-size: 13px;">' + gejala.cf_combine.toFixed(3) + '</span>';
            cfDetailsHtml += '</div>';
            cfDetailsHtml += '</div></div></div>';
          });
          cfDetailsHtml += '</div>';
        }

        // CF Combination steps
        if (cf.calculation_details.cf_combination_steps && cf.calculation_details.cf_combination_steps.length > 0) {
          cfDetailsHtml += '<div class="mb-3">';
          cfDetailsHtml += '<strong class="d-block mb-2"><i class="fas fa-calculator text-primary"></i> Langkah Kombinasi CF:</strong>';
          cfDetailsHtml += '<div class="alert alert-warning mb-2 p-2">';
          cfDetailsHtml += '<small><strong>Formula:</strong> CF<sub>combine</sub> = CF<sub>old</sub> + CF<sub>new</sub> × (1 - CF<sub>old</sub>)</small>';
          cfDetailsHtml += '</div>';
          
          cf.calculation_details.cf_combination_steps.forEach(step => {
            cfDetailsHtml += '<div class="card border-primary mb-1">';
            cfDetailsHtml += '<div class="card-body p-2">';
            cfDetailsHtml += '<small>';
            cfDetailsHtml += '<strong>Step ' + step.step + ':</strong> ';
            cfDetailsHtml += '<code style="font-size: 10px; background: #f8f9fa; padding: 2px 4px;">' + step.calculation + '</code>';
            cfDetailsHtml += '</small>';
            cfDetailsHtml += '</div></div>';
          });
          cfDetailsHtml += '</div>';
        }

        // Final CF
        if (cf.calculation_details.cf_total) {
          cfDetailsHtml += '<div class="alert alert-success mb-0">';
          cfDetailsHtml += '<div class="row align-items-center">';
          cfDetailsHtml += '<div class="col-7">';
          cfDetailsHtml += '<strong><i class="fas fa-trophy text-warning"></i> CF Total:</strong>';
          cfDetailsHtml += '</div>';
          cfDetailsHtml += '<div class="col-5 text-right">';
          cfDetailsHtml += '<span class="badge badge-success p-2" style="font-size: 15px;">' + cf.calculation_details.cf_total.toFixed(6) + '</span>';
          cfDetailsHtml += '<br><small class="text-muted">(' + cf.calculation_details.cf_total_percentage.toFixed(2) + '%)</small>';
          cfDetailsHtml += '</div></div></div>';
        }

        $('#cf-calculation-details').html(cfDetailsHtml);
      }
    }

    // Show result section
    $('#result-section').show();
    
    // Smooth scroll to result
    $('html, body').animate({
      scrollTop: $('#result-section').offset().top - 100
    }, 500);
  }

  function displayError(message) {
    $('#error-message').text(message);
    $('#error-section').show();
    
    // Smooth scroll to error
    $('html, body').animate({
      scrollTop: $('#error-section').offset().top - 100
    }, 500);
  }
</script>

<style>
  .card {
    border: none;
    border-radius: 15px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  
  .card:hover {
    transform: translateY(-2px);
  }
  
  .card-header {
    border-radius: 15px 15px 0 0 !important;
    font-weight: 600;
  }
  
  .bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
  }
  
  .form-control:focus {
    border-color: #88c8bc;
    box-shadow: 0 0 0 0.2rem rgba(136, 200, 188, 0.25);
  }
  
  .btn-link {
    color: #333;
    font-weight: 500;
    text-align: left;
  }
  
  .btn-link:hover {
    color: #007bff;
    text-decoration: none;
  }
  
  .progress {
    border-radius: 20px;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
  }
  
  .progress-bar {
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    transition: width 1s ease;
  }
  
  .accordion .card {
    border: 1px solid rgba(0,0,0,.125);
    margin-bottom: 10px;
  }
  
  .accordion .card:last-child {
    margin-bottom: 0;
  }
  
  .badge-lg {
   h-100 {
    height: 100%
  
  .table-hover tbody tr:hover {
    background-color: rgba(0,123,255,.05);
  }
  
  .font-weight-medium {
    font-weight: 500;
  }
  
  .text-dark {
    color: #2c3e50 !important;
  }
  
  /* Custom badge colors */
  .badge-success {
    background-color: #28a745;
  }
  
  .badge-primary {
    background-color: #007bff;
  }
  
  .badge-info {
    background-color: #17a2b8;
  }
  
  .badge-warning {
    background-color: #ffc107;
    color: #212529;
  }
  
  /* Animation for cards */
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  #result-section {
    animation: fadeInUp 0.5s ease;
  }
  
  /* Responsive adjustments */
  @media (max-width: 768px) {
    .card-body {
      padding: 1.5rem !important;
    }
    
    .btn-link {
      font-size: 14px;
    }
    
    .badge-lg {
      padding: 6px 10px;
      font-size: 12px;
    }
  }
  
  /* Code styling */
  code {
    color: #e83e8c;
    background-color: #f8f9fa;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 90%;
  }
  
  /* Alert improvements */
  .alert {
    border-radius: 10px;
    border: none;
  }
  
  .alert-info {
    background-color: #d1ecf1;
    color: #0c5460;
  }
  
  .alert-success {
    background-color: #d4edda;
    color: #155724;
  }
  
  .alert-warning {
    background-color: #fff3cd;
    color: #856404;
  }
  
  /* Icon styling */
  .fa-3x {
    font-size: 3em;
  }
  
  /* Gap utility for flexbox */
  .gap-2 {
    gap: 0.5rem;
  }
</style>
