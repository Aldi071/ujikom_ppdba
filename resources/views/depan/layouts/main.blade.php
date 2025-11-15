<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>SPMB 2025/2026 - BAKNUS 666</title>
  <meta content="Penerimaan Peserta Didik Baru BAKNUS 666 Tahun Ajaran 2025/2026. Daftar sekarang dan bergabung bersama kami!" name="description" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.12/typed.min.js"></script>
  <script src="https://unpkg.com/splitting@1.0.6/dist/splitting.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/splitting@1.0.6/dist/splitting.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/matter-js/0.19.0/matter.min.js"></script>
  <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
</head>

<body>
  <div id="loader-wrapper">
    <div class="loader">
      <div class="inner"></div>
    </div>
  </div>
  @include('depan.partials.header')

  @yield('content')
  @if(session('success'))
  <div style="position: fixed; top: 20px; right: 20px; background: #10b981; color: white; padding: 15px 25px; border-radius: 10px; z-index: 10000; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
    {{ session('success') }}
  </div>
  @endif

  @if(session('error'))
  <div style="position: fixed; top: 20px; right: 20px; background: #ef4444; color: white; padding: 15px 25px; border-radius: 10px; z-index: 10000; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
    {{ session('error') }}
  </div>
  @endif

  @include('depan.partials.footer')

  <script src="{{ asset('js/main.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
</body>