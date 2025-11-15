<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>SPMB 2025/2026 - BAKNUS 666</title>
    <meta content="Penerimaan Peserta Didik Baru BAKNUS 666 Tahun Ajaran 2025/2026. Daftar sekarang dan bergabung bersama kami!"name="description" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap"rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.12/typed.min.js"></script>
    <script src="https://unpkg.com/splitting@1.0.6/dist/splitting.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/splitting@1.0.6/dist/splitting.css"rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css"rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/matter-js/0.19.0/matter.min.js"></script>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"rel="stylesheet" />
</head>
<body>
    <section class="section" id="login-section">
    <div class="container">
        <div class="form-container fade-in">
            <h2 class="section-title">Login Staff/Admin</h2>

            @if($errors->any())
            <div style="background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #dc2626;">
                <strong>Error:</strong> {{ $errors->first() }}
            </div>
            @endif

            @if(session('error'))
            <div style="background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #dc2626;">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="loginEmail">Email / NISN</label>
                    <input
                        id="loginEmail"
                        name="email"
                        placeholder="Masukkan email atau NISN"
                        required
                        type="text"
                        value="{{ old('email') }}" />
                </div>
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <input
                        id="loginPassword"
                        name="password"
                        placeholder="Masukkan password"
                        required
                        type="password" />
                </div>
                <button
                    class="btn btn-primary"
                    style="width: 100%; margin-top: 10px"
                    type="submit">
                    Login
                </button>
            </form>
        </div>
    </div>
</section>

    <script src="{{ asset('js/main.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
</body>