@extends('siswas.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Tabel Siswa</h6>

                    <a href="{{ route('siswas.create') }}" class="btn btn-primary float-end">Create New Siswa</a>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#importSiswaModal">
                        Import Siswa
                    </button>

                    <!-- Filter Form -->
                    <form action="{{ route('siswas.index') }}" method="GET" class="d-flex mb-3">
                        <div class="row">
                            <div class="form-group me-2">
                                <label for="tahun_masuk" class="form-label">Filter by Tahun Masuk</label>
                                <select name="tahun_masuk" id="tahun_masuk" class="form-control">
                                    <option value="">All</option>
                                    @foreach ($siswas->pluck('tahun_masuk')->unique() as $tahun)
                                        <option value="{{ $tahun }}"
                                            {{ request('tahun_masuk') == $tahun ? 'selected' : '' }}>
                                            {{ $tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group align-self-end">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('siswas.index') }}" class="btn btn-secondary">Clear</a>
                            </div>
                        </div>

                    </form>



                    <!-- Import Siswa Modal -->
                    <div class="modal fade" id="importSiswaModal" tabindex="-1" aria-labelledby="importSiswaModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="importSiswaModalLabel">Import Siswa</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('siswas.upload') }}" method="POST"
                                        enctype="multipart/form-data">
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
                                @foreach ($siswas as $index => $siswa)
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
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $siswa->nomor_induk }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $siswa->tahun_masuk }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <button type="button"
                                                class="text-secondary font-weight-bold text-xs btn btn-link"
                                                data-bs-toggle="modal" data-bs-target="#editSiswaModal{{ $siswa->id }}"
                                                data-toggle="tooltip" data-original-title="Edit Guru">
                                                Edit
                                            </button>

                                            <form action="{{ route('gurus.destroy', $siswa->id) }}" method="POST"
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

                                    <!-- Edit Siswa Modal -->
                                    <div class="modal fade" id="editSiswaModal{{ $siswa->id }}" tabindex="-1"
                                        aria-labelledby="editSiswaModalLabel{{ $siswa->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editSiswaModalLabel{{ $siswa->id }}">
                                                        Edit
                                                        Siswa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('siswas.update', $siswa->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="name{{ $siswa->id }}">Name</label>
                                                            <input type="text" class="form-control" name="name"
                                                                value="{{ $siswa->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email{{ $siswa->id }}">Email</label>
                                                            <input type="email" class="form-control" name="email"
                                                                value="{{ $siswa->email }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="nomor_induk{{ $siswa->id }}">Nomor
                                                                Induk</label>
                                                            <input type="text" class="form-control" name="nomor_induk"
                                                                value="{{ $siswa->nomor_induk }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tahun_masuk{{ $siswa->id }}">Tahun
                                                                Masuk</label>
                                                            <input type="text" class="form-control" name="tahun_masuk"
                                                                value="{{ $siswa->tahun_masuk }}">
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
