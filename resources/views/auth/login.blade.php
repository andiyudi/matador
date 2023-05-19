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
    <title>Sign in - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
    <!-- CSS files -->
    <link href="{{ asset ('') }}assets/dist/css/tabler.min.css?1674944402" rel="stylesheet"/>
    <link href="{{ asset ('') }}assets/dist/css/tabler-flags.min.css?1674944402" rel="stylesheet"/>
    <link href="{{ asset ('') }}assets/dist/css/tabler-payments.min.css?1674944402" rel="stylesheet"/>
    <link href="{{ asset ('') }}assets/dist/css/tabler-vendors.min.css?1674944402" rel="stylesheet"/>
    <link href="{{ asset ('') }}assets/dist/css/demo.min.css?1674944402" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <script src="{{ asset ('') }}assets/dist/js/demo-theme.min.js?1674944402"></script>
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
        </div>
        <div class="card card-md">
          <div class="card-body">
            <h3 class="text-center mb-4">APLIKASI MANAJEMEN DATABASE VENDOR</h3>
            <form method="POST" action="{{ route('login') }}" autocomplete="off" novalidate>
                @csrf
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="username" name="username" class="form-control" placeholder="Your username" autocomplete="off">
              </div>
              <div class="mb-2">
                <label class="form-label">
                  Password
                </label>
                <div class="input-group input-group-flat">
                  <input type="password"  name="password" class="form-control"  placeholder="Your password"  autocomplete="off">
                  <span class="input-group-text">
                  </span>
                </div>
              </div>
              <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">Sign in</button>
              </div>
            </form>
          </div>
        </div>
        <div class="text-center text-muted mt-3">
          Don't have account yet? <a href="{{ route('register') }}" tabindex="-1">Sign up</a>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{ asset ('') }}assets/dist/js/tabler.min.js?1674944402" defer></script>
    <script src="{{ asset ('') }}assets/dist/js/demo.min.js?1674944402" defer></script>
  </body>
</html>
