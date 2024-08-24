@extends('layouts.main')

@section('container')
<div class="row justify-content-center">
    <div class="col-md-10">
        <h2 class="mt-2 mb-4">Data Karyawan</h2>
        <div class="table-responsive small">
            <a href="/karyawan/create" class="btn btn-primary btn-sm mb-3">Tambah Data</a>
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nomor Induk</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Tanggal Lahir</th>
                        <th scope="col">Tanggal Bergabung</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($karyawans as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->nmr_induk }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->alamat }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->tgl_lahir)->format('d - M - Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->tgl_bergabung)->format('d - M - Y') }}</td>
                        <td>
                            <a href="/karyawan/{{ $row->nmr_induk }}/edit" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                            <form action="/karyawan/{{ $row->nmr_induk }}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah yakin menghapus data ini?')"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <hr class="my-5">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Tab 1</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Tab 2</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Tab 3</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent" style="margin-bottom: 10rem">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <h3 class="mt-2 mb-4">Data Karyawan yang pertama kali bergabung</h3>
                <div class="table-responsive small">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nomor Induk</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($karyawans_2 as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->nmr_induk }}</td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->alamat }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                <h3 class="mt-2 mb-4">Data Karyawan yang saat ini pernah mengambil cuti</h3>
                <div class="table-responsive small">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nomor Induk</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($karyawans_3 as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->nmr_induk }}</td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->alamat }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                <h3 class="mt-2 mb-4">Data sisa cuti setiap karyawan</h3>
                <div class="table-responsive small mb-5">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nomor Induk</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Sisa Cuti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($karyawans_4 as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row['nmr_induk'] }}</td>
                                <td>{{ $row['nama'] }}</td>
                                <td>{{ $row['sisa_cuti'] }} Hari</td>
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
