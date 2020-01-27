<section>
    <div class="card">
        <div class="card-header">
            <h1>
                {{ $title }}
            </h1>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xl-12 text-right">
                    <a href="javascript:void(0)" id="btnAddUser" class="btn btn-success"><i class="fas fa-plus"></i> Tambah</a>
                </div>
            </div>
        <hr>
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped nowrap" style="width:100%" id="tableData">
                    <thead>
                       <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Loker</th>
                            <th>Witel</th>
                            <th>Kota</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr> 
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<form id="formUser">
    @csrf
  <div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="modalUser" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xl-6">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username">
                        <small class="text-danger" id="valid_username"></small>
                    </div>
                    <div class="form-group">
                        <label for="id_role">Role</label>
                        <select name="id_role" id="id_role" class="form-control">
                            @foreach ($role as $r)
                                <option value="{{ $r->id_role }}">{{ $r->nama_role }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="valid_id_role"></small>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <small class="text-danger" id="valid_keterangan"></small>
                        <textarea name="keteragan" id="keterangan" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xl-6">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama">
                        <small class="text-danger" id="valid_nama"></small>
                    </div>
                    <div class="form-group">
                        <label for="loker">Loker</label>
                        <select name="loker" id="loker" onchange="getPlasa()" class="form-control select2" style="width:100%">
                            <option value="">-- Pilih Loker --</option>
                            @foreach ($loker as $l)
                                <option value="{{ $l->nama_plasa }}">{{ $l->nama_plasa }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="valid_loker"></small>
                    </div>
                    <div class="form-group">
                        <label for="kota">Kota</label>
                        <input type="text" class="form-control" name="kota" id="kota" readonly>
                        <small class="text-danger" id="valid_kota"></small>
                    </div>
                    <div class="form-group">
                        <label for="witel">Witel</label>
                        <input type="text" class="form-control" name="witel" id="witel" readonly>
                        <small class="text-danger" id="valid_witel"></small>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="INACTIVE">INACTIVE</option>
                        </select>
                        <small class="text-danger" id="valid_status"></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-sm" onclick="tambah()" id="insert"><i class="fas fa-plus"></i> Simpan</button>
          <button type="button" class="btn btn-danger btn-sm" onclick="batal()" id="cancel"><i class="fas fa-times"></i> Cancel</button>
          <button type="button" class="btn btn-warning btn-sm" onclick="ubah()" id="update"><i class="fas fa-edit"></i> Update</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
    $(function(){
        loadData();
        
        $('#btnAddUser').click(function(){
            $('#modalUser').modal('show');
            $('#update').hide();
            $('#cancel').hide();
            $('#insert').show();
            $('#modalTitle').text('Tambah User');
            $('small').text('');
            $('#password').attr('disabled',false);
            $('#formUser').trigger('reset');
            setPlasa();
        })
    });

    function setPlasa(){
        var sess = '{{ session("id_role") }}';
        if(sess != 1){
            var plasa = '{{ session("plasa") }}';
            var valPlasa = $('#loker').val(plasa).trigger('change');
            getPlasa();

        }
    }

    function batal(){
        $('#cancel').hide();
        $('#update').hide();
        $('form').trigger('reset');
        $('#insert').show();
        $('small').text('');
    }

    function btnToUpdate(){
        $('#modalUser').modal('show')
        $('small').text('');
        $('#insert').hide();
        $('#update').show();
        $('#cancel').show();
    }
    
    function loadData(){
        $('#tableData').DataTable({
            asynchronous: true,
            processing: true, 
            destroy: true,
            ajax: {
                url: "{{ url('user/load') }}",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'id', searchable: false, orderable: true, className: 'text-center' },
                { name: 'nama'},
                { name: 'username'},
                { name: 'loker'},
                { name: 'witel'},
                { name: 'kota'},
                { name: 'status', className:'text-center'},
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 10 
        });
    }

    function tambah(){
        var formData = $('#formUser').serialize();
        $.ajax({
            url : '{{ url("user/insert") }}',
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : formData,
            method : 'POST',
            success:function(res){
                if(res.status == 200){
                    $('#modalUser').modal('hide');
                    $('#tableData').DataTable().ajax.reload(null, false);
                }else if(res.status == 401){
                    $.each(res.errors, function (i, val) {
                        $('#valid_'+i).text(val);
                    });
                }else{
                    alert(res.result);
                } 
            }
        })
    }

    function show(id){
        btnToUpdate();
        $.ajax({
            url : '{{ url("user/edit") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            success:function(res){
               $('#username').val(res.username),
               $('#password').attr('disabled',true);
               $('#nama').val(res.nama);
               $('#loker').val(res.loker).trigger('change')
               $('#witel').val(res.witel)
               $('#kota').val(res.kota)
               $('#status').val(res.status).trigger('change')
               $('#id_role').val(res.id_role).trigger('change')
               $('#keterangan').val(res.keterangan)
               $('#update').attr('onclick','ubah('+res.id+')')
            }
        })
    }

    function ubah(id){
        var formData = $('#formUser').serialize();
        $.ajax({
            url : '{{ url("user/update") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : formData,
            method : 'POST',
            success:function(res){
                if(res.status == 200){
                    $('#modalUser').modal('hide');
                    $('#tableData').DataTable().ajax.reload(null, false);
                }else if(res.status == 401){
                    $.each(res.errors, function (i, val) {
                        $('#valid_'+i).text(val);
                    });
                }else{
                    alert(res.result);
                } 
            }
        })
    }

    function getPlasa(){
        var id = $('#loker').val();
        $.ajax({
            url : '{{ url("plasa/name") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            success:function(res){
                $('#witel').val(res.witel_plasa);
                $('#kota').val(res.kota_plasa);
            }
        })
    }

    function changeStatus(id,status){
        if(status == 0){
            var param = 1;
        }else{
            var param = 0;
        }
        $.ajax({
            url : '{{ url("user/change") }}/'+id+'/'+param,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            success:function(res){
                if(res.status == 200){
                    $('#tableData').DataTable().ajax.reload(null, false)
                }else{
                    alert(res.result);
                }
            }
        })
    }
</script>