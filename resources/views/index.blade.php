@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Index') }}</div>

                <div class="card-body">
                    <div class="row">
                        @foreach ($datas as $data)
                            <div class="card m-3" style="width: 18rem;">
                                <img src="{{ asset('storage/'.$data->cover) }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h2 class="card-title">{{ $data->judul }}</h2>
                                    <p class="text-secondary">Editor : {{ $data->user->name }}</p>
                                    <p class="text-secondary">Kategori : {{ $data->kategori->name }}</p>
                                    <p class="text-secondary">Penerbit : {{ $data->penerbit }}</p>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $loop->iteration }}">
                                        Detail
                                    </button>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="detailModal{{ $loop->iteration }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $data->judul }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ asset('storage/'.$data->cover) }}" alt="" class="img img-fluid">
                                            <p>
                                                {{ $data->sinopsis }}
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
