<?php

namespace App\Http\Controllers;

use App\Models\makanan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MakananController extends Controller
{
    public function index(): View
    {
        //get makanan
        $makanan = makanan::latest()->paginate(5);

        //render view with makanan
        return view('makanan.index', compact('makanan'));
    }

    public function create(): View
    {
        return view('makanan.create');
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
        makanan::create([
            'image'     => $image->hashName(),
            'nama'     => $request->nama,
            'harga'   => $request->input('harga')
        ]);

        //redirect to index
        return redirect()->route('makan.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id): View
    {
        //get makanan by ID
        $makanan = makanan::findOrFail($id);

        //render view with makanan
        return view('makanan.show', compact('makanan'));
    }

    public function edit(string $id): View
    {
        //get makanan by ID
        $makanan = makanan::findOrFail($id);

        //render view with makanan
        return view('makanan.edit', compact('makanan'));
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
        $makan = makanan::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            //delete old image
            Storage::delete('public/posts/'.$makan->image);

            //update post with new image
            $makan->update([
                'image'     => $image->hashName(),
                'nama'     => $request->nama,
                'harga'   => $request->input('harga')
            ]);

        } else {

            //update post without image
            $makan->update([
                'nama'     => $request->nama,
                'harga'   => $request->input('harga')
            ]);
        }

        //redirect to index
        return redirect()->route('makan.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
    {
        //get post by ID
        $makanan = makanan::findOrFail($id);

        //delete image
        Storage::delete('public/posts/'. $makanan->image);

        //delete post
        $makanan->delete();

        //redirect to index
        return redirect()->route('makan.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
