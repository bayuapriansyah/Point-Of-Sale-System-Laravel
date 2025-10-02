<!-- Button trigger modal -->

@if($id)
    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalproduk{{ $id }}">
        <i class="fas fa-edit"></i>
    </button>
@else
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalproduk">
        Tambah Produk
    </button>
@endif


<!-- Modal -->
<div class="modal fade" id="modalproduk{{ $id ?? '' }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $id ? 'Edit Produk' : 'Tambah Produk' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('master-data.produk.store')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $id ?? '' }}   ">
                    <div class="wrap-form p-3">
                        <div class="">
                            <label for="nama_kategori" class="form-label">SKU</label>
                            <input type="text" class="form-control" id="sku" name="sku"
                                value="{{ $id ? $sku : old('sku') }}">
                        </div>
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                                value="{{ $id ? $nama_produk : old('nama_produk') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="nama_kategori" class="form-label">Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-control">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}" {{ $kategori_id || old('nama_kategori') == $item->id ? 'selected' : '' }}>{{ $item->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Harga Jual</label>
                            <input type="text" class="form-control" id="harga_jual" name="harga_jual"
                                value="{{ $id ? $harga_jual : old('harga_jual') }}">
                        </div>
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Harga Beli</label>
                            <input type="text" class="form-control" id="harga_beli" name="harga_beli"
                                value="{{ $id ? $harga_beli : old('harga_beli') }}">
                        </div>
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Stok</label>
                            <input type="text" class="form-control" id="stok" name="stok"
                                value="{{ $id ? $stok : old('stok') }}">
                        </div>
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Stok Minimal</label>
                            <input type="text" class="form-control" id="stok_minimal" name="stok_minimal"
                                value="{{ $id ? $stok_minimal : old('stok_minimal') }}">
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Aktif</label>
                            <select class="form-control" id="is_active" name="is_active">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
</div>