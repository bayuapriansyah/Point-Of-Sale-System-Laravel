@extends('layouts.app')
@section('content_title', 'Data Users')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-tittle">Data User</h4>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <x-user.formuser />
            </div>
            <table class="table table-bordered table-sm">
                <thead class="bg-success">
                    <td>No</td>
                    <td>Nama</td>
                    <td>Email</td>
                    <td>Aksi</td>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning"><i
                                        class="fas fa-edit"></i></a>
                                <a href="{{ route('users.destroy', $user->id) }}" class="btn btn-sm btn-danger"
                                    data-confirm-delete="true"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection