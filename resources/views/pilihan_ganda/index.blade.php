@extends('pilihan_ganda.master') <!-- Adjust to your main layout -->

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Daftar Pilihan Ganda</h6>
                    <form action="{{ route('pilihan_gandas.index') }}" method="GET" class="d-flex align-items-center">
                        <div class="form-group me-3">
                            <label for="soal" class="form-label">Pilih Soal</label>
                            <select name="soal_id" id="soal" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Pilih Soal --</option>
                                @foreach ($soals as $soal)
                                    <option value="{{ $soal->id }}"
                                        {{ request('soal_id') == $soal->id ? 'selected' : '' }}>
                                        {{ $soal->soal }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#addPilihanGandaModal">
                        Tambah Pilihan Ganda
                    </button>
                    <!-- Add Import Button -->
                    <button type="button" class="btn btn-primary float-end ms-2" data-bs-toggle="modal"
                        data-bs-target="#ImportModal">
                        Import Pilihan Ganda
                    </button>
                </div>

                <!-- Add New Pilihan Ganda Modal -->
                <div class="modal fade" id="addPilihanGandaModal" tabindex="-1" aria-labelledby="addPilihanGandaModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addPilihanGandaModalLabel">Tambah Pilihan Ganda</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addPilihanGandaForm" action="{{ route('pilihan_gandas.store') }}" method="POST">
                                    @csrf
                                    <!-- Soal -->
                                    <div class="mb-3">
                                        <label for="soal" class="form-label">Soal</label>
                                        <select class="form-select" id="soal" name="soal_id" required>
                                            @foreach ($soals as $soal)
                                                <option value="{{ $soal->id }}">{{ $soal->soal }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Jawaban -->
                                    <div class="mb-3">
                                        <label for="jawaban" class="form-label">Jawaban</label>
                                        <input type="text" class="form-control" id="jawaban" name="jawaban" required>
                                    </div>

                                    <!-- Value -->
                                    <div class="mb-3">
                                        <label for="value" class="form-label">Nilai</label>
                                        <select class="form-select" id="value" name="value" required>
                                            <option value="1">Benar</option>
                                            <option value="0">Salah</option>
                                        </select>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Tambah Pilihan Ganda</button>
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
                                        Soal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Jawaban</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nilai</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pilihanGandas as $index => $pilihanGanda)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $pilihanGanda->soal->soal }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $pilihanGanda->jawaban }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $pilihanGanda->value ? 'Benar' : 'Salah' }}</p>
                                        </td>

                                        <td class="align-middle text-center">
                                            <!-- Edit Button -->
                                            <button type="button"
                                                class="text-secondary font-weight-bold text-xs btn btn-link"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editPilihanGandaModal{{ $pilihanGanda->id }}">
                                                Edit
                                            </button>

                                            <!-- Delete Button -->
                                            <form action="{{ route('pilihan_gandas.destroy', $pilihanGanda->id) }}"
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

                                    <!-- Edit Pilihan Ganda Modal -->
                                    <div class="modal fade" id="editPilihanGandaModal{{ $pilihanGanda->id }}"
                                        tabindex="-1" aria-labelledby="editPilihanGandaModalLabel{{ $pilihanGanda->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editPilihanGandaModalLabel{{ $pilihanGanda->id }}">
                                                        Edit Pilihan Ganda
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editPilihanGandaForm{{ $pilihanGanda->id }}"
                                                        action="{{ route('pilihan_gandas.update', $pilihanGanda->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="soal{{ $pilihanGanda->id }}"
                                                                class="form-label">Soal</label>
                                                            <select class="form-select" id="soal{{ $pilihanGanda->id }}"
                                                                name="soal_id" required>
                                                                @foreach ($soals as $soal)
                                                                    <option value="{{ $soal->id }}"
                                                                        {{ $pilihanGanda->soal_id == $soal->id ? 'selected' : '' }}>
                                                                        {{ $soal->soal }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="jawaban{{ $pilihanGanda->id }}"
                                                                class="form-label">Jawaban</label>
                                                            <input type="text" class="form-control"
                                                                id="jawaban{{ $pilihanGanda->id }}" name="jawaban"
                                                                value="{{ $pilihanGanda->jawaban }}" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="value{{ $pilihanGanda->id }}"
                                                                class="form-label">Nilai</label>
                                                            <select class="form-select" id="value{{ $pilihanGanda->id }}"
                                                                name="value" required>
                                                                <option value="1"
                                                                    {{ $pilihanGanda->value ? 'selected' : '' }}>Benar
                                                                </option>
                                                                <option value="0"
                                                                    {{ !$pilihanGanda->value ? 'selected' : '' }}>Salah
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary">Update Pilihan
                                                                Ganda</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form[id^="editPilihanGandaForm"]').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    let formData = new FormData(form);
                    let action = form.getAttribute('action');
                    fetch(action, {
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
                                // Close the modal
                                let modal = bootstrap.Modal.getInstance(document.querySelector(
                                    `#editPilihanGandaModal${data.pilihanGanda.id}`));
                                modal.hide();

                                // Update the table row with the new data
                                let row = document.querySelector(
                                    `tr[data-id="${data.pilihanGanda.id}"]`);
                                row.querySelector('.soal-name').textContent = data.pilihanGanda
                                    .soal.soal;
                                row.querySelector('.jawaban-name').textContent = data
                                    .pilihanGanda.jawaban;
                                row.querySelector('.value-name').textContent = data.pilihanGanda
                                    .value ? 'Benar' : 'Salah';

                                // Optionally, show a success message
                                alert('Pilihan Ganda updated successfully!');
                            } else {
                                // Handle errors
                                alert('Failed to update Pilihan Ganda.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        });
    </script>
@endsection
