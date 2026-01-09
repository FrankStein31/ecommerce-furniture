<div class="section small_pb small_pt">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="heading_s1 text-center">
          <h2>Produk Terbaru</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <!-- List Produk -->
        <div id="list-produk"></div>
      </div>
    </div>
    <br>
    <div class="text-center">
      <a href="<?= site_url('Produk/search') ?>" class="btn btn-fill-out">Tampilkan Semua Produk</a>
    </div>
  </div>
</div>



<script>
  $(document).ready(function() {
    getProduk()

    // Handle damage report form submission
    $('#damage-report-form').on('submit', function(e) {
      e.preventDefault()
      submitDamageReport()
    })
  })

  function getProduk() {
    $.ajax({
      url: site_url + "/Produk/fetch_data_produk",
      type: 'GET',
      dataType: 'html',
      data: {
        sortby: 'created_at',
        sorttype: 'desc',
        limit: 12,
        show_pagination: false
      },
      beforeSend: function() {},
      success: function(result) {
        $('#list-produk').html(result);
      }
    });
  }

  function submitDamageReport() {
    var formData = new FormData($('#damage-report-form')[0])

    $.ajax({
      url: site_url + "/Home/submit_damage_report",
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      beforeSend: function() {
        $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...')
      },
      success: function(response) {
        if (response.status === 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Laporan kerusakan telah dikirim. Tim kami akan menghubungi Anda segera.',
            confirmButtonText: 'OK'
          }).then(() => {
            $('#damage-report-form')[0].reset()
          })
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: response.message || 'Terjadi kesalahan saat mengirim laporan.',
            confirmButtonText: 'OK'
          })
        }
      },
      error: function() {
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: 'Terjadi kesalahan koneksi. Silakan coba lagi.',
          confirmButtonText: 'OK'
        })
      },
      complete: function() {
        $('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-paper-plane mr-2"></i>Kirim Laporan Kerusakan')
      }
    })
  }
</script>

<style>
  .damage_card {
    background: white;
    border-radius: 10px;
    padding: 30px 20px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    height: 100%;
  }

  .damage_card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
  }

  .damage_list {
    list-style: none;
    padding: 0;
    margin: 15px 0;
  }

  .damage_list li {
    color: #666;
    margin-bottom: 5px;
    font-size: 14px;
  }

  .damage_time {
    background: #f8f9fa;
    padding: 5px 15px;
    border-radius: 15px;
    font-size: 12px;
    color: #666;
    display: inline-block;
    margin-top: 10px;
  }

  .damage_report_section {
    border: 2px solid #e9ecef;
  }

  .damage_contact_info {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 10px;
    margin-top: 20px;
  }

  .contact_methods .btn {
    margin: 5px;
  }

  .bg_light_gray {
    background-color: #f8f9fa;
  }

  @media (max-width: 768px) {
    .damage_card {
      margin-bottom: 20px;
    }

    .contact_methods .btn {
      display: block;
      margin: 10px auto;
      width: 80%;
    }
  }
</style>