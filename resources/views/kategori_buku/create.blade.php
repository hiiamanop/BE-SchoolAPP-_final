@extends('kategori_buku.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Create New Kategori Buku</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('kategori_buku.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Buku</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" value="{{ old('kategori') }}" required>
                        @error('kategori')
                            <span class="text-danger text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Create Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
