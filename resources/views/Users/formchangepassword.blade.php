@extends('layouts.app')
@section('content_title', 'Ganti Password')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5>Ganti Password</h5>
            <form action="{{ route('users.update-password') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="password_lama" class="form-label">Password lama</label>
                    <input type="text" class="form-control" id="password_lama" name="password_lama" value=""
                        autocomplete="off">
                    @error('password_lama')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_baru" class="form-label">Password baru</label>
                    <input type="password" class="form-control" id="password_baru" name="password_baru" value=""
                        autocomplete="off"></input>
                    @error('password_baru')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="konfirmasi_password" class="konfirmasi_password">Konfirmasi password baru</label>
                    <input type="password" class="form-control" id="password_baru_confirmation"
                        name="password_baru_confirmation" value="" autocomplete="off"></input>
                    @error('password_baru_konfirmasi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">Ganti password</button>

            </form>
        </div>
    </div>
@endsection