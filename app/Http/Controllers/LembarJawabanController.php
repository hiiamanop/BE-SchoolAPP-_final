<?php

namespace App\Http\Controllers;

use App\Models\LembarJawaban;
use App\Models\Assignment;
use App\Models\Siswa;
use App\Models\Soal;
use Illuminate\Http\Request;

class LembarJawabanController extends Controller
{
    // Function untuk menampilkan lembar_jawaban.index
    public function index(Request $request)
{
    // Ambil query parameter untuk filter
    $namaSiswa = $request->input('nama_siswa');
    $kodeAssignment = $request->input('kode_assignment');

    // Ambil semua soal
    $soals = Soal::all();

    // Query lembar jawabans dengan relasi yang diperlukan
    $lembarJawabans = LembarJawaban::with(['soal.assignment', 'soal.assignment.penilaians', 'soal.assignment.penilaians.siswa'])
        ->when($namaSiswa, function ($query, $namaSiswa) {
            // Filter berdasarkan nama siswa
            return $query->whereHas('soal.assignment.penilaians.siswa', function ($query) use ($namaSiswa) {
                $query->where('name', 'like', '%' . $namaSiswa . '%');
            });
        })
        ->when($kodeAssignment, function ($query, $kodeAssignment) {
            // Filter berdasarkan kode assignment
            return $query->whereHas('soal.assignment', function ($query) use ($kodeAssignment) {
                $query->where('kode_assignment', 'like', '%' . $kodeAssignment . '%');
            });
        })
        ->distinct('soal_id')
        ->get();

    // Kirim data soals ke view
    return view('lembar_jawaban.index', compact('lembarJawabans', 'soals'));
}



    // Function untuk menampilkan lembar_jawaban.detail
    public function detail($assignmentId, $siswaId)
    {
        // Ambil detail assignment dan jawaban siswa
        $assignment = Assignment::with(['soals', 'soals.lembarJawaban' => function ($query) use ($siswaId) {
            $query->where('siswa_id', $siswaId);
        }])->findOrFail($assignmentId);

        $siswa = Siswa::findOrFail($siswaId);

        return view('lembar_jawaban.detail', compact('assignment', 'siswa'));
    }

    // Function untuk mengupdate score pada soal esai
    public function updateScore(Request $request, $lembarJawabanId)
    {
        $lembarJawaban = LembarJawaban::findOrFail($lembarJawabanId);
        $lembarJawaban->score = $request->input('score');
        $lembarJawaban->save();

        return back()->with('success', 'Score updated successfully');
    }
}
