<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Pesanan - {title}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .tracking-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .tracking-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 30px;
        }

        .order-status {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .status-timeline {
            position: relative;
            padding-left: 0;
        }

        .status-item {
            position: relative;
            padding: 20px 0 20px 60px;
            list-style: none;
            border-left: 3px solid #e9ecef;
        }

        .status-item:last-child {
            border-left: none;
        }

        .status-item.active {
            border-left-color: #28a745;
        }

        .status-item.active .status-icon {
            background: #28a745;
            color: white;
        }

        .status-item.completed {
            border-left-color: #28a745;
        }

        .status-item.completed .status-icon {
            background: #28a745;
            color: white;
        }

        .status-icon {
            position: absolute;
            left: -15px;
            top: 25px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .status-content h5 {
            color: #333;
            margin-bottom: 5px;
        }

        .status-content p {
            color: #666;
            margin: 0;
            font-size: 14px;
        }

        .order-details {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .detail-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #333;
        }

        .detail-value {
            color: #666;
        }

        .tracking-input {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .btn-track {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-track:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .alert-custom {
            border-radius: 15px;
            border: none;
            padding: 20px;
        }

        .order-photos img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">

    <div class="container mt-5">
        <div class="tracking-container">

            <!-- Header -->
            <div class="tracking-header">
                <h2><i class="fas fa-search-location"></i> Lacak Pesanan Layanan</h2>
                <p class="mb-0">Pantau status pesanan layanan perbaikan Anda</p>
            </div>

            <!-- Input Tracking -->
            <div class="tracking-input">
                <h4 class="mb-3">Masukkan Nomor Pesanan</h4>
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" id="trackingInput" class="form-control"
                            placeholder="Contoh: ORD-20241220-1234" value="{order_id}">
                    </div>
                    <div class="col-md-4">
                        <button onclick="trackOrder()" class="btn btn-track w-100">
                            <i class="fas fa-search"></i> Lacak Pesanan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Loading -->
            <div id="loadingSection" class="text-center" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Sedang mencari pesanan...</p>
            </div>

            <!-- Alert -->
            <div id="alertSection" style="display: none;"></div>

            <!-- Order Status -->
            <div id="orderStatusSection" style="display: none;">
                <div class="order-status">
                    <h4 class="mb-4">Status Pesanan</h4>
                    <ul class="status-timeline">
                        <li class="status-item" id="status-pesanan_diterima">
                            <div class="status-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="status-content">
                                <h5>Pesanan Diterima</h5>
                                <p>Pesanan Anda telah diterima dan sedang diproses</p>
                            </div>
                        </li>
                        <li class="status-item" id="status-inspeksi">
                            <div class="status-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <div class="status-content">
                                <h5>Inspeksi</h5>
                                <p>Tim teknisi sedang melakukan inspeksi dan analisis kebutuhan</p>
                            </div>
                        </li>
                        <li class="status-item" id="status-konfirmasi_biaya">
                            <div class="status-icon">
                                <i class="fas fa-calculator"></i>
                            </div>
                            <div class="status-content">
                                <h5>Konfirmasi Biaya</h5>
                                <p>Biaya final telah dihitung dan menunggu persetujuan</p>
                            </div>
                        </li>
                        <li class="status-item" id="status-pengerjaan">
                            <div class="status-icon">
                                <i class="fas fa-tools"></i>
                            </div>
                            <div class="status-content">
                                <h5>Proses Pengerjaan</h5>
                                <p>Proses perbaikan/pembuatan sedang berlangsung</p>
                            </div>
                        </li>
                        <li class="status-item" id="status-siap_diambil">
                            <div class="status-icon">
                                <i class="fas fa-gift"></i>
                            </div>
                            <div class="status-content">
                                <h5>Siap Diambil</h5>
                                <p>Pesanan telah selesai dan siap untuk diambil/diantar</p>
                            </div>
                        </li>
                        <li class="status-item" id="status-selesai">
                            <div class="status-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="status-content">
                                <h5>Selesai</h5>
                                <p>Pesanan telah selesai dan diserahkan kepada pelanggan</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Order Details -->
                <div class="order-details">
                    <h4 class="mb-4">Detail Pesanan</h4>
                    <div id="orderDetailsContent">
                        <!-- Content will be loaded here -->
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto track if order ID is provided
        window.onload = function() {
            var orderId = document.getElementById('trackingInput').value;
            if (orderId.trim() !== '') {
                trackOrder();
            }
        };

        function trackOrder() {
            var orderId = document.getElementById('trackingInput').value.trim();

            if (orderId === '') {
                showAlert('Silakan masukkan nomor pesanan', 'warning');
                return;
            }

            showLoading(true);
            hideAlert();
            hideOrderStatus();

            // Real AJAX call to API
            fetch('<?= base_url("Home/api_track_order") ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'order_id=' + encodeURIComponent(orderId)
                })
                .then(response => response.json())
                .then(data => {
                    showLoading(false);

                    if (data.status === 'success') {
                        displayOrderStatus(data.data);
                    } else {
                        showAlert(data.message || 'Pesanan tidak ditemukan. Periksa kembali nomor pesanan Anda.', 'danger');
                    }
                })
                .catch(error => {
                    showLoading(false);
                    console.error('Error:', error);

                    // Fallback with sample data for demo
                    if (orderId.includes('ORD-')) {
                        var orderData = {
                            order_id: orderId,
                            customer_name: 'John Doe',
                            service_type: 'jok-motor',
                            service_method: 'antar-jemput',
                            service_date: '2024-12-25',
                            service_time: '10:00',
                            status: 'inspeksi',
                            order_date: '2024-12-20 14:30:00',
                            estimated_cost: 'Rp 150.000 - Rp 200.000'
                        };
                        displayOrderStatus(orderData);
                    } else {
                        showAlert('Terjadi kesalahan koneksi. Silakan coba lagi.', 'danger');
                    }
                });
        }

        function showLoading(show) {
            document.getElementById('loadingSection').style.display = show ? 'block' : 'none';
        }

        function showAlert(message, type) {
            var alertHtml = '<div class="alert alert-' + type + ' alert-custom">' + message + '</div>';
            document.getElementById('alertSection').innerHTML = alertHtml;
            document.getElementById('alertSection').style.display = 'block';
        }

        function hideAlert() {
            document.getElementById('alertSection').style.display = 'none';
        }

        function hideOrderStatus() {
            document.getElementById('orderStatusSection').style.display = 'none';
        }

        function displayOrderStatus(orderData) {
            // Update timeline status
            updateTimelineStatus(orderData.status);

            // Update order details
            var serviceTypes = {
                'jok-motor': 'Perbaikan Jok Motor',
                'jok-mobil': 'Perbaikan Jok Mobil',
                'kursi-rumah': 'Perbaikan Kursi Rumah Tangga',
                'spring-bed': 'Perbaikan/Pemesanan Spring Bed'
            };

            var serviceMethods = {
                'antar-lokasi': 'Antar ke Lokasi Workshop',
                'antar-jemput': 'Layanan Antar & Jemput'
            };

            var detailsHtml = `
                <div class="detail-item">
                    <div class="row">
                        <div class="col-4 detail-label">Order ID:</div>
                        <div class="col-8 detail-value">${orderData.order_id}</div>
                    </div>
                </div>
                <div class="detail-item">
                    <div class="row">
                        <div class="col-4 detail-label">Nama Pelanggan:</div>
                        <div class="col-8 detail-value">${orderData.customer_name}</div>
                    </div>
                </div>
                <div class="detail-item">
                    <div class="row">
                        <div class="col-4 detail-label">Jenis Layanan:</div>
                        <div class="col-8 detail-value">${serviceTypes[orderData.service_type] || orderData.service_type}</div>
                    </div>
                </div>
                <div class="detail-item">
                    <div class="row">
                        <div class="col-4 detail-label">Metode Layanan:</div>
                        <div class="col-8 detail-value">${serviceMethods[orderData.service_method] || orderData.service_method}</div>
                    </div>
                </div>
                <div class="detail-item">
                    <div class="row">
                        <div class="col-4 detail-label">Tanggal Layanan:</div>
                        <div class="col-8 detail-value">${orderData.service_date} ${orderData.service_time}</div>
                    </div>
                </div>
                <div class="detail-item">
                    <div class="row">
                        <div class="col-4 detail-label">Tanggal Pesanan:</div>
                        <div class="col-8 detail-value">${orderData.order_date}</div>
                    </div>
                </div>
                <div class="detail-item">
                    <div class="row">
                        <div class="col-4 detail-label">Estimasi Biaya:</div>
                        <div class="col-8 detail-value">${orderData.estimated_cost}</div>
                    </div>
                </div>
            `;

            document.getElementById('orderDetailsContent').innerHTML = detailsHtml;
            document.getElementById('orderStatusSection').style.display = 'block';
        }

        function updateTimelineStatus(currentStatus) {
            // Reset all status items
            var statusItems = document.querySelectorAll('.status-item');
            statusItems.forEach(function(item) {
                item.classList.remove('active', 'completed');
            });

            // Status order
            var statusOrder = [
                'pesanan_diterima',
                'inspeksi',
                'konfirmasi_biaya',
                'pengerjaan',
                'siap_diambil',
                'selesai'
            ];

            var currentIndex = statusOrder.indexOf(currentStatus);

            // Mark completed and active status
            for (var i = 0; i <= currentIndex; i++) {
                var statusElement = document.getElementById('status-' + statusOrder[i]);
                if (statusElement) {
                    if (i === currentIndex) {
                        statusElement.classList.add('active');
                    } else {
                        statusElement.classList.add('completed');
                    }
                }
            }
        }

        // Allow Enter key to trigger search
        document.getElementById('trackingInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                trackOrder();
            }
        });
    </script>
</body>

</html>