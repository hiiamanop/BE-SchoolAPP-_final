@extends('guru_pelajarans.master') <!-- Extend your main layout -->

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Daftar Guru dan Mata Pelajaran</h6>

                    <!-- Filter Form -->
                    <form action="{{ route('guru_pelajarans.index') }}" method="GET" class="d-flex align-items-center">
                        <!-- Mata Pelajaran Filter -->
                        <div class="form-group me-3">
                            <label for="mata_pelajaran_id" class="form-label">Pilih Mata Pelajaran</label>
                            <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-select"
                                onchange="this.form.submit()">
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                @foreach ($mataPelajarans as $mataPelajaran)
                                    <option value="{{ $mataPelajaran->id }}"
                                        {{ request('mata_pelajaran_id') == $mataPelajaran->id ? 'selected' : '' }}>
                                        {{ $mataPelajaran->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <!-- Add New GuruPelajaran Button -->
                    <button type="button" class="btn btn-primary float-end ms-2" data-bs-toggle="modal"
                        data-bs-target="#addGuruPelajaranModal">
                        Add New GuruPelajaran
                    </button>

                    <!-- Import GuruPelajaran Button -->
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#importGuruPelajaranModal">
                        Import GuruPelajaran
                    </button>
                </div>

                <!-- Import Guru Modal -->
                <div class="modal fade" id="importGuruPelajaranModal" tabindex="-1" aria-labelledby="importGuruModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="importGuruModalLabel">Import Guru</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('guru_pelajarans.import') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Select Excel File</label>
                                        <input type="file" class="form-control" id="file" name="file"
                                            accept=".xlsx" required>
                                        @error('file')
                                            <span class="text-danger text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Import</button>
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
                                        Guru</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Mata Pelajaran</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($guruPelajarans as $index => $guruPelajaran)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $guruPelajaran->guru->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $guruPelajaran->mataPelajaran->name }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <!-- Edit Button -->
                                            <button type="button"
                                                class="text-secondary font-weight-bold text-xs btn btn-link"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editGuruPelajaranModal{{ $guruPelajaran->id }}">
                                                Edit
                                            </button>

                                            <!-- Delete Button -->
                                            <form action="{{ route('guru_pelajarans.destroy', $guruPelajaran->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-secondary font-weight-bold text-xs btn btn-link">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit GuruPelajaran Modal -->
                                    <div class="modal fade" id="editGuruPelajaranModal{{ $guruPelajaran->id }}"
                                        tabindex="-1"
                                        aria-labelledby="editGuruPelajaranModalLabel{{ $guruPelajaran->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editGuruPelajaranModalLabel{{ $guruPelajaran->id }}">
                                                        Edit Guru Mata Pelajaran
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editGuruPelajaranForm{{ $guruPelajaran->id }}"
                                                        action="{{ route('guru_pelajarans.update', $guruPelajaran->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="guru{{ $guruPelajaran->id }}"
                                                                class="form-label">Guru</label>
                                                            <select class="form-select" id="guru{{ $guruPelajaran->id }}"
                                                                name="guru_id" required>
                                                                @foreach ($gurus as $guru)
                                                                    <option value="{{ $guru->id }}"
                                                                        {{ $guruPelajaran->guru_id == $guru->id ? 'selected' : '' }}>
                                                                        {{ $guru->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="mataPelajaran{{ $guruPelajaran->id }}"
                                                                class="form-label">Mata Pelajaran</label>
                                                            <select class="form-select"
                                                                id="mataPelajaran{{ $guruPelajaran->id }}"
                                                                name="mata_pelajaran_id" required>
                                                                @foreach ($mataPelajarans as $mataPelajaran)
                                                                    <option value="{{ $mataPelajaran->id }}"
                                                                        {{ $guruPelajaran->mata_pelajaran_id == $mataPelajaran->id ? 'selected' : '' }}>
                                                                        {{ $mataPelajaran->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary">Update Guru
                                                                Mata Pelajaran</button>
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

    <!-- Add New Guru Pelajaran Modal -->
    <div class="modal fade" id="addGuruPelajaranModal" tabindex="-1" aria-labelledby="addGuruPelajaranModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGuruPelajaranModalLabel">Tambah Guru ke Mata Pelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addGuruPelajaranForm" action="{{ route('guru_pelajarans.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="addGuru" class="form-label">Guru</label>
                            <select class="form-select" id="addGuru" name="guru_id" required>
                                @foreach ($gurus as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addMataPelajaran" class="form-label">Mata Pelajaran</label>
                            <select class="form-select" id="addMataPelajaran" name="mata_pelajaran_id" required>
                                @foreach ($mataPelajarans as $mataPelajaran)
                                    <option value="{{ $mataPelajaran->id }}">{{ $mataPelajaran->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Tambah Guru ke Mata Pelajaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include JavaScript for modal and AJAX form submission -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // AJAX form submission for editing GuruPelajaran
            document.querySelectorAll('form[id^="editGuruPelajaranForm"]').forEach(form => {
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

            // AJAX form submission for adding new GuruPelajaran
            document.getElementById('addGuruPelajaranForm').addEventListener('submit', function(e) {
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
