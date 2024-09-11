@extends('tahun_ajarans.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Create New Tahun Ajaran</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('tahun-ajaran.store') }}" method="POST">
                    @csrf
                    <!-- Start Year Input -->
                    <div class="mb-3">
                        <label for="start_year" class="form-label">Start Year</label>
                        <input type="number" class="form-control" id="start_year" name="start_year" value="{{ old('start_year') }}" required min="1900" max="{{ date('Y') + 10 }}">
                        @error('start_year')
                            <span class="text-danger text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- End Year Input -->
                    <div class="mb-3">
                        <label for="end_year" class="form-label">End Year</label>
                        <input type="number" class="form-control" id="end_year" name="end_year" value="{{ old('end_year') }}" required min="1900" max="{{ date('Y') + 10 }}">
                        @error('end_year')
                            <span class="text-danger text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Create Tahun Ajaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
