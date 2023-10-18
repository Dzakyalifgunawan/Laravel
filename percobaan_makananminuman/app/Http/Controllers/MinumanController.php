<?php

namespace App\Http\Controllers;

use App\Models\minuman;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MinumanController extends Controller
{
    public function index(): View
    {
        //get minuman
        $minuman = minuman::latest()->paginate(5);

        //render view with minuman
        return view('minuman.index', compact('minuman'));
    }

    public function create(): View
    {
        return view('minuman.create');
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
        minuman::create([
            'image'     => $image->hashName(),
            'nama'     => $request->nama,
            'harga'   => $request->input('harga')
        ]);

        //redirect to index
        return redirect()->route('minum.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id): View
    {
        //get minuman by ID
        $minuman = minuman::findOrFail($id);

        //render view with minuman
        return view('minuman.show', compact('minuman'));
    }

    public function edit(string $id): View
    {
        //get minuman by ID
        $minuman = minuman::findOrFail($id);

        //render view with minuman
        return view('minuman.edit', compact('minuman'));
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
        $minuman = minuman::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            //delete old image
            Storage::delete('public/posts/'.$minuman->image);

            //update post with new image
            $minuman->update([
                'image'     => $image->hashName(),
                'nama'     => $request->nama,
                'harga'   => $request->input('harga')
            ]);

        } else {

            //update post without image
            $minuman->update([
                'nama'     => $request->nama,
                'harga'   => $request->input('harga')
            ]);
        }

        //redirect to index
        return redirect()->route('minum.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
    {
        //get post by ID
        $minuman = minuman::findOrFail($id);

        //delete image
        Storage::delete('public/posts/'. $minuman->image);

        //delete post
        $minuman->delete();

        //redirect to index
        return redirect()->route('minum.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
