@extends('adminlte::page')

@section('title', 'Data Pengguna')

@section('content_header')
    <h1 class="m-0 text-dark">Data Pengguna</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        Data User
                    </h3>
                    <div class="card-tools">
                        
                        <button class="btn btn-success"  onclick="addData()"><i class="fas fa-plus"></i>
                            Tambah Data</button>
                    </div>
                </div>

                <div class="card-body">

                    
<!-- 
                    <a href="{{route('users.create')}}" class="btn btn-primary mb-2">
                        Tambah
                    </a> -->



                    <table class="table table-hover table-bordered table-stripped " id="example2">
                        <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- @foreach($users as $key => $user)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                <center>
                                    <a href="{{route('users.edit', $user)}}"  class="btn btn-sm btn btn-primary btn_edit" onclick="updateData('11')"> <i class="fas fa-edit"></i> Ubah  </a>
                                    <a href="{{route('users.destroy', $user)}}"  class="btn btn-sm btn btn-danger btn_delete" onclick="notificationBeforeDelete(event, this)" > <i class="fa fa-trash"></i> Hapus  </a>
                                </center>

                                   
                                </td>
                            </tr>
                        @endforeach -->
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
            <strong>Copyright ©  Dental.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
@stop
    

@push('js')
    <form action="" id="delete-form" method="post">
        @method('delete')
        @csrf
    </form>

    <script>

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        $('#example2').DataTable({
            "responsive": true,
            processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]

        });


        function addData() {
            $('#savedata').val("create");
            $('#id').val('');
            $('#postForm').trigger("reset");
            $('#modelHeading').html("Input Pasien Baru");
            $('#modal-data-pasien').modal('show');
        };

       function editData(id) {
            console.log('edit');
            $.get("{{ route('users.index') }}" +'/' + id +'/edit', function (data) {
                $('#modelHeading').html("Edit  Pasien");
                $('#savedata').val("update");
                $('#modal-data-pasien').modal('show');
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
            });
        };

        function postData(e) {
            console.log('save');
            // e.preventDefault();
            // $(this).html('Sending..')
        
            $.ajax({
            data: $('#postForm').serialize(),
            url: "{{ route('users.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {

                
                $('#postForm').trigger("reset");
                $('#modal-data-pasien').modal('hide');

                saveSuccess('', '');
                $('#example2').DataTable().ajax.reload();
                   
                },
            error: function (data) {
                    console.log('Error:', data);
                    $('#savedata').html('Save Changes');

                    danger(data.status, data.statusText);
                }
            });
        };

        function deleteData(id) {

            $.ajax({
                type: "DELETE",
                url: "{{ route('users.store') }}"+'/'+id,
                success: function (data) {
                    saveSuccess('', '');
                    $('#example2').DataTable().ajax.reload();
                },
                error: function (data) {
                    danger(data.status, data.statusText);
                }
            });
        }




        function notificationBeforeDelete(event, id) {

            event.preventDefault();
            let el = 'delete-form';

           {
                Swal.fire({
                    icon: 'warning',
                    title: 'Apakah anda yakin akan hapus data ini?',
                    text: 'Data yang telah di hapus tidak dapat di kembalikan!',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    confirmButtonColor: '#7066e0',
                    cancelButtonColor: '#dc3545'
                }).then((result) => {
                    if (result.isConfirmed) {
                       
                        // document.getElementById('delete-form').submit();
                        deleteData(id);
                    }
                });
            }

            // event.preventDefault();
            // if (confirm('Apakah anda yakin akan menghapus data ? ')) {
            //     $("#delete-form").attr('action', $(el).attr('href'));
            //     $("#delete-form").submit();
            // }
        }


        function danger(title, text) {
            event.preventDefault();

            toast_show('error', text);

            Swal.fire({
                icon: 'error',
                title: title,
                text: text,
                showCancelButton: false,
                confirmButtonColor: '#dc3545',
            });
        }

        function saveSuccess(title, text) {
            event.preventDefault();

            toast_show('success', text);

            Swal.fire({
                icon: 'success',
                title: title,
                text: text,
                showCancelButton: false,
                confirmButtonColor: '#28a745',
            });
        }


    </script>
    
@endpush


            <div class="modal fade" id="modal-data-pasien" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="modelHeading">Data Pasien</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">

                        <form  id="postForm" name="postForm"  >
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">

                                           <input type="hidden" name="id" id="id">

                                            <div class="form-group">
                                                <label for="exampleInputName">Nama</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nama lengkap" name="name" value="{{old('name')}}">
                                                @error('name') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail">Username</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Masukkan Email" name="email" value="{{old('email')}}">
                                                @error('email') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword">Password</label>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" name="password">
                                                @error('password') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword">Konfirmasi Password</label>
                                                <input type="password" class="form-control" id="confirm_password" placeholder="Konfirmasi Password" name="password_confirmation">
                                            </div>

                                        </div>

                                        
                                    </div>
                                </div>
                            </div>


							<!-- <form id="form-data-pasien">
                            <input type="hidden" class="form-control" id="id_pasien" name="id_pasien" placeholder="Nama Pasien">
								<div class="form-group">
									<label>Nama Pasien</label>
									<input type="text" class="form-control" id="nama_pasien" name="nama_pasien" placeholder="Nama Pasien">
                                        <small class=" clear-error bold text-danger"></small>
								</div>
								<div class="form-group">
									<label>NIK KTP</label>
									<input type="text" class="form-control" id="nik_ktp" name="nik_ktp" placeholder="NIK KTP">
                                        <small class=" clear-error bold text-danger"></small>
								</div>
								<div class="form-group">
									<label>No Telepon (WhatsApp)</label>
									<input type="text" class="form-control" id="no_telepon" name="no_telepon" placeholder="No Telepon (WhatsApp)">
                                        <small class=" clear-error bold text-danger"></small>
								</div>
								<div class="form-group">
									<label>Alamat</label>
									<textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat"></textarea>
                                        <small class=" clear-error bold text-danger"></small>
								</div>
							</form> -->

                        </div>
                        <div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button"  id="savedata" class="btn btn-primary" onclick="postData(this)">Simpan Data</button>
						</div>


                         </form>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>