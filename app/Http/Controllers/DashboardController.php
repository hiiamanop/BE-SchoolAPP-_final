<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guru;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //use Carbon\Carbon;

    public function index()
    {
        $events = Event::with('assignment')->get();

        // Determine the current semester
        $currentMonth = Carbon::now()->month;
        $semester = ($currentMonth >= 1 && $currentMonth <= 7) ? 'Genap' : 'Ganjil';

        // Get the next event and calculate the time remaining
        $jumlahSiswa = Siswa::count(); // Get the total count of registered students
        $jumlahGuru = Guru::count(); // Get the total count of registered teacher
        $nextEvent = Event::where('tanggal', '>', Carbon::now())
            ->orderBy('tanggal', 'asc')
            ->first();

        $timeToNextEvent = $nextEvent ? Carbon::now()->diffForHumans($nextEvent->tanggal, true) : null;

        return view('dashboard.index', compact('events', 'nextEvent', 'timeToNextEvent', 'jumlahSiswa', 'jumlahGuru', 'semester'));
    }
}
