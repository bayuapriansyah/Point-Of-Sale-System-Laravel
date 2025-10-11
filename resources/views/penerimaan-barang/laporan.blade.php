@extends('layouts.app')
@section('content_title', 'Laporan Penerimaan Barang')
@section('content')

    <div class="card">
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr class="bg-success">
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Distributor</th>
                        <th>Nomor Faktur</th>
                        <th>Items</th>
                        <th>Nama Penerima</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penerimaanBarang as $index => $p)
                        <tr class="">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $p->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $p->distributor }}</td>
                            <td>{{ $p->nomor_faktur }}</td>
                            <td>
                                <ul>
                                    @foreach($p->items as $it)
                                        <li>{{ optional($it->product)->nama_produk ?? 'Produk terhapus' }} - {{ $it->qty }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ ucwords(Auth::user()->name) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection