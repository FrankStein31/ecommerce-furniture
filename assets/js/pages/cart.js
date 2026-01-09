$(document).ready(function () {
	loadCart();
})

function loadCart() {
	$.ajax({
		url: site_url + "/Order/get_list_cart",
		type: 'GET',
		dataType: 'html',
		data: {},
		beforeSend: function () {},
		success: function (result) {
			$('#div-cart').html(result);
			calculateGrandTotal();
		}
	});
}

function getTableCart() {
	let cart = [];
	$('#cart-table tr').each(function (index) {
		var cek = $(this).find("td .product-check").is(":checked");
		var id_cart = $(this).find("td .cart-id").val();
		var id_produk = $(this).find("td .product-id").val();
		var nama = $(this).find("td .product-name").val();
		var qty = $(this).find("td .qty").val();
		var harga = $(this).find("td .product-price").val();

		if (index != 0) {
			if (cek) {
				cart.push({
					id_cart: id_cart,
					id_produk: id_produk,
					nama: nama,
					qty: qty,
					harga: harga,
				})
			}
		}
	});

	return cart;
}

function checkout() {
	let cart = getTableCart();
	if (cart.length > 0) {
		let total = 0;
		$("#order-table tbody tr").remove();
		cart.forEach(el => {
			total += parseInt(el.qty * el.harga);
			let html = "<tr>" +
				"<td>" + el.nama + "<span class='product-qty'> x " + el.qty + "</span></td>" +
				"<td>Rp " + formatRupiah(parseInt(el.qty * el.harga)) + "</td>" +
				"</tr>";
			$('#order-table').append(html);
		});

		$('#order-detail-json').val(JSON.stringify(cart));
		$('#total-order').text("Rp " + formatRupiah(total));
		$('#modal-checkout').modal('show');
	} else {
		Swal.fire({
			icon: 'error',
			title: 'Oops...',
			text: "Harap pilih produk sebelum melakukan checkout"
		});
	}
}

$(document).on('click', '.btn-delete-cart', function (e) {
	var id = $(this).attr('data-id');
	$.ajax({
		method: 'GET',
		dataType: 'json',
		url: site_url + "/Order/delete_cart/" + id,
		data: {},
		success: function (data) {
			if (data.success === true) {
				Toast.fire({
					icon: 'success',
					title: data.message
				});
				loadCart();
				loadNotifikasiCart()
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

$(document).on('submit', '#form-checkout', function (event) {
	event.preventDefault();
	var order_detail = $('#order-detail-json').val();
	var formData = new FormData($('#form-checkout')[0]);
	formData.append('order_detail', order_detail);

	var cekAlamat = $("#alamat-pengiriman").val();
	if (cekAlamat == "") {
		Swal.fire({
			icon: 'error',
			title: 'Oops...',
			text: "Harap pilih alamat pengiriman. Jika belum memiliki alamat Anda dapat menambahkan alamat di account user"
		});
	} else {
		Swal.fire({
			title: 'Buat Pesanan',
			text: "Apakah Anda yakin menyimpan pesanan !",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3498db',
			cancelButtonColor: '#95a5a6',
			confirmButtonText: 'Simpan',
			cancelButtonText: 'Batal',
			showLoaderOnConfirm: true,
			preConfirm: function () {
				return new Promise(function (resolve) {
					$.ajax({
						url: site_url + '/Order/save',
						method: 'POST',
						dataType: 'json',
						data: formData,
						async: true,
						processData: false,
						contentType: false,
						success: function (data) {
							if (data.success == true) {
								Toast.fire({
									icon: 'success',
									title: data.message
								});
								$('#modal-checkout').modal('hide');
								setTimeout(function () {
									window.location.href = data.page;
								}, 1000);
							} else {
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									text: data.message
								});
							}
						},
						fail: function (event) {
							alert(event);
						}
					});
				});
			},
			allowOutsideClick: false
		});
	}
	event.preventDefault();
});

$(document).on('input', ".qty", function () {
	const self = $(this);
	let qty = parseInt($(this).val() || 0);
	let harga = parseFloat($(this).parents('tr').find(".product-price").val() || 0);
	let total = (qty * harga);
	$(this).parents('tr').find(".product-subtotal-hidden").val(total);
	$(this).parents('tr').find(".product-subtotal").text("Rp " + formatRupiah(total));
	calculateGrandTotal()
});

$(document).on('click', ".plus", function () {
	const self = $(this);
	let qty = parseFloat($(this).parents('tr').find(".qty").val() || 0);
	let harga = parseFloat($(this).parents('tr').find(".product-price").val() || 0);
	let total = (qty * harga);
	$(this).parents('tr').find(".product-subtotal-hidden").val(total);
	$(this).parents('tr').find(".product-subtotal").text("Rp " + formatRupiah(total));
	calculateGrandTotal()
});

$(document).on('click', ".minus", function () {
	const self = $(this);
	let qty = parseFloat($(this).parents('tr').find(".qty").val() || 0);
	let harga = parseFloat($(this).parents('tr').find(".product-price").val() || 0);
	let total = (qty * harga);
	$(this).parents('tr').find(".product-subtotal-hidden").val(total);
	$(this).parents('tr').find(".product-subtotal").text("Rp " + formatRupiah(total));
	calculateGrandTotal()
});

$(document).on('input', ".product-check", function () {
	calculateGrandTotal()
});

$(document).on('input', ".check-alamat", function () {
	const value = $(this).val();
	$('#alamat-pengiriman').val(value);
});

$(document).on('click', "#check-all", function () {
	var cek = $(this).is(":checked");
	$(this).closest('table').find("td input:checkbox").prop('checked', cek)
	calculateGrandTotal()
});

function calculateGrandTotal() {
	var total = 0;
	var jml = 0;
	$(".product-check").each(function () {
		var cek = $(this).is(":checked");
		$(this).parents('tr').find(".cart-check-product").val(cek);
		if (cek) {
			let value = $(this).parents('tr').find(".product-subtotal-hidden").val();
			if (!isNaN(value) && value.length != 0) {
				total += parseFloat(value);
			}
			jml++;
		}
	});

	$('#total-cart').text("Rp " + formatRupiah(total));
	$('#total-items').text(jml);
}

function formatNumber(val) {
	if (!val) return 0
	return parseInt(val) < 0 ?
		'(' + Number(Math.abs(parseInt(val))).toLocaleString() + ')' :
		Number(Math.abs(parseInt(val))).toLocaleString()
}

function isNumberKey(evt) {
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}
