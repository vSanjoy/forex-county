<!DOCTYPE html>
<html dir="ltr" lang="{{ app()->getLocale() }}" class="light-style customizer-hide">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Favicon icon -->
    <link rel="icon" type="image/x-icon" sizes="16x16" href="{{ asset('images/admin/favicon/favicon.ico') }}" />
    <title>Administrator :: @if ($title) {{ $title }} @else {{ getAppName() }} @endif</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" />
    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('css/admin/vendor/fonts/boxicons.css') }}" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/admin/vendor/libs/fontawesome/fontawesome.css') }}" />

    <!-- Core CSS -->
    @if (strpos(Route::currentRouteName(), '.list') !== false)
    <link rel="stylesheet" href="{{ asset('css/admin/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    @else
    <link rel="stylesheet" href="{{ asset('css/admin/vendor/css/core.css') }}" class="template-customizer-core-css" />
    @endif
    <link rel="stylesheet" href="{{ asset('css/admin/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('css/admin/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('css/admin/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('css/admin/vendor/css/pages/page-auth.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('js/admin/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('js/admin/config.js') }}"></script>

    <!-- Sweetalert -->
    <link href="{{ asset('css/admin/vendor/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">

    <!-- Toastr css -->
    <link href="{{ asset('css/admin/vendor/libs/toastr/toastr.min.css') }}" rel="stylesheet">

    <!-- Development css -->
    <link href="{{ asset('css/admin/development.css') }}" rel="stylesheet">
</head>

<body>
    
    @include('admin.includes.notification')

    <!-- Preloader -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('admin.includes.navigation')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('admin.includes.header')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    @yield('content')
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('admin.includes.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->
    
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('js/admin/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('js/admin/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('js/admin/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('js/admin/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- jQuery -->
    <script src="{{ asset('js/admin/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/admin/development.js') }}"></script>
    
    <!-- Vendors JS -->
    <script src="{{ asset('js/admin/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('js/admin/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('js/admin/dashboards-analytics.js') }}"></script>
    
    <!-- Preloader -->
    <script type="text/javascript">
    $(".preloader").fadeOut();
    </script>

    <!-- Toastr js & rendering -->
    <script src="{{ asset('js/admin/vendor/libs/toastr/toastr.min.js') }}"></script>
    <script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    </script>

    @if (strpos(Route::currentRouteName(), '.list') !== false)        
    <!-- DataTables -->
    <link href="{{ asset('css/admin/vendor/libs/datatable/datatables.bootstrap5.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/vendor/libs/datatable/responsive.bootstrap5.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/vendor/libs/datatable/datatables.checkboxes.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/vendor/libs/datatable/buttons.bootstrap5.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/vendor/libs/datatable/flatpickr.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/vendor/libs/datatable/rowgroup.bootstrap5.css') }}" rel="stylesheet">
    <script src="{{ asset('js/admin/vendor/libs/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/admin/vendor/libs/datatable/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/admin/vendor/libs/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/admin/vendor/libs/datatable/responsive.bootstrap5.min.js') }}"></script>
    {{-- <script type="text/javascript">
        $(function () {
            $('#responsive-table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script> --}}
    @endif

    <!-- CKEditor -->
    @if (strpos(Route::currentRouteName(), '.add') !== false || strpos(Route::currentRouteName(), '.edit') !== false || strpos(Route::currentRouteName(), '.profile') !== false)
    <script src="{{ asset('js/admin/ckeditor.js') }}"></script>
    <script>
    $(function () {
        try {
            CKEDITOR.ClassicEditor.create(document.getElementById("description"), {
                toolbar: {
                    items: [
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'outdent', 'indent', 'undo', 'redo', '-', 'fontSize', 'alignment', '|',
                        'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
                placeholder: '',
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                fontSize: {
                    options: [ 10, 12, 14, 'default', 18, 20, 22, 24, 26, 28, 30 ],
                    supportAllValues: true
                },
                ckfinder: {
                    uploadUrl: "{{route("admin.ckeditor-upload", ["_token" => csrf_token() ])}}",
                },
                removePlugins: [
                    'CKBox',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader'
                ]
            });
        } catch {}
    });
    </script>
    @endif

    <!-- Sweetalert -->
    <script src="{{ asset('js/admin/vendor/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    @stack('scripts')

</body>

</html>