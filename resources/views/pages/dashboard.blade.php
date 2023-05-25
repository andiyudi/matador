@extends('layouts.templates')
@section('content')
<h1>Welcome to Dashboard, {{ auth()->user()->name }}</h1>
<div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Registered Vendors</h5>
          <p class="card-text" id="registeredCount">Loading...</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Active Vendors</h5>
          <p class="card-text" id="activeCount">Loading...</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Expired Vendors</h5>
          <p class="card-text" id="expiredCount">Loading...</p>
        </div>
      </div>
    </div>
  </div>


  <script>
    // Fungsi untuk mengambil data jumlah vendor terdaftar, aktif, dan kedaluwarsa melalui API
function fetchData() {
  fetch('{{ route('dashboard.vendor-count') }}')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        document.getElementById('registeredCount').textContent = data.registered;
        document.getElementById('activeCount').textContent = data.active;
        document.getElementById('expiredCount').textContent = data.expired;
      } else {
        console.log(data.message); // Menampilkan pesan error jika ada
      }
    })
    .catch(error => {
      console.log(error);
    });
}

// Memanggil fungsi fetchData saat halaman selesai dimuat
document.addEventListener('DOMContentLoaded', fetchData);

  </script>
@endsection
