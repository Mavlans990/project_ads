@extends('layouts.main')

@section('container')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom">
            <h1 class="h2">Tambah Data Karyawan</h1>
        </div>
        
        <div class="col-md-8">
            <form action="/karyawan" method="post">
                @csrf
                {{-- <input type="hidden" name="users_id" value="1"> --}}
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required value="{{ old('nama') }}">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" cols="30" rows="5">{{ old('alamat') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required value="{{ old('tgl_lahir') }}">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Tanggal Bergabung</label>
                    <input type="date" name="tgl_bergabung" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required value="{{ old('tgl_bergabung') }}">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="/karyawan" class="btn btn-danger">Back</a>
            </form>
        </div>
    </div>
</div>
@endsection