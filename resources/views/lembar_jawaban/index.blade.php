@extends('lembar_jawaban.master')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Daftar Lembar Jawaban</h4>
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#filterModal">
                    Filter
                </button>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Kode Assignment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lembarJawabans as $lembarJawaban)
                            <tr>
                                <td>{{ $lembarJawaban->soal->assignment->penilaians->first()->siswa->name }}</td>
                                <td>{{ $lembarJawaban->soal->assignment->code_assignment }}</td>
                                <td>
                                    <a href="{{ route('lembar_jawaban.detail', ['assignmentId' => $lembarJawaban->soal->assignment->id, 'siswaId' => $lembarJawaban->soal->assignment->penilaians->first()->siswa_id]) }}"
                                        class="btn btn-primary">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Filter Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">Filter Lembar Jawaban</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('lembar_jawaban.index') }}" method="GET">
                            <div class="mb-3">
                                <label for="nama_siswa" class="form-label">Nama Siswa</label>
                                <input type="text" class="form-control" id="nama_siswa" name="nama_siswa"
                                    value="{{ request('nama_siswa') }}" placeholder="Nama Siswa">
                            </div>
                            <div class="mb-3">
                                <label for="kode_assignment" class="form-label">Kode Assignment</label>
                                <input type="text" class="form-control" id="kode_assignment" name="kode_assignment"
                                    value="{{ request('kode_assignment') }}" placeholder="Kode Assignment">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
