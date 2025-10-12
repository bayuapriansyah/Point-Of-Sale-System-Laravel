@extends('layouts.app')
@section('content_title', 'Pengeluaran Barang / Transaksi')
@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        @foreach ($errors as $error)
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endforeach
    @endif

    <div class="card">
        <div class="card-title border-bottom p-3">
            <form action="{{ route('pengeluaran-barang.store') }}" method="post" id="form-pengeluaran-barang">
                @csrf
                <div id="input-hidden"></div>
                <div class="d-flex justify-content-between">
                    <h5 class="h5">Pengeluaran Barang</h5>

                </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="w-100 mr-2">
                                    <label for="select2">Produk</label>
                                    <select name="select2" id="select2" class="form-control"></select>
                                </div>
                                <div class="mr-2">
                                    <label for="jumlah">Stok</label>
                                    <input type="number" id="jumlah" class="form-control" style="width:100px;" readonly>
                                </div>
                                <div class="mr-2">
                                    <label for="harga">Harga</label>
                                    <input id="harga" class="form-control" style="width:100px;" readonly>
                                </div>
                                <div class="mr-2">
                                    <label for="qty">Qty</label>
                                    <input type="number" id="qty" class="form-control" style="width:100px;">
                                </div>
                                <div style="padding-top: 32px;">
                                    <button type="button" class="btn btn-dark" id="btn-tambah">Tambahkan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-card d-flex ">
                        <div class="col-8">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-sm mt-3" id="table-produk">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Produk</th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th>Sub total</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>Total:</strong></td>
                                                <td colspan="1"><strong id="grand-total">0</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Ringkasan Pembayaran</h5>
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <td>Total</td>
                                            <td class="text-right"><strong id="summary-total">0</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Bayar</td>
                                            <td class="text-right">
                                                <input type="number" id="input-jumlah-bayar" class="form-control"
                                                    style="width:160px; margin-left:auto;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Kembalian</td>
                                            <td class="text-right"><strong id="summary-kembalian">0</strong></td>
                                        </tr>
                                    </table>
                                    <div class="container-submit mt-3 d-flex justify-content-between">
                                        <div class="">
                                            <button type="button" id="btn-reset-pembayaran"
                                                class="btn btn-secondary">Reset</button>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-success">Simpan Transaksi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>

