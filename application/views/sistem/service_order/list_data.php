<div class="table-responsive">
    <table class="table table-striped table-hover dataTable">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th>Order ID</th>
                <th>Pelanggan</th>
                <th>Layanan</th>
                <th>Tanggal Order</th>
                <th>Jadwal Service</th>
                <th>Status</th>
                <th width="15%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = ($paging['current'] * $paging['limit']) - $paging['limit'] + 1;
            if (count($list) > 0) {
                foreach ($list as $row) {
                    $service_names = [
                        'jok-motor' => 'Jok Motor',
                        'jok-mobil' => 'Jok Mobil',
                        'kursi-rumah' => 'Kursi Rumah',
                        'spring-bed' => 'Spring Bed'
                    ];

                    $status_badges = [
                        'pesanan_diterima' => '<span class="badge badge-info">Pesanan Diterima</span>',
                        'inspeksi' => '<span class="badge badge-warning">Inspeksi</span>',
                        'konfirmasi_biaya' => '<span class="badge badge-purple">Konfirmasi Biaya</span>',
                        'pengerjaan' => '<span class="badge badge-primary">Pengerjaan</span>',
                        'siap_diambil' => '<span class="badge badge-success">Siap Diambil</span>',
                        'selesai' => '<span class="badge badge-dark">Selesai</span>',
                        'ditolak' => '<span class="badge badge-danger">Ditolak</span>'
                    ];
            ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td>
                            <strong><?= $row->order_id ?></strong><br>
                            <small class="text-muted"><?= $row->phone_number ?></small>
                        </td>
                        <td>
                            <strong><?= $row->customer_name ?></strong><br>
                            <small class="text-muted"><?= substr($row->address, 0, 50) . (strlen($row->address) > 50 ? '...' : '') ?></small>
                        </td>
                        <td>
                            <?= $service_names[$row->service_type] ?? $row->service_type ?><br>
                            <small class="text-muted"><?= $row->service_method == 'antar-lokasi' ? 'Antar ke Workshop' : 'Antar & Jemput' ?></small>
                        </td>
                        <td><?= date('d M Y H:i', strtotime($row->order_date)) ?></td>
                        <td><?= date('d M Y', strtotime($row->service_date)) ?> <?= $row->service_time ?></td>
                        <td><?= $status_badges[$row->status] ?? '<span class="badge badge-secondary">' . ucfirst($row->status) . '</span>' ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewDetail('<?= $row->id ?>')">
                                    <i class="ti-eye"></i> Detail
                                </button>
                                <?php if ($row->status == 'pesanan_diterima'): ?>
                                    <button type="button" class="btn btn-sm btn-success" onclick="approveOrder('<?= $row->order_id ?>')">
                                        <i class="ti-check"></i> Approve
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="rejectOrder('<?= $row->order_id ?>')">
                                        <i class="ti-close"></i> Reject
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-sm btn-warning" onclick="updateStatus('<?= $row->order_id ?>', '<?= $row->status ?>')">
                                        <i class="ti-pencil"></i> Update
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php
                    $no++;
                }
            } else {
                ?>
                <tr>
                    <td colspan="8" class="text-center">Data tidak ditemukan</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- PAGING -->
<div class="row">
    <div class="col-md-6">
        <span class="text-muted">
            Menampilkan <?= count($list) ?> dari <?= $paging['count_row'] ?> data
        </span>
    </div>
    <div class="col-md-6">
        <div class="float-right">
            <?= $paging['list'] ?>
        </div>
    </div>
</div>