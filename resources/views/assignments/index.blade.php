@extends('assignments.master') <!-- Extend your main layout -->

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Daftar Assignment</h6>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#addAssignmentModal">
                        Tambah Assignment
                    </button>
                </div>

                <!-- Add New Assignment Modal -->
                <div class="modal fade" id="addAssignmentModal" tabindex="-1" aria-labelledby="addAssignmentModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addAssignmentModalLabel">Tambah Assignment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addAssignmentForm" action="{{ route('assignments.store') }}" method="POST">
                                    @csrf
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

                                    <!-- Token -->
                                    <div class="mb-3">
                                        <label for="token" class="form-label">Token</label>
                                        <select class="form-select" id="token" name="token_id" required>
                                            @foreach ($tokens as $token)
                                                <option value="{{ $token->id }}">{{ $token->value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Enroll Class -->
                                    <div class="mb-3">
                                        <label for="enrollClass" class="form-label">Enroll Class</label>
                                        <select class="form-select" id="enrollClass" name="enroll_class_id" required>
                                            @foreach ($enroll as $enroll)
                                                <option value="{{ $enroll->id }}">{{ $enroll->code_enroll }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Code Assignment -->
                                    <div class="mb-3">
                                        <label for="codeAssignment" class="form-label">Code Assignment</label>
                                        <input type="text" class="form-control" id="codeAssignment"
                                            name="code_assignment" required>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Tambah Assignment</button>
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
                                        Mata Pelajaran</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Jenis Penilaian</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Token</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Code Enroll</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Code Assignment</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignments as $index => $assignment)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $assignment->mataPelajaran->name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $assignment->jenisPenilaian->name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $assignment->token->value }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $assignment->enroll ? $assignment->enroll->code_enroll : 'Not Assigned' }}
                                            </p>
                                        </td>

                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $assignment->code_assignment }}</p>
                                        </td>

                                        <td class="align-middle text-center">
                                            <!-- Edit Button -->
                                            <button type="button"
                                                class="text-secondary font-weight-bold text-xs btn btn-link"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editAssignmentModal{{ $assignment->id }}">
                                                Edit
                                            </button>

                                            <!-- Delete Button -->
                                            <form action="{{ route('assignments.destroy', $assignment->id) }}"
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

                                    <!-- Edit Assignment Modal -->
                                    <div class="modal fade" id="editAssignmentModal{{ $assignment->id }}" tabindex="-1"
                                        aria-labelledby="editAssignmentModalLabel{{ $assignment->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editAssignmentModalLabel{{ $assignment->id }}">
                                                        Edit Assignment
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editAssignmentForm{{ $assignment->id }}"
                                                        action="{{ route('assignments.update', $assignment->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="mataPelajaran{{ $assignment->id }}"
                                                                class="form-label">Mata Pelajaran</label>
                                                            <select class="form-select"
                                                                id="mataPelajaran{{ $assignment->id }}"
                                                                name="mata_pelajaran_id" required>
                                                                @foreach ($mataPelajarans as $mataPelajaran)
                                                                    <option value="{{ $mataPelajaran->id }}"
                                                                        {{ $assignment->mata_pelajaran_id == $mataPelajaran->id ? 'selected' : '' }}>
                                                                        {{ $mataPelajaran->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="jenisPenilaian{{ $assignment->id }}"
                                                                class="form-label">Jenis Penilaian</label>
                                                            <select class="form-select"
                                                                id="jenisPenilaian{{ $assignment->id }}"
                                                                name="jenis_penilaian_id" required>
                                                                @foreach ($jenisPenilaians as $jenisPenilaian)
                                                                    <option value="{{ $jenisPenilaian->id }}"
                                                                        {{ $assignment->jenis_penilaian_id == $jenisPenilaian->id ? 'selected' : '' }}>
                                                                        {{ $jenisPenilaian->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="token{{ $assignment->id }}"
                                                                class="form-label">Token</label>
                                                            <select class="form-select" id="token{{ $assignment->id }}"
                                                                name="token_id" required>
                                                                @foreach ($tokens as $token)
                                                                    <option value="{{ $token->id }}"
                                                                        {{ $assignment->token_id == $token->id ? 'selected' : '' }}>
                                                                        {{ $token->value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <!-- Enroll -->
                                                        <div class="mb-3">
                                                            <label for="enroll{{ $assignment->id }}"
                                                                class="form-label">Enroll</label>
                                                            <select class="form-select" id="enroll{{ $assignment->id }}"
                                                                name="enroll_id" required>
                                                                @foreach ($enrolls as $enroll)
                                                                    <option value="{{ $enroll->id }}"
                                                                        {{ $assignment->enroll_id == $enroll->id ? 'selected' : '' }}>
                                                                        {{ $enroll->code_enroll }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="codeAssignment{{ $assignment->id }}"
                                                                class="form-label">Code Assignment</label>
                                                            <input type="text" class="form-control"
                                                                id="codeAssignment{{ $assignment->id }}"
                                                                name="code_assignment"
                                                                value="{{ $assignment->code_assignment }}" required>
                                                        </div>
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary">Update
                                                                Assignment</button>
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
            document.querySelectorAll('form[id^="editAssignmentForm"]').forEach(form => {
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
                                    `#editAssignmentModal${data.assignment.id}`));
                                modal.hide();

                                // Update the table row with the new data
                                let row = document.querySelector(
                                    `tr[data-id="${data.assignment.id}"]`);
                                row.querySelector('.mata-pelajaran-name').textContent = data
                                    .assignment.mataPelajaran.name;
                                row.querySelector('.jenis-penilaian-name').textContent = data
                                    .assignment.jenisPenilaian.name;
                                row.querySelector('.token-name').textContent = data.assignment
                                    .token.name;
                                row.querySelector('.code-assignment').textContent = data
                                    .assignment.code_assignment;

                                // Optionally, show a success message
                                alert('Assignment updated successfully!');
                            } else {
                                // Handle errors
                                alert('Failed to update assignment.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while updating the assignment.');
                        });
                });
            });
        });
    </script>
@endsection
