$(document).ready(function() {
  pageLoad(1)
})

$('#search').on('keypress', function(e) {
  if (e.which == 13) {
    pageLoad(1);
  }
});

function pageLoad(page=1) {
  var search = $('#search').val();
  var limit = $('#limit').val();
  var id_th = $('#hidden_id_th').val();
  var column_name = $('#hidden_column_name').val();
  var sort_type = $('#hidden_sort_type').val();
  $.ajax({
    url: base_url + "/Order/fetch_data",
    type: 'GET',
    dataType: 'html',
    data: {
      page : page,
      sortby : column_name,
      sorttype : sort_type,
      limit : limit,
      search : search,
    },
    beforeSend: function() {},
    success: function(result) {
        $('#list').html(result);
        $('#hidden_page').val(page);
        sort_finish(id_th,sort_type);
    }
  });
}

function sort_table(id, column){
  var sort = $(id).attr("data-sort");
  $('#hidden_id_th').val(id);
  $('#hidden_column_name').val(column);
  
  if(sort=="asc"){
      sort = 'desc';
  }else if(sort=="desc"){
      sort = 'asc';
  }else{
      sort = 'asc';
  }
  $('#hidden_sort_type').val(sort);
  $('#hidden_page').val(1);
  pageLoad(1);
}

$('#btn-create').on('click', function() {
    $.ajax({
        url: base_url + "/Pelanggan/load_modal",
        type: 'POST',
        data : {},
        dataType: 'html',
        beforeSend: function() {},
        success: function(result) {
            $('#div_modal').html(result);
            $('#modalTitleAdd').show();
            $('#modeform').val('ADD');
            $('#formModal').modal('show');
        }
    });
});

$(document).on('click', '.btn-edit', function(event) {
  event.preventDefault();
  var id = $(this).attr('data-id');
  $.ajax({
    url: base_url + "/Pelanggan/load_modal",
    type: 'POST',
    dataType: 'html',
    data:{id:id},
    beforeSend: function () {},
    success: function (result) {    
      $('#div_modal').html(result);
      $('#modalTitleEdit').show();
      $('#modeform').val('UPDATE');
      $('#formModal').modal('show');
    }
  });
});

$(document).on('click', '.btn-delete', function(e) {
  var id = $(this).attr('data-id');
  var title = $(this).attr('data-name');
  var page = $('#hidden_page').val();

  Swal.fire({
    title: 'Hapus Pelanggan',
    text: "Apakah Anda yakin menghapus data " + title + " ?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#95a5a6',
    confirmButtonText: 'Hapus',
    cancelButtonText: 'Batal',
    showLoaderOnConfirm: true,
    preConfirm: function () {
      return new Promise(function (resolve) {
        $.ajax({
          method: 'GET',
          dataType: 'json',
          url: base_url + "/Pelanggan/delete/" + id,
          data: {},
          success: function (data) {
            if (data.success === true) {
              Toast.fire({
                icon: 'success',
                title: data.message
              });
              swal.hideLoading()
              pageLoad(page);
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.message
              });
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
  e.preventDefault();
});

$(document).on('submit', '#formData', function(event) {
  event.preventDefault();
  var modeform = $('#modeform').val();
  var page = (modeform=='UPDATE') ? $('#hidden_page').val() : 1;
  $.ajax({
      url: base_url + "/Pelanggan/save",
      method: 'POST',
      dataType: 'json',	
      data: new FormData($('#formData')[0]),
      async: true,
      processData: false,
      contentType: false,
      success: function (data) {
        if (data.success == true) {
            Toast.fire({
                icon: 'success',
                title: data.message
            });
            $('#formModal').modal('hide');
            pageLoad(page);
        } else {
            Swal.fire({icon: 'error',title: 'Oops...',text: data.message});
        }
      },
      fail: function (event) {
          alert(event);
      }
  });
});