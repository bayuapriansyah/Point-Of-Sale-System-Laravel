@extends('layouts.app')
@section('content_title', 'Pengeluaran Barang / Transaksi')
@section('content')

    <div class="card">
        <div class="card-title border-bottom p-3">
            <form action="{{ route('penerimaan-barang.store') }}" method="post" id="form-penerimaan-barang">
                @csrf
                <div id="input-hidden"></div>
                <div class="d-flex justify-content-between">
                    <h5 class="h5">Pengeluaran Barang</h5>
                    <div>
                        <button type="submit" class="btn btn-success">Simpan Pengeluaran</button>
                    </div>
                </div>
        </div>
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

                listProduk.push({ id, nama: produk.nama_produk, qty: qty, stok, harga_jual: harga, subtotal: subtotal });

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
            }

            window.hapusItem = function (index) {
                listProduk.splice(index, 1);
                tampilTable();
                renderHiddenInputs();
            }

            function renderHiddenInputs() {
                let html = '';
                listProduk.forEach((item, index) => {
                    const qty = parseInt(item.qty) || 0;
                    const harga = parseFloat(item.harga_jual || item.harga || 0) || 0;
                    const subtotal = harga * qty;

                    html += `
                                        <input type="hidden" name="produk[${index}][id]" value="${item.id}">
                                         <input type="hidden" name="produk[${index}][qty]" value="${qty}">
                                           <input type="hidden" name="produk[${index}][harga_jual]" value="${harga}">
                                           <input type="hidden" name="produk[${index}][subtotal]" value="${subtotal}">
                                                                                                        `;
                });
                $("#input-hidden").html(html);
            }

            function formatRupiah(number) {

                return new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0 }).format(number);
            }
        });
    </script>
@endpush