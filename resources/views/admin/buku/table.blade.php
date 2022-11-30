@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Buku</div>

                <div class="card-body">

                    <!-- Button Tambah buku -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                        Tambah Buku
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ url('buku') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Buku</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">ISBN</label>
                                            <input type="text" class="form-control" name="isbn">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Judul</label>
                                            <input type="text" class="form-control" name="judul">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Sinopsis</label>
                                            <input type="text" class="form-control" name="sinopsis">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Penerbit</label>
                                            <input type="text" class="form-control" name="penerbit">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Cover</label>
                                            <input type="file" class="form-control" name="cover">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Sinopsis</label>
                                            <select name="kategori_id" class="form-control">
                                                @foreach ($kategoris as $kategori)
                                                    <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ISBN</th>
                                <th scope="col">Judul</th>
                                <th scope="col" @if(Auth::user()->role=='admin') style="width: 35%" @else style="width: 40%" @endif>Sinopsis</th>
                                <th scope="col">Penerbit</th>
                                <th scope="col">Cover</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Editor</th>
                                <th scope="col" @if(Auth::user()->role=='admin') style="width: 25%" @else style="width: 15%" @endif>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $data->isbn }}</td>
                                <td>{{ $data->judul }}</td>
                                <td>{{ $data->sinopsis }}</td>
                                <td>{{ $data->penerbit }}</td>
                                <td><img src="{{ asset('storage/'.$data->cover) }}" alt="" class="img img-thumbnail"></td>
                                <td>{{ $data->kategori->name }}</td>
                                <td>{{ $data->user->name }}</td>
                                <td>
                                    @if(Auth()->user()->role == 'admin')
                                        @if ($data->tampil == true)
                                            <a href="{{ url('buku/tampil/'.$data->id) }}" class="btn btn-primary">Hide</a>
                                        @else
                                            <a href="{{ url('buku/tampil/'.$data->id) }}" class="btn btn-primary">Show</a>
                                        @endif
                                    @endif

                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $loop->iteration }}">Edit</button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="editModal{{ $loop->iteration }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ url('buku/'.$data->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('put')
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit buku</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">ISBN</label>
                                                            <input type="text" class="form-control" name="isbn" value="{{ $data->isbn }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Judul</label>
                                                            <input type="text" class="form-control" name="judul" value="{{ $data->judul }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Sinopsis</label>
                                                            <input type="text" class="form-control" name="sinopsis" value="{{ $data->sinopsis }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Penerbit</label>
                                                            <input type="text" class="form-control" name="penerbit" value="{{ $data->penerbit }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Cover</label>
                                                            <input type="file" class="form-control" name="cover">
                                                            <input type="hidden" class="form-control" name="oldCover" value="{{ $data->cover }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Sinopsis</label>
                                                            <select name="kategori_id" class="form-control">
                                                                @foreach ($kategoris as $kategori)
                                                                    <option value="{{ $kategori->id }}" @selected($data->kategori_id == $kategori->id)>{{ $kategori->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-danger" onclick="event.preventDefault();
                                    document.getElementById('delete-form{{ $loop->iteration }}').submit();">Delete</button>

                                    <form id="delete-form{{ $loop->iteration }}" action="{{ url('buku/'.$data->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
