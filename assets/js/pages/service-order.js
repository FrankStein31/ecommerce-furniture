$(document).ready(function () {
	pageLoad(1);

	$("#search").keypress(function (e) {
		if (e.which == 13) {
			pageLoad(1);
		}
	});
});

function pageLoad(page) {
	var limit = $("#limit").val();
	var search = $("#search").val();
	var status_filter = $("#status_filter").val();
	var sortby = $("#hidden_column_name").val();
	var sorttype = $("#hidden_sort_type").val();

	$.ajax({
		url: site_url + "/Service_order/fetch_data",
		type: "GET",
		dataType: "html",
		data: {
			page: page,
			limit: limit,
			search: search,
			status: status_filter,
			sortby: sortby,
			sorttype: sorttype,
		},
		beforeSend: function () {
			$("#list").html(
				'<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>'
			);
		},
		success: function (result) {
			$("#list").html(result);
			$("#hidden_page").val(page);
		},
		error: function () {
			$("#list").html(
				'<div class="text-center text-danger">Error loading data</div>'
			);
		},
	});
}

function viewDetail(id) {
	window.location.href = site_url + "/Service_order/detail_service_order/" + id;
}

function approveOrder(orderId) {
	Swal.fire({
		title: "Setujui Pesanan",
		html: `
            <div class="text-left">
                <div class="form-group">
                    <label>Estimasi Biaya (Opsional):</label>
                    <input type="text" id="estimated_cost" class="form-control" placeholder="Contoh: Rp 150.000 - Rp 200.000">
                </div>
                <div class="form-group">
                    <label>Catatan Admin:</label>
                    <textarea id="admin_notes" class="form-control" rows="3" placeholder="Catatan untuk pelanggan..."></textarea>
                </div>
            </div>
        `,
		showCancelButton: true,
		confirmButtonText: "Setujui",
		cancelButtonText: "Batal",
		confirmButtonColor: "#28a745",
		cancelButtonColor: "#6c757d",
		preConfirm: () => {
			return {
				estimated_cost: document.getElementById("estimated_cost").value,
				admin_notes: document.getElementById("admin_notes").value,
			};
		},
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: site_url + "/Service_order/approve_order",
				type: "POST",
				dataType: "json",
				data: {
					order_id: orderId,
					estimated_cost: result.value.estimated_cost,
					admin_notes: result.value.admin_notes,
				},
				beforeSend: function () {
					Swal.fire({
						title: "Processing...",
						allowOutsideClick: false,
						didOpen: () => {
							Swal.showLoading();
						},
					});
				},
				success: function (response) {
					if (response.success) {
						Swal.fire({
							icon: "success",
							title: "Berhasil!",
							text: response.message,
							timer: 2000,
						}).then(() => {
							pageLoad($("#hidden_page").val());
						});
					} else {
						Swal.fire({
							icon: "error",
							title: "Gagal!",
							text: response.message,
						});
					}
				},
				error: function () {
					Swal.fire({
						icon: "error",
						title: "Error!",
						text: "Terjadi kesalahan sistem",
					});
				},
			});
		}
	});
}

function rejectOrder(orderId) {
	Swal.fire({
		title: "Tolak Pesanan",
		html: `
            <div class="text-left">
                <div class="form-group">
                    <label>Alasan Penolakan: <span class="text-danger">*</span></label>
                    <textarea id="rejection_reason" class="form-control" rows="4" placeholder="Jelaskan alasan penolakan..." required></textarea>
                </div>
            </div>
        `,
		showCancelButton: true,
		confirmButtonText: "Tolak Pesanan",
		cancelButtonText: "Batal",
		confirmButtonColor: "#dc3545",
		cancelButtonColor: "#6c757d",
		preConfirm: () => {
			const reason = document.getElementById("rejection_reason").value;
			if (!reason.trim()) {
				Swal.showValidationMessage("Alasan penolakan harus diisi");
				return false;
			}
			return { rejection_reason: reason };
		},
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: site_url + "/Service_order/reject_order",
				type: "POST",
				dataType: "json",
				data: {
					order_id: orderId,
					rejection_reason: result.value.rejection_reason,
				},
				beforeSend: function () {
					Swal.fire({
						title: "Processing...",
						allowOutsideClick: false,
						didOpen: () => {
							Swal.showLoading();
						},
					});
				},
				success: function (response) {
					if (response.success) {
						Swal.fire({
							icon: "success",
							title: "Berhasil!",
							text: response.message,
							timer: 2000,
						}).then(() => {
							pageLoad($("#hidden_page").val());
						});
					} else {
						Swal.fire({
							icon: "error",
							title: "Gagal!",
							text: response.message,
						});
					}
				},
				error: function () {
					Swal.fire({
						icon: "error",
						title: "Error!",
						text: "Terjadi kesalahan sistem",
					});
				},
			});
		}
	});
}

function updateStatus(orderId, currentStatus) {
	// Define sequential status flow and their display names
	const statusFlow = {
		inspeksi: { next: "konfirmasi_biaya", label: "Konfirmasi Biaya" },
		konfirmasi_biaya: { next: "pengerjaan", label: "Proses Pengerjaan" },
		pengerjaan: { next: "siap_diambil", label: "Siap Diambil" },
		siap_diambil: { next: "selesai", label: "Selesai" },
	};

	// Check if current status can be progressed
	if (!statusFlow[currentStatus]) {
		Swal.fire({
			icon: "warning",
			title: "Peringatan!",
			text: "Status ini tidak dapat diupdate lebih lanjut",
		});
		return;
	}

	const nextStatus = statusFlow[currentStatus];

	Swal.fire({
		title: "Update Status Pesanan",
		html: `
            <div class="text-left">
                <div class="form-group">
                    <label>Status akan diubah menjadi:</label>
                    <div class="alert alert-info">
                        <strong>${nextStatus.label}</strong>
                    </div>
                </div>
                <div class="form-group">
                    <label>Catatan (Opsional):</label>
                    <textarea id="status_notes" class="form-control" rows="3" placeholder="Catatan untuk pelanggan..."></textarea>
                </div>
            </div>
        `,
		showCancelButton: true,
		confirmButtonText: "Update Status",
		cancelButtonText: "Batal",
		confirmButtonColor: "#007bff",
		cancelButtonColor: "#6c757d",
		preConfirm: () => {
			return {
				notes: document.getElementById("status_notes").value,
			};
		},
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: site_url + "/Service_order/update_status",
				type: "POST",
				dataType: "json",
				data: {
					order_id: orderId,
					current_status: currentStatus,
					notes: result.value.notes,
				},
				beforeSend: function () {
					Swal.fire({
						title: "Processing...",
						allowOutsideClick: false,
						didOpen: () => {
							Swal.showLoading();
						},
					});
				},
				success: function (response) {
					if (response.success) {
						Swal.fire({
							icon: "success",
							title: "Berhasil!",
							text: response.message,
							timer: 2000,
						}).then(() => {
							// Reload the page to show updated status
							location.reload();
						});
					} else {
						Swal.fire({
							icon: "error",
							title: "Gagal!",
							text: response.message,
						});
					}
				},
				error: function () {
					Swal.fire({
						icon: "error",
						title: "Error!",
						text: "Terjadi kesalahan sistem",
					});
				},
			});
		}
	});
}
