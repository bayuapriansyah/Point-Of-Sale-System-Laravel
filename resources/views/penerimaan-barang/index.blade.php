@extends('layouts.app')
@section('content_title', 'Penerimaan Barang')
@section('content')

    <div class="card">
        <div class="card-title">
            <h5 class="card-header">Penerimaan Barang</h5>
        </div>
        <div class="card-body">
            <div class="d-flex">
                <div class="w-100">
                    <label for="select2">Produk</label>
                    <select name="select2" id="select2" class="form-control"></select>
                </div>
                <div>
                    <label for="jumlah">Stok</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" style="width:100px;" readonly>
                </div>
                <div>
                    <label for="qty">Qty</label>
                    <input type="number" name="qty" id="qty" class="form-control" style="width:100px;">
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