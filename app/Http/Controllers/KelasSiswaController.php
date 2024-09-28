<?php

namespace App\Http\Controllers;

use App\Imports\KelasSiswaImport;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\KelasSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class KelasSiswaController extends Controller
{
    /**
     * Display a listing of the students in a class.
     */
    public function index(Request $request)
    {
        // Get the selected kelas_id from the request
        $kelasId = $request->query('kelas_id');

        // Get the list of kelas and siswa for dropdowns
        $kelasList = Kelas::all();
        $siswaList = Siswa::all();

        // Query the KelasSiswa model
        if ($kelasId) {
            $kelasSiswaList = KelasSiswa::where('kelas_id', $kelasId)
                ->with('siswa', 'kelas')
                ->get();
        } else {
            $kelasSiswaList = KelasSiswa::with('siswa', 'kelas')->get();
        }

        return view('kelas_siswa.index', [
            'kelasSiswaList' => $kelasSiswaList,
            'kelasList' => $kelasList,
            'siswaList' => $siswaList
        ]);
    }

    /**
     * Show the form for assigning a student to a class.
     */
    public function create($kelasId)
    {
        // Fetch only siswas with the role of 'siswa' (role_id = 3)
        $siswas = Siswa::all();

        // Fetch all kelas for the dropdown
        $kelasList = Kelas::all();

        return view('kelas_siswa.create', compact('siswas', 'kelasList'));
    }

    /**
     * Store the newly assigned student in the class.
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        KelasSiswa::create([
            'siswa_id' => $request->siswa_id,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->route('kelas_siswas.index')
            ->with('success', 'Siswa added to Kelas successfully!');
    }

    public function update(Request $request, KelasSiswa $kelasSiswa)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $kelasSiswa->update([
            'siswa_id' => $request->siswa_id,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->route('kelas_siswas.index')
            ->with('success', 'Siswa added to Kelas successfully!');
    }

    /**
     * Remove the specified student from the class.
     */
    public function destroy($id)
    {
        $kelasSiswa = KelasSiswa::findOrFail($id);
        $kelasSiswa->delete();

        return redirect()->route('kelas_siswas.index')
            ->with('success', 'Siswa removed from Kelas successfully!');
    }

    public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|file|mimes:xlsx',
        ]);

        // Import the file using the KelasSiswaImport class
        Excel::import(new KelasSiswaImport, $request->file('file'));

        return redirect()->back()->with('success', 'KelasSiswa imported successfully.');
    }
}
