@extends('bukus.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Buku Table</h6>
                    <a href="{{ route('bukus.create') }}" class="btn btn-primary float-end">Create New Buku</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Judul</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Kategori</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bukus as $index => $buku)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $buku->judul }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $buku->kategoriBuku->kategori }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <button type="button" class="text-secondary font-weight-bold text-xs btn btn-link"
                                                data-bs-toggle="modal" data-bs-target="#editBukuModal{{ $buku->id }}"
                                                data-toggle="tooltip" data-original-title="Edit Buku">
                                                Edit
                                            </button>

                                            <form action="{{ route('bukus.destroy', $buku->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-secondary font-weight-bold text-xs btn btn-link"
                                                    data-toggle="tooltip" data-original-title="Delete Buku">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Buku Modal -->
                                    <div class="modal fade" id="editBukuModal{{ $buku->id }}" tabindex="-1"
                                        aria-labelledby="editBukuModalLabel{{ $buku->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editBukuModalLabel{{ $buku->id }}">Edit Buku</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editBukuForm{{ $buku->id }}"
                                                        action="{{ route('bukus.update', $buku->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="judul{{ $buku->id }}" class="form-label">Judul</label>
                                                            <input type="text" class="form-control"
                                                                id="judul{{ $buku->id }}" name="judul"
                                                                value="{{ $buku->judul }}" required>
                                                            @error('judul')
                                                                <span class="text-danger text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="kategori_buku_id{{ $buku->id }}" class="form-label">Kategori</label>
                                                            <select class="form-select" id="kategori_buku_id{{ $buku->id }}"
                                                                name="kategori_buku_id" required>
                                                                @foreach ($kategori_bukus as $kategori)
                                                                    <option value="{{ $kategori->id }}"
                                                                        {{ $kategori->id == $buku->kategori_buku_id ? 'selected' : '' }}>
                                                                        {{ $kategori->kategori }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('kategori_buku_id')
                                                                <span class="text-danger text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary">Update Buku</button>
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
