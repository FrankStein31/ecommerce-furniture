<?php
  $path_logo = base_url('assets/images/logo---.png');
  $type = pathinfo($path_logo, PATHINFO_EXTENSION);
  $data = file_get_contents($path_logo);
  $image_base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
?>

<!DOCTYPE html>
<html>

<head>
  <title><?=$title?></title>
  <style>
  .table {
    border-collapse: collapse;
    border-color: black;
    font-family: TimesNewRoman, Times New Roman, Times, Baskerville, Georgia, serif;
    width: 100%;
  }

  .head-table th {
    padding: 10px;
    border: 1px solid black;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
  }

  .body-table td,
  th {
    padding: 10px;
    border: 1px solid black;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 11px;
  }

  .head-lap td {
    padding: 1px;
    font-family: Arial, Helvetica, sans-serif;
  }

  .text-center {
    text-align: center;
  }

  .text-left {
    text-align: left;
  }

  .text-right {
    text-align: right;
  }

  .line-title {
    border: 0;
    border-style: inset;
    border-top: 2px solid #000;
  }

  .line-title-child {
    border: 0;
    margin-top: -7px;
    border-top: 1px solid #000;
  }

  .page_break {
    page-break-before: always;
  }

  .kata-pengantar {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 13px;
  }
  </style>
</head>

<body>
  <div style="margin:-25px;">

    <table class="table" style="text-align:left;">
      <tbody class="head-lap">
        <tr>
          <td width="20%">
            <div style="200px;">
              <img style="width:100%;" src="<?= $image_base64 ?>" alt="">
            </div>
          </td>
          <td width="70%" class="text-center" colspan="2">
            <span style="font-size:15px">LAPORAN PRODUK TERJUAL</span> <br>
            <span style="font-size:15px;"><?= $aplikasi['instansi'] ?></span> <br>
            <span style="font-size:12px"><?= $aplikasi['jalan'] .' '. $aplikasi['kelurahan'] .', Kec. '. $aplikasi['kecamatan'] .', '. $aplikasi['kabupaten'] .', '.$aplikasi['kode_pos'] ?></span> <br>
            <span style="font-size:12px">Email : <a href=""><?= $aplikasi['email_instansi'] ?></a></span>
            <span style="font-size:12px">Telepon : <?= $aplikasi['telp'] ?></span>
          </td>
          <td width="10%"></td>
        </tr>
      </tbody>
    </table>
    <hr class="line-title">
    <hr class="line-title-child">

    <p style="margin-top:35px;" class="kata-pengantar">Laporan Produk Terjual Periode Tanggal :
      <?= format_date($tanggal_awal, 'd/m/Y') ?> s/d <?= format_date($tanggal_akhir, 'd/m/Y') ?></p>
    <table class="table">
      <thead class="head-table">
        <tr>
          <th width="4%" class="text-center">No.</th>
          <th width="10%" class="text-center">Kode Produk</th>
          <th width="40%" class="text-center">Produk</th>
          <th width="10%" class="text-center">Satuan</th>
          <th width="8%">Jumlah</th>
        </tr>
      </thead>
      <tbody class="body-table">
        <?php 
        $no = 0;
        $total = 0;
        if(count($report)>0){
        foreach ($report as $row) { 
          $no++; 
          $total += ($row->jumlah_terjual);
        ?>
        
        <tr>
          <td class="text-center"><?= $no ?>.</td>
          <td><?= $row->kode_produk ?></td>
          <td><?= $row->nama_produk ?></td>
          <td class="text-center"><?= $row->satuan ?></td>
          <td class="text-center"><?= $row->jumlah_terjual ?></td>
        </tr>
        <?php }}else{ ?>
        <tr>
          <td colspan="5"></td>
        </tr>
        <?php } ?>
        <tr>
          <td colspan="4" class="text-right"><b>TOTAL</b></td>
          <td class="text-center"><b><?= $total ?></b></td>
        </tr>
      </tbody>
    </table>
  </div>
</body>

</html>