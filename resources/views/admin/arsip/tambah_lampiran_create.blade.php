<section>
    <div class="card">
        <div class="card-header">
            <h1>
                {{ $title }}
                <a href="{{ url('lampiran') }}" class="btn btn-danger float-right"><i class="fas fa-arrow-left"></i> Kembali</a>
            </h1>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sukses!</strong> {!! Session::get('success') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
    
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal!</strong> {{ Session::get('error')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <form action="{{ url('lampiran/insert/'.request()->segment(3).'/'.request()->segment(4))}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8 col-sm-12 col-xl-8">
                        <label for="lampiran">File Lampiran :</label>
                        <input type="file" class="form-control" name="lampiran" id="lampiran" placeholder="Tambahkan Lampiran">
                        @error('lampiran') <small class="text-danger"> {{ $message }} </small> @enderror
                        <br>
                        <label for="keterangan_lampiran">Keterangan :</label>
                        <textarea name="keterangan_lampiran" id="keterangan_lampiran" class="form-control">{{ old('keterangan_lampiran') }}</textarea>
                        @error('keterangan_lampiran') <small class="text-danger"> {{ $message }} </small> @enderror
                        <br>
                        <button type="submit" class="btn btn-success btn-block"><i class="fas fa-save"></i> Tambah Lampiran</button>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xl-4">
                        <img src="" id="previewLampiran" width="100%" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#previewLampiran').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#lampiran").change(function(){
        readURL(this);
    });
</script>