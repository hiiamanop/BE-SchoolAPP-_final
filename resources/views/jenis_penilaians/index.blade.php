@extends('jenis_penilaians.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Jenis Penilaian Table</h6>
                <a href="{{ route('jenis-penilaian.create') }}" class="btn btn-primary float-end">Create New Jenis Penilaian</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jenisPenilaians as $index => $jenisPenilaian)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $jenisPenilaian->name }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button type="button" class="text-secondary font-weight-bold text-xs btn btn-link" data-bs-toggle="modal" data-bs-target="#editJenisPenilaianModal{{ $jenisPenilaian->id }}" data-toggle="tooltip" data-original-title="Edit Jenis Penilaian">
                                            Edit
                                        </button>

                                        <form action="{{ route('jenis-penilaian.destroy', $jenisPenilaian->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-secondary font-weight-bold text-xs btn btn-link" data-toggle="tooltip" data-original-title="Delete Jenis Penilaian">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Jenis Penilaian Modal -->
                                <div class="modal fade" id="editJenisPenilaianModal{{ $jenisPenilaian->id }}" tabindex="-1" aria-labelledby="editJenisPenilaianModalLabel{{ $jenisPenilaian->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editJenisPenilaianModalLabel{{ $jenisPenilaian->id }}">Edit Jenis Penilaian</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editJenisPenilaianForm{{ $jenisPenilaian->id }}" action="{{ route('jenis-penilaian.update', $jenisPenilaian->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="name{{ $jenisPenilaian->id }}" class="form-label">Name</label>
                                                        <input type="text" class="form-control" id="name{{ $jenisPenilaian->id }}" name="name" value="{{ $jenisPenilaian->name }}" required>
                                                        @error('name')
                                                            <span class="text-danger text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-primary">Update Jenis Penilaian</button>
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
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form[id^="editJenisPenilaianForm"]').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            
            let formData = new FormData(this);
            let formAction = this.getAttribute('action');
            let formMethod = this.getAttribute('method');

            fetch(formAction, {
                method: formMethod,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let modal = bootstrap.Modal.getInstance(document.querySelector('#' + this.getAttribute('id').replace('editJenisPenilaianForm', 'editJenisPenilaianModal')));
                    modal.hide();
                    alert('Jenis Penilaian updated successfully!');
                    location.reload(); // Refresh the page to see changes
                } else {
                    alert('Error updating jenis penilaian!');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>
@endsection
