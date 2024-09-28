@extends('mata_pelajarans.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Mata Pelajaran Table</h6>
                    <a href="{{ route('mata-pelajaran.create') }}" class="btn btn-primary float-end">Create New Mata
                        Pelajaran</a>
                    <button class="btn btn-primary float-end me-2" data-bs-toggle="modal" data-bs-target="#importModal">
                        Import Mata Pelajaran
                    </button>
                </div>
                <!-- Import Modal -->
                <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="importModalLabel">Import Mata Pelajaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('mata-pelajaran.import') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Choose XLSX File</label>
                                        <input type="file" name="file" class="form-control" id="file" required
                                            accept=".xlsx">
                                    </div>
                                    @error('file')
                                        <span class="text-danger text-xs">{{ $message }}</span>
                                    @enderror
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
                                        Name</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mataPelajarans as $index => $mataPelajaran)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $mataPelajaran->name }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <button type="button"
                                                class="text-secondary font-weight-bold text-xs btn btn-link"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editMataPelajaranModal{{ $mataPelajaran->id }}"
                                                data-toggle="tooltip" data-original-title="Edit Mata Pelajaran">
                                                Edit
                                            </button>

                                            <form action="{{ route('mata-pelajaran.destroy', $mataPelajaran->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-secondary font-weight-bold text-xs btn btn-link"
                                                    data-toggle="tooltip" data-original-title="Delete Mata Pelajaran">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Mata Pelajaran Modal -->
                                    <div class="modal fade" id="editMataPelajaranModal{{ $mataPelajaran->id }}"
                                        tabindex="-1" aria-labelledby="editMataPelajaranModalLabel{{ $mataPelajaran->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editMataPelajaranModalLabel{{ $mataPelajaran->id }}">Edit Mata
                                                        Pelajaran</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editMataPelajaranForm{{ $mataPelajaran->id }}"
                                                        action="{{ route('mata-pelajaran.update', $mataPelajaran->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="name{{ $mataPelajaran->id }}"
                                                                class="form-label">Name</label>
                                                            <input type="text" class="form-control"
                                                                id="name{{ $mataPelajaran->id }}" name="name"
                                                                value="{{ $mataPelajaran->name }}" required>
                                                            @error('name')
                                                                <span class="text-danger text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary">Update Mata
                                                                Pelajaran</button>
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
            document.querySelectorAll('form[id^="editMataPelajaranForm"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    let formData = new FormData(this);
                    let formAction = this.getAttribute('action');
                    let formMethod = this.getAttribute('method');

                    fetch(formAction, {
                            method: formMethod,
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content'),
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                let modal = bootstrap.Modal.getInstance(document.querySelector(
                                    '#' + this.getAttribute('id').replace(
                                        'editMataPelajaranForm',
                                        'editMataPelajaranModal')));
                                modal.hide();
                                alert('Mata Pelajaran updated successfully!');
                                location.reload(); // Refresh the page to see changes
                            } else {
                                alert('Error updating Mata Pelajaran!');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
@endsection
