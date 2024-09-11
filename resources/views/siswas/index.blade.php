@extends('siswas.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Siswas Table</h6>
                    <a href="{{ route('siswas.create') }}" class="btn btn-primary float-end">Create New Siswa</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Email</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $index => $siswa)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $siswa->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $siswa->email }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <button type="button"
                                                class="text-secondary font-weight-bold text-xs btn btn-link"
                                                data-bs-toggle="modal" data-bs-target="#editSiswaModal{{ $siswa->id }}"
                                                data-toggle="tooltip" data-original-title="Edit Siswa">
                                                Edit
                                            </button>

                                            <form action="{{ route('siswas.destroy', $siswa->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-secondary font-weight-bold text-xs btn btn-link"
                                                    data-toggle="tooltip" data-original-title="Delete Siswa">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Siswa Modal -->
                                    <div class="modal fade" id="editSiswaModal{{ $siswa->id }}" tabindex="-1"
                                        aria-labelledby="editSiswaModalLabel{{ $siswa->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editSiswaModalLabel{{ $siswa->id }}">Edit
                                                        Siswa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editSiswaForm{{ $siswa->id }}"
                                                        action="{{ route('siswas.update', $siswa->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="name{{ $siswa->id }}"
                                                                class="form-label">Name</label>
                                                            <input type="text" class="form-control"
                                                                id="name{{ $siswa->id }}" name="name"
                                                                value="{{ $siswa->name }}" required>
                                                            @error('name')
                                                                <span class="text-danger text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email{{ $siswa->id }}"
                                                                class="form-label">Email</label>
                                                            <input type="email" class="form-control"
                                                                id="email{{ $siswa->id }}" name="email"
                                                                value="{{ $siswa->email }}" required>
                                                            @error('email')
                                                                <span class="text-danger text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="password{{ $siswa->id }}"
                                                                class="form-label">Password (Leave empty to keep current
                                                                password)</label>
                                                            <input type="password" class="form-control"
                                                                id="password{{ $siswa->id }}" name="password">
                                                            @error('password')
                                                                <span class="text-danger text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="password_confirmation{{ $siswa->id }}"
                                                                class="form-label">Confirm Password</label>
                                                            <input type="password" class="form-control"
                                                                id="password_confirmation{{ $siswa->id }}"
                                                                name="password_confirmation">
                                                        </div>
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary">Update
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
@endsection
