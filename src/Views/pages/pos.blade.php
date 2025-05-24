@extends('components.app')
@section('main')
    <h1 class="mt-4">POS</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Point Of Sale</li>
    </ol>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-cart-shopping"></i>
            Point Of Sale
        </div>
        <div class="card-body">
            <h3>Tambah Produk</h3>
            <div class="row mb-3">
                <div class="col-md-6">
                    <select name="item" class="form-select select-search" id="itemSelect">
                        <option value="" disabled selected>-- Pilih Barang --</option>
                        @foreach ($products as $product)
                            <option data-product="{{ json_encode($product) }}" value="{{ $product['id'] }}">
                                {{ $product['kode_barang'] }} - {{ $product['nama_barang'] }} - Rp. {{ number_format(num: $product['harga_beli'], thousands_separator: '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input id="stock" type="text" class="form-control" placeholder="Stok" disabled>
                </div>
                <div class="col-md-2">
                    <input id="qty" type="number" min="1" class="form-control" placeholder="Qty">
                </div>
                <div class="col-md-2">
                    <button id="addItem" class="btn btn-primary w-100">
                        <i class="fas fa-plus"></i>
                        Tambah Barang
                    </button>
                </div>
            </div>

            <h4 class="mb-3">Daftar Belanja</h4>
            <table class="table table-bordered" id="posTable">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="posTableBody">
                    <tr id="emptyRow">
                        <td colspan="6" class="text-center text-muted">Belum ada produk ditambahkan</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th id="totalQty">0</th>
                        <th id="totalSubtotal">Rp. 0</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>

            <button id="createInvoice" class="btn btn-success mt-3" disabled>Buat Invoice</button>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    let cartItems = [];

    function renderEmptyState() {
        if ($('#posTableBody tr').length === 0) {
            $('#posTableBody').append(`
                <tr id="emptyRow">
                    <td colspan="6" class="text-center text-muted">Belum ada produk ditambahkan</td>
                </tr>
            `);
        }
    }

    function removeEmptyState() {
        $('#emptyRow').remove();
    }

    function updateTotals() {
        const totalQty = cartItems.reduce((sum, item) => sum + item.qty, 0);
        const totalSubtotal = cartItems.reduce((sum, item) => sum + item.subtotal, 0);
        const rupiahFormat = Intl.NumberFormat('id-ID', { style: "currency", currency: "IDR" });

        $('#totalQty').text(totalQty);
        $('#totalSubtotal').text(rupiahFormat.format(totalSubtotal));

        // Enable/disable tombol Buat Invoice berdasarkan ada item atau tidak
        $('#createInvoice').prop('disabled', cartItems.length === 0);
    }

    $(document).ready(() => {
        $('#itemSelect').on('change', (e) => {
            const product = $(e.target).find(':selected').data('product');
            $('#stock').val(`${product.jumlah_barang} ${product.satuan_barang}`);
        });

        $('#addItem').on('click', function () {
            const selected = $('#itemSelect').find(':selected');
            const product = selected.data('product');
            const productId = selected.val();
            const qty = parseInt($('#qty').val());

            if (!productId || !product || isNaN(qty) || qty <= 0) {
                alert('⚠️ Pilih produk dan masukkan qty yang valid.');
                return;
            }

            if (qty > product.jumlah_barang) {
                alert('⚠️ Jumlah melebihi stok!');
                return;
            }

            const exists = cartItems.find(item => item.id == productId);
            if (exists) {
                alert('⚠️ Produk sudah ada dalam daftar!');
                return;
            }

            const subtotal = product.harga_beli * qty;
            const rupiahFormat = Intl.NumberFormat('id-ID', { style: "currency", currency: "IDR" });

            cartItems.push({
                id: product.id,
                kode: product.kode_barang,
                nama: product.nama_barang,
                harga: product.harga_beli,
                qty: qty,
                subtotal: subtotal
            });

            removeEmptyState();

            $('#posTableBody').append(`
                <tr data-id="${productId}">
                    <td>${product.kode_barang}</td>
                    <td>${product.nama_barang}</td>
                    <td>${rupiahFormat.format(product.harga_beli)}</td>
                    <td>${qty}</td>
                    <td>${rupiahFormat.format(subtotal)}</td>
                    <td><button class="btn btn-sm btn-danger remove-row">Hapus</button></td>
                </tr>
            `);

            $('#qty').val('');
            updateTotals();
        });

        $('#posTable').on('click', '.remove-row', function () {
            const row = $(this).closest('tr');
            const id = row.data('id');

            cartItems = cartItems.filter(item => item.id != id);
            row.remove();

            renderEmptyState();
            updateTotals();
        });

        $('#createInvoice').on('click', function () {
            if (cartItems.length === 0) {
                alert('⚠️ Tidak ada produk untuk dibuat invoice.');
                return;
            }

            const form = $('<form>', {
                method: 'POST',
                action: '/pos'
            });

            form.append($('<input>', {
                type: 'hidden',
                name: 'cart_items',
                value: JSON.stringify(cartItems)
            }));

            $('body').append(form);
            form.submit();
        });

        renderEmptyState();
        updateTotals();
    });
</script>
@endsection
