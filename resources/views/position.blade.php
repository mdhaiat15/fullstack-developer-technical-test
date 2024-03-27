@extends('layout.app')

@section('css')
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Jabatan</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Jabatan</li>
    </ol>
</div>
@endsection
@section('content')
<div class="card sm mb-4">
    <button type="button" class="btn btn-xs btn-primary float-right add" id="btn-create-post">Tambah Data Jabatan</button>
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
                    <h5 class="modal-title">New Position</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id">

                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" class="form-control input-sm">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-name"></div>
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
    function showAlertWithAutoClose(selector, message)
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

        let table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('position.index') }}",
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false, className: "text-center"},
                { data: 'name' },
                { data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        btnAdd.click(function(){
            modal.modal();
            form.trigger('reset');
            modal.find('.modal-title').text('Tambah Data Jabatan');
            btnSave.show();
            btnUpdate.hide();
        });

        btnSave.click(function(e){
            e.preventDefault();
            var data = form.serialize();
            $.ajax({
                type: "POST",
                url: "",
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
                    if (error.responseJSON) { // Check if responseJSON is defined
                        if (error.responseJSON.name && error.responseJSON.name[0]) {
                            showAlertWithAutoClose('#alert-name', error.responseJSON.name[0]);
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

            var rowData =  table.row($(this).parents('tr')).data();

            form.find('input[name="id"]').val(rowData.id);
            form.find('input[name="name"]').val(rowData.name);

            modal.modal();
        });

        btnUpdate.click(function(){
            if(!confirm("Are you sure?")) return;
            var formData = form.serialize()+'&_method=PUT&_token='+token;
            var updateId = form.find('input[name="id"]').val();
            $.ajax({
                type: "POST",
                url: "/position/" + updateId,
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
                    if (error.responseJSON) { // Check if responseJSON is defined
                        if (error.responseJSON.name && error.responseJSON.name[0]) {
                            showAlertWithAutoClose('#alert-name', error.responseJSON.name[0]);
                        }
                    }
                }
             });
        });

        $(document).on('click','.btn-delete',function(){
            if(!confirm("Are you sure?")) return;

            var rowid = $(this).data('rowid');
            var el = $(this);
            if(!rowid) return;

            $.ajax({
                type: "POST",
                dataType: 'JSON',
                url: "/position/" + rowid,
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
                            showAlertWithAutoClose('#alert-name', error.responseJSON.name[0]);
                        }
                    }
                }
             });
        });
    });
</script>
@endpush
