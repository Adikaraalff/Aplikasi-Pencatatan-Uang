@extends('layout')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 shadow-lg">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 margin-tb">
                                <div class="card-header pb-0">
                                    <h4>Tambah Uang Keluar</h4>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <form method="POST" action="{{ route('uang_keluars.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="created_by">Created By:</label>
                                    <input type="text" class="form-control" id="created_by" name="created_by"
                                        value="{{ Auth::user()->name }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="lokasi_Uang">Lokasi Uang:</label>
                                    <select name="lokasi_Uang" class="form-control">
                                        <?php
                                        foreach ($lokasi_Uang as $lokasi) {
                                            echo "<option value='" . $lokasi['id'] . "'>" . $lokasi['nama'] . '</option>';
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

                                <div class="form-group">
                                    <label for="file">Gambar:</label>
                                    <input type="file" class="form-control" id="file" name="file">
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('uang_keluars.index') }}" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="{{ asset('argon/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('argon/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('argon/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('argon/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('argon/js/plugins/smooth-scrollbar.min.js') }}"></script>
@endsection
