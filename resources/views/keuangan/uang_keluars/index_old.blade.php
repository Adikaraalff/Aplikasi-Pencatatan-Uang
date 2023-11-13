@extends('layout')

@section('content')
    <div class="container">
        <h1>Daftar Uang Keluar</h1>
        <a href="{{ route('uang_keluars.create') }}" class="btn btn-primary">Tambah Uang Keluar</a>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Created By</th>
                    <th>Lokasi Uang</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($uang_Keluar as $uk)
                    <tr>
                        <td>{{ $uk->id }}</td>
                        <td>{{ $uk->created_by }}</td>
                        <td>{{ $uk->Lokasi_Uang->nama }}</td>
                        <td>{{ $uk->jumlah }}</td>
                        <td>{{ $uk->keterangan }}</td>
                        <td>
                            <a href="{{ route('uang_keluars.edit', $uk->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('uang_keluars.destroy', $uk->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
