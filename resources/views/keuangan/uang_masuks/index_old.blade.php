@extends('layout')

@section('content')
    <div class="container">
        <h1>Daftar Uang Masuk</h1>
        <a href="{{ route('uang_masuks.create') }}" class="btn btn-primary">Tambah Uang Masuk</a>

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
                @foreach ($uang_Masuk as $um)
                    <tr>
                        <td>{{ $um->id }}</td>
                        <td>{{ $um->created_by }}</td>
                        <td>{{ $um->Lokasi_Uang->nama }}</td>
                        <td>{{ $um->jumlah }}</td>
                        <td>{{ $um->keterangan }}</td>
                        <td>
                            <a href="{{ route('uang_masuks.edit', $um->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('uang_masuks.destroy', $um->id) }}" method="POST" style="display: inline;">
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
