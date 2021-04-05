@php
    header("Access-Control-Allow-Origin: *");
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
        body{
            margin: 0;
        }
    </style>
</head>
<body>
    <button id="cmd" onclick="generate()" style="width: 200px;height:50px"><i class="fa fa-file"></i> <b>Download as PDF</b></button>
    <br>
    <div id="content" style="width: 100%">
        @foreach ($data as $v)
            <img src="{{ $v['path'] }}" alt="{{ $v['nama_file'] }}"/><br>
        @endforeach
    </div>
    <div id="editor"></div>
    <script src="{{ asset('assets/admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.1/html2pdf.bundle.min.js" integrity="sha512-vDKWohFHe2vkVWXHp3tKvIxxXg0pJxeid5eo+UjdjME3DBFBn2F8yWOE0XmiFcFbXxrEOR1JriWEno5Ckpn15A==" crossorigin="anonymous"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script> --}}
    <script>

        $(document).ready(function(){
            // generate();
            // setTimeout(function () { 
            //     window.close();
            // },7000)
        })
        var title = document.title;

        function generate(){
            var element = document.getElementById('content');
            var opt = {
            margin:       0,
            filename:     title,
            image:        { type: 'jpg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' },
            useCORS:       true
            };

            html2pdf(element, opt);
        }
    </script>
</body>
</html>