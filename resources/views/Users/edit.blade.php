@extends('layouts.app')
@section('content_title', 'Edit User')
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
            <form action="{{ route('users.update', $users->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Nama User</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $users->name }}">
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Email</label>
                    <input class="form-control" id="email" name="email" value="{{ $users->email }}"></input>
                </div>
                <button type="submit" class="btn btn-success">Update</button>

            </form>
        </div>
    </div>
@endsection