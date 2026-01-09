<div class="row">
  <?php if($foto_produk->num_rows()>0){ 
  foreach ($foto_produk->result() as $row) { ?>
  <div class="col-md-2">
    <div class="img-produk">
      <a href="javascript" class="btn-delete-foto" data-id="<?= $row->id ?>">
        <div class="img-icon-delete">
          <i class="fa fa-times-circle"></i>
        </div>
      </a>
      <img src="<?= base_url().$row->foto ?>" alt="">
    </div>
  </div>
  <?php }} else { ?>
  <?php } ?>
  <div class="col-md-2">
    <div class="img-produk-plus">
      <input type="file" style="display:none;" name="file_upload" id="file_upload" />
      <div style="padding:40% 46%; cursor:pointer;" onclick="document.getElementById('file_upload').click()">
        <i class="fa fa-plus-circle" style="color:grey; font-size:16pt;"></i>
      </div>
    </div>
  </div>
</div>

<script>
$(function() {
  $("#file_upload").on('change', function(e) {
    e.preventDefault();
    let id = $("#id").val();
    let file = document.getElementById('file_upload').files[0]

    const formData = new FormData();
    formData.append('id_produk', id);
    formData.append('file', file);

    $.ajax({
      url: base_url + '/Produk/upload_foto',
      method: 'POST',
      dataType: 'json',
      data: formData,
      async: true,
      processData: false,
      contentType: false,
      success: function(data) {
        if (data.success == true) {
          Toast.fire({
            icon: 'success',
            title: data.message
          });
          getFotoProduk();
        } else {
          setTimeout(function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data.message
            });
          }, 1000);
        }
      },
      fail: function(event) {
        alert(event);
      }
    });
  });
});

$(document).on('click', '.btn-delete-foto', function(e) {
  var id = $(this).attr('data-id');
 
  Swal.fire({
    title: 'Hapus Foto Produk',
    text: "Apakah Anda yakin menghapus foto ?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#95a5a6',
    confirmButtonText: 'Hapus',
    cancelButtonText: 'Batal',
    showLoaderOnConfirm: true,
    preConfirm: function() {
      return new Promise(function(resolve) {
        $.ajax({
          method: 'GET',
          dataType: 'json',
          url: base_url + "/Produk/delete_foto/" + id,
          data: {},
          success: function(data) {
            if (data.success === true) {
              Toast.fire({
                icon: 'success',
                title: data.message
              });
              swal.hideLoading();
              getFotoProduk();
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.message
              });
            }
          },
          fail: function(e) {
            alert(e);
          }
        });
      });
    },
    allowOutsideClick: false
  });
  e.preventDefault();
});
</script>