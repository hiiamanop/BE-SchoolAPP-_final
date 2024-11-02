<?php

namespace App\Http\Controllers;

use App\Imports\KelasSiswaImport;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\User;
use Illuminate\Http\Request;
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
        $siswaList = User::where('role_id', 3)->get();

        // Query the KelasSiswa model
        if ($kelasId) {
            $kelasSiswaList = KelasSiswa::where('kelas_id', $kelasId)
                ->with('user', 'kelas')
                ->get();
        } else {
            $kelasSiswaList = KelasSiswa::with('user', 'kelas')->get();
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
        $siswaList = User::where('role', 3)->get();

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
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        KelasSiswa::create([
            'user_id' => $request->user_id,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->route('kelas_siswas.index')
            ->with('success', 'Siswa added to Kelas successfully!');
    }

    public function update(Request $request, KelasSiswa $kelasSiswa)
    {
        $request->validate([
            'user_id' => 'required|exists:user,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $kelasSiswa->update([
            'user_id' => $request->user_id,
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
