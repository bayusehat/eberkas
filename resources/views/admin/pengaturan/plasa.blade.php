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
                    {{-- <a href="javascript:void(0)" id="btnAddAdmin" class="btn btn-success"><i class="fas fa-plus"></i> Tambah</a> --}}
                </div>
            </div>
        <hr>
        <form action="{{ url('plasa/import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-9 col-sm-12 col-xl-9">
                    <input type="file" class="form-control" name="data_plasa" id="data_plasa" placeholder="Data Plasa">
                    <small class="text-danger" id="valid_data_plasa"></small>
                </div>
                <div class="col-md-3 col-sm-12 col-xl-3">
                    <button type="submit" class="btn btn-success btn-block"><i class="fas fa-save"></i> Import Data</button>
                    {{-- <button type="button" class="btn btn-danger btn-block" onclick="batal()" id="cancel"><i class="fas fa-times"></i> Cancel</button>
                    <button type="button" class="btn btn-warning btn-block" onclick="ubah()" id="update"><i class="fas fa-edit"></i> Update</button> --}}
                </div>
            </div>
        </form>
        <hr>
            <form id="formPlasa">
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xl-3">
                        <input type="text" class="form-control" name="nama_plasa" id="nama_plasa" placeholder="Nama Plasa">
                        <small class="text-danger" id="valid_nama_plasa"></small>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xl-3">
                        <input type="text" class="form-control" name="witel_plasa" id="witel_plasa" placeholder="Witel Plasa">
                        <small class="text-danger" id="valid_witel_plasa"></small>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xl-3">
                        <input type="text" class="form-control" name="kota_plasa" id="kota_plasa" placeholder="Kota Plasa">
                        <small class="text-danger" id="valid_kota_plasa"></small>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xl-3">
                        <button type="button" class="btn btn-success btn-block" onclick="tambah()" id="insert"><i class="fas fa-plus"></i> Tambah</button>
                        <button type="button" class="btn btn-danger btn-block" onclick="batal()" id="cancel"><i class="fas fa-times"></i> Cancel</button>
                        <button type="button" class="btn btn-warning btn-block" onclick="ubah()" id="update"><i class="fas fa-edit"></i> Update</button>
                    </div>
                </div>
            </form>
        <hr>
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped nowrap" style="width:100%" id="tableData">
                    <thead>
                       <tr>
                            <th>No</th>   
                            <th>Plasa</th>
                            <th>Witel</th>
                            <th>Kota</th>
                            <th>Action</th>
                        </tr> 
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    $(function(){
        loadData();
        $('#cancel').hide();
        $('#update').hide();
        $('small').text('');
    });

    function batal(){
        $('#cancel').hide();
        $('#update').hide();
        $('#formPlasa').trigger('reset');
        $('#insert').show();
        $('small').text('');
    }

    function btnToUpdate(){
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
                url: "{{ url('plasa/load') }}",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'id_plasa', searchable: false, orderable: true, className: 'text-center' },
                { name: 'nama_plasa' },
                { name: 'witel_plasa' },
                { name: 'kota_plasa' },
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 10 
        });
    }

    function tambah(){
        var formData = $('#formPlasa').serialize();
        $.ajax({
            url : '{{ url("plasa/insert") }}',
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : formData,
            method : 'POST',
            success:function(res){
                if(res.status == 200){
                    $('#formPlasa').trigger('reset')
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
            url : '{{ url("plasa/edit") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            success:function(res){
                $('#nama_plasa').val(res.nama_plasa)
                $('#witel_plasa').val(res.witel_plasa)
                $('#kota_plasa').val(res.kota_plasa)
                $('#update').attr('onclick','ubah('+res.id_plasa+')');
            }
        })
    }

    function ubah(id){
        var formData = $('#formPlasa').serialize();
        $.ajax({
            url : '{{ url("plasa/update") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : formData,
            method : 'POST',
            success:function(res){
                if(res.status == 200){
                    $('#tableData').DataTable().ajax.reload(null, false);
                    $('#insert').show();
                    $('#cancel').hide();
                    $('#update').hide();
                    $('small').text('');
                    $('#formPlasa').trigger('reset')
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
            url : '{{ url("plasa/delete") }}/'+id,
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