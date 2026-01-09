<html>
<head></head>
<body>
  <p>Upload bukti pembayaran :</p>
  <table>
    <tr>
      <td>Nama</td>
      <td>:</td>
      <td><?= $order['nama_pelanggan'] ?> (<?= $order['kode_pelanggan'] ?>)</td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td>:</td>
      <td><?= $order['tanggal'] ?></td>
    </tr>
    <tr>
      <td>No. Invoice</td>
      <td>:</td>
      <td><?= $order['no_invoice'] ?></td>
    </tr>
  </table>
  <p>Detail Pesanan</p>
  <table border="1" cellpadding="6" style="border: 1px solid black; border-collapse: collapse;">
    <thead>
      <tr>
        <th>No.</th>
        <th>Produk</th>
        <th>Satuan</th>
        <th>Qty</th>
        <th>Harga</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php 
    $no = 0;
    $total = 0;
    foreach ($order_detail as $row) { 
      $no++; 
      $total += ($row->qty*$row->harga);
    ?>
      <tr>
        <td><?= $no ?>.</td>
        <td><?= $row->nama_produk ?></td>
        <td><?= $row->satuan ?></td>
        <td><?= $row->qty ?></td>
        <td><?= rupiah($row->harga) ?></td>
        <td><?= rupiah($row->qty * $row->harga) ?></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="4"></td>
        <td><b>Total</b></td>
        <td>
          <span><?= rupiah($total) ?></span>
        </td>
      </tr>
    </tfoot>
  </table>
  <p style="font-weight:200;font-family:Helvetica,Arial,sans-serif;font-size:10pt;color:#2C3A47">Keterangan
    : Bukti upload pembayaran dapat dilihat di detail order pesanan.</p>
</body>

</html>