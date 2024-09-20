@extends('lembar_jawaban.master')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Detail Lembar Jawaban</h4>
            <p>Nama Siswa: {{ $siswa->name }}</p>
            <p>Kode Assignment: {{ $assignment->code_assignment }}</p>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Soal</th>
                        <th>Jawaban Siswa</th>
                        <th>Nilai</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignment->soals as $soal)
                        @php
                            $lembarJawaban = $soal->lembarJawaban->first();
                        @endphp
                        <tr>
                            <td>{{ $soal->soal }}</td>
                            <td>{{ $lembarJawaban->jawaban_siswa ?? '-' }}</td>
                            <td>
                                <form action="{{ route('lembar_jawaban.update_score', $lembarJawaban->id) }}" method="POST">
                                    @csrf
                                    <input type="number" name="score" value="{{ $lembarJawaban->score ?? '' }}" class="form-control" style="width: 80px;">
                                    <button type="submit" class="btn btn-success mt-2">Simpan</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
