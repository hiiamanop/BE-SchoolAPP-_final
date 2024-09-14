@extends('gurus.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Import Gurus from Excel</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('gurus.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">Upload XLSX File</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".xlsx" required>
                        @error('file')
                            <span class="text-danger text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Import Gurus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
