@extends('layout.app')

@section('css')
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Karyawan</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Karyawan</li>
    </ol>
</div>
@endsection
@section('content')
<div class="card sm mb-4">
    <button type="button" class="btn btn-xs btn-primary float-right add" id="btn-create-post">Tambah Data Karyawan</button>
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive p-3">
            <table class="table align-items-center table-flush" id="dataTable">
              <thead class="thead-light">
                <tr>
                  <th>No.</th>
                  <th>Name</th>
                  <th>NIP</th>
                  <th>Jabatan</th>
                  <th>Departemen</th>
                  <th>Tanggal Lahir</th>
                  <th>Tahun Lahir</th>
                  <th>Alamat</th>
                  <th>No. Telepon</th>
                  <th>Agama</th>
                  <th>Status</th>
                  <th width="100px">Action</th>
                </tr>
              </thead>
            </table>
          </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form class="form" action="" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control input-sm">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-name"></div>
                    </div>
                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="text" name="nip" class="form-control input-sm">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nip"></div>
                    </div>
                    <div class="form-group">
                        <label for="position_id">Jabatan</label>
                        <select class="form-control" id="position_id" name="position_id">
                            @foreach($listDataJabatan as $id => $jabatan)
                                <option value="{{ $id }}">{{ $jabatan }}</option>
                            @endforeach
                        </select>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-position_id"></div>
                    </div>
                    <div class="form-group">
                        <label for="departemen">Departemen</label>
                        <input type="text" name="departemen" class="form-control input-sm">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-departemen"></div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="text" name="tgl_lahir" class="form-control input-sm">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tgl_lahir"></div>
                    </div>
                    <div class="form-group">
                        <label for="thn_lahir">Tahun Lahir</label>
                        <input type="text" name="thn_lahir" class="form-control input-sm">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-thn_lahir"></div>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="alamat"></textarea>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-alamat"></div>
                    </div>
                    <div class="form-group">
                        <label for="tlp">Nomor Telepon</label>
                        <input type="text" name="tlp" class="form-control input-sm">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tlp"></div>
                    </div>
                    <div class="form-group">
                        <label for="agama">Agama</label>
                        @foreach($listDataAgama as $key => $agama)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="agama" id="agama{{ $loop->iteration }}" value="{{ $key }}" {{ $loop->first ? 'checked' : '' }}>
                                <label class="form-check-label" for="agama{{ $loop->iteration }}">{{ $agama }}</label>
                            </div>
                        @endforeach
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-status"></div>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        @foreach($listDataStatus as $key => $status)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status{{ $loop->iteration }}" value="{{ $key }}" {{ $loop->first ? 'checked' : '' }}>
                                <label class="form-check-label" for="status{{ $loop->iteration }}">{{ $status }}</label>
                            </div>
                        @endforeach
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-status"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-save">Save</button>
                    <button type="button" class="btn btn-primary btn-update">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('js')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    function timerAlert(selector, message)
    {
        $(selector).removeClass('d-none').addClass('d-block').html(message);
        setTimeout(function() {
            $(selector).removeClass('d-block').addClass('d-none').html('');
        }, 2000);
    }

    $(document).ready(function() {
        let token = $("meta[name='csrf-token']").attr("content");
        let modal = $('.modal');
        let form = $('.form');
        let btnAdd = $('.add');
        let btnSave = $('.btn-save');
        let btnUpdate = $('.btn-update');

        let name   = $('#name').val();
        let nip = $('#nip').val();
        let positionId = $('#position_id').val();
        let departemen = $('#departemen').val();
        let tglLahir = $('#tgl_lahir').val();
        let thnLahir = $('#thn_lahir').val();
        let alamat = $('#alamat').val();
        let tlp = $('#tlp').val();
        let agama = $('#agama').val();
        let status = $('#status').val();

        let table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('employee.index') }}",
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false, className: "text-center"},
                { data: 'name' },
                { data: 'nip' },
                { data: 'position.name', name: 'position.name' },
                { data: 'departemen' },
                { data: 'tgl_lahir' },
                { data: 'thn_lahir' },
                { data: 'alamat' },
                { data: 'tlp' },
                { data: 'agama_label', name: 'agama_label' },
                { data: 'status_label', name: 'status_label' },
                { data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        btnAdd.click(function(){
            modal.modal();
            form.trigger('reset');
            modal.find('.modal-title').text('Add New');
            btnSave.show();
            btnUpdate.hide();
        });

        btnSave.click(function(e){
            e.preventDefault();
            let data = form.serialize();
            $.ajax({
                type: "POST",
                url: "/employee",
                data: data+'&_token='+token,
                success: function (data) {
                    if (data.success) {
                        table.draw();
                        form.trigger("reset");
                        modal.modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: `${data.message}`,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                },
                error: function(error) {
                    if (error.responseJSON) {
                        if (error.responseJSON.name && error.responseJSON.name[0]) {
                            timerAlert('#alert-name', error.responseJSON.name[0]);
                        }
                        if (error.responseJSON.positionId && error.responseJSON.positionId[0]) {
                            timerAlert('#alert-position_id', error.responseJSON.positionId[0]);
                        }
                        if (error.responseJSON.nip && error.responseJSON.nip[0]) {
                            timerAlert('#alert-nip', error.responseJSON.nip[0]);
                        }
                        if (error.responseJSON.departemen && error.responseJSON.departemen[0]) {
                            timerAlert('#alert-departemen', error.responseJSON.departemen[0]);
                        }
                        if (error.responseJSON.tglLahir && error.responseJSON.tglLahir[0]) {
                            timerAlert('#alert-tgl_lahir', error.responseJSON.tglLahir[0]);
                        }
                        if (error.responseJSON.thnLahir && error.responseJSON.thnLahir[0]) {
                            timerAlert('#alert-thn_lahir', error.responseJSON.thnLahir[0]);
                        }
                        if (error.responseJSON.alamat && error.responseJSON.alamat[0]) {
                            timerAlert('#alert-alamat', error.responseJSON.alamat[0]);
                        }
                        if (error.responseJSON.tlp && error.responseJSON.tlp[0]) {
                            timerAlert('#alert-tlp', error.responseJSON.tlp[0]);
                        }
                        if (error.responseJSON.agama && error.responseJSON.agama[0]) {
                            timerAlert('#alert-agama', error.responseJSON.agama[0]);
                        }
                        if (error.responseJSON.status && error.responseJSON.status[0]) {
                            timerAlert('#alert-status', error.responseJSON.status[0]);
                        }
                    }
                }
             });
        });

        $(document).on('click','.btn-edit',function(){
            btnSave.hide();
            btnUpdate.show();

            modal.find('.modal-title').text('Update Record');
            modal.find('.modal-footer button[type="submit"]').text('Update');

            let rowData =  table.row($(this).parents('tr')).data();

            form.find('input[name="id"]').val(rowData.id);
            form.find('input[name="name"]').val(rowData.name);
            form.find('input[name="nip"]').val(rowData.nip);
            form.find('input[name="position_id"]').val(rowData.position_id);
            form.find('input[name="departemen"]').val(rowData.departemen);
            form.find('input[name="tgl_lahir"]').val(rowData.tgl_lahir);
            form.find('input[name="thn_lahir"]').val(rowData.thn_lahir);
            form.find('textarea[name="alamat"]').val(rowData.alamat);
            form.find('input[name="tlp"]').val(rowData.tlp);

            form.find('input[name="agama"]').each(function() {
                if ($(this).val() == rowData.agama) {
                    $(this).prop('checked', true);
                } else {
                    $(this).prop('checked', false);
                }
            });

            form.find('input[name="status"]').each(function() {
                if ($(this).val() == rowData.status) {
                    $(this).prop('checked', true);
                } else {
                    $(this).prop('checked', false);
                }
            });

            modal.modal();
        });

        btnUpdate.click(function(){
            if(!confirm("Are you sure?")) return;
            let formData = form.serialize()+'&_method=PUT&_token='+token;
            let updateId = form.find('input[name="id"]').val();
            $.ajax({
                type: "POST",
                url: "/employee/" + updateId,
                data: formData,
                success: function (data) {
                    if (data.success) {
                        table.draw();
                        modal.modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: `${data.message}`,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                },
                error: function(error) {
                    if (error.responseJSON) {
                        if (error.responseJSON.name && error.responseJSON.name[0]) {
                            timerAlert('#alert-name', error.responseJSON.name[0]);
                        }
                        if (error.responseJSON.positionId && error.responseJSON.positionId[0]) {
                            timerAlert('#alert-position_id', error.responseJSON.positionId[0]);
                        }
                        if (error.responseJSON.nip && error.responseJSON.nip[0]) {
                            timerAlert('#alert-nip', error.responseJSON.nip[0]);
                        }
                        if (error.responseJSON.departemen && error.responseJSON.departemen[0]) {
                            timerAlert('#alert-departemen', error.responseJSON.departemen[0]);
                        }
                        if (error.responseJSON.tglLahir && error.responseJSON.tglLahir[0]) {
                            timerAlert('#alert-tgl_lahir', error.responseJSON.tglLahir[0]);
                        }
                        if (error.responseJSON.thnLahir && error.responseJSON.thnLahir[0]) {
                            timerAlert('#alert-thn_lahir', error.responseJSON.thnLahir[0]);
                        }
                        if (error.responseJSON.alamat && error.responseJSON.alamat[0]) {
                            timerAlert('#alert-alamat', error.responseJSON.alamat[0]);
                        }
                        if (error.responseJSON.tlp && error.responseJSON.tlp[0]) {
                            timerAlert('#alert-tlp', error.responseJSON.tlp[0]);
                        }
                        if (error.responseJSON.agama && error.responseJSON.agama[0]) {
                            timerAlert('#alert-agama', error.responseJSON.agama[0]);
                        }
                        if (error.responseJSON.status && error.responseJSON.status[0]) {
                            timerAlert('#alert-status', error.responseJSON.status[0]);
                        }
                    }
                }
             });
        });

        $(document).on('click','.btn-delete',function(){
            if(!confirm("Are you sure?")) return;

            let rowid = $(this).data('rowid');
            let el = $(this);
            if(!rowid) return;

            $.ajax({
                type: "POST",
                dataType: 'JSON',
                url: "/employee/" + rowid,
                data: {_method: 'delete',_token:token},
                success: function (data) {
                    if (data.success) {
                        table.row(el.parents('tr'))
                            .remove()
                            .draw();

                            Swal.fire({
                                icon: 'success',
                                title: `${data.message}`,
                                showConfirmButton: false,
                                timer: 2000
                            });
                    }
                },
                error: function(error) {
                    if (error.responseJSON) { // Check if responseJSON is defined
                        if (error.responseJSON.name && error.responseJSON.name[0]) {
                            timerAlert('#alert-name', error.responseJSON.name[0]);
                        }
                        if (error.responseJSON.departemen && error.responseJSON.departemen[0]) {
                            timerAlert('#alert-departemen', error.responseJSON.departemen[0]);
                        }
                    }
                }
             });
        });
    });
</script>
@endpush
