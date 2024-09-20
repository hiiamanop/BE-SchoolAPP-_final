@extends('penilaians.master') <!-- Extend your main layout -->

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Daftar Penilaian</h6>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#addPenilaianModal">
                        Tambah Penilaian
                    </button>
                </div>

                <!-- Add New Penilaian Modal -->
                <div class="modal fade" id="addPenilaianModal" tabindex="-1" aria-labelledby="addPenilaianModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addPenilaianModalLabel">Tambah Penilaian</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addPenilaianForm" action="{{ route('penilaians.store') }}" method="POST">
                                    @csrf
                                    <!-- Siswa -->
                                    <div class="mb-3">
                                        <label for="siswa" class="form-label">Siswa</label>
                                        <select class="form-select" id="siswa" name="siswa_id" required>
                                            @foreach ($siswas as $siswa)
                                                <option value="{{ $siswa->id }}">{{ $siswa->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Assignment -->
                                    <div class="mb-3">
                                        <label for="assignment" class="form-label">Assignment</label>
                                        <select class="form-select" id="assignment" name="assignment_id" required>
                                            @foreach ($assignments as $assignment)
                                                <option value="{{ $assignment->id }}">{{ $assignment->code_assignment }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Jumlah Soal -->
                                    <div class="mb-3">
                                        <label for="jumlahSoal" class="form-label">Jumlah Soal</label>
                                        <input type="number" class="form-control" id="jumlahSoal" name="jumlah_soal" required>
                                    </div>

                                    <!-- Max Score -->
                                    <div class="mb-3">
                                        <label for="maxScore" class="form-label">Max Score</label>
                                        <input type="number" class="form-control" id="maxScore" name="max_score" required>
                                    </div>

                                    <!-- Pilihan Ganda Score -->
                                    <div class="mb-3">
                                        <label for="pilganScore" class="form-label">Nilai Pilihan Ganda</label>
                                        <input type="number" class="form-control" id="pilganScore" name="pilgan_score" required>
                                    </div>

                                    <!-- Essay Score -->
                                    <div class="mb-3">
                                        <label for="essayScore" class="form-label">Nilai Essay</label>
                                        <input type="number" class="form-control" id="essayScore" name="essay_score" required>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Tambah Penilaian</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Siswa</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Assignment</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah Soal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Max Score</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pilihan Ganda</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Essay</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penilaians as $index => $penilaian)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $penilaian->siswa->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $penilaian->assignment->code_assignment }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $penilaian->jumlah_soal }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $penilaian->max_score }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $penilaian->pilgan_score }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $penilaian->essay_score }}</p>
                                        </td>

                                        <td class="align-middle text-center">
                                            <!-- Edit Button -->
                                            <button type="button" class="text-secondary font-weight-bold text-xs btn btn-link" data-bs-toggle="modal" data-bs-target="#editPenilaianModal{{ $penilaian->id }}">
                                                Edit
                                            </button>

                                            <!-- Delete Button -->
                                            <form action="{{ route('penilaians.destroy', $penilaian->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-secondary font-weight-bold text-xs btn btn-link">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Penilaian Modal -->
                                    <div class="modal fade" id="editPenilaianModal{{ $penilaian->id }}" tabindex="-1" aria-labelledby="editPenilaianModalLabel{{ $penilaian->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editPenilaianModalLabel{{ $penilaian->id }}">Edit Penilaian</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editPenilaianForm{{ $penilaian->id }}" action="{{ route('penilaians.update', $penilaian->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="siswa{{ $penilaian->id }}" class="form-label">Siswa</label>
                                                            <select class="form-select" id="siswa{{ $penilaian->id }}" name="siswa_id" required>
                                                                @foreach ($siswas as $siswa)
                                                                    <option value="{{ $siswa->id }}" {{ $penilaian->siswa_id == $siswa->id ? 'selected' : '' }}>
                                                                        {{ $siswa->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="assignment{{ $penilaian->id }}" class="form-label">Assignment</label>
                                                            <select class="form-select" id="assignment{{ $penilaian->id }}" name="assignment_id" required>
                                                                @foreach ($assignments as $assignment)
                                                                    <option value="{{ $assignment->id }}" {{ $penilaian->assignment_id == $assignment->id ? 'selected' : '' }}>
                                                                        {{ $assignment->code_assignment }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="jumlahSoal{{ $penilaian->id }}" class="form-label">Jumlah Soal</label>
                                                            <input type="number" class="form-control" id="jumlahSoal{{ $penilaian->id }}" name="jumlah_soal" value="{{ $penilaian->jumlah_soal }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="maxScore{{ $penilaian->id }}" class="form-label">Max Score</label>
                                                            <input type="number" class="form-control" id="maxScore{{ $penilaian->id }}" name="max_score" value="{{ $penilaian->max_score }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="pilganScore{{ $penilaian->id }}" class="form-label">Nilai Pilihan Ganda</label>
                                                            <input type="number" class="form-control" id="pilganScore{{ $penilaian->id }}" name="pilgan_score" value="{{ $penilaian->pilgan_score }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="essayScore{{ $penilaian->id }}" class="form-label">Nilai Essay</label>
                                                            <input type="number" class="form-control" id="essayScore{{ $penilaian->id }}" name="essay_score" value="{{ $penilaian->essay_score }}" required>
                                                        </div>
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary">Update Penilaian</button>
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
    </div>
@endsection
