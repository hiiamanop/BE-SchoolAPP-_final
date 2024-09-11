@extends('tokens.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Create New Token</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('tokens.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="value" class="form-label">Value</label>
                        <input type="text" class="form-control" id="value" name="value" value="{{ old('value') }}" required>
                        @error('value')
                            <span class="text-danger text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="lifetime" class="form-label">Lifetime</label>
                        <input type="date" class="form-control" id="lifetime" name="lifetime" value="{{ old('lifetime') }}" required>
                        @error('lifetime')
                            <span class="text-danger text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Create Token</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
