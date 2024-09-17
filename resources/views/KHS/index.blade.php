@extends('khs.master') <!-- Extend your main layout -->

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Daftar KHS Siswa</h6>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#addKHSModal">
                        Tambah KHS
                    </button>
                </div>

                <!-- Add New KHS Modal -->
                <div class="modal fade" id="addKHSModal" tabindex="-1" aria-labelledby="addKHSModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addKHSModalLabel">Tambah KHS Siswa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addKHSForm" action="{{ route('khs.store') }}" method="POST">
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

                                    <!-- Mata Pelajaran -->
                                    <div class="mb-3">
                                        <label for="mataPelajaran" class="form-label">Mata Pelajaran</label>
                                        <select class="form-select" id="mataPelajaran" name="mata_pelajaran_id" required>
                                            @foreach ($mataPelajarans as $mataPelajaran)
                                                <option value="{{ $mataPelajaran->id }}">{{ $mataPelajaran->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Jenis Penilaian -->
                                    <div class="mb-3">
                                        <label for="jenisPenilaian" class="form-label">Jenis Penilaian</label>
                                        <select class="form-select" id="jenisPenilaian" name="jenis_penilaian_id" required>
                                            @foreach ($jenisPenilaians as $jenisPenilaian)
                                                <option value="{{ $jenisPenilaian->id }}">{{ $jenisPenilaian->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Tahun Ajaran -->
                                    <div class="mb-3">
                                        <label for="tahunAjaran" class="form-label">Tahun Ajaran</label>
                                        <select class="form-select" id="tahunAjaran" name="tahun_ajaran_id" required>
                                            @foreach ($tahunAjarans as $tahunAjaran)
                                                <option value="{{ $tahunAjaran->id }}">{{ $tahunAjaran->tahun }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Nilai -->
                                    <div class="mb-3">
                                        <label for="nilai" class="form-label">Nilai</label>
                                        <input type="number" class="form-control" id="nilai" name="nilai" required>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Tambah KHS</button>
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Siswa</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Mata Pelajaran</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Jenis Penilaian</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nilai</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Tahun_Ajaran</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($khs as $index => $khsRecord)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $khsRecord->siswa->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $khsRecord->mataPelajaran->name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $khsRecord->jenisPenilaian->name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $khsRecord->tahunAjaran->tahun }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $khsRecord->nilai }}</p>
                                        </td>

                                        <td class="align-middle text-center">
                                            <!-- Edit Button -->
                                            <button type="button"
                                                class="text-secondary font-weight-bold text-xs btn btn-link"
                                                data-bs-toggle="modal" data-bs-target="#editKHSModal{{ $khsRecord->id }}">
                                                Edit
                                            </button>

                                            <!-- Delete Button -->
                                            <form action="{{ route('khs.destroy', $khsRecord->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-secondary font-weight-bold text-xs btn btn-link">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit KHS Modal -->
                                    <div class="modal fade" id="editKHSModal{{ $khsRecord->id }}" tabindex="-1"
                                        aria-labelledby="editKHSModalLabel{{ $khsRecord->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editKHSModalLabel{{ $khsRecord->id }}">
                                                        Edit KHS
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editKHSForm{{ $khsRecord->id }}"
                                                        action="{{ route('khs.update', $khsRecord->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="siswa{{ $khsRecord->id }}"
                                                                class="form-label">Siswa</label>
                                                            <select class="form-select" id="siswa{{ $khsRecord->id }}"
                                                                name="siswa_id" required>
                                                                @foreach ($siswas as $siswa)
                                                                    <option value="{{ $siswa->id }}"
                                                                        {{ $khsRecord->siswa_id == $siswa->id ? 'selected' : '' }}>
                                                                        {{ $siswa->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="nilai{{ $khsRecord->id }}"
                                                                class="form-label">Nilai</label>
                                                            <input type="number" class="form-control"
                                                                id="nilai{{ $khsRecord->id }}" name="nilai"
                                                                value="{{ $khsRecord->nilai }}" required>
                                                        </div>
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary">Update
                                                                KHS</button>
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

    <!-- Include JavaScript for modal and AJAX form submission -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // AJAX form submission for editing KHS
            document.querySelectorAll('form[id^="editKHSForm"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    let formData = new FormData(this);
                    let formAction = this.getAttribute('action');
                    fetch(formAction, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                // Handle validation errors
                                console.log(data.errors);
                            }
                        });
                });
            });

            // AJAX form submission for adding new KHS
            document.getElementById('addKHSForm').addEventListener('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let formAction = this.getAttribute('action');
                fetch(formAction, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            // Handle validation errors
                            console.log(data.errors);
                        }
                    });
            });
        });
    </script>
@endsection
