@extends('enroll.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Enrollment Table</h6>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#addEnrollmentModal">
                        Add Enrollment
                    </button>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#importEnrollModal">
                        Import Enrollment
                    </button>

                    <!-- Add Enrollment Modal -->
                    <div class="modal fade" id="addEnrollmentModal" tabindex="-1" aria-labelledby="addEnrollmentModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addEnrollmentModalLabel">Add Enrollment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('enrolls.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="guru_pelajaran_id" class="form-label">Select Guru</label>
                                            <select class="form-select" id="guru_pelajaran_id" name="guru_pelajaran_id" required>
                                                @foreach ($guruPelajaranList as $guruPelajaran)
                                                    <option value="{{ $guruPelajaran->id }}">{{ $guruPelajaran->guru->name }} - {{ $guruPelajaran->mataPelajaran->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('guru_pelajaran_id')
                                                <span class="text-danger text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="code_enroll" class="form-label">Code Enrollment</label>
                                            <input type="text" class="form-control" id="code_enroll" name="code_enroll" required>
                                            @error('code_enroll')
                                                <span class="text-danger text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Add Enrollment</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Import Enrollment Modal -->
                    <div class="modal fade" id="importEnrollModal" tabindex="-1" aria-labelledby="importEnrollModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="importEnrollModalLabel">Import Enrollment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('enrolls.import') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="file" class="form-label">Upload Excel File</label>
                                            <input type="file" class="form-control" id="file" name="file"
                                                accept=".xlsx" required>
                                            @error('file')
                                                <span class="text-danger text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Import Enrollment</button>
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
                                        Guru Pelajaran</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Code Enroll</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($enrolls as $index => $enroll)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $enroll->guruPelajaran->guru->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $enroll->code_enroll }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <button type="button"
                                                class="text-secondary font-weight-bold text-xs btn btn-link"
                                                data-bs-toggle="modal" data-bs-target="#editEnrollModal{{ $enroll->id }}"
                                                data-toggle="tooltip" data-original-title="Edit Enrollment">
                                                Edit
                                            </button>

                                            <form action="{{ route('enrolls.destroy', $enroll->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-secondary font-weight-bold text-xs btn btn-link"
                                                    data-toggle="tooltip" data-original-title="Delete Enrollment">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Enrollment Modal -->
                                    <div class="modal fade" id="editEnrollModal{{ $enroll->id }}" tabindex="-1"
                                        aria-labelledby="editEnrollModalLabel{{ $enroll->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editEnrollModalLabel{{ $enroll->id }}">Edit
                                                        Enrollment</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('enrolls.update', $enroll->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="guru_pelajaran_id{{ $enroll->id }}"
                                                                class="form-label">Guru Pelajaran</label>
                                                            <select class="form-select"
                                                                id="guru_pelajaran_id{{ $enroll->id }}"
                                                                name="guru_pelajaran_id" required>
                                                                @foreach ($guruPelajaranList as $guruPelajaran)
                                                                    <option value="{{ $guruPelajaran->id }}"
                                                                        {{ $guruPelajaran->id == $enroll->guru_pelajaran_id ? 'selected' : '' }}>
                                                                        {{ $guruPelajaran->guru->name }} - {{ $guruPelajaran->mataPelajaran->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('guru_pelajaran_id')
                                                                <span class="text-danger text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="code_enroll{{ $enroll->id }}"
                                                                class="form-label">Code Enroll</label>
                                                            <input type="text" class="form-control"
                                                                id="code_enroll{{ $enroll->id }}" name="code_enroll"
                                                                value="{{ $enroll->code_enroll }}" required>
                                                            @error('code_enroll')
                                                                <span class="text-danger text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary">Update
                                                                Enrollment</button>
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
