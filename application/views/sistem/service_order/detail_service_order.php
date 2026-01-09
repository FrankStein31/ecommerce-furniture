<div class="row">
    <div class="col-12">
        <div class="card flat">
            <div class="card-header card-header-blue d-flex justify-content-between align-items-center">
                <span class="card-title">Detail Service Order</span>
                <a href="<?= site_url('Service_order') ?>" class="btn btn-sm btn-light">
                    <i class="ti-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Order Info -->
                    <div class="col-md-6">
                        <h5>Informasi Pesanan</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Order ID:</strong></td>
                                <td><?= $order->order_id ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Order:</strong></td>
                                <td><?= date('d M Y H:i', strtotime($order->order_date)) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <?php
                                    $status_badges = [
                                        'pesanan_diterima' => '<span class="badge badge-info">Pesanan Diterima</span>',
                                        'inspeksi' => '<span class="badge badge-warning">Inspeksi</span>',
                                        'konfirmasi_biaya' => '<span class="badge badge-purple">Konfirmasi Biaya</span>',
                                        'pengerjaan' => '<span class="badge badge-primary">Pengerjaan</span>',
                                        'siap_diambil' => '<span class="badge badge-success">Siap Diambil</span>',
                                        'selesai' => '<span class="badge badge-dark">Selesai</span>',
                                        'ditolak' => '<span class="badge badge-danger">Ditolak</span>'
                                    ];
                                    echo $status_badges[$order->status] ?? '<span class="badge badge-secondary">' . ucfirst($order->status) . '</span>';
                                    ?>
                                </td>
                            </tr>
                        </table>

                        <h5 class="mt-4">Informasi Pelanggan</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Nama:</strong></td>
                                <td><?= $order->customer_name ?></td>
                            </tr>
                            <tr>
                                <td><strong>Telepon:</strong></td>
                                <td><?= $order->phone_number ?></td>
                            </tr>
                            <tr>
                                <td><strong>Alamat:</strong></td>
                                <td><?= $order->address ?></td>
                            </tr>
                        </table>
                    </div>

                    <!-- Service Info -->
                    <div class="col-md-6">
                        <h5>Informasi Layanan</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Jenis Layanan:</strong></td>
                                <td>
                                    <?php
                                    $service_names = [
                                        'jok-motor' => 'Perbaikan Jok Motor',
                                        'jok-mobil' => 'Perbaikan Jok Mobil',
                                        'kursi-rumah' => 'Perbaikan Kursi Rumah Tangga',
                                        'spring-bed' => 'Perbaikan/Pemesanan Spring Bed'
                                    ];
                                    echo $service_names[$order->service_type] ?? $order->service_type;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Metode:</strong></td>
                                <td><?= $order->service_method == 'antar-lokasi' ? 'Antar ke Lokasi Workshop' : 'Layanan Antar & Jemput' ?></td>
                            </tr>
                            <tr>
                                <td><strong>Jadwal:</strong></td>
                                <td><?= date('d M Y', strtotime($order->service_date)) ?> pukul <?= $order->service_time ?></td>
                            </tr>
                            <tr>
                                <td><strong>Estimasi Biaya:</strong></td>
                                <td><?= $order->estimated_cost ?: '<em class="text-muted">Belum ditentukan</em>' ?></td>
                            </tr>
                        </table>

                        <h5 class="mt-4">Detail Tambahan</h5>
                        <table class="table table-borderless">
                            <?php if ($order->vehicle_brand): ?>
                                <tr>
                                    <td width="40%"><strong>Merk Kendaraan:</strong></td>
                                    <td><?= $order->vehicle_brand ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($order->chair_type): ?>
                                <tr>
                                    <td width="40%"><strong>Jenis Kursi:</strong></td>
                                    <td><?= $order->chair_type ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($order->bed_size): ?>
                                <tr>
                                    <td width="40%"><strong>Ukuran Kasur:</strong></td>
                                    <td><?= $order->bed_size ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($order->material_type): ?>
                                <tr>
                                    <td width="40%"><strong>Jenis Material:</strong></td>
                                    <td><?= $order->material_type ?></td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>

                <!-- Description -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h5>Deskripsi Kebutuhan</h5>
                        <div class="alert alert-light">
                            <?= nl2br(htmlspecialchars($order->damage_description)) ?>
                        </div>
                    </div>
                </div>

                <!-- Special Notes -->
                <?php if ($order->special_notes): ?>
                    <div class="row">
                        <div class="col-12">
                            <h5>Catatan Khusus</h5>
                            <div class="alert alert-info">
                                <?= nl2br(htmlspecialchars($order->special_notes)) ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Admin Notes -->
                <?php if (isset($order->admin_notes) && $order->admin_notes): ?>
                    <div class="row">
                        <div class="col-12">
                            <h5>Catatan Admin</h5>
                            <div class="alert alert-warning">
                                <?= nl2br(htmlspecialchars($order->admin_notes)) ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Photos -->
                <?php if ($order->order_photos): ?>
                    <div class="row">
                        <div class="col-12">
                            <h5>Foto</h5>
                            <div class="row">
                                <?php
                                $photos = json_decode($order->order_photos, true);
                                if ($photos) {
                                    foreach ($photos as $photo) {
                                        echo '<div class="col-md-3 mb-3">';
                                        echo '<img src="' . base_url('assets/uploads/service_orders/' . $photo) . '" class="img-fluid rounded" alt="Foto Order">';
                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="row mt-4">
                    <div class="col-12">
                        <hr>
                        <div class="btn-group" role="group">
                            <?php if ($order->status == 'pesanan_diterima'): ?>
                                <button type="button" class="btn btn-success" onclick="approveOrder('<?= $order->order_id ?>')">
                                    <i class="ti-check"></i> Setujui Pesanan
                                </button>
                                <button type="button" class="btn btn-danger" onclick="rejectOrder('<?= $order->order_id ?>')">
                                    <i class="ti-close"></i> Tolak Pesanan
                                </button>
                            <?php elseif (in_array($order->status, ['inspeksi', 'konfirmasi_biaya', 'pengerjaan', 'siap_diambil'])): ?>
                                <button type="button" class="btn btn-warning" onclick="updateStatus('<?= $order->order_id ?>', '<?= $order->status ?>')">
                                    <i class="ti-pencil"></i>
                                    <?php
                                    $next_status_labels = [
                                        'inspeksi' => 'Lanjut ke Konfirmasi Biaya',
                                        'konfirmasi_biaya' => 'Mulai Pengerjaan',
                                        'pengerjaan' => 'Siap Diambil',
                                        'siap_diambil' => 'Selesaikan Pesanan'
                                    ];
                                    echo $next_status_labels[$order->status] ?? 'Update Status';
                                    ?>
                                </button>
                            <?php elseif ($order->status == 'selesai'): ?>
                                <span class="badge badge-success badge-lg">
                                    <i class="ti-check"></i> Pesanan Telah Selesai
                                </span>
                            <?php elseif ($order->status == 'ditolak'): ?>
                                <span class="badge badge-danger badge-lg">
                                    <i class="ti-close"></i> Pesanan Ditolak
                                </span>
                            <?php endif; ?>
                            <a href="<?= site_url('track/' . $order->order_id) ?>" target="_blank" class="btn btn-info">
                                <i class="ti-external-link"></i> Lihat Tracking
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Reuse functions from service-order.js
    function approveOrder(orderId) {
        // Will be handled by service-order.js
        window.parent.approveOrder(orderId);
    }

    function rejectOrder(orderId) {
        // Will be handled by service-order.js  
        window.parent.rejectOrder(orderId);
    }

    function updateStatus(orderId, currentStatus) {
        // Will be handled by service-order.js
        window.parent.updateStatus(orderId, currentStatus);
    }
</script>