@extends('layouts.templates')
@php
 $pretitle ='Data';
 $title ='Core Business';
@endphp
@section('content')
<h1>Data Core Business</h1>

        <table id="table-default" class="table table-responsive table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Core Business</th>
                    <th width="280px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($coreBusinesses as $coreBusiness)
                <tr>
                    <td>{{ $coreBusiness->name }}</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCoreBusinessModal" data-corebusiness-id="{{ $coreBusiness->id }}" data-corebusiness-name="{{ $coreBusiness->name }}">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCoreBusinessModal" data-corebusiness-id="{{ $coreBusiness->id }}">
                            Hapus
                        </button>
                    </td>
                </tr>
                @endforeach --}}
            </tbody>
        </table>

        <!-- Modal Tambah Core Business -->
        <div class="modal fade" id="createCoreBusinessModal" tabindex="-1" aria-labelledby="createCoreBusinessModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('core-business.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createCoreBusinessModalLabel">Tambah Data Core Business</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Nama Core Business</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit Core Business -->
<div class="modal fade" id="editCoreBusinessModal" tabindex="-1" aria-labelledby="editCoreBusinessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editCoreBusinessModalLabel">Edit Core Business</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editCoreBusinessForm" method="POST">
          <div class="modal-body">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="editCoreBusinessName">Name</label>
              <input type="text" class="form-control" id="editCoreBusinessName" name="name" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  

@endsection
@push('page-action')
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCoreBusinessModal">
    Tambah Core Business
</button>
@endpush