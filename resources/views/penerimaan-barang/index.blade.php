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
                    <button class="btn btn-dark">Tambahkan</button>
                </div>
            </div>
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
    </script>
@endpush
