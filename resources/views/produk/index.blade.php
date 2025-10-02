@extends('layouts.app')
@section('content_title', 'Data Produk')
@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <small>{{ $error }}</small>
            @endforeach
        </div>
    @endif
    <div class="card">
        <div class="card-tittle">
            <h5 class="card-header">Data Produk</h5>
        </div>
        <div class="card-body">
            <table class="table table-sm table-bordered">
                <div class="wrap-modal mb-3">
                    <x-products.formproduk />
                </div>
                <thead class="bg-success">
                    <td>No</td>
                    <td>SKU</td>
                    <td>Nama Produk</td>
                    <td>Harga Jual</td>
                    <td>Harga Beli</td>
                    <td>Stok</td>
                    <td>Status</td>
                    <td>Aksi</td>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->nama_produk }}</td>
                            <td>Rp. {{ number_format($product->harga_jual) }}</td>
                            <td>Rp. {{ number_format($product->harga_beli) }}</td>
                            <td>{{ number_format($product->stok) }}</td>
                            <td class="">
                                @if ($product->is_active == 1)
                                    <p class="badge bg-success">Aktif</p>
                                @else
                                    <p class="badge bg-warning">Tidak Aktif</p>
                                @endif
                            </td>
                            <td>
                                <!-- <a href="{{ route('master-data.produk.store', $product->id) }}"
                                                        class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a> -->

                                <div class="d-inline">
                                    <x-products.formproduk :id="$product->id" />
                                    <a href="{{ route('master-data.produk.destroy', $product->id) }}"
                                        class="btn btn-sm btn-danger" data-confirm-delete="true"><i
                                            class="fas fa-trash-alt"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection