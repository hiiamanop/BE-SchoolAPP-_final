@extends('layouts.index')

@section('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('assets/themes/css/datagrid/datatables/datatables.bundle.css') }}">
@endsection

@section('content')
    <ol class="breadcrumb breadcrumb-sm breadcrumb-arrow">
        <li>
            <a href="#"><i class="fal fa-home"></i></a>
        </li>
        <li>
            <a href="#"><i class="fal fa-chart-pie"></i> <span class="hidden-md-down">Setting</span></a>
        </li>
        <li class="active">
            <a href="#"><i class="fal fa-arrow-down"></i> <span class="hidden-md-down">Tahun</span></a>
        </li>
    </ol>

    <div class="subheader mb-2">
        <h1 class="subheader-title"><i class='fal fa-info-circle'></i> Setting <small>Setting Tahun</small></h1>
        <a href="{{ route('tahun.create') }}" class="btn btn-primary"><i class="fal fa-plus-circle"></i> Tambah Data</a>
    </div>

    <div class="fs-lg fw-300 p-5 bg-white border-faded rounded mb-g">
        <div class="row">
            <div class="col-md-12 mb-5">
                <div class="table-responsive">
                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th class="text-center" width="50">Nomor</th>
                                <th class="text-center">Tahun</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($settingTahun as $key => $tahun)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td class="text-center">{{ $tahun->tahun }}</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-info btn-sm"><i class="fal fa-search"></i> Preview</a>
                                        <!-- Tombol untuk membuka modal edit -->
                                        <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editTahunModal{{ $tahun->id }}"><i class="fal fa-pencil"></i> Edit</a>
                                        <!-- Form Hapus -->
                                        <form action="{{ route('tahun.destroy', $tahun->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="fal fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editTahunModal{{ $tahun->id }}" tabindex="-1" aria-labelledby="editTahunModalLabel{{ $tahun->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editTahunModalLabel{{ $tahun->id }}">Edit Data Setting Tahun</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editTahunForm{{ $tahun->id }}" action="{{ route('tahun.update', $tahun->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="editTahun{{ $tahun->id }}">Tahun</label>
                                                        <input type="text" id="editTahun{{ $tahun->id }}" name="tahun" class="form-control" value="{{ $tahun->tahun }}" required>
                                                        @error('tahun')
                                                            <span class="text-danger text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/themes/js/datagrid/datatables/datatables.bundle.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dt-basic-example').dataTable({
                responsive: true
            });
        });
    </script>
@endsection
