@extends('layout')

@section('content')
    <div class="container">
        <h1>Tambah Uang Masuk</h1>
        <form method="POST" action="{{ route('uang_masuks.store') }}">
            @csrf

            <div class="form-group">
                <label for="created_by">Created By:</label>
                <input type="text" class="form-control" id="created_by" name="created_by" value="{{ Auth::user()->name }}" required>
            </div>

            <div class="form-group">
                <label for="lokasi_Uang">Lokasi Uang:</label>
                <select name="lokasi_Uang" class="form-control">
                    <?php
                foreach($lokasi_Uang as $lokasi){
                        echo "<option value='".$lokasi['id']."'>".$lokasi['nama']."</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="jumlah">Jumlah:</label>
                <input type="text" class="form-control" id="jumlah" name="jumlah" required>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan:</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('uang_masuks.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
