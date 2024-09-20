@extends('kelas_siswa.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Add New Siswa to Kelas</h6>
                <a href="{{ route('kelas_siswas.index') }}" class="btn btn-primary float-end">Back to List</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form action="{{ route('kelas_siswas.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="siswa" class="form-label">Siswa</label>
                        <select class="form-select" id="siswa" name="user_id" required>
                            <option value="">-- Select Siswa --</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="text-danger text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <select class="form-select" id="kelas" name="kelas_id" required>
                            <option value="">-- Select Kelas --</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->name }}</option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <span class="text-danger text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Add to Kelas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
