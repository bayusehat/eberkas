<section>
    <div class="card">
        <div class="card-header">
            <h1>
                {{ $title }}
            </h1>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sukses!</strong> {{ Session::get('success')}}
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
            <form action="{{ url('user/signature/insert') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8 col-sm-12 col-xl-8">
                        <input type="text" class="form-control" name="id_signature" id="id_signature">
                        @error('id_signature') <small class="text-danger"> {{ $message }} </small> @enderror
                    </div>
                    <div class="col-md-4 col-sm-12 col-xl-4">
                        <button type="submit" class="btn btn-success btn-block"><i class="fas fa-save"></i> Simpan Ke Database</button>
                    </div>
                </div>
            </form>
        <br>
            <div class="form-group">
                <a href="javascript:void(0)" class="btn btn-primary btn-sm btn-block" id="signature"><i class="fas fa-sign"></i> Tanda Tangan Petugas</a>
            <br>
                <div id="signature-pad" class="jay-signature-pad">
                    <div class="jay-signature-pad--body">
                        <canvas id="jay-signature-pad" height="100px"></canvas>
                    </div>
                    <div class="signature-pad--footer txt-center">
                        <small class="description">Tanda Tangan Diatas</small>
                        <div class="signature-pad--actions txt-center">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="button clear" data-action="clear">Clear</button>
                                    <button type="button" class="button" data-action="change-color">Change color</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="button save" data-action="save-png">Save as PNG</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                use App\Login;

                $login = Login::where('id',session('id'))->first();
            @endphp
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xl-12 text-center">
                    @if ($login->signature_login)
                        <strong>Tanda Tangan:</strong>
                        <img src="{{ asset('signature/'.$login->signature_login) }}" alt="{{ $login->nama}}">
                        <hr>
                        <p>{{ $login->nama }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>