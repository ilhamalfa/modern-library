<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Buku::all();
        $datas1 = Kategori::all();

        return view('admin.buku.table', [
            'datas' => $datas,
            'kategoris' => $datas1
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'isbn' => 'required|unique:bukus',
            'judul' => 'required',
            'sinopsis' => 'required',
            'penerbit' => 'required',
            'cover' => 'image|required',
            'kategori_id' => 'required'
        ]);

        $validate['cover'] = $request->file('cover')->store('cover');
        $validate['user_id'] = Auth::user()->id;

        Buku::create($validate);

        return redirect('buku');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function show(Buku $buku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function edit(Buku $buku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buku $buku)
    {
        if(isset($request->cover)){
            $validate = $request->validate([
                'isbn' => 'required',
                'judul' => 'required',
                'sinopsis' => 'required',
                'penerbit' => 'required',
                'kategori_id' => 'required',
                'cover' => 'image|required'
            ]);

            unlink('storage/'.$request->oldCover);

            $validate['cover'] = $request->file('cover')->store('cover');
            $validate['user_id'] = Auth::user()->id;
    
            $buku->update($validate);
        }else{
            $validate = $request->validate([
                'isbn' => 'required',
                'judul' => 'required',
                'sinopsis' => 'required',
                'penerbit' => 'required',
                'kategori_id' => 'required'
            ]);

            $validate['user_id'] = Auth::user()->id;
    
            $buku->update($validate);
        }

        return redirect('buku');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buku $buku)
    {
        unlink('storage/'.$buku->cover);

        $buku->delete();
        
        return redirect('buku');
    }

    public function tampil($id)
    {
        $buku = Buku::find($id);
        
        if($buku->tampil == true){
            $buku->update([
                'tampil' => 0
            ]);
        }else{
            $buku->update([
                'tampil' => 1
            ]);
        }
        
        return redirect('buku');
    }
}
