<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $data['title'] }}</title>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('assets/admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="{{ asset('assets/admin/vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('assets/admin/css/sb-admin.css') }}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
  <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
  <link href="/resources/demos/style.css" rel="stylesheet">

  <script src="{{ asset('assets/admin/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('assets/admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Page level plugin JavaScript-->
  <script src="{{ asset('assets/admin/vendor/chart.js/Chart.min.js') }}"></script>
  <script src="{{ asset('assets/admin/vendor/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/admin/vendor/datatables/dataTables.bootstrap4.js') }}"></script>
  <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $(document).ready(function() {
      tinymce.init({
        selector: 'textarea#tiny',
        plugins: [
          "advlist autolink lists link image charmap print preview anchor",
          "searchreplace visualblocks code fullscreen",
          "insertdatetime media table paste imagetools wordcount"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
      });

      $('.select2').select2();
      
      $('.tags').select2({
        tags : true
      });

      $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' })
    });
  </script>
  <style>
    .btn-warning{
      color: white;
    }
    .bg-red{
      background-color: #f90000;
    }
  </style>
</head>