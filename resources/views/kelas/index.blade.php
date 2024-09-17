@extends('kelas.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Kelas Table</h6>
                    <a href="{{ route('kelas.create') }}" class="btn btn-primary float-end">Create New Kelas</a>
                    
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
                                @foreach ($kelas as $index => $kelasItem)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $kelasItem->name }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <button type="button"
                                                class="text-secondary font-weight-bold text-xs btn btn-link"
                                                data-bs-toggle="modal" data-bs-target="#editKelasModal{{ $kelasItem->id }}"
                                                data-toggle="tooltip" data-original-title="Edit Kelas">
                                                Edit
                                            </button>

                                            <form action="{{ route('kelas.destroy', $kelasItem->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-secondary font-weight-bold text-xs btn btn-link"
                                                    data-toggle="tooltip" data-original-title="Delete Kelas">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Kelas Modal -->
                                    <div class="modal fade" id="editKelasModal{{ $kelasItem->id }}" tabindex="-1"
                                        aria-labelledby="editKelasModalLabel{{ $kelasItem->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editKelasModalLabel{{ $kelasItem->id }}">
                                                        Edit
                                                        Kelas</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editKelasForm{{ $kelasItem->id }}"
                                                        action="{{ route('kelas.update', $kelasItem->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="name{{ $kelasItem->id }}"
                                                                class="form-label">Name</label>
                                                            <input type="text" class="form-control"
                                                                id="name{{ $kelasItem->id }}" name="name"
                                                                value="{{ $kelasItem->name }}" required>
                                                            @error('name')
                                                                <span class="text-danger text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary">Update
                                                                Kelas</button>
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
