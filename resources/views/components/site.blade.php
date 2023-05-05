<!DOCTYPE html>
<html lang="en">
<head>
    <title>Booking - Multipurpose Online Booking Theme</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="booknow.ng">
    <meta name="description" content="BookNow - Keep The Best Reservations">

    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&amp;family=Poppins:wght@400;500;700&amp;display=swap">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/flatpickr/css/flatpickr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/choices/css/choices.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/tiny-slider/tiny-slider.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/nouislider/nouislider.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

    <!-- Dark mode script-->
    <script>
        const storedTheme = localStorage.getItem('theme')

        const getPreferredTheme = () => {
            if (storedTheme) {
                return storedTheme
            }
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
        }

        const setTheme = function (theme) {
            if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('data-bs-theme', 'dark')
            } else {
                document.documentElement.setAttribute('data-bs-theme', theme)
            }
        }

        setTheme(getPreferredTheme())

        window.addEventListener('DOMContentLoaded', () => {
            var el = document.querySelector('.theme-icon-active');
            if(el != 'undefined' && el != null) {
                const showActiveTheme = theme => {
                    const activeThemeIcon = document.querySelector('.theme-icon-active use')
                    const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
                    const svgOfActiveBtn = btnToActive.querySelector('.mode-switch use').getAttribute('href')

                    document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
                        element.classList.remove('active')
                    })

                    btnToActive.classList.add('active')
                    activeThemeIcon.setAttribute('href', svgOfActiveBtn)
                }

                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                    if (storedTheme !== 'light' || storedTheme !== 'dark') {
                        setTheme(getPreferredTheme())
                    }
                })

                showActiveTheme(getPreferredTheme())

                document.querySelectorAll('[data-bs-theme-value]')
                    .forEach(toggle => {
                        toggle.addEventListener('click', () => {
                            const theme = toggle.getAttribute('data-bs-theme-value')
                            localStorage.setItem('theme', theme)
                            setTheme(theme)
                            showActiveTheme(theme)
                        })
                    })

            }
        })

    </script>
