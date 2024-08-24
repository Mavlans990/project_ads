@extends('layouts.main')

@section('container')
<div class="row justify-content-center">
    <div class="col-md-10">
        <h2 class="mt-2 mb-4">Data Cuti</h2>
        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nomor Induk</th>
                        <th scope="col">Tanggal Cuti</th>
                        <th scope="col">Lama Cuti</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cutis as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->nmr_induk }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->tgl_cuti)->format('d - M - Y') }}</td>
                        <td>{{ $row->lama_cuti }}</td>
                        <td>{{ $row->keterangan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
