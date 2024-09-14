@extends('kelas_siswa.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Daftar Kelas dan Siswa</h6>
                    <form action="{{ route('kelas_siswas.index') }}" method="GET" class="d-flex align-items-center">
                        <div class="form-group me-3">
                            <label for="kelas" class="form-label">Pilih Kelas</label>
                            <select name="kelas_id" id="kelas" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}"
                                        {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#addSiswaModal">
                        Add New Siswa to Kelas
                    </button>
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
                                        Kelas</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelasSiswaList as $index => $kelasSiswa)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $kelasSiswa->siswa->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $kelasSiswa->kelas->name }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <!-- Edit Button -->
                                            <button type="button"
                                                class="text-secondary font-weight-bold text-xs btn btn-link"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editKelasSiswaModal{{ $kelasSiswa->id }}">
                                                Edit
                                            </button>

                                            <!-- Delete Button -->
                                            <form action="{{ route('kelas_siswas.destroy', $kelasSiswa->id) }}"
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

                                    <!-- Edit KelasSiswa Modal -->
                                    <div class="modal fade" id="editKelasSiswaModal{{ $kelasSiswa->id }}" tabindex="-1"
                                        aria-labelledby="editKelasSiswaModalLabel{{ $kelasSiswa->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editKelasSiswaModalLabel{{ $kelasSiswa->id }}">Edit Kelas Siswa
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editKelasSiswaForm{{ $kelasSiswa->id }}"
                                                        action="{{ route('kelas_siswas.update', $kelasSiswa->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="siswa{{ $kelasSiswa->id }}"
                                                                class="form-label">Siswa</label>
                                                            <select class="form-select" id="siswa{{ $kelasSiswa->id }}"
                                                                name="user_id" required>
                                                                @foreach ($siswaList as $siswa)
                                                                    <option value="{{ $siswa->id }}"
                                                                        {{ $kelasSiswa->user_id == $siswa->id ? 'selected' : '' }}>
                                                                        {{ $siswa->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('user_id')
                                                                <span class="text-danger text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="kelas{{ $kelasSiswa->id }}"
                                                                class="form-label">Kelas</label>
                                                            <select class="form-select" id="kelas{{ $kelasSiswa->id }}"
                                                                name="kelas_id" required>
                                                                @foreach ($kelasList as $kelas)
                                                                    <option value="{{ $kelas->id }}"
                                                                        {{ $kelasSiswa->kelas_id == $kelas->id ? 'selected' : '' }}>
                                                                        {{ $kelas->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('kelas_id')
                                                                <span class="text-danger text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary">Update Kelas
                                                                Siswa</button>
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

    <!-- Add New Siswa Modal -->
    <div class="modal fade" id="addSiswaModal" tabindex="-1" aria-labelledby="addSiswaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSiswaModalLabel">Add New Siswa to Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSiswaForm" action="{{ route('kelas_siswas.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="addSiswa" class="form-label">Siswa</label>
                            <select class="form-select" id="addSiswa" name="user_id" required>
                                @foreach ($siswaList as $siswa)
                                    <option value="{{ $siswa->id }}">{{ $siswa->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="text-danger text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="addKelas" class="form-label">Kelas</label>
                            <select class="form-select" id="addKelas" name="kelas_id" required>
                                @foreach ($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->name }}</option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <span class="text-danger text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Add Siswa to Kelas</button>
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
            document.querySelectorAll('form[id^="editKelasSiswaForm"]').forEach(form => {
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

            document.getElementById('addSiswaForm').addEventListener('submit', function(e) {
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
