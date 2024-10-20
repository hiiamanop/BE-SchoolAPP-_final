@extends('enroll_class.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Enroll Class Table</h6>
                    <!-- Filter Form -->
                    <form action="{{ route('enroll_classes.index') }}" method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="enroll_id_filter" class="form-label">Filter by Enroll</label>
                                <select class="form-select" id="enroll_id_filter" name="enroll_id">
                                    <option value="">-- All Enrolls --</option>
                                    @foreach ($enrolls as $enroll)
                                        <option value="{{ $enroll->id }}"
                                            {{ request('enroll_id') == $enroll->id ? 'selected' : '' }}>
                                            {{ $enroll->code_enroll }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 align-self-end">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('enroll_classes.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#addEnrollClassModal">
                        Add Enroll Class
                    </button>

                    <!-- Add Enroll Class Modal -->
                    <div class="modal fade" id="addEnrollClassModal" tabindex="-1"
                        aria-labelledby="addEnrollClassModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addEnrollClassModalLabel">Add Enroll Class</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('enroll_classes.store') }}" method="POST">
                                        @csrf
                                        <!-- Student Selection -->
                                        <div class="mb-3">
                                            <label for="siswa_id" class="form-label">Student</label>
                                            <select class="form-select" id="siswa_id" name="siswa_id" required>
                                                @foreach ($siswas as $siswa)
                                                    <option value="{{ $siswa->id }}">{{ $siswa->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Enroll Selection -->
                                        <div class="mb-3">
                                            <label for="enroll_id" class="form-label">Enroll</label>
                                            <select class="form-select" id="enroll_id" name="enroll_id" required>
                                                @foreach ($enrolls as $enroll)
                                                    <option value="{{ $enroll->id }}">{{ $enroll->code_enroll }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Add Enroll Class</button>
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
                                        Student</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Enroll</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Kelas</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama Guru</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($enrollClasses as $index => $enrollClass)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $enrollClass->siswa->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $enrollClass->enroll->code_enroll }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $enrollClass->enroll->guruPelajaran->mataPelajaran->name ?? 'N/A' }}</p>
                                        </td>
                                        <!-- Assuming this gets the class name -->
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $enrollClass->enroll->guruPelajaran->guru->name ?? 'N/A' }}
                                            </p>
                                        </td>
                                        <!-- Assuming this gets the teacher's name -->
                                        <td class="align-middle text-center">
                                            <!-- Edit Button -->
                                            <button type="button"
                                                class="text-secondary font-weight-bold text-xs btn btn-link"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editEnrollClassModal{{ $enrollClass->id }}">
                                                Edit
                                            </button>

                                            <!-- Delete Button -->
                                            <form action="{{ route('enroll_classes.destroy', $enrollClass->id) }}"
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

                                    <!-- Edit Enroll Class Modal -->
                                    <div class="modal fade" id="editEnrollClassModal{{ $enrollClass->id }}" tabindex="-1"
                                        aria-labelledby="editEnrollClassModalLabel{{ $enrollClass->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editEnrollClassModalLabel{{ $enrollClass->id }}">
                                                        Edit Enroll Class</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('enroll_classes.update', $enrollClass->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <!-- Student Selection -->
                                                        <div class="mb-3">
                                                            <label for="siswa_id{{ $enrollClass->id }}"
                                                                class="form-label">Student</label>
                                                            <select class="form-select"
                                                                id="siswa_id{{ $enrollClass->id }}" name="siswa_id"
                                                                required>
                                                                @foreach ($siswas as $siswa)
                                                                    <option value="{{ $siswa->id }}"
                                                                        {{ $siswa->id == $enrollClass->siswa_id ? 'selected' : '' }}>
                                                                        {{ $siswa->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('siswa_id')
                                                                <span class="text-danger text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <!-- Enroll Selection -->
                                                        <div class="mb-3">
                                                            <label for="enroll_id{{ $enrollClass->id }}"
                                                                class="form-label">Enroll</label>
                                                            <select class="form-select"
                                                                id="enroll_id{{ $enrollClass->id }}" name="enroll_id"
                                                                required>
                                                                @foreach ($enrolls as $enroll)
                                                                    <option value="{{ $enroll->id }}"
                                                                        {{ $enroll->id == $enrollClass->enroll_id ? 'selected' : '' }}>
                                                                        {{ $enroll->code_enroll }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('enroll_id')
                                                                <span class="text-danger text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <!-- Submit Button -->
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary">Update Enroll
                                                                Class</button>
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
