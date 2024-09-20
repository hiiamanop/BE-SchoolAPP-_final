@extends('gurus.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Gurus Table</h6>
                    <a href="{{ route('gurus.create') }}" class="btn btn-primary float-end">Create New Guru</a>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#importGuruModal">
                        Import Guru
                    </button>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#filterModal">
                        Filter
                    </button>

                    <!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Gurus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="filterForm" action="{{ route('gurus.index') }}" method="GET">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ request('name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ request('email') }}">
                    </div>
                    <div class="mb-3">
                        <label for="nomor_induk" class="form-label">Nomor Induk</label>
                        <input type="text" class="form-control" id="nomor_induk" name="nomor_induk" value="{{ request('nomor_induk') }}">
                    </div>
                    <div class="mb-3">
                        <label for="tahun_masuk" class="form-label">Tahun Masuk</label>
                        <select name="tahun_masuk" id="tahun_masuk" class="form-control">
                            <option value="">All</option>
                            @foreach ($gurus->pluck('tahun_masuk')->unique() as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun_masuk') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="{{ route('gurus.index') }}" class="btn btn-secondary">Clear</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

                    


                    <!-- Import Guru Modal -->
                    <div class="modal fade" id="importGuruModal" tabindex="-1" aria-labelledby="importGuruModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="importGuruModalLabel">Import Guru</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('gurus.import') }}" method="POST" enctype="multipart/form-data">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nomor Induk</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Tahun Masuk</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gurus as $index => $guru)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $guru->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $guru->email }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $guru->nomor_induk }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $guru->tahun_masuk }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <button type="button"
                                                class="text-secondary font-weight-bold text-xs btn btn-link"
                                                data-bs-toggle="modal" data-bs-target="#editGuruModal{{ $guru->id }}"
                                                data-toggle="tooltip" data-original-title="Edit Guru">
                                                Edit
                                            </button>

                                            <form action="{{ route('gurus.destroy', $guru->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-secondary font-weight-bold text-xs btn btn-link"
                                                    data-toggle="tooltip" data-original-title="Delete Guru">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Guru Modal -->
                                    <div class="modal fade" id="editGuruModal{{ $guru->id }}" tabindex="-1"
                                        aria-labelledby="editGuruModalLabel{{ $guru->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editGuruModalLabel{{ $guru->id }}">Edit
                                                        Guru</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editGuruForm{{ $guru->id }}"
                                                        action="{{ route('gurus.update', $guru->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="name{{ $guru->id }}"
                                                                class="form-label">Name</label>
                                                            <input type="text" class="form-control"
                                                                id="name{{ $guru->id }}" name="name"
                                                                value="{{ $guru->name }}" required>
                                                            @error('name')
                                                                <span class="text-danger text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email{{ $guru->id }}"
                                                                class="form-label">Email</label>
                                                            <input type="email" class="form-control"
                                                                id="email{{ $guru->id }}" name="email"
                                                                value="{{ $guru->email }}" required>
                                                            @error('email')
                                                                <span class="text-danger text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="password{{ $guru->id }}"
                                                                class="form-label">Password (Leave empty to keep current
                                                                password)</label>
                                                            <input type="password" class="form-control"
                                                                id="password{{ $guru->id }}" name="password">
                                                            @error('password')
                                                                <span class="text-danger text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="password_confirmation{{ $guru->id }}"
                                                                class="form-label">Confirm Password</label>
                                                            <input type="password" class="form-control"
                                                                id="password_confirmation{{ $guru->id }}"
                                                                name="password_confirmation">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="nomor_induk{{ $guru->id }}"
                                                                class="form-label">Nomor Induk</label>
                                                            <input type="text" class="form-control"
                                                                id="nomor_induk{{ $guru->id }}" name="nomor_induk"
                                                                value="{{ $guru->nomor_induk }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tahun_masuk{{ $guru->id }}"
                                                                class="form-label">Tahun Masuk</label>
                                                            <input type="text" class="form-control"
                                                                id="tahun_masuk{{ $guru->id }}" name="tahun_masuk"
                                                                value="{{ $guru->tahun_masuk }}">
                                                        </div>
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary">Update
                                                                Guru</button>
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
