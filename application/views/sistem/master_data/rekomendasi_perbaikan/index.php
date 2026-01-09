<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
        <span class="card-title">Data Rekomendasi Perbaikan</span>
      </div>
      <div class="card-body">
        <div class="row" style="padding-top:12px;">
          <div class="col-md-4">
            <button class="btn btn-info" onclick="loadData()">
              <i class="fa fa-refresh"></i> Refresh Data
            </button>
          </div>
          <div class="col-md-2">
            <select class="form-control" id="perPage" onchange="changePerPage()">
              <option value="10">10 Baris</option>
              <option value="25" selected>25 Baris</option>
              <option value="50">50 Baris</option>
              <option value="100">100 Baris</option>
            </select>
          </div>
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" id="search" name="search" class="form-control" placeholder="Cari...">
              <div class="input-group-append cursor-pointer" onclick="filterData()">
                <span class="input-group-text">
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
let allData = [];
let filteredData = [];
let currentPage = 1;
let perPage = 25;

$(document).ready(function() {
  loadData();
  
  $('#search').on('keyup', function(e) {
    if (e.key === 'Enter' || this.value === '') {
      filterData();
    }
  });
});

function loadData() {
  $('#loading').show();
  $('#list').html('');
  
  $.ajax({
    url: '<?= site_url("Master_data/fetch_rekomendasi_perbaikan") ?>',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      $('#loading').hide();
      if (response.success && response.data.length > 0) {
        allData = response.data;
        filteredData = allData;
        currentPage = 1;
        displayTable();
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

function filterData() {
  const searchValue = $('#search').val().toLowerCase().trim();
  
  if (searchValue === '') {
    filteredData = allData;
  } else {
    filteredData = allData.filter(item => {
      return item.kode.toLowerCase().includes(searchValue) ||
             item.rekomendasi_perbaikan.toLowerCase().includes(searchValue);
    });
  }
  
  currentPage = 1;
  displayTable();
}

function changePerPage() {
  perPage = parseInt($('#perPage').val());
  currentPage = 1;
  displayTable();
}

function displayTable() {
  const startIndex = (currentPage - 1) * perPage;
  const endIndex = startIndex + perPage;
  const paginatedData = filteredData.slice(startIndex, endIndex);
  const totalPages = Math.ceil(filteredData.length / perPage);
  
  let html = `
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="bg-danger text-white">
          <tr>
            <th width="80">No</th>
            <th width="120">Kode</th>
            <th>Rekomendasi Perbaikan</th>
          </tr>
        </thead>
        <tbody>
  `;
  
  if (paginatedData.length > 0) {
    paginatedData.forEach((item, index) => {
      const displayNo = startIndex + index + 1;
      html += `
        <tr>
          <td class="text-center">${displayNo}</td>
          <td class="text-center"><span class="badge badge-danger">${item.kode}</span></td>
          <td>${item.rekomendasi_perbaikan}</td>
        </tr>
      `;
    });
  } else {
    html += `<tr><td colspan="3" class="text-center">Tidak ada data yang sesuai pencarian</td></tr>`;
  }
  
  html += `
        </tbody>
      </table>
    </div>
  `;
  
  // Pagination
  html += `
    <div class="row mt-3">
      <div class="col-md-6">
        <p class="text-muted">
          Menampilkan ${startIndex + 1} - ${Math.min(endIndex, filteredData.length)} dari ${filteredData.length} data
          ${filteredData.length !== allData.length ? `(disaring dari ${allData.length} total data)` : ''}
        </p>
      </div>
      <div class="col-md-6">
        <nav>
          <ul class="pagination justify-content-end mb-0">
  `;
  
  // Previous button
  html += `
    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
      <a class="page-link" href="javascript:void(0)" onclick="goToPage(${currentPage - 1})">
        <i class="fa fa-angle-left"></i>
      </a>
    </li>
  `;
  
  // Page numbers
  const maxPagesToShow = 5;
  let startPage = Math.max(1, currentPage - Math.floor(maxPagesToShow / 2));
  let endPage = Math.min(totalPages, startPage + maxPagesToShow - 1);
  
  if (endPage - startPage < maxPagesToShow - 1) {
    startPage = Math.max(1, endPage - maxPagesToShow + 1);
  }
  
  if (startPage > 1) {
    html += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="goToPage(1)">1</a></li>`;
    if (startPage > 2) {
      html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
    }
  }
  
  for (let i = startPage; i <= endPage; i++) {
    html += `
      <li class="page-item ${i === currentPage ? 'active' : ''}">
        <a class="page-link" href="javascript:void(0)" onclick="goToPage(${i})">${i}</a>
      </li>
    `;
  }
  
  if (endPage < totalPages) {
    if (endPage < totalPages - 1) {
      html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
    }
    html += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="goToPage(${totalPages})">${totalPages}</a></li>`;
  }
  
  // Next button
  html += `
    <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
      <a class="page-link" href="javascript:void(0)" onclick="goToPage(${currentPage + 1})">
        <i class="fa fa-angle-right"></i>
      </a>
    </li>
  `;
  
  html += `
          </ul>
        </nav>
      </div>
    </div>
  `;
  
  $('#list').html(html);
}

function goToPage(page) {
  const totalPages = Math.ceil(filteredData.length / perPage);
  if (page >= 1 && page <= totalPages) {
    currentPage = page;
    displayTable();
  }
}
</script>
