@extends('layout')

@section('content')
    <div class="container">
        <h1>Edit Lokasi Uang</h1>
        <form method="POST" action="{{ route('lokasi_uangs.update', $lokasi_Uang->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ $lokasi_Uang->nama }}" required>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan:</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="4">{{ $lokasi_Uang->keterangan }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('lokasi_uangs.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
