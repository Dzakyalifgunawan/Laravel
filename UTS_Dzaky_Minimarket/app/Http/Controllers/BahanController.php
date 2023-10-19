<?php

namespace App\Http\Controllers;

use App\Models\bahan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BahanController extends Controller
{
    public function index(): View
    {
        //get bahan
        $bahan = bahan::latest()->paginate(5);

        //render view with bahan
        return view('bahan.index', compact('bahan'));
    }

    public function create(): View
    {
        return view('bahan.create');
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
        bahan::create([
            'image'     => $image->hashName(),
            'nama'     => $request->nama,
            'harga'   => $request->input('harga')
        ]);

        //redirect to index
        return redirect()->route('bahan.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id): View
    {
        //get bahan by ID
        $bahan = bahan::findOrFail($id);

        //render view with bahan
        return view('bahan.show', compact('bahan'));
    }

    public function edit(string $id): View
    {
        //get bahan by ID
        $bahan = bahan::findOrFail($id);

        //render view with bahan
        return view('bahan.edit', compact('bahan'));
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
        $bahan = bahan::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            //delete old image
            Storage::delete('public/posts/'.$bahan->image);

            //update post with new image
            $bahan->update([
                'image'     => $image->hashName(),
                'nama'     => $request->nama,
                'harga'   => $request->input('harga')
            ]);

        } else {

            //update post without image
            $bahan->update([
                'nama'     => $request->nama,
                'harga'   => $request->input('harga')
            ]);
        }

        //redirect to index
        return redirect()->route('bahan.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
    {
        //get post by ID
        $bahan = bahan::findOrFail($id);

        //delete image
        Storage::delete('public/posts/'. $bahan->image);

        //delete post
        $bahan->delete();

        //redirect to index
        return redirect()->route('bahan.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
