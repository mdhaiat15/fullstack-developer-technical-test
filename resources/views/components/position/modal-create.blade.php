<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH POST</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="name" class="control-label">Nama Posisi</label>
                    <input type="text" class="form-control" id="name" name="name" >
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-name"></div>
                </div>

                <div class="form-group">
                    <label for="departemen" class="control-label">Departemen</label>
                    <input type="text" class="form-control" id="departemen" name="departemen" >
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-departemen"></div>
                </div>
                

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="button" class="btn btn-primary" id="store">SIMPAN</button>
            </div>
        </div>
    </div>
</div>

<script>
    //button create post event
    $('#btn-create-post').on('click', function() {

        //open modal
        $('#modal-create').modal('show');
    });

    //action create post
    $('#store').click(function(e) {
        e.preventDefault();

        //define variable
        let name   = $('#name').val();
        let departemen = $('#departemen').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: `/position`,
            type: "POST",
            cache: false,
            data: {
                "name": name,
                "departemen": departemen,
                "_token": token
            },
            success:function(response){

                //show success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });

                //data post
                let post = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.name}</td>
                        <td>${response.data.departemen}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                            <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                        </td>
                    </tr>
                `;
                
                //append to table
                $('#table-posts').prepend(post);
                
                //clear form
                $('#name').val('');
                $('#departemen').val('');

                //close modal
                $('#modal-create').modal('hide');
                

            },
            error:function(error){
                
                if (error.responseJSON && error.responseJSON.name && error.responseJSON.name[0]) {
                    // Menampilkan alert
                    $('#alert-name').removeClass('d-none').addClass('d-block');
                    // Menambahkan pesan ke alert
                    $('#alert-name').html(error.responseJSON.name[0]);
                }

                // Memeriksa apakah properti 'departemen' ada di dalam responseJSON
                if (error.responseJSON && error.responseJSON.departemen && error.responseJSON.departemen[0]) {
                    // Menampilkan alert
                    $('#alert-departemen').removeClass('d-none').addClass('d-block');
                    // Menambahkan pesan ke alert
                    $('#alert-departemen').html(error.responseJSON.departemen[0]);
                }

            }

        });

    });

</script>