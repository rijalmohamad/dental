@extends('adminlte::page')

@section('title', 'Data Pengingat Pasien')

@section('content_header')
    <h1 class="m-0 text-dark">Data Pengingat Pasien</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">           


                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        Data Pengingat Pasien
                    </h3>
                    <div class="card-tools">
                        
                        <button class="btn btn-success"  onclick="addData()"><i class="fas fa-plus"></i>
                            Tambah Data</button>
                    </div>
                </div>

                <div class="card-body">

                    

                    <table class="table table-hover table-bordered table-stripped " id="example2">
                        <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="">Nama Pasien</th>
                            <th class="text-center">No Telepon (WhatsApp)</th>
                            <th class="text-center">Tanggal Kirim</th>
                            <th class="text-center">Kategori</th>
                            <th class="">Pesan</th>
                            <th class="text-center">Status Kirim</th>
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

        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
        theme: 'bootstrap4'
        });

        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#reservationdate1').datetimepicker({
            format: 'YYYY-MM-DD'
        });


        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        $('#example2').DataTable({
            "responsive": true,
            processing: true,
                serverSide: true,
                ajax: "{{ route('pengingat.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center'},
                    {data: 'nama_pasien', name: 'nama_pasien'},
                    {data: 'no_hp', name: 'no_hp', class: 'text-center'},
                    {data: 'tgl_kirim', name: 'tgl_kirim',class: 'text-center'},
                    {data: 'kategori', name: 'kategori'},
                    {data: 'pesan', name: 'pesan', class: 'text-center'},
                    {data: 'status', name: 'status', class: 'text-center'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}

                ]

        });


        let cariPsn = document.getElementsByClassName('cari-pasien');

        function addData() {
            for (var i = 0; i < cariPsn.length; i ++) {
                console.log('index', i);
                cariPsn[i].style.display = 'flex';
            }
            document.getElementById('is_pasien_baru').value =  1;//yes

            $('#savedata').val("create");
            $('#id').val('');
            $('#postForm').trigger("reset");
            $('#modelHeading').html("Data Pengingat Pasien");
            $('#modal-data-pasien').modal('show');
        };

       function editData(id) {
            console.log('edit');
            for (var i = 0; i < cariPsn.length; i ++) {
                console.log('index', i);
                cariPsn[i].style.display = 'none';
            }
            document.getElementById('is_pasien_baru').value =  0;//no

            $.get("{{ route('pengingat.index') }}" +'/' + id +'/edit', function (data) {
                $('#modelHeading').html("Edit  Data Pengingat Pasien");
                $('#savedata').val("update");
                $('#modal-data-pasien').modal('show');
                $('#id').val(data.id);

                $('#nama_pasien').val(data.nama_pasien);
                $('#no_hp').val(data.no_hp);
                $('#tgl_kirim').val(data.tgl_kirim);
                $('#kategori').val(data.kategori);
                $('#pesan').val(data.pesan);
                $('#status').val(data.status);
            });
        };

        function postData(e) {
            console.log('save');
            // e.preventDefault();
            // $(this).html('Sending..')
        
            $.ajax({
            data: $('#postForm').serialize(),
            url: "{{ route('pengingat.store') }}",
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
                url: "{{ route('pengingat.store') }}"+'/'+id,
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

        let pasien   = {!!$pasien!!};
        let selected = null;

        function pilihPasien(event) {
            selected = pasien.find((r) => r.id == event.value);
            console.log(selected);
        }

        function inToForm() {
            
            console.log(selected);
            
            if (selected) {
                document.getElementById('pasien_baru').checked =  false;//no
                document.getElementById('is_pasien_baru').value =  0;//no
                
                $('#nama_pasien').val(selected.nama_pasien);
                $('#no_rm').val(selected.no_rm);
                $('#no_hp').val(selected.no_hp);
                $('#tgl_periksa').val(selected.tgl_periksa);
                $('#keluhan').val(selected.keluhan);
                $('#td').val(selected.td);
                $('#gd').val(selected.gd);
                $('#diagnosa').val(selected.diagnosa);
                $('#keterangan').val(selected.keterangan);

            }
            
        }


        let psnBaru = document.getElementsByClassName('pasien-baru');

        for (var i = 0; i < psnBaru.length; i ++) {
            console.log('index', i);
            psnBaru[i].style.display = 'none';
        }

        
        function isBaru(event) {
            console.log(event.checked);

            document.getElementById('nama_pasien').readOnly = !event.checked;
            document.getElementById('no_hp').readOnly = !event.checked;
            document.getElementById('no_rm').readOnly = !event.checked;
            document.getElementById('keluhan').readOnly = !event.checked;
            document.getElementById('diagnosa').readOnly = !event.checked;
            document.getElementById('td').readOnly = !event.checked;
            document.getElementById('gd').readOnly = !event.checked;
            document.getElementById('keterangan').readOnly = !event.checked;

            document.getElementById('is_pasien_baru').value =  event.checked ? 1 : 0;

            
            

            for (var i = 0; i < psnBaru.length; i ++) {
                console.log('index', i);
                psnBaru[i].style.display = event.checked ? 'flex' : 'none';
            }

            $('#postForm').trigger("reset");
        }

        function kirimWA(id) {
            console.log('kirirm wa', id);
        }


    </script>
    
@endpush


    <div class="modal fade" id="modal-data-pasien" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Data Pengingat Pasien</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
						

                        <div class="modal-body">
          

                            <div class="row cari-pasien">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cari Data Pasien</label>
                                        <select class="form-control select2" style="width: 100%;height:auto!important"  onchange="pilihPasien(this)">
                                            @foreach($pasien as $k => $row)
                                            <option value="{{$row->id}}" > {{$row->nama_pasien}}</option>
                                            @endforeach
                                        </select>

                                        <input type="checkbox" id="pasien_baru" name="pasien_baru"  onclick="isBaru(this)"> Pasien Baru ?
                                    </div>
                                </div>
                                <div class="col-md-4" style="margin-top:32px;">
                                    <button type="button" class="btn btn-primary" id="btn_pilih" onclick="inToForm()">Pilih</button>
                                </div>
                            </div>
                            <hr>


							    
							<form id="postForm" name="postForm"  >
								
                            
                               <input type="hidden" id="is_pasien_baru" name="is_pasien_baru"> 
                               <input type="hidden" id="id" name="id"> 
                           

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Nama Pasien</label>
											<input type="text" class="form-control" readonly id="nama_pasien" name="nama_pasien" placeholder="Nama Pasien">
												<small class=" clear-error bold text-danger"></small>
										</div>
									</div>

                                    <div class="col-md-6">
										<div class="form-group">
											<label>No HP</label>
											<input type="text" class="form-control" readonly id="no_hp" name="no_hp" placeholder="No Telepon (WhatsApp)">
												<small class="clear-error bold text-danger"></small>
										</div>
									</div>
								</div>
							
                                <!-- pasien baeru -->

                                <div class="row pasien-baru">
									<div class="col-md-6">
										<div class="form-group">
											<label>No. RM</label>
											<input type="text" class="form-control" id="no_rm" name="no_rm" placeholder="No. RM">
												<small class=" clear-error bold text-danger"></small>
										</div>
									</div>

                                    <div class="col-md-6">
										<div class="form-group">
                                            <label>Tanggal Periksa</label>
                                            <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                                                <input type="text" name="tgl_periksa" id="tgl_periksa" class="form-control datetimepicker-input" data-target="#reservationdate1"/>
                                                <div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
										</div>
									</div>
								</div>
                                <div class="row pasien-baru">
									<div class="col-md-6">
										<div class="form-group">
											<label>Keluhan</label>
											<input type="text" class="form-control" id="keluhan" name="keluhan" placeholder="Keluhan">
												<small class=" clear-error bold text-danger"></small>
										</div>
									</div>

                                    <div class="col-md-6">
										<div class="form-group">
											<label>Diagnosa</label>
											<input type="text" class="form-control" id="diagnosa" name="diagnosa" placeholder="Diagnosa">
												<small class="clear-error bold text-danger"></small>
										</div>
									</div>
								</div>
                                <div class="row pasien-baru">
									<div class="col-md-6">
										<div class="form-group">
											<label>TD</label>
											<input type="text" class="form-control" id="td" name="td" placeholder="TD">
												<small class=" clear-error bold text-danger"></small>
										</div>
									</div>

                                    <div class="col-md-6">
										<div class="form-group">
											<label>GD</label>
											<input type="text" class="form-control" id="gd" name="gd" placeholder="GD">
												<small class="clear-error bold text-danger"></small>
										</div>
									</div>
								</div>

                                <div class="row pasien-baru">
									<div class="col-md-12">
										<div class="form-group">
											<label>Keterangan</label>
											<textarea class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan"></textarea>
												<small class=" clear-error bold text-danger"></small>
										</div>
									</div>
								</div>


                                <!-- end -->


								
								<hr>
								<div class="row">
									<div class="col-md-12">
                                        <div class="form-group">
                                            <label>Tanggal Kirim</label>
                                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                <input type="text" name="tgl_kirim" id="tgl_kirim" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Kategori </label>
											<select name="kategori" id="kategori" class="form-control">
											<option value="" selected="">-- Pilih Kategori --</option>
											<option value="1">Pengngat Pertemuan Berikutnya</option>
											<option value="2">Edukasi Tentang Perawatan Setelah Pencabutan</option>
											<option value="3">Edukasi Cara Menyikat Gigi</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Pesan</label>
											<textarea type="text" class="form-control" id="pesan" name="pesan" placeholder="Pesan"></textarea>
												<small class=" clear-error bold text-danger"></small>
										</div>
									</div>
								</div>
							</form>
						</div>


                        <div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button"  id="savedata" class="btn btn-primary" onclick="postData(this)">Simpan Data</button>
						</div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>