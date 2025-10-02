@extends('layouts.app')
@section('content_title', 'Edit Kategori')
@section('content')
    <div class="card">
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <small>{{ $error }}</small>
                @endforeach
            </div>
        @endif
        <div class="card-body">
            <h5>Edit Kategori</h5>
            <form action="{{ route('master-data.kategori.update', $kategori->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori"
                        value="{{ $kategori->nama_kategori }}">
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan"
                        rows="3">{{ $kategori->keterangan }}</textarea>
                </div>
                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
@endsection