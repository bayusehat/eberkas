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
            <div class="row">
                <div class="col-md-8 col-sm-12 col-xl-8">
                    <input type="text" class="form-control" name="nama_produk" id="nama_produk" placeholder="Nama Produk">
                    <small class="text-danger" id="valid_nama_produk"></small>
                </div>
                <div class="col-md-4 col-sm-12 col-xl-4">
                    <button type="button" class="btn btn-success btn-block" onclick="tambah()" id="insert"><i class="fas fa-plus"></i> Tambah</button>
                    <button type="button" class="btn btn-danger btn-block" onclick="batal()" id="cancel"><i class="fas fa-times"></i> Cancel</button>
                    <button type="button" class="btn btn-warning btn-block" onclick="ubah()" id="update"><i class="fas fa-edit"></i> Update</button>
                </div>
            </div>
        <hr>
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped nowrap" style="width:100%" id="tableData">
                    <thead>
                       <tr>
                            <th>No</th>   
                            <th>Nama</th>
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
        $('#nama_produk').val('');
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
                url: "{{ url('produk/load') }}",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'id_produk', searchable: false, orderable: true, className: 'text-center' },
                { name: 'nama_produk' },
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 10 
        });
    }

    function tambah(){
        var formData = $('#nama_produk').val();
        $.ajax({
            url : '{{ url("nama_produkinsert") }}',
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : {
                'nama_produk' : formData
            },
            method : 'POST',
            success:function(res){
                if(res.status == 200){
                    $('#nama_produk').val('');
                    $('#nama_produk').focus();
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
            url : '{{ url("produk/edit") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            success:function(res){
                $('#nama_produk').val(res.nama_produk)
                $('#update').attr('onclick','ubah('+res.id_produk+')');
            }
        })
    }

    function ubah(id){
        var formData = $('#nama_produk').val();
        $.ajax({
            url : '{{ url("produk/update") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : {
                'nama_produk' : formData
            },
            method : 'POST',
            success:function(res){
                if(res.status == 200){
                    $('#tableData').DataTable().ajax.reload(null, false);
                    $('#insert').show();
                    $('#cancel').hide();
                    $('#update').hide();
                    $('small').text('');
                    $('#nama_produk').val('')
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
            url : '{{ url("produk/delete") }}/'+id,
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