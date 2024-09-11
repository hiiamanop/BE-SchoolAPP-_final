@extends('bukus.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Create New Buku</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('bukus.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
                        @error('judul')
                            <span class="text-danger text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="kategori_buku_id" class="form-label">Kategori Buku</label>
                        <select class="form-select" id="kategori_buku_id" name="kategori_buku_id" required>
                            <option value="" selected disabled>Select Kategori</option>
                            @foreach ($kategoriBukus as $kategoriBuku)
                                <option value="{{ $kategoriBuku->id }}">{{ $kategoriBuku->kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_buku_id')
                            <span class="text-danger text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Create Buku</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
