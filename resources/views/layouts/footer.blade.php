<div class="container">
    <div class="row pb-5">
        <div class="col-lg-3 col-12 mb-4">
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/images/last.png') }}" class="logo img-fluid" alt="logo">
        </a>
        </div>

        <div class="col-lg-4 col-md-6 col-12 mb-4">
            <h5 class="site-footer-title mb-3">Quick Links</h5>

            <ul class="footer-menu">
                <li class="footer-menu-item"><a href="{{ route('about') }}" class="footer-menu-link">How to use</a></li>
                <li class="footer-menu-item"><a href="{{ route('service') }}" class="footer-menu-link">Become a member</a></li>
            </ul>
        </div>

        <div class="col-lg-4 col-md-6 col-12 mx-auto">
            <h5 class="site-footer-title mb-3">Contact Infomation</h5>

            <p class="text-white d-flex mb-2">
                <i class="bi-telephone me-2"></i>

                <a href="tel: 120-240-9600" class="site-footer-link">
                    +8801537403196
                </a>
            </p>

            <p class="text-white d-flex">
                <i class="bi-envelope me-2"></i>

                <a href="mailto:info@yourgmail.com" class="site-footer-link">
                   info@slinqq.com
                </a>
            </p>
        <!--
            <p class="text-white d-flex mt-3">
                <i class="bi-geo-alt me-2"></i>
                Akershusstranda 20, 0150 Oslo, Norway
            </p>

            <a href="#" class="custom-btn btn mt-3">Get Direction</a>
        -->
        
        </div>
    </div>
</div>