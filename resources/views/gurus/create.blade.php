@extends('gurus.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Create New Guru</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('gurus.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-danger text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nomor_induk" class="form-label">Nomor Induk</label>
                        <input type="text" class="form-control" id="nomor_induk" name="nomor_induk" value="{{ old('nomor_induk') }}">
                    </div>
                    <div class="mb-3">
                        <label for="tahun_masuk" class="form-label">Tahun Masuk</label>
                        <input type="text" class="form-control" id="tahun_masuk" name="tahun_masuk" value="{{ old('tahun_masuk') }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-danger text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        @error('password')
                            <span class="text-danger text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <!-- Hidden field for role_id -->
                    <input type="hidden" name="role_id" value="2">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Create Guru</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
