<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Aplikasi Manajemen Database Vendor PT. Citra Marga Nusaphala Persada Tbk.</title>
    <!-- CSS files -->
   @include('includes.style')
   @stack('after-style')

  </head>
  <body >
    @routes()
    <script src="{{ asset ('') }}assets/dist/js/demo-theme.min.js?1674944402"></script>

    <div class="page">
      <!-- Sidebar -->
     @include('includes.sidebar')
      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                 {{-- {{ $pretitle ?? ''}} --}}
                </div>
                <h2 class="page-title">
                 {{-- {{ $title ?? ''}} --}}
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                @stack('page-action')
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
           @yield('content')
          </div>
        </div>
       @include('includes.footer')
      </div>
    </div>
    <!-- Libs JS -->
    @include('includes.script')
    @include('sweetalert::alert')
      </body>
</html>
