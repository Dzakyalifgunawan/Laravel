<?php

namespace App\Http\Controllers;

use App\Models\alat;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlatController extends Controller
{
    public function index(): View
    {
        //get alat
        $alat = alat::latest()->paginate(5);

        //render view with alat
        return view('alat.index', compact('alat'));
    }

    public function create(): View
    {
        return view('alat.create');
    }

    
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'image'     => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'nama'     => 'required|min:5',
            'harga' => 'required|numeric',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        //create post
        alat::create([
            'image'     => $image->hashName(),
            'nama'     => $request->nama,
            'harga'   => $request->input('harga')
        ]);

        //redirect to index
        return redirect()->route('alat.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id): View
    {
        //get alat by ID
        $alat = alat::findOrFail($id);

        //render view with alat
        return view('alat.show', compact('alat'));
    }

    public function edit(string $id): View
    {
        //get alat by ID
        $alat = alat::findOrFail($id);

        //render view with alat
        return view('alat.edit', compact('alat'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'image'     => 'image|mimes:jpeg,jpg,png|max:2048',
            'nama'     => 'required|min:5',
            'harga'   => 'required|numeric'
        ]);

        //get post by ID
        $alat = alat::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            //delete old image
            Storage::delete('public/posts/'.$alat->image);

            //update post with new image
            $alat->update([
                'image'     => $image->hashName(),
                'nama'     => $request->nama,
                'harga'   => $request->input('harga')
            ]);

        } else {

            //update post without image
            $alat->update([
                'nama'     => $request->nama,
                'harga'   => $request->input('harga')
            ]);
        }

        //redirect to index
        return redirect()->route('alat.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
    {
        //get post by ID
        $alat = alat::findOrFail($id);

        //delete image
        Storage::delete('public/posts/'. $alat->image);

        //delete post
        $alat->delete();

        //redirect to index
        return redirect()->route('alat.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
