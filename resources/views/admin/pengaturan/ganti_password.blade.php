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
            <a href="{{ url('user/change/password/reset/'.session('id')) }}" class="btn btn-info btn-sm right"><i class="fas fa-sync"></i> Reset Password</a>
            <hr>
            <form action="{{ url('user/change/password/do') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8 col-sm-12 col-xl-8">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Masukan Password Baru">
                        @error('password') <small class="text-danger"> {{ $message }} </small> @enderror
                    </div>
                    <div class="col-md-4 col-sm-12 col-xl-4">
                        <button type="submit" class="btn btn-success btn-block"><i class="fas fa-save"></i> Ganti Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>