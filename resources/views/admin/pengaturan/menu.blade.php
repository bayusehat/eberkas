<style>
    .form-control,.form-control-sm{
      text-transform: capitalize;
    }
</style>
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
                    <a href="javascript:void(0)" id="btnAddMenu" class="btn btn-success"><i class="fas fa-plus"></i> Tambah</a>
                </div>
            </div>
        <hr>
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped nowrap" style="width:100%" id="tableData">
                    <thead>
                       <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>URL</th>
                            <th>Parent</th>
                            <th>Action</th>
                        </tr> 
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<form id="formMenu">
    @csrf
  <div class="modal fade" id="modalMenu" tabindex="-1" role="dialog" aria-labelledby="modalMenu" aria-hidden="true">
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
                        <label for="nama_menu">Nama Menu</label>
                        <input type="text" class="form-control" name="nama_menu" id="nama_menu">
                        <small class="text-danger" id="valid_nama_menu"></small>
                    </div>
                    <div class="form-group">
                        <label for="url_menu">URL Menu</label>
                        <input type="text" class="form-control" name="url_menu" id="url_menu">
                        <small class="text-danger" id="valid_url_menu"></small>
                    </div>
                    <div class="form-group">
                        <label for="parent_menu">Parent Menu</label>
                        <select name="parent_menu" id="parent_menu" class="form-control">
                            <option value="0">is Parent!</option>
                            @foreach ($parent_menu as $p)
                                <option value="{{ $p->id_menu }}">{{ $p->nama_menu }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="valid_parent_menu"></small>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xl-6">
                    <div class="form-group">
                        <label for="url_active_menu">URL Aktif</label>
                        <input type="text" class="form-control" name="url_active_menu" id="url_active_menu">
                        <small class="text-danger" id="valid_url_active_menu"></small>
                    </div>
                    <div class="form-group">
                        <label for="parent_active_menu">Parent Active</label>
                        <input type="text" class="form-control" name="parent_active_menu" id="parent_active_menu">
                        <small class="text-danger" id="valid_parent_active_menu"></small>
                    </div>
                    <div class="form-group">
                        <label for="icon_menu">Icon (for Parent Menu)</label>
                        <input type="text" class="form-control" name="icon_menu" id="icon_menu">
                        <small class="text-danger" id="valid_icon_menu"></small>
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
        $('#btnAddMenu').click(function(){
            $('#modalMenu').modal('show');
            $('#update').hide();
            $('#cancel').hide();
            $('#modalTitle').text('Tambah Menu');
            $('small').text('');
            $('#adminPassword').attr('disabled',false);
            $('#formMenu').trigger('reset');
        })
    });

    function batal(){
        $('#cancel').hide();
        $('#update').hide();
        $('form').trigger('reset');
        $('#insert').show();
        $('small').text('');
    }

    function btnToUpdate(){
        $('#modalMenu').modal('show')
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
                url: "{{ url('menu/load') }}",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'id_menu', searchable: false, orderable: true, className: 'text-center' },
                { name: 'nama_menu'},
                { name: 'url_menu'},
                { name: 'parent_menu'},
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 10 
        });
    }

    function tambah(){
        var formData = $('#formMenu').serialize();
        $.ajax({
            url : '{{ url("menu/insert") }}',
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : formData,
            method : 'POST',
            success:function(res){
                if(res.status == 200){
                    $('#modalMenu').modal('hide');
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
            url : '{{ url("menu/edit") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            success:function(res){
               $('#nama_menu').val(res.nama_menu)
               $('#url_menu').val(res.url_menu)
               $('#parent_menu').val(res.parent_menu).trigger('change')
               $('#url_active_menu').val(res.url_active_menu)
               $('#parent_active_menu').val(res.parent_active_menu)
               $('#icon_menu').val(res.icon_menu)
               $('#update').attr('onclick','ubah('+res.id_menu+')')
            }
        })
    }

    function ubah(id){
        var formData = $('#formMenu').serialize();
        $.ajax({
            url : '{{ url("menu/update") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : formData,
            method : 'POST',
            success:function(res){
                if(res.status == 200){
                    $('#modalMenu').modal('hide');
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

    function deleteData(id){
        $.ajax({
            url : '{{ url("menu/delete") }}/'+id,
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