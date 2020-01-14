@include('admin.layout.head')
@include('admin.layout.sidebar')
@if($data['content']) {{ view($data['content'], $data) }} @endif
@include('admin.layout.foot')