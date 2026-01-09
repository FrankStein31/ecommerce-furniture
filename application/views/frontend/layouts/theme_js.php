<!-- popper min js -->
<script src="<?= base_url('assets/frontend/js/popper.min.js') ?>"></script>
<!-- Latest compiled and minified Bootstrap -->
<script src="<?= base_url('assets/frontend/bootstrap/js/bootstrap.min.js') ?>"></script>
<!-- owl-carousel min js  -->
<script src="<?= base_url('assets/frontend/owlcarousel/js/owl.carousel.min.js') ?>"></script>
<!-- magnific-popup min js  -->
<script src="<?= base_url('assets/frontend/js/magnific-popup.min.js') ?>"></script>
<!-- waypoints min js  -->
<script src="<?= base_url('assets/frontend/js/waypoints.min.js') ?>"></script>
<!-- parallax js  -->
<script src="<?= base_url('assets/frontend/js/parallax.js') ?>"></script>
<!-- countdown js  -->
<script src="<?= base_url('assets/frontend/js/jquery.countdown.min.js') ?>"></script>
<!-- imagesloaded js -->
<script src="<?= base_url('assets/frontend/js/imagesloaded.pkgd.min.js') ?>"></script>
<!-- isotope min js -->
<script src="<?= base_url('assets/frontend/js/isotope.min.js') ?>"></script>
<!-- jquery.dd.min js -->
<script src="<?= base_url('assets/frontend/js/jquery.dd.min.js') ?>"></script>
<!-- slick js -->
<script src="<?= base_url('assets/frontend/js/slick.min.js') ?>"></script>
<!-- elevatezoom js -->
<script src="<?= base_url('assets/frontend/js/jquery.elevatezoom.js') ?>"></script>
<!-- scripts js -->
<script src="<?= base_url('assets/frontend/js/scripts.js') ?>"></script>

<script src="<?= base_url('assets/all/sweetalert2/sweetalert2.all.min.js') ?>"></script>

<script>
  var site_url = '<?= site_url() ?>';
  var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });

  var ToastFast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1000
  });

  $(document).ready(function() {
    loadNotifikasiCart();
  })

  function logout() {
    Swal.fire({
        // title: 'Keluar',
        text: "Apakah Anda yakin keluar dari aplikasi !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Logout',
        cancelButtonText: 'Batal',
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $.ajax({
                    method: 'POST',
                    dataType: 'json',
                    url: '<?= site_url() ?>' + '/Auth/logout',
                    success: function (data) {
                        if (data.success == true) {
                            Swal.fire('Berhasil',data.message,'success');
                            swal.hideLoading()
                            setTimeout(function(){ 
                              window.location.href = '<?= site_url('/') ?>';
                            }, 1000);
                        } else {
                            Swal.fire({icon: 'error',title: 'Oops...',text: data.message});
                        }
                    },
                    fail: function (e) {
                        alert(e);
                    }
                });
            });
        },
        allowOutsideClick: false
    });
  }

  function loadNotifikasiCart() {
    $.ajax({
      url: "<?= site_url() ?>" + "/Order/fetch_data_cart",
      type: 'GET',
      dataType: 'json',
      data: {},
      beforeSend: function() {},
      success: function(result) {
        let data = result.data;
        if(data.length>0){
          let html = "<span class='cart_count'>"+ data.length +"</span>"
          $('#cart-count').html(html);
        }
      }
    });
  }

  function formatRupiah(angka){
    var reverse = angka.toString().split('').reverse().join(''),
    ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join('.').split('').reverse().join('');
    return ribuan;
  }
</script>