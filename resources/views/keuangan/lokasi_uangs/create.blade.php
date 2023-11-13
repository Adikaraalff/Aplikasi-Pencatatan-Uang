@extends('layout')

@section('content')
    <div class="container">
        <h1>Tambah Lokasi Uang Baru</h1>
        <form method="POST" action="{{ route('lokasi_uangs.store') }}">
            @csrf

            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan:</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('lokasi_uangs.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
