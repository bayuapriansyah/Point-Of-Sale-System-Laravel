@extends('layouts.app')
@section('content_title', 'Data Kategori')
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
        <div class="card-body">
            <h5>Data Kategori</h5>
            <table class="table table-sm table-bordered ">
                <div class="d-flex justify-content-between mb-3">
                    <div class="wrap-modal">
                        <x-kategori.tambahkategori />
                    </div>
                    <div class="wrap-search">
                        <x-kategori.searchkategori />
                    </div>
                </div>
                <thead class="bg-success">
                    <tr>
                        <th>No</th>
                        <th style="width: 150px;">Nama Kategori</th>
                        <th>Keterangan</th>
                        <th style="" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategori as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_kategori }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>
                                <div class="wrap-btn d-flex" style="gap: 5px">
                                    <a href="{{ route('master-data.kategori.edit', $item->id) }}"
                                        class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <!-- <form action="{{ route('master-data.kategori.destroy', $item->id) }}" method="POST"
                                                             data-confirm-delete="true">
                                                             @csrf
                                                             @method('DELETE') -->
                                    <a href="{{ route('master-data.kategori.destroy', $item->id) }}"
                                        class="btn btn-sm btn-danger" data-confirm-delete="true"><i
                                            class="fas fa-trash-alt"></i></a>
                                    <!-- </form> -->
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection