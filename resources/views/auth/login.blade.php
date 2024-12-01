<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('admin_lte/plugins/sweetalert2/sweetalert2.min.css') }}">
    <style>
        body,
        * {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .container-fluid {
            width: 100%;
            height: 100vh;
            background-color: rgb(43, 27, 6);
        }

        .wrapper {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
            margin: 0;
        }

        .card {
            /* min-width: 600px; */
            background-color: rgb(161, 161, 161);
        }

        .password input[type="password"] {
            /* padding-right: 30px; */
            /* Adjust as needed */
        }

        .password .icon {
            position: relative;
        }

        .password .icon i {
            position: absolute;
            top: 50%;
            right: 10px;
            /* Adjust as needed */
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="wrapper row">
            <div class="card col-lg-4 p-3">
                <div class="text-center">
                    <h1>{{ config('app.name') }}</h1>
                    <p>Sign-In untuk melanjutkan ke aplikasi.</p>
                </div>
                <hr>
                <form id="login" class="needs-validation" action="{{ route('login') }}" method="post" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="usernameinput" class="form-label">Username</label>
                        <input type="text" class="form-control" id="usernameinput" name="username"
                            aria-describedby="username" placeholder="Enter your nisn/email" required minlength="5">
                        <div id="username" class="form-text">We'll never share your email with anyone else.</div>
                        @error('username')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Wajib di sini, minlength 8.
                        </div>
                    </div>
                    <div class="mb-3 password">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <div class="icon">
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password"
                                placeholder="Enter your password" required minlength="8">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Wajib di sini, minlength 8.
                        </div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Remember me</label>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" id="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('admin_lte/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        const passwordInput = document.getElementById('exampleInputPassword1');
        const eyeIcon = document.querySelector('.password .icon i');

        eyeIcon.addEventListener('click', () => {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        });

        (() => {
    'use strict'
    
    const forms = document.querySelectorAll('.needs-validation')

    Array.from(forms).forEach(form => {
        const submitButton = form.querySelector('button[type="submit"]')
        submitButton.disabled = true

        form.addEventListener('input', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
                submitButton.disabled = true
            } else {
                submitButton.disabled = false
            }
            form.classList.add('was-validated')
        }, false)
    })
})()

// Reload saat tombol refresh di tekan
window.addEventListener('beforeunload', function (event) {
    // sebelum halaman di muat ulang
    Swal.fire({
        html: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 150" style="background: none; width:200px;">  <linearGradient id="a11">
            <stop offset="0" stop-color="#2239e3" stop-opacity="0"></stop>
            <stop offset="1" stop-color="#2239e3"></stop>
          </linearGradient>
          <circle fill="none" stroke="url(#a11)" stroke-width="25" stroke-linecap="round" stroke-dasharray="0 44 0 44 0 44 0 44 0 360" cx="75" cy="75" r="55" transform-origin="center">
            <animateTransform type="rotate" attributeName="transform" calcMode="discrete" dur="2" values="360;324;288;252;216;180;144;108;72;36" repeatCount="indefinite"></animateTransform>
          </circle>
        </svg>`,
        showConfirmButton: false,
        allowOutsideClick: false,
        willOpen: () => {
            // Mengatur style popup agar background transparan
            const swalContainer = Swal.getPopup();
            swalContainer.style.background = 'transparent'; // Menghilangkan background
            swalContainer.style.boxShadow = 'none'; // Menghilangkan bayangan
        }
    });
});
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>