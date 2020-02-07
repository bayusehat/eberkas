<style>
    .form-control{
        text-transform: none;
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
            <button type="button" onclick="loadData()" class="btn btn-primary float-right"><i class="fas fa-sync"></i> Refresh</button>
            <hr>
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped table-hover display nowrap" style="width:100%" id="tableData">
                    <thead>
                       <tr>
                            <th>No</th>   
                            <th>User</th>
                            <th>IP</th>
                            <th>Keterangan</th>
                            <th>Tgl. Log</th>
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
    });

    function loadData(){
        $('#tableData').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: '{{ url("log/load") }}'
            },
            columns: [
                { name: 'id_log', searchable: false, className: 'text-center' },
                { name: 'nama' },
                { name: 'ip_log'},
                { name: 'keterangan_log'},
                { name: 'create_log' }
            ],
            lengthMenu: [10],
            order: [[0, 'desc']],
        });
    }
</script>