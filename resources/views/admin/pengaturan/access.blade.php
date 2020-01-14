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
                    <a href="{{ url('role') }}" class="btn btn-success"><i class="fas fa-save"></i> Simpan</a>
                </div>
            </div>
        {{-- <hr>
            <div class="row">
                <div class="col-md-8 col-sm-12 col-xl-8">
                    <input type="text" class="form-control" name="nama_role" id="nama_role" placeholder="Nama Role">
                    <small class="text-danger" id="valid_nama_role"></small>
                </div>
                <div class="col-md-4 col-sm-12 col-xl-4">
                    <button type="button" class="btn btn-success btn-block" onclick="tambah()" id="insert"><i class="fas fa-plus"></i> Tambah</button>
                    <button type="button" class="btn btn-danger btn-block" onclick="batal()" id="cancel"><i class="fas fa-times"></i> Cancel</button>
                    <button type="button" class="btn btn-warning btn-block" onclick="ubah()" id="update"><i class="fas fa-edit"></i> Update</button>
                </div>
            </div> --}}
        @php
            use App\Access;
        @endphp
        <hr>
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped nowrap" style="width:100%" id="tableData">
                    <thead>
                       <tr>
                            <th>No</th>   
                            <th>Nama Menu</th>
                            <th>Action</th>
                        </tr> 
                    </thead>
                    <tbody>
                        @foreach ($menu as $i => $v)
                            @php
                                $access = Access::where(['id_menu'=>$v->id_menu,'id_role'=> $role->id_role])->first();
                            @endphp
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $v->nama_menu }}</td>
                                <td class="text-center">
                                    <input type="checkbox" id="check_{{$v->id_menu}}" onclick="change_access({{ $v->id_menu}} ,{{ $role->id_role }})" @if ($access) {{ 'checked' }} @else {{ '' }} @endif>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    function change_access(menu,role){
        if($('#check_'+menu).is(':checked')){
            $('#check_'+menu).attr('checked',false);
        }else{
            $('#check_'+menu).attr('checked',false);
        }
        $.ajax({
            url : '{{ url("role/access/change") }}/'+menu+'/'+role,
            headers :{
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            method : 'GET',
            success:function(res){
                if(res.status == 200){
                    alert(res.result);
                }else{
                    alert(res.result)
                }
            }
        })
    }
</script>