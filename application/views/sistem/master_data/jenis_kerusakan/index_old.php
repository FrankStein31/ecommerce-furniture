<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
        <span class="card-title">Data Jenis Kerusakan</span>
      </div>
      <div class="card-body">
        <div class="row" style="padding-top:12px;">
          <div class="col-md-6">
            <button class="btn btn-info" onclick="loadData()">
              <i class="fa fa-refresh"></i> Refresh Data
            </button>
          </div>
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" id="search" name="search" class="form-control" placeholder="Cari...">
              <div class="input-group-append">
                <span class="input-group-text cursor-pointer">
                  <i class="ti-search"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        <br>
        <div id="loading" class="text-center" style="display:none;">
          <i class="fa fa-spinner fa-spin fa-3x"></i>
          <p>Memuat data...</p>
        </div>
        <div id="list"></div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  loadData();
  
  $('#search').on('keyup', function() {
    filterTable();
  });
});

function loadData() {
  $('#loading').show();
  $('#list').html('');
  
  $.ajax({
    url: '<?= site_url("Master_data/fetch_jenis_kerusakan") ?>',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      $('#loading').hide();
      if (response.success && response.data.length > 0) {
        displayTable(response.data, response.total);
      } else {
        $('#list').html('<div class="alert alert-warning">Tidak ada data tersedia</div>');
      }
    },
    error: function(xhr, status, error) {
      $('#loading').hide();
      $('#list').html('<div class="alert alert-danger">Gagal memuat data: ' + error + '</div>');
    }
  });
}

function displayTable(data, total) {
  let html = `
    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="dataTable">
        <thead class="bg-warning text-dark">
          <tr>
            <th width="80">No</th>
            <th width="120">Kode</th>
            <th>Jenis Kerusakan</th>
          </tr>
        </thead>
        <tbody>
  `;
  
  data.forEach((item, index) => {
    html += `
      <tr>
        <td class="text-center">${item.id}</td>
        <td class="text-center"><span class="badge badge-warning">${item.kode}</span></td>
        <td>${item.jenis_kerusakan}</td>
      </tr>
    `;
  });
  
  html += `
        </tbody>
      </table>
    </div>
    <div class="mt-3">
      <p class="text-muted">Total: <strong>${total}</strong> data</p>
    </div>
  `;
  
  $('#list').html(html);
}

function filterTable() {
  const searchValue = $('#search').val().toLowerCase();
  const table = document.getElementById('dataTable');
  const tr = table.getElementsByTagName('tr');
  
  for (let i = 1; i < tr.length; i++) {
    const td = tr[i].getElementsByTagName('td');
    let found = false;
    
    for (let j = 0; j < td.length; j++) {
      if (td[j]) {
        const txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toLowerCase().indexOf(searchValue) > -1) {
          found = true;
          break;
        }
      }
    }
    
    tr[i].style.display = found ? '' : 'none';
  }
}
</script>
