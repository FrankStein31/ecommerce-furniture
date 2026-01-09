<?php if (!empty($service_orders)): ?>
    <?php foreach ($service_orders as $order): ?>
        <div class="tracking-card mb-3">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center mb-2">
                        <h6 class="mb-0 mr-3"><strong><?= $order->order_id ?></strong></h6>
                        <?php
                        $status_class = '';
                        $status_text = '';
                        switch ($order->status) {
                            case 'pesanan_diterima':
                                $status_class = 'status-diterima';
                                $status_text = 'Pesanan Diterima';
                                break;
                            case 'inspeksi':
                                $status_class = 'status-inspeksi';
                                $status_text = 'Inspeksi';
                                break;
                            case 'konfirmasi_biaya':
                                $status_class = 'status-konfirmasi';
                                $status_text = 'Konfirmasi Biaya';
                                break;
                            case 'pengerjaan':
                                $status_class = 'status-pengerjaan';
                                $status_text = 'Proses Pengerjaan';
                                break;
                            case 'siap_diambil':
                                $status_class = 'status-siap';
                                $status_text = 'Siap Diambil';
                                break;
                            case 'selesai':
                                $status_class = 'status-selesai';
                                $status_text = 'Selesai';
                                break;
                            default:
                                $status_class = 'status-diterima';
                                $status_text = ucfirst(str_replace('_', ' ', $order->status));
                        }
                        ?>
                        <span class="status-badge <?= $status_class ?>"><?= $status_text ?></span>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <small class="text-muted">Layanan:</small><br>
                            <span class="font-weight-medium">
                                <?php
                                $service_names = [
                                    'jok-motor' => 'Perbaikan Jok Motor',
                                    'jok-mobil' => 'Perbaikan Jok Mobil',
                                    'kursi-rumah' => 'Perbaikan Kursi Rumah Tangga',
                                    'spring-bed' => 'Perbaikan/Pemesanan Spring Bed'
                                ];
                                echo $service_names[$order->service_type] ?? $order->service_type;
                                ?>
                            </span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted">Tanggal Pesanan:</small><br>
                            <span class="font-weight-medium"><?= date('d M Y', strtotime($order->order_date)) ?></span>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-6">
                            <small class="text-muted">Jadwal Layanan:</small><br>
                            <span class="font-weight-medium"><?= date('d M Y', strtotime($order->service_date)) ?> • <?= $order->service_time ?></span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted">Estimasi Biaya:</small><br>
                            <span class="font-weight-medium"><?= $order->estimated_cost ?: 'Belum ditentukan' ?></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 text-right">
                    <button onclick="trackSpecificOrder('<?= $order->order_id ?>')" class="btn btn-outline-primary btn-sm mb-2">
                        <i class="ti-search"></i> Lacak
                    </button>
                    <br>
                    <a href="<?= site_url('track/' . $order->order_id) ?>" target="_blank" class="btn btn-outline-secondary btn-sm">
                        <i class="ti-external-link"></i> Detail
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <script>
        function trackSpecificOrder(orderId) {
            $('#quick-track-input').val(orderId);
            quickTrackOrder();
        }
    </script>

<?php else: ?>
    <div class="text-center py-4">
        <i class="ti-package" style="font-size: 48px; color: #ddd;"></i>
        <p class="text-muted mt-2">Belum ada riwayat layanan</p>
        <a href="<?= site_url('service') ?>" class="btn btn-outline-primary">
            <i class="ti-plus"></i> Pesan Layanan Sekarang
        </a>
    </div>
<?php endif; ?>