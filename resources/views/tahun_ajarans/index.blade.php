@extends('tahun_ajarans.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Tahun Ajaran Table</h6>
                    <a href="{{ route('tahun-ajaran.create') }}" class="btn btn-primary float-end">Create New Tahun Ajaran</a>
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
                                @foreach ($tahunAjarans as $index => $tahunAjaran)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $tahunAjaran->name }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <button type="button"
                                                class="text-secondary font-weight-bold text-xs btn btn-link"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editTahunAjaranModal{{ $tahunAjaran->id }}"
                                                data-toggle="tooltip" data-original-title="Edit Tahun Ajaran">
                                                Edit
                                            </button>

                                            <form action="{{ route('tahun-ajaran.destroy', $tahunAjaran->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-secondary font-weight-bold text-xs btn btn-link"
                                                    data-toggle="tooltip" data-original-title="Delete Tahun Ajaran">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Tahun Ajaran Modal -->
                                    <div class="modal fade" id="editTahunAjaranModal{{ $tahunAjaran->id }}" tabindex="-1"
                                        aria-labelledby="editTahunAjaranModalLabel{{ $tahunAjaran->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editTahunAjaranModalLabel{{ $tahunAjaran->id }}">Edit Tahun
                                                        Ajaran</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editTahunAjaranForm{{ $tahunAjaran->id }}"
                                                        action="{{ route('tahun-ajaran.update', $tahunAjaran->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <!-- Start Year Input -->
                                                        <div class="mb-3">
                                                            <label for="start_year{{ $tahunAjaran->id }}"
                                                                class="form-label">Start Year</label>
                                                            <input type="number" class="form-control"
                                                                id="start_year{{ $tahunAjaran->id }}" name="start_year"
                                                                value="{{ $tahunAjaran->start_year }}" required
                                                                min="1900" max="{{ date('Y') + 10 }}">
                                                            @error('start_year')
                                                                <span class="text-danger text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <!-- End Year Input -->
                                                        <div class="mb-3">
                                                            <label for="end_year{{ $tahunAjaran->id }}"
                                                                class="form-label">End Year</label>
                                                            <input type="number" class="form-control"
                                                                id="end_year{{ $tahunAjaran->id }}" name="end_year"
                                                                value="{{ $tahunAjaran->end_year }}" required
                                                                min="1900" max="{{ date('Y') + 10 }}">
                                                            @error('end_year')
                                                                <span class="text-danger text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <!-- Submit Button -->
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary">Update Tahun
                                                                Ajaran</button>
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
            document.querySelectorAll('form[id^="editTahunAjaranForm"]').forEach(form => {
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
                                        'editTahunAjaranForm', 'editTahunAjaranModal')));
                                modal.hide();
                                alert('Tahun Ajaran updated successfully!');
                                location.reload(); // Refresh the page to see changes
                            } else {
                                alert('Error updating Tahun Ajaran!');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
@endsection