@endsection
@push('script')
    <script>

        $(document).ready(function () {
            let selectedProduk = {};
            window.listProduk = [];
            $('#select2').select2({
                theme: "bootstrap",
                minimumInputLength: 2,
                placeholder: 'Cari produk...',
                ajax: {
                    url: "{{ route('get-data.produk') }}",
                    dataType: "json",
                    delay: 250,
                    data: (params) => {
                        return {
                            search: params.term
                        }
                    },
                    processResults: (data) => {
                        data.results.forEach(item => {
                            item.harga_jual = item.harga ?? item.harga_jual ?? 0;
                            selectedProduk[item.id] = item;
                        });
                        return {
                            results: data.results.map((item) => {
                                return {
                                    id: item.id,
                                    text: item.nama_produk
                                }
                            })
                        }
                    },
                    cache: true
                }
            });

            $("#select2").on("change", function (e) {
                let id = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "{{ route('get-data.cek-stok') }}",
                    data: { id: id },
                    dataType: "json",
                    success: function (response) {
                        $('#jumlah').val(response);
                    }
                })

                const cached = selectedProduk[id];
                if (cached && cached.harga_jual && Number(cached.harga_jual) > 0) {
                    const harga = Number(cached.harga_jual);
                    $('#harga').val("Rp" + harga.toLocaleString('id-ID'));
                } else if (id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('get-data.cek-harga') }}",
                        data: { id: id },
                        dataType: "json",
                        success: function (response) {
                            const harga = Number(response) || 0;
                            $('#harga').val("Rp" + harga.toLocaleString('id-ID'));
                            if (selectedProduk[id]) selectedProduk[id].harga_jual = harga;
                        }
                    })
                } else {
                    $('#harga').val('');
                }
            })

            $("#btn-tambah").on("click", function () {
                let id = $("#select2").val();
                let produk = selectedProduk[id];
                let stok = parseInt($("#jumlah").val());
                let qty = parseInt($("#qty").val());
                const harga = Number(produk.harga_jual || produk.harga || 0);
                const subtotal = harga * parseInt(qty);

                if (!id) {
                    return alert("silahkan pilih produk terlebih dahulu");
                }

                if (qty > stok) {
                    return alert("stok tidak mencukupi");
                }

                listProduk.push({ id, nama: produk.nama_produk, qty: qty, stok, harga_jual: harga });

                tampilTable();
                renderHiddenInputs();

                $("#select2").val(null).trigger("change");
                $("#qty").val("");
                $("#jumlah").val("");
                $("#harga").val("");

            });

            function tampilTable() {
                let rows = '';
                let grandTotal = 0;
                listProduk.forEach((item, index) => {

                    const qty = parseInt(item.qty) || 0;
                    const harga = parseFloat(item.harga_jual || item.harga || 0) || 0;
                    const subtotal = harga * qty;
                    grandTotal += subtotal;

                    rows += `
                                                                                                   <tr>
                                                                                                     <td>${index + 1}</td>
                                                                                                    <td>${item.nama}</td>
                                                                                                      <td>${qty}</td>
                                                                                                    <td>${formatRupiah(harga)}</td>
                                                                                                      <td>${formatRupiah(subtotal)}</td>
                                                                                                        <td>
                                                                                                     <button type="button" class="btn btn-danger btn-sm" onclick="hapusItem(${index})">Hapus</button>
                                                                                                    </td>
                                                                                                   </tr>`;
                });

                $("#table-produk tbody").html(rows);
                $("#grand-total").text(formatRupiah(grandTotal));

                $("#summary-total").text(formatRupiah(grandTotal));
                updatePaymentHiddenInputs(grandTotal);
                // enable/disable submit
                $("#form-pengeluaran-barang button[type=submit]").prop('disabled', listProduk.length === 0);
            }

            window.hapusItem = function (index) {
                listProduk.splice(index, 1);
                tampilTable();
                renderHiddenInputs();
            }


            $(document).on('input', '#input-jumlah-bayar', function () {
                const bayar = Number($(this).val()) || 0;
                const total = parseNumberFromFormatted($('#summary-total').text());
                const kembalian = bayar - total;
                $('#summary-kembalian').text(formatRupiah(kembalian > 0 ? kembalian : 0));
                $("input[name='jumlah_bayar']").val(bayar);
                $("input[name='kembalian']").val(kembalian > 0 ? kembalian : 0);
            });

            $(document).on('click', '#btn-reset-pembayaran', function () {
                $('#input-jumlah-bayar').val('');
                $('#summary-kembalian').text(formatRupiah(0));
                $("input[name='jumlah_bayar']").val('');
                $("input[name='kembalian']").val('');
            });

            function renderHiddenInputs() {
                let html = '';
                listProduk.forEach((item, index) => {
                    let grandTotal = 0;
                    const qty = parseInt(item.qty) || 0;
                    const harga = parseFloat(item.harga_jual || item.harga || 0) || 0;
                    const subtotal = harga * qty;
                    grandTotal += subtotal;

                    html += `
                                        <input type="hidden" name="produk[${index}][id]" value="${item.id}">
                                        <input type="hidden" name="produk[${index}][qty]" value="${qty}">
                                        <input type="hidden" name="produk[${index}][harga_jual]" value="${harga}">
                                    `;
                });
                $("#input-hidden").html(html);
            }

            function updatePaymentHiddenInputs(grandTotal) {
                // rebuild inputs from current listProduk to avoid stale values
                let html = '';
                listProduk.forEach((item, index) => {
                    const qty = parseInt(item.qty) || 0;
                    const harga = parseFloat(item.harga_jual || item.harga || 0) || 0;
                    html += `<input type="hidden" name="produk[${index}][id]" value="${item.id}">`;
                    html += `<input type="hidden" name="produk[${index}][qty]" value="${qty}">`;
                    html += `<input type="hidden" name="produk[${index}][harga_jual]" value="${harga}">`;
                });

                html += `<input type="hidden" name="total" value="${grandTotal}">`;
                html += `<input type="hidden" name="jumlah_bayar" value="${$("input[name='jumlah_bayar']").val() || ''}">`;
                html += `<input type="hidden" name="kembalian" value="${$("input[name='kembalian']").val() || ''}">`;

                $('#input-hidden').html(html);
            }

            function parseNumberFromFormatted(str) {
                return Number(String(str).replace(/[^0-9\-]/g, '')) || 0;
            }
            function formatRupiah(number) {

                return new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0 }).format(number);
            }
        });
    </script>
@endpush