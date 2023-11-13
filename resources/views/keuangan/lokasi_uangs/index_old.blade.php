@extends('layout')

@section('content')
    <div class="container">
        <h1>Daftar Lokasi Uang</h1>
        <a href="{{ route('lokasi_uangs.create') }}" class="btn btn-primary">Tambah Lokasi Uang</a>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lokasi_Uang as $lokasi)
                <tr>
                    <td>{{ $lokasi->id }}</td>
                    <td>{{ $lokasi->nama }}</td>
                    <td>{{ $lokasi->keterangan }}</td>
                    <td>
                        <a href="{{ route('lokasi_uangs.edit', $lokasi->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('lokasi_uangs.destroy', $lokasi->id) }}" method="POST" style="display: inline;">
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
