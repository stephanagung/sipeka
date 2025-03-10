<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SiPeka : Sistem Penunjang Karyawan PT Mada Wikri Tunggal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <link rel="icon" href="{{ asset('assets/img/favicon-mwt.png') }}" type="image/x-icon" />
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>

    <script>
        WebFont.load({
            google: {
                families: ["Poppins :300,400,500,600,700"]
            },
            custom: {
                families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ["{{ asset('assets/css/fonts.min.css') }}"]
            },
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert/dist/sweetalert2.min.css') }}" />

</head>

<body>
    <div class="wrapper">
        @php
            $user = session('user');
        @endphp

        @if ($user)
            @if ($user->level === 'Admin')
                @include('partial.sidebar-admin')
            @elseif ($user->level === 'Atasan')
                @include('partial.sidebar-atasan')
            @endif
        @endif

        <div class="main-panel">
            @include('partial.header')

            <div class="container">
                <div class="page-inner">
                    @yield('content')
                </div>
            </div>

            @include('partial.footer')
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert/dist/sweetalert2.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- jQuery UI JavaScript -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Plugins -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#basic-datatables").DataTable({});

            // Add Row
            $("#add-row").DataTable({
                pageLength: 5,
            });

            var action =
                '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

            $("#addRowButton").click(function () {
                $("#add-row")
                    .dataTable()
                    .fnAddData([
                        $("#addName").val(),
                        $("#addPosition").val(),
                        $("#addOffice").val(),
                        action,
                    ]);
                $("#addRowModal").modal("hide");
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            // Custom Bootstrap Notify
            @if (session('success'))
                $.notify({
                    icon: 'fa fa-check-circle',
                    message: "<strong>Success:</strong> {{ session('success') }}"
                }, {
                    type: 'success',
                    delay: 4000,
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    offset: {
                        x: 30,
                        y: 80
                    },
                    animate: {
                        enter: 'animated bounceInRight',
                        exit: 'animated bounceOutRight'
                    },
                    template: `
                            <div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert" style="background: linear-gradient(45deg, #32a852, #4CAF50); color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                <button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="color: white; background: transparent; border: none; box-shadow: none; outline: none;">×</button>
                                <span data-notify="icon"></span>
                                <span data-notify="message" style="color: white; margin-left: 10px;">{2}</span>
                            </div>`
                });
            @endif

            @if (session('error'))
                $.notify({
                    icon: 'fa fa-exclamation-circle',
                    message: "<strong>Error:</strong> {{ session('error') }}"
                }, {
                    type: 'danger',
                    delay: 4000,
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    offset: {
                        x: 30,
                        y: 80
                    },
                    animate: {
                        enter: 'animated bounceInRight',
                        exit: 'animated bounceOutRight'
                    },
                    template: `
                            <div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert" style="background: linear-gradient(45deg, #f44336, #e53935); color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                <button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="color: white; background: transparent; border: none; box-shadow: none; outline: none;">×</button>
                                <span data-notify="icon"></span>
                                <span data-notify="message" style="color: white; margin-left: 10px;">{2}</span>
                            </div>`
                });
            @endif
        });
    </script>

    <script>
        function refreshPage() {
            window.location.reload();
        }
    </script>

    <script>
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });

        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });

        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });
    </script>
</body>

</html>