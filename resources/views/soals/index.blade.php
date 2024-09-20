@extends('soals.master') <!-- Adjust to your main layout -->

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Daftar Soal</h6>
                    <form action="{{ route('soals.index') }}" method="GET" class="d-flex align-items-center">
                        <div class="form-group me-3">
                            <label for="assignment" class="form-label">Pilih Assignment</label>
                            <select name="assignment_id" id="assignment" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Pilih Assignment --</option>
                                @foreach ($assignments as $assignment)
                                    <option value="{{ $assignment->id }}"
                                        {{ request('assignment_id') == $assignment->id ? 'selected' : '' }}>
                                        {{ $assignment->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#addSoalModal">
                        Tambah Soal
                    </button>
                    <!-- Add Import Button -->
                    <button type="button" class="btn btn-primary float-end ms-2" data-bs-toggle="modal"
                        data-bs-target="#ImportModal">
                        Import Soal
                    </button>

                </div>

                <!-- Add New Soal Modal -->
                <div class="modal fade" id="addSoalModal" tabindex="-1" aria-labelledby="addSoalModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addSoalModalLabel">Tambah Soal</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addSoalForm" action="{{ route('soals.store') }}" method="POST">
                                    @csrf
                                    <!-- Assignment -->
                                    <div class="mb-3">
                                        <label for="assignment" class="form-label">Assignment</label>
                                        <select class="form-select" id="assignment" name="assignment_id" required>
                                            @foreach ($assignments as $assignment)
                                                <option value="{{ $assignment->id }}">{{ $assignment->code_assignment }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Soal (Question) -->
                                    <div class="mb-3">
                                        <label for="soal" class="form-label">Soal</label>
                                        <textarea class="form-control" id="soal" name="soal" rows="3" required></textarea>
                                    </div>

                                    <!-- Type -->
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Tipe Soal</label>
                                        <select class="form-select" id="type" name="type" required>
                                            <option value="multiple_choice">Multiple Choice</option>
                                            <option value="essay">Essay</option>
                                        </select>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Tambah Soal</button>
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
                                        Assignment</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Soal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Tipe</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($soals as $index => $soal)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $soal->assignment->code_assignment }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $soal->soal }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ ucfirst($soal->type) }}</p>
                                        </td>

                                        <td class="align-middle text-center">
                                            <!-- Edit Button -->
                                            <button type="button"
                                                class="text-secondary font-weight-bold text-xs btn btn-link"
                                                data-bs-toggle="modal" data-bs-target="#editSoalModal{{ $soal->id }}">
                                                Edit
                                            </button>

                                            <!-- Delete Button -->
                                            <form action="{{ route('soals.destroy', $soal->id) }}" method="POST"
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

                                    <!-- Edit Soal Modal -->
                                    <div class="modal fade" id="editSoalModal{{ $soal->id }}" tabindex="-1"
                                        aria-labelledby="editSoalModalLabel{{ $soal->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editSoalModalLabel{{ $soal->id }}">
                                                        Edit Soal
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editSoalForm{{ $soal->id }}"
                                                        action="{{ route('soals.update', $soal->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="assignment{{ $soal->id }}"
                                                                class="form-label">Assignment</label>
                                                            <select class="form-select"
                                                                id="assignment{{ $soal->id }}" name="assignment_id"
                                                                required>
                                                                @foreach ($assignments as $assignment)
                                                                    <option value="{{ $assignment->id }}"
                                                                        {{ $soal->assignment_id == $assignment->id ? 'selected' : '' }}>
                                                                        {{ $assignment->code_assignment }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="soal{{ $soal->id }}"
                                                                class="form-label">Soal</label>
                                                            <textarea class="form-control" id="soal{{ $soal->id }}" name="soal" rows="3" required>{{ $soal->soal }}</textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="type{{ $soal->id }}" class="form-label">Tipe
                                                                Soal</label>
                                                            <select class="form-select" id="type{{ $soal->id }}"
                                                                name="type" required>
                                                                <option value="multiple_choice"
                                                                    {{ $soal->type == 'multiple_choice' ? 'selected' : '' }}>
                                                                    Multiple Choice</option>
                                                                <option value="essay"
                                                                    {{ $soal->type == 'essay' ? 'selected' : '' }}>Essay
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary">Update
                                                                Soal</button>
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
            document.querySelectorAll('form[id^="editSoalForm"]').forEach(form => {
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
                                    `#editSoalModal${data.soal.id}`));
                                modal.hide();

                                // Update the table row with the new data
                                let row = document.querySelector(
                                    `tr[data-id="${data.soal.id}"]`);
                                row.querySelector('.soal-name').textContent = data.soal.soal;
                                row.querySelector('.type-name').textContent = data.soal.type;

                                // Optionally, show a success message
                                alert('Soal updated successfully!');
                            } else {
                                // Handle errors
                                alert('Failed to update soal.');
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
