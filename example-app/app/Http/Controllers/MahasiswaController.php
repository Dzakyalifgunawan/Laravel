<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index(Request $request): View
    {
        //get posts
        $pagination=5;
        $mahasiswa = mahasiswa::latest()->paginate($pagination);

        //render view with posts
        return view('mahasiswa.index', compact('mahasiswa'))->with('i', ($request->input('page', 1) - 1)*$pagination);
    }

    public function create(): View
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'nim'     => 'required|min:11',
            'nama'     => 'required|min:11',
            'alamat'   => 'required|min:11',
            'tgl_lahir'
        ]);

        $date = $request->tgl_lahir;

        //create post
        mahasiswa::create([
            'tgl_lahir'     => $date,
            'nim'     => $request->nim,
            'nama'   => $request->nama,
            'alamat'   => $request->alamat,
        ]);

        //redirect to index
        return redirect()->route('mahasiswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id): View
    {
        //get post by ID
        $mahasiswa = mahasiswa::findOrFail($id);

        //render view with post
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function edit(string $id): View
    {
        //get post by ID
        $mahasiswa = mahasiswa::findOrFail($id);

        //render view with post
        return view('mahasiswa.edit', compact('mahasiswa'));
    }
    
    
    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'nim'     => 'required|min:11',
            'nama'     => 'required|min:11',
            'alamat'   => 'required|min:11',
            'tgl_lahir'
        ]);

        //get post by ID
        $mahasiswa = mahasiswa::findOrFail($id);

            //update mahasiswa 
            $date = $request->tgl_lahir;
            $mahasiswa->update([
                'nim'     =>  $request->nim,
                'nama'     =>  $request->nama,
                'alamat'   =>  $request->alamat,
                'tgl_lahir' => $date
            ]);

        //redirect to index
        return redirect()->route('mahasiswa.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
        {
            //get post by ID
            $mahasiswa = mahasiswa::findOrFail($id);
    
            //delete post
            $mahasiswa->delete();
    
            //redirect to index
            return redirect()->route('mahasiswa.index')->with(['success' => 'Data Berhasil Dihapus!']);
        }
}
