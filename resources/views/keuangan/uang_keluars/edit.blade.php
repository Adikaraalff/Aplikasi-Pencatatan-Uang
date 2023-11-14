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
                                    <h4>Edit Uang Keluar</h4>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <form method="POST" action="{{ route('uang_keluars.update', $uang_Keluar->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="nama">Created By:</label>
                                    <input type="text" class="form-control" id="nama" name="created_by"
                                        value="{{ Auth::user()->name }}" required>
                                </div>

                                {{-- <div class="form-group">
                                    <label for="lokasi_Uang">Lokasi Uang:</label>
                                    <input type="text" class="form-control" id="lokasi_Uang" name="lokasi_uang"
                                        value="{{ $lokasi_Uang->nama }}" required>
                                </div> --}}

                                <div class="form-group">
                                    <label for="lokasi_Uang">Lokasi Uang:</label>
                                    <select class="form-control" id="lokasi_Uang" name="lokasi_uang" required>
                                        @foreach ($lokasi_Uang as $lokasi)
                                            <option value="{{ $lokasi->id }}"
                                                {{ $lokasi->id == $uang_Keluar->id_lokasi_Uang ? 'selected' : '' }}>
                                                {{ $lokasi->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="jumlah">Jumlah:</label>
                                    <input type="text" class="form-control" id="jumlah" name="jumlah"
                                        value="{{ $uang_Keluar->jumlah }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="keterangan">Keterangan:</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="4">{{ $uang_Keluar->keterangan }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
@endsection
