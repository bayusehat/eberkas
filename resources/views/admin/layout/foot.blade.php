</div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © E-berkas</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="{{ url('logout') }}">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('assets/admin/js/sb-admin.min.js') }}"></script>

  <!-- Demo scripts for this page-->
  <script src="{{ asset('assets/admin/js/demo/datatables-demo.js') }}"></script>
  <script src="{{ asset('assets/admin/js/demo/chart-area-demo.js') }}"></script>
  <script>
    $('#signature').click(function () {
      $('#signature-pad').fadeIn();
      $('#jay-signature-pad').attr('width','500px');
      $('#jay-signature-pad').attr('height','200px');
    })
    $('#signature-atasan').click(function () {
      $('#signature-pad-atasan').fadeIn();
      $('#jay-signature-pad-atasan').attr('width','500px');
      $('#jay-signature-pad-atasan').attr('height','200px');
    })
  </script>
  <script>
    var wrapper = document.getElementById("signature-pad");
    var clearButton = wrapper.querySelector("[data-action=clear]");
    var changeColorButton = wrapper.querySelector("[data-action=change-color]");
    var savePNGButton = wrapper.querySelector("[data-action=save-png]");
    var canvas = wrapper.querySelector("#jay-signature-pad");
    var signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)'
    });
    function makeid(length) {
      var result           = '';
      var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      var charactersLength = characters.length;
      for ( var i = 0; i < length; i++ ) {
          result += characters.charAt(Math.floor(Math.random() * charactersLength));
      }
      return result;
    }
    function resizeCanvas() {
        var ratio =  Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
  
        signaturePad.clear();
    }

    window.onresize = resizeCanvas;
    resizeCanvas();
    function download(dataURL, filename) {
        var blob = dataURLToBlob(dataURL);
        var url = window.URL.createObjectURL(blob);
        var a = document.createElement("a");
        a.style = "display: none";
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
    }
    // One could simply use Canvas#toBlob method instead, but it's just to show
    // that it can be done using result of SignaturePad#toDataURL.
    function dataURLToBlob(dataURL) {
        var parts = dataURL.split(';base64,');
        var contentType = parts[0].split(":")[1];
        var raw = window.atob(parts[1]);
        var rawLength = raw.length;
        var uInt8Array = new Uint8Array(rawLength);
        for (var i = 0; i < rawLength; ++i) {
            uInt8Array[i] = raw.charCodeAt(i);
        }
        return new Blob([uInt8Array], { type: contentType });
    }
    clearButton.addEventListener("click", function (event) {
        signaturePad.clear();
    });
    changeColorButton.addEventListener("click", function (event) {
        var r = Math.round(Math.random() * 255);
        var g = Math.round(Math.random() * 255);
        var b = Math.round(Math.random() * 255);
        var color = "rgb(" + r + "," + g + "," + b +")";
        signaturePad.penColor = color;
    });

    function checkValSignature(){
        var signatureVal = $('#id_signature').val();
        if(signatureVal != ''){
            $('#submit').removeClass('disabled');
          }else{
            $('#submit').addClass('disabled');
          }
      }
    
    function simpanFile(dataURL) {
      $.ajax({
        url : '{{ url("signature/save") }}',
        headers : {
          'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
        },
        data : {
          'id_signature' : dataURL
        },
        method : 'POST',
        success:function(res){
          alert('Tanda tangan berhasil disimpan!');
          $('#id_signature').val(res.name);
          checkValSignature();
        }
      })
    }

    savePNGButton.addEventListener("click", function (event) {
        if (signaturePad.isEmpty()) {
        alert("Tolong isi tanda tangan terlebih dahulu!");
        } else {
        var dataURL = signaturePad.toDataURL();
        simpanFile(dataURL);
        }
    });
</script>
<script>
  var wrapper = document.getElementById("signature-pad-atasan");
  var clearButton = wrapper.querySelector("[data-action=clear2]");
  var changeColorButton = wrapper.querySelector("[data-action=change-color2]");
  var savePNGButton = wrapper.querySelector("[data-action=save-png2]");
  var canvas = wrapper.querySelector("#jay-signature-pad-atasan");
  var signaturePad = new SignaturePad(canvas, {
      backgroundColor: 'rgb(255, 255, 255)'
  });
  function makeid2(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
  }
  function resizeCanvas2() {
      var ratio =  Math.max(window.devicePixelRatio || 1, 1);
      canvas.width = canvas.offsetWidth * ratio;
      canvas.height = canvas.offsetHeight * ratio;
      canvas.getContext("2d").scale(ratio, ratio);

      signaturePad.clear();
  }

  window.onresize = resizeCanvas;
  resizeCanvas2();
  function download2(dataURL, filename) {
      var blob = dataURLToBlob(dataURL);
      var url = window.URL.createObjectURL(blob);
      var a = document.createElement("a");
      a.style = "display: none";
      a.href = url;
      a.download = filename;
      document.body.appendChild(a);
      a.click();
      window.URL.revokeObjectURL(url);
  }
  // One could simply use Canvas#toBlob method instead, but it's just to show
  // that it can be done using result of SignaturePad#toDataURL.
  function dataURLToBlob2(dataURL) {
      var parts = dataURL.split(';base64,');
      var contentType = parts[0].split(":")[1];
      var raw = window.atob(parts[1]);
      var rawLength = raw.length;
      var uInt8Array = new Uint8Array(rawLength);
      for (var i = 0; i < rawLength; ++i) {
          uInt8Array[i] = raw.charCodeAt(i);
      }
      return new Blob([uInt8Array], { type: contentType });
  }
  clearButton.addEventListener("click", function (event) {
      signaturePad.clear();
  });
  changeColorButton.addEventListener("click", function (event) {
      var r = Math.round(Math.random() * 255);
      var g = Math.round(Math.random() * 255);
      var b = Math.round(Math.random() * 255);
      var color = "rgb(" + r + "," + g + "," + b +")";
      signaturePad.penColor = color;
  });

  function simpanFileAtasan(dataURL) {
    $.ajax({
      url : '{{ url("signature/atasan/save") }}',
      headers : {
        'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
      },
      data : {
        'id_signature_atasan' : dataURL
      },
      method : 'POST',
      success:function(res){
        alert('Tanda tangan berhasil disimpan!');
        $('#id_signature_atasan').val(res.name);
      }
    })
  }

  savePNGButton.addEventListener("click", function (event) {
      if (signaturePad.isEmpty()) {
      alert("Tolong isi tanda tangan terlebih dahulu!");
      } else {
      var dataURL = signaturePad.toDataURL();
      simpanFileAtasan(dataURL);
      }
  });

  function sama(){
    var nama   = $('#nama_transaksi').val();
    var alamat = $('#alamat_identitas_transaksi').val();
    var jenis  = $('#jenis_identitas_transaksi').val();
    var no_id  = $('#no_identitas_transaksi').val();

    $('#nama_penerima_kuasa_transaksi').val(nama);
    $('#alamat_penerima_kuasa_transaksi').val(alamat);
    $('#jenis_identitas_penerima_kuasa_transaksi').val(jenis).trigger('change');
    $('#no_identitas_penerima_kuasa_transaksi').val(no_id);
  }
</script>
</body>

</html>