</head>
<body>

    <x-site.header />

    {{ $slot }}

    <!-- Footer START -->
    <footer class="bg-dark pt-5">
        <div class="container">
            <!-- Row START -->
            <div class="row g-4">

                <!-- Widget 1 START -->
                <div class="col-lg-3">
                    <!-- logo -->
                    <a href="index.html">
                        <img class="h-40px" src="{{ asset('images/logo-light.svg') }}" alt="logo">
                    </a>
                    <p class="my-3 text-muted">Departure defective arranging rapturous did believe him all had supported.</p>
                    <p class="mb-2"><a href="#" class="text-muted text-primary-hover"><i class="bi bi-telephone me-2"></i>+1234 568 963</a> </p>
                    <p class="mb-0"><a href="#" class="text-muted text-primary-hover"><i class="bi bi-envelope me-2"></i>example@gmail.com</a></p>
                </div>
                <!-- Widget 1 END -->

                <!-- Widget 2 START -->
                <div class="col-lg-8 ms-auto">
                    <div class="row g-4">
                        <!-- Link block -->
                        <div class="col-6 col-md-3">
                            <h5 class="text-white mb-2 mb-md-4">Page</h5>
                            <ul class="nav flex-column text-primary-hover">
                                <li class="nav-item"><a class="nav-link text-muted" href="#">About us</a></li>
                                <li class="nav-item"><a class="nav-link text-muted" href="#">Contact us</a></li>
                                <li class="nav-item"><a class="nav-link text-muted" href="#">News and Blog</a></li>
                                <li class="nav-item"><a class="nav-link text-muted" href="#">Meet a Team</a></li>
                            </ul>
                        </div>

                        <!-- Link block -->
                        <div class="col-6 col-md-3">
                            <h5 class="text-white mb-2 mb-md-4">Link</h5>
                            <ul class="nav flex-column text-primary-hover">
                                <li class="nav-item"><a class="nav-link text-muted" href="#">Sign up</a></li>
                                <li class="nav-item"><a class="nav-link text-muted" href="#">Sign in</a></li>
                                <li class="nav-item"><a class="nav-link text-muted" href="#">Privacy Policy</a></li>
                                <li class="nav-item"><a class="nav-link text-muted" href="#">Terms</a></li>
                                <li class="nav-item"><a class="nav-link text-muted" href="#">Cookie</a></li>
                                <li class="nav-item"><a class="nav-link text-muted" href="#">Support</a></li>
                            </ul>
                        </div>

                        <!-- Link block -->
                        <div class="col-6 col-md-3">
                            <h5 class="text-white mb-2 mb-md-4">Global Site</h5>
                            <ul class="nav flex-column text-primary-hover">
                                <li class="nav-item"><a class="nav-link text-muted" href="#">India</a></li>
                                <li class="nav-item"><a class="nav-link text-muted" href="#">California</a></li>
                                <li class="nav-item"><a class="nav-link text-muted" href="#">Indonesia</a></li>
                                <li class="nav-item"><a class="nav-link text-muted" href="#">Canada</a></li>
                                <li class="nav-item"><a class="nav-link text-muted" href="#">Malaysia</a></li>
                            </ul>
                        </div>

                        <!-- Link block -->
                        <div class="col-6 col-md-3">
                            <h5 class="text-white mb-2 mb-md-4">Booking</h5>
                            <ul class="nav flex-column text-primary-hover">
                                <li class="nav-item"><a class="nav-link text-muted" href="#"><i class="fa-solid fa-hotel me-2"></i>Hotel</a></li>
                                <li class="nav-item"><a class="nav-link text-muted" href="#"><i class="fa-solid fa-plane me-2"></i>Flight</a></li>
                                <li class="nav-item"><a class="nav-link text-muted" href="#"><i class="fa-solid fa-globe-americas me-2"></i>Tour</a></li>
                                <li class="nav-item"><a class="nav-link text-muted" href="#"><i class="fa-solid fa-car me-2"></i>Cabs</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Widget 2 END -->

            </div><!-- Row END -->

            <!-- Tops Links -->
            <div class="row mt-5">
                <h5 class="mb-2 text-white">Top Links</h5>
                <ul class="list-inline text-primary-hover lh-lg">
                    <li class="list-inline-item"><a href="#" class="text-muted">Flights</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">Hotels</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">Tours</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">Cabs</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">About</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">Contact us</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">Blogs</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">Services</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">Detail page</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">Services</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">Policy</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">Testimonials</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">Newsletters</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">Podcasts</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">Protests</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">NewsCyber</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">Education</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">Sports</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">Tech and Auto</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">Opinion</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted">Share Market</a></li>
                </ul>
            </div>

            <!-- Payment and card -->
            <div class="row g-4 justify-content-between mt-0 mt-md-2">

                <!-- Payment card -->
                <div class="col-sm-7 col-md-6 col-lg-4">
                    <h5 class="text-white mb-2">Payment & Security</h5>
                    <ul class="list-inline mb-0 mt-3">
                        <li class="list-inline-item"> <a href="#"><img src="{{ asset('images/element/paypal.svg') }}" class="h-30px" alt=""></a></li>
                        <li class="list-inline-item"> <a href="#"><img src="{{ asset('images/element/visa.svg') }}" class="h-30px" alt=""></a></li>
                        <li class="list-inline-item"> <a href="#"><img src="{{ asset('images/element/mastercard.svg') }}" class="h-30px" alt=""></a></li>
                        <li class="list-inline-item"> <a href="#"><img src="{{ asset('images/element/expresscard.svg') }}" class="h-30px" alt=""></a></li>
                    </ul>
                </div>

                <!-- Social media icon -->
                <div class="col-sm-5 col-md-6 col-lg-3 text-sm-end">
                    <h5 class="text-white mb-2">Follow us on</h5>
                    <ul class="list-inline mb-0 mt-3">
                        <li class="list-inline-item"> <a class="btn btn-sm px-2 bg-facebook mb-0" href="#"><i class="fab fa-fw fa-facebook-f"></i></a> </li>
                        <li class="list-inline-item"> <a class="btn btn-sm shadow px-2 bg-instagram mb-0" href="#"><i class="fab fa-fw fa-instagram"></i></a> </li>
                        <li class="list-inline-item"> <a class="btn btn-sm shadow px-2 bg-twitter mb-0" href="#"><i class="fab fa-fw fa-twitter"></i></a> </li>
                        <li class="list-inline-item"> <a class="btn btn-sm shadow px-2 bg-linkedin mb-0" href="#"><i class="fab fa-fw fa-linkedin-in"></i></a> </li>
                    </ul>
                </div>
            </div>

            <!-- Divider -->
            <hr class="mt-4 mb-0">

            <!-- Bottom footer -->
            <div class="row">
                <div class="container">
                    <div class="d-lg-flex justify-content-between align-items-center py-3 text-center text-lg-start">
                        <!-- copyright text -->
                        <div class="text-muted text-primary-hover"> Copyrights ©2023 Booking. Build by <a href="https://www.webestica.com/" class="text-muted">Webestica</a>. </div>
                        <!-- copyright links-->
                        <div class="nav mt-2 mt-lg-0">
                            <ul class="list-inline text-primary-hover mx-auto mb-0">
                                <li class="list-inline-item me-0"><a class="nav-link py-1 text-muted" href="#">Privacy policy</a></li>
                                <li class="list-inline-item me-0"><a class="nav-link py-1 text-muted" href="#">Terms and conditions</a></li>
                                <li class="list-inline-item me-0"><a class="nav-link py-1 text-muted pe-0" href="#">Refund policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer END -->

    <!-- Back to top -->
    <div class="back-top"></div>

<script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/flatpickr/js/flatpickr.min.js') }}"></script>
<script src="{{ asset('vendor/choices/js/choices.min.js') }}"></script>
<script src="{{ asset('vendor/tiny-slider/tiny-slider.js') }}"></script>
<script src="{{ asset('vendor/nouislider/nouislider.min.js') }}"></script>
<script src="{{ asset('js/functions.js') }}"></script>

</body>
</html>
