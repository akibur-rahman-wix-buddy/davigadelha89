
@php
    $systemSetting = App\Models\SystemSetting::first();
@endphp


<link rel="shortcut icon" type="image/x-icon" href="{{ $systemSetting->favicon ?? asset('backend/images/logo/img34.png') }}" />


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


{{--only used in dark-mode class start--}}
<style>
    /* Apply dark mode styles only if the body has the 'dark-only' class */
    body.dark-only {
        /* CKEditor Dark Mode Custom Styling */
        .ck-editor__editable {
            background-color: #10101C !important;  /* Dark background for CKEditor */
            color: #e0e0e0 !important;  /* Light text color */
        }

        .ck-editor__editable[role="textbox"] {
            border: 1px solid #444 !important;  /* Dark border */
        }

        .ck-editor__editable.ck-rounded-corners {
            border-radius: 5px !important;  /* Rounded corners */
        }

        .ck-editor__editable:focus {
            border-color: #1e90ff !important;  /* Blue border on focus */
            box-shadow: 0 0 5px rgba(30, 144, 255, 0.5) !important;  /* Light blue shadow on focus */
        }

        .ck-editor__editable .ck-placeholder {
            color: #777 !important;  /* Lighter placeholder text */
        }

        /* Dropify Dark Mode Custom Styling */
        .dropify-wrapper {
            background-color: #10101C !important;  /* Dark background for Dropify */
            border: 2px solid #555 !important;  /* Dark border */
            color: #ddd !important;  /* Light text color */
        }

        .dropify-message {
            color: #bbb !important;  /* Lighter message text */
        }

        .dropify-wrapper .dropify-render img {
            background-color: #444 !important;  /* Dark background for image preview */
        }

        .dropify-wrapper:hover {
            background-color: #10101C !important; /* Dark background on hover */
            color: #bbb !important; /* Gray text on hover */
        }

        .dropify-wrapper:hover .dropify-message {
            color: #bbb !important; /* Gray color for message text on hover */
        }

        .dropify-clear {
            color: white !important;  /* Red color for the clear button */
        }
    }
</style>

{{--only used in dark-mode class ends--}}




<!-- App css-->
<link rel="stylesheet" type="text/css" href="{{asset('backend/css/style.css')}}">
<link id="color" rel="stylesheet" href="{{asset('backend/css/color-1.css')}}" media="screen">

<!-- Responsive css-->
<link rel="stylesheet" type="text/css" href="{{asset('backend/css/responsive.css')}}">
@stack('styles')
