@extends('layouts.app')
@section('content_title', 'Penerimaan Barang')
@section('content')

    <div class="card">
        <div class="card-title border-bottom p-3">
            <form action="{{ route('penerimaan-barang.store') }}" method="post">
                @csrf
                <div class="d-flex justify-content-between">
                    <h5 class="h5">Penerimaan Barang</h5>
                    <div>
                        <button type="submit" class="btn btn-success">Simpan Penerimaan</button>
                    </div>
                </div>
        </div>
        <div class="card-body">
            <div>
                <label for="distributor">Distributor</label>
                <input type="text" name="distributor" id="distributor" class="form-control">
            </div>
            <div>
                <label for="distributor">Nomor faktur</label>
                <input type="text" name="nomor_faktur" id="nomor_faktur" class="form-control">
            </div>
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
                    <label for="qty">Qty</label>
                    <input type="number" id="qty" class="form-control" style="width:100px;">
                </div>
                <div style="padding-top: 32px;">
                    <button type="button" class="btn btn-success" id="btnadd">Tambahkan</button>
                </div>
            </div>
        </div>
        </form>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-produk" id="table-produk">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

@endsection
@push('script')
    <script>
        $(document).ready(function () {
            let selectedProduk = {};
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
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        $('#jumlah').val(response);
                    }
                })
            });

            $("#btnadd").on("click", function () {

                const selectedId = $("#select2").val();
                const qty = Number($("#qty").val());
                const jumlah = Number($("#jumlah").val());
                const produk = $("#select2 option:selected").text().trim();

                if (!selectedId || !qty) {
                    alert('Produk dan Qty harus diisi');
                    return;
                }
                if (qty > jumlah) {
                    alert('Jumlah barang tidak tersedia');
                    return;
                }

                let exist = false;
                $("#table-produk tbody tr").each(function () {
                    const rowProduk = $(this).find("td:first").text();

                    if (rowProduk === produk) {
                        let jumlah = Number($(this).find("td:eq(1)").text());
                        let newQty = Number(qty) + Number(jumlah);

                        $(this).find("td:eq(2)").text(newQty);
                        exist = true;
                        return false;

                    }
                });

                if (!exist) {
                    const row = `
                                                  <tr>
                                                   <td>${produk}</td>
                                                    <td>${qty}</td>
                                                     <td>
                                                    <button class="btn btn-danger btn-remove">
                                                    <i class="fas fa-trash"></i></button>
                                                        </td>
                                                      </tr>
                                                                    `
                    $("#table-produk tbody").append(row);
                }

                $("#select2").val(null).trigger("change");
                $("#jumlah").val(null);
                $("#qty").val(null);
            });


            $("#table-produk").on("click", ".btn-remove", function () {
                $(this).closest("tr").remove();
            });

        });

    </script>
@endpush