<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;

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
        $jumlahSiswa = User::where('role_id', 3)->count(); // Get the total count of users with role_id = 3 (siswa)
        $jumlahGuru = User::where('role_id', 2)->count(); // Get the total count of users with role_id = 2 (guru)

        $nextEvent = Event::where('tanggal', '>', Carbon::now())
            ->orderBy('tanggal', 'asc')
            ->first();

        $timeToNextEvent = $nextEvent ? Carbon::now()->diffForHumans($nextEvent->tanggal, true) : null;
        // Ambil semua event dengan relasi assignment
        $events = Event::with('assignment')->get();
        // Ambil semua assignment untuk dropdown di modal
        $assignments = Assignment::all();

        return view('dashboard.index', compact('events', 'nextEvent', 'timeToNextEvent', 'jumlahSiswa', 'jumlahGuru', 'semester', 'assignments'));
    }
}
