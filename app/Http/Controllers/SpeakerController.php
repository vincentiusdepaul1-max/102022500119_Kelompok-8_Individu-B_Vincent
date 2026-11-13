<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    // Menampilkan daftar data dan form (Create / Edit) dalam satu halaman
    public function index(Request $request)
    {
        $speaker = Speaker::latest('id')->get();
        
        // Mengambil data speaker yang akan diedit jika parameter ?edit=id tersedia
        $speakerToEdit = null;
        if ($request->has('edit')) {
            $speakerToEdit = Speaker::find($request->edit);
        }

        return view('speaker.index', compact('speaker', 'speakerToEdit'));
    }

    // Menyimpan data baru (Create)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:180',
            'email' => 'required|email|max:180|unique:speakers,email',
            'phone' => 'required|max:40',
            'role' => 'required|in:Keynote Speaker,Workshop Facilitator,Panelist,Guest Lecturer',
            'status' => 'required|in:Verified,Pending Review,On Leave',
            'current_institution' => 'required|max:180',
            'primary_domain' => 'required|max:180',
            'bio' => 'nullable',
            'skills' => 'nullable',
            'portfolio_url' => 'nullable|url|max:255',
        ]);

        Speaker::create($validated);

        return redirect()->route('speakers.index')->with('success', 'Speaker berhasil ditambahkan!');
    }

    // Memperbarui data (Update)
    public function update(Request $request, $id)
    {
        $speaker = Speaker::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|max:180',
            'email' => 'required|email|max:180|unique:speakers,email,' . $id,
            'phone' => 'required|max:40',
            'role' => 'required|in:Keynote Speaker,Workshop Facilitator,Panelist,Guest Lecturer',
            'status' => 'required|in:Verified,Pending Review,On Leave',
            'current_institution' => 'required|max:180',
            'primary_domain' => 'required|max:180',
            'bio' => 'nullable',
            'skills' => 'nullable',
            'portfolio_url' => 'nullable|url|max:255',
        ]);

        $speaker->update($validated);

        return redirect()->route('speakers.index')->with('success', 'Data speaker berhasil diperbarui!');
    }

    // Menghapus data (Delete)
    public function destroy($id)
    {
        Speaker::destroy($id);

        return redirect()->route('speakers.index')->with('success', 'Speaker berhasil dihapus!');
    }
}