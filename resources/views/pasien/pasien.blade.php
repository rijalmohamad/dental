@extends('adminlte::page')

@section('title', 'Data Pasien')

@section('content_header')
    <h1 class="m-0 text-dark">Data Pasien</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        Data Pasien
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
                            <th class="">Nama Pasien</th>
                            <th class="text-center">No. RM</th>
                            <th class="text-center">No. Hp</th>
                            <th class="text-center">Tgl.Periksa</th>
                            <th class="">Keluhan</th>
                            <th class="text-center">TD</th>
                            <th class="text-center">GD</th>
                            <th class="">Diagnosa</th>
                            <th class="">Keterangan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
            <strong>Copyright ©  Dental.</strong> All rights reserved. <div class="float-right d-none d-sm-inline-block"> <b>Version</b> 1.0.0</div>
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
                ajax: "{{ route('pasien.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center'},
                    {data: 'nama_pasien', name: 'nama_pasien'},
                    {data: 'no_rm', name: 'no_rm', class: 'text-center'},
                    {data: 'no_hp', name: 'no_hp', class: 'text-center'},
                    {data: 'tgl_periksa', name: 'tgl_periksa',class: 'text-center'},
                    {data: 'keluhan', name: 'keluhan'},
                    {data: 'td', name: 'td', class: 'text-center'},
                    {data: 'gd', name: 'gd', class: 'text-center'},
                    {data: 'diagnosa', name: 'diagnosa'},
                    {data: 'keterangan', name: 'keterangan'},
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
            $.get("{{ route('pasien.index') }}" +'/' + id +'/edit', function (data) {
                $('#modelHeading').html("Edit  Pasien");
                $('#savedata').val("update");
                $('#modal-data-pasien').modal('show');
                $('#id').val(data.id);

                $('#nama_pasien').val(data.nama_pasien);
                $('#no_rm').val(data.no_rm);
                $('#no_hp').val(data.no_hp);
                $('#tgl_periksa').val(data.tgl_periksa);
                $('#keluhan').val(data.keluhan);
                $('#td').val(data.td);
                $('#gd').val(data.gd);
                $('#diagnosa').val(data.diagnosa);
                $('#keterangan').val(data.keterangan);
            });
        };

        function postData(e) {
            console.log('save');
            // e.preventDefault();
            // $(this).html('Sending..')
        
            $.ajax({
            data: $('#postForm').serialize(),
            url: "{{ route('pasien.store') }}",
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
                url: "{{ route('pasien.store') }}"+'/'+id,
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
                                                <label for="exampleInputName">Nama Pasien</label>
                                                <input type="text" class="form-control @error('nama_pasien') is-invalid @enderror" id="nama_pasien" placeholder="" name="nama_pasien" value="{{old('nama_pasien')}}">
                                                @error('nama_pasien') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail">No.RM</label>
                                                <input type="text" class="form-control @error('no_rm') is-invalid @enderror" id="no_rm" placeholder="" name="no_rm" value="{{old('no_rm')}}">
                                                @error('no_rm') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail">No.HP</label>
                                                <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" placeholder="" name="no_hp" value="{{old('no_hp')}}">
                                                @error('no_hp') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail">Tgl.Periksa</label>
                                                <input type="date" class="form-control @error('tgl_periksa') is-invalid @enderror" id="tgl_periksa" placeholder="" name="tgl_periksa" value="{{old('tgl_periksa')}}">
                                                @error('tgl_periksa') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail">Keluhan</label>
                                                <textarea class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" placeholder="" name="keluhan" value="{{old('keluhan')}}"></textarea>
                                                @error('keluhan') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail">TD</label>
                                                <input type="text" class="form-control @error('td') is-invalid @enderror" id="td" placeholder="" name="td" value="{{old('td')}}">
                                                @error('td') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail">GD</label>
                                                <input type="text" class="form-control @error('gd') is-invalid @enderror" id="gd" placeholder="" name="gd" value="{{old('gd')}}">
                                                @error('gd') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail">Diagnosa</label>
                                                <input type="text" class="form-control @error('diagnosa') is-invalid @enderror" id="diagnosa" placeholder="" name="diagnosa" value="{{old('diagnosa')}}">
                                                @error('diagnosa') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail">Keterangan</label>
                                                <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" placeholder="" name="keterangan" value="{{old('keterangan')}}">
                                                @error('keterangan') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>

                                        </div>

                                        
                                    </div>
                                </div>
                            </div>


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