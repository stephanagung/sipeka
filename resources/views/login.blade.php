<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SiPeka : Sistem Penunjang Karyawan PT Mada Wikri Tunggal</title>
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
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>


    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert/dist/sweetalert2.min.css') }}" />
    <style>
        .required::after {
            content: "*(wajib diisi)";
            color: red;
            margin-left: 5px;
            font-size: 10px;
            position: relative;
            top: -3px;
            display: inline-block;
        }

        ::-webkit-input-placeholder {
            font-style: italic;
        }

        ::-moz-placeholder {
            font-style: italic;
        }

        :-ms-input-placeholder {
            font-style: italic;
        }

        :-moz-placeholder {
            font-style: italic;
        }
    </style>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-4 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a class="text-nowrap logo-img text-center d-block py-2 w-100">
                                    <img src="{{ asset('assets/img/logo_sipeka_color.png') }}" width="250" alt="">
                                </a>
                                <br>
                                <form id="login-form" method="POST" action="{{ route('login.process') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label required">Username</label>
                                        <input type="text" name="username" id="username" class="form-control"
                                            placeholder="Masukkan Username Anda" required autofocus>
                                    </div>
                                    <div class="mb-4 position-relative">
                                        <label for="password" class="form-label required">Password</label>
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Masukkan Password Anda" required>
                                        <i class="fas fa-eye position-absolute" id="togglePassword"
                                            style="top: 60%; right: 20px; cursor: pointer;"></i>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 rounded-2">Sign
                                        In</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert/dist/sweetalert2.min.js') }}"></script>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function(e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>

    <script>
        document.getElementById("login-form").addEventListener("submit", function(event) {
            var formElements = document.querySelectorAll("#login-form input");
            var isValid = true;

            formElements.forEach(function(element) {
                // Periksa validitas
                if (!element.checkValidity()) {
                    isValid = false;
                }
            });

            // Jika tidak valid, hentikan pengiriman form
            if (!isValid) {
                event.preventDefault(); // Menghentikan proses submit
                alert("Mohon periksa kembali input Anda.");
            }
        });
    </script>

</body>

</html>
