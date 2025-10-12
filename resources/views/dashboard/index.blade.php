@extends('layouts.app')
@section('content_title', 'Dashboard')

@section('content')

    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalProducts }}</h3>
                    <p>Total Produk</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $lowStock }}</h3>
                    <p>Produk Stok Rendah</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $recentPengeluaran->count() }}</h3>
                    <p>Transaksi Terakhir</p>
                </div>
                <div class="icon">
                    <i class="fas fa-receipt"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Recent Penerimaan</div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Total Items</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPenerimaan as $p)
                                <tr>
                                    <td>{{ $p->created_at }}</td>
                                    <td>{{ $p->items->sum('qty') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Recent Pengeluaran</div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPengeluaran as $p)
                                <tr>
                                    <td>{{ $p->created_at }}</td>
                                    <td>{{ number_format($p->total, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection