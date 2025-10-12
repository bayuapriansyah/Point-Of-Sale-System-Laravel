@extends('layouts.app')
@section('content_title', 'Laporan Pengeluaran Barang')
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
            <form method="get" class="form-inline mb-3">
                <div class="form-group mr-2">
                    <label for="from" class="mr-1">From</label>
                    <input type="date" id="from" name="from" value="{{ $from ?? '' }}" class="form-control">
                </div>
                <div class="form-group mr-2">
                    <label for="to" class="mr-1">To</label>
                    <input type="date" id="to" name="to" value="{{ $to ?? '' }}" class="form-control">
                </div>
                <button class="btn btn-primary mr-2" type="submit">Filter</button>
                <a href="?export=csv{{ $from ? '&from=' . $from : '' }}{{ $to ? '&to=' . $to : '' }}"
                    class="btn btn-secondary">Export CSV</a>
            </form>

            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Jumlah Bayar</th>
                            <th>Kembalian</th>
                            <th>Items</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengeluaran as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->created_at }}</td>
                                <td>{{ number_format($p->total, 0, ',', '.') }}</td>
                                <td>{{ number_format($p->jumlah_bayar ?? 0, 0, ',', '.') }}</td>
                                <td>{{ number_format($p->kembalian ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    <ul>
                                        @foreach($p->items as $it)
                                            <li>{{ $it->product->nama_produk ?? 'Produk dihapus' }} - {{ $it->qty }} x
                                                {{ number_format($it->harga_jual, 0, ',', '.') }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pengeluaran->links() }}
            </div>
        </div>
    </div>

@endsection