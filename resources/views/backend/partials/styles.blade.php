
@php
    $systemSetting = App\Models\SystemSetting::first();
@endphp


<link rel="shortcut icon" type="image/x-icon" href="{{ $systemSetting->favicon ?? asset('backend/images/logo/image 13.png') }}" />


<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('backend/css/vendors/font-awesome.css')}}">

<!-- ico-font-->
<link rel="stylesheet" type="text/css" href="{{asset('backend/css/vendors/icofont.css')}}">

<!-- Themify icon-->
<link rel="stylesheet" type="text/css" href="{{asset('backend/css/vendors/themify.css')}}">


<link rel="stylesheet" type="text/css" href="{{asset('backend/css/vendors/scrollbar.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('backend/css/vendors/datatables.css')}}">

<!-- Bootstrap css-->
<link rel="stylesheet" type="text/css" href="{{asset('backend/css/vendors/bootstrap.css')}}">


{{-- dropify --}}
<link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">


{{-- dropify and ck-editor start --}}
<style>
    .ck-editor__editable[role="textbox"] {
        min-height: 150px;
    }

    .dropify-wrapper .dropify-render {
        display: unset !important;
    }
</style>
{{-- dropify and ck-editor end --}}

<!-- App css-->
<link rel="stylesheet" type="text/css" href="{{asset('backend/css/style.css')}}">
<link id="color" rel="stylesheet" href="{{asset('backend/css/color-1.css')}}" media="screen">

<!-- Responsive css-->
<link rel="stylesheet" type="text/css" href="{{asset('backend/css/responsive.css')}}">
@stack('styles')
