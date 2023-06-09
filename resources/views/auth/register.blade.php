
<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta17
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Sign up - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
    <!-- CSS files -->
    <link href="{{ asset('') }}assets/dist/css/tabler.min.css?1674944402" rel="stylesheet"/>
    <link href="{{ asset('') }}assets/dist/css/tabler-flags.min.css?1674944402" rel="stylesheet"/>
    <link href="{{ asset('') }}assets/dist/css/tabler-payments.min.css?1674944402" rel="stylesheet"/>
    <link href="{{ asset('') }}assets/dist/css/tabler-vendors.min.css?1674944402" rel="stylesheet"/>
    <link href="{{ asset('') }}assets/dist/css/demo.min.css?1674944402" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
        background-image: url('{{ asset ('') }}assets/logo/background-login.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
      .logo-image {
    width: 200px;
    height: auto;
    }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <script src="{{ asset('') }}assets/dist/js/demo-theme.min.js?1674944402"></script>
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
          <a href="." class="navbar-brand navbar-brand-autodark">
            <img src="{{ asset('assets/logo/cmnplogo.png') }}" alt="Logo" class="mb-3 logo-image">
        </a>
        </div>
        <form class="card card-md" action="{{ route('register') }}" method="POST" autocomplete="off" novalidate>
            @csrf
            <div class="card-body">
            <h2 class="card-title text-center mb-4">Create new account</h2>
            <div class="row">
                <div class="col form-floating mb-3">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                    <label for="name">Name</label>
                </div>
                <div class="col form-floating mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                    <label for="username">Username</label>
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
                <label for="email">Email address</label>
            </div>
            <div class="row">
                <div class="col form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password"  autocomplete="off">
                    <label for="password">Password</label>
                </div>
                <div class="col form-floating mb-3">
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Password"  autocomplete="off">
                    <label for="password_confirmation">Confirm Password</label>
                </div>
            </div>
            <div class="form-footer">
              <button type="submit" class="btn btn-primary w-100">Create new account</button>
            </div>
          </div>
        </form>
        <div class="text-center text-muted mt-3">
          Already have account? <a href="{{ route('login') }}" tabindex="-1">Sign in</a>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{ asset('') }}assets/dist/js/tabler.min.js?1674944402" defer></script>
    <script src="{{ asset('') }}assets/dist/js/demo.min.js?1674944402" defer></script>
  </body>
</html>
