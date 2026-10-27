<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Masuk & Registrasi - Perpustakaan Digital Kampus</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #059669;
            --primary-hover: #047857;
            --primary-light: #ecfdf5;
            --primary-border: #a7f3d0;
            --accent-teal: #0d9488;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --text-sub: #94a3b8;
            --bg-page: #f8fafc;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --radius-lg: 24px;
            --radius-md: 14px;
            --radius-sm: 10px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background-color: var(--bg-page);
            background-image:
                radial-gradient(at 0% 0%, #ecfdf5 0px, transparent 55%),
                radial-gradient(at 100% 100%, #eff6ff 0px, transparent 50%),
                radial-gradient(at 50% 50%, #f8fafc 0px, transparent 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            color: var(--text-main);
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
            background: var(--card-bg);
            border-radius: var(--radius-lg);
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 20px 45px -12px rgba(15, 23, 42, 0.12), 0 4px 16px -2px rgba(15, 23, 42, 0.04);
            padding: 28px 24px;
            position: relative;
            overflow: hidden;
            animation: fadeIn 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Top Brand Bar */
        .brand-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            background: #f0fdf4;
            border: 1px solid var(--primary-border);
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            color: var(--primary);
        }

        .brand-badge svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }

        .app-status {
            font-size: 11px;
            color: #059669;
            background: #d1fae5;
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 600;
        }

        .welcome-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }

        .welcome-desc {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 20px;
            line-height: 1.5;
        }

        /* Navigation Mode Tabs (Masuk vs Daftar) */
        .tab-mode-pill {
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #f1f5f9;
            padding: 4px;
            border-radius: var(--radius-md);
            margin-bottom: 18px;
            gap: 4px;
        }

        .tab-btn {
            border: none;
            background: transparent;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .tab-btn.active {
            background: #ffffff;
            color: var(--primary);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        /* Role Segment Selector */
        .role-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 14px;
        }

        .role-btn {
            border: 1.5px solid var(--border-color);
            background: #ffffff;
            padding: 10px 12px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }

        .role-btn:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
        }

        .role-btn.active {
            border-color: var(--primary);
            background: #f0fdf4;
            color: var(--primary);
            font-weight: 700;
        }

        /* Sub-Segment (Misal: Guru Ijazah vs Non-Ijazah) */
        .sub-segment {
            display: flex;
            gap: 6px;
            margin-bottom: 16px;
            background: #f8fafc;
            padding: 4px;
            border-radius: 10px;
            border: 1px dashed var(--border-color);
        }

        .sub-btn {
            flex: 1;
            border: none;
            background: transparent;
            padding: 6px 8px;
            border-radius: 8px;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.15s ease;
            text-align: center;
        }

        .sub-btn.active {
            background: var(--primary);
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(5, 150, 105, 0.25);
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 14px;
            text-align: left;
        }

        .form-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .forgot-link {
            font-size: 12px;
            color: #0284c7;
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: var(--text-sub);
            width: 17px;
            height: 17px;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 11px 14px 11px 40px;
            font-size: 13.5px;
            color: var(--text-main);
            background: #ffffff;
            border: 1.5px solid var(--border-color);
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
            outline: none;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.12);
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: var(--text-sub);
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle:hover {
            color: var(--text-main);
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 16px;
            cursor: pointer;
        }

        .form-check input {
            accent-color: var(--primary);
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        /* Toggle switch (Lokasi) */
        .switch-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
            background: #f8fafc;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-color);
            margin-bottom: 14px;
        }

        .switch-label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-main);
        }

        .switch-sub {
            font-size: 11px;
            color: var(--text-muted);
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 38px;
            height: 22px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #cbd5e1;
            transition: .3s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--primary);
        }

        input:checked + .slider:before {
            transform: translateX(16px);
        }

        /* Main Submit Button */
        .btn-submit {
            width: 100%;
            padding: 13px 20px;
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: #ffffff;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.02em;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(5, 150, 105, 0.35);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            margin-top: 6px;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(5, 150, 105, 0.45);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* 1-Klik Akses Cepat (Demo Box dari screenshot HP) */
        .quick-access-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: var(--radius-md);
            padding: 12px;
            margin-top: 18px;
            text-align: left;
        }

        .quick-access-header {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 800;
            color: #475569;
            letter-spacing: 0.04em;
            margin-bottom: 10px;
        }

        .quick-user-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
            padding: 8px 10px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            margin-bottom: 6px;
            transition: all 0.15s ease;
        }

        .quick-user-card:last-child {
            margin-bottom: 0;
        }

        .quick-user-card:hover {
            border-color: var(--primary-border);
            background: #f0fdf4;
        }

        .quick-user-info {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .quick-avatar {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: #d1fae5;
            color: #065f46;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
        }

        .quick-user-text h4 {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
        }

        .quick-user-text p {
            font-size: 10.5px;
            color: var(--text-muted);
            margin: 0;
        }

        .btn-try {
            background: #ffffff;
            border: 1px solid #059669;
            color: #059669;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn-try:hover {
            background: #059669;
            color: #ffffff;
        }

        /* Divider & Social Login */
        .divider-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 18px 0 14px;
            color: var(--text-sub);
            font-size: 11.5px;
            font-weight: 500;
        }

        .divider-row::before, .divider-row::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .social-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 16px;
        }

        .btn-social {
            background: #ffffff;
            border: 1.5px solid var(--border-color);
            padding: 9px 12px;
            border-radius: var(--radius-sm);
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn-social:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
        }

        .btn-social svg {
            width: 16px;
            height: 16px;
        }

        /* Footer Link */
        .auth-footer {
            margin-top: 10px;
            font-size: 12px;
            color: var(--text-muted);
            text-align: center;
        }

        .auth-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            cursor: pointer;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        /* Alert notifications */
        .alert-box {
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            font-size: 12.5px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-align: left;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .error-hint {
            font-size: 11.5px;
            color: #b91c1c;
            margin-top: 4px;
            font-weight: 500;
        }

        /* Hide elements dynamically */
        .hidden {
            display: none !important;
        }
    </style>
</head>
<body>

<div class="auth-container">
    <!-- Top Brand Header -->
    <div class="brand-header">
        <div class="brand-badge">
            <svg viewBox="0 0 24 24"><path d="M12 3L1 9l11 6 9-4.91V17h2V9M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/></svg>
            EduPustaka Jemari
        </div>
        <span class="app-status">● Live V12</span>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert-box alert-success">
            <span>✓</span> {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-box alert-error">
            <span>⚠️</span> Periksa kembali data formulir Anda.
        </div>
    @endif

    <!-- Tab Navigasi Mode: Masuk vs Daftar -->
    <div class="tab-mode-pill">
        <button type="button" class="tab-btn active" id="tabLoginBtn" onclick="switchMainTab('login')">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
            Masuk ke Akun
        </button>
        <button type="button" class="tab-btn" id="tabRegisterBtn" onclick="switchMainTab('register')">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
            Buat Akun Baru
        </button>
    </div>

    <!-- ==================== TAB 1: FORM LOGIN ==================== -->
    <div id="loginViewSection">
        <div class="welcome-title" id="loginGreeting">Selamat Datang 👋</div>
        <p class="welcome-desc" id="loginSubDesc">Masuk untuk mengakses materi digital, pinjaman buku, & fasilitas kampus.</p>

        <!-- Role Selector (Siswa / Guru) -->
        <div class="role-selector">
            <button type="button" class="role-btn active" id="loginRoleSiswa" onclick="selectLoginRole('siswa')">
                <span>🎓</span> Siswa / Peserta
            </button>
            <button type="button" class="role-btn" id="loginRoleGuru" onclick="selectLoginRole('guru')">
                <span>👨‍🏫</span> Guru / Petugas
            </button>
        </div>

        <!-- Sub Segment khusus Guru (sesuai PDF hal 1: Ijazah vs Non-Ijazah) -->
        <div class="sub-segment hidden" id="guruSubSegment">
            <button type="button" class="sub-btn active" id="subBtnIjazah" onclick="setGuruSub('ijazah')">
                ✓ Guru Berijazah / NIP
            </button>
            <button type="button" class="sub-btn" id="subBtnNonIjazah" onclick="setGuruSub('non-ijazah')">
                Non-Ijazah / Asisten
            </button>
        </div>

        <!-- Form Login ke Backend Laravel -->
        <form action="{{ route('login') }}" method="POST" id="mainLoginForm">
            @csrf

            <!-- Input Email / NIP -->
            <div class="form-group">
                <label class="form-label" for="loginEmail" id="emailInputLabel">Email atau Nomor Handphone</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </span>
                    <input type="text" name="email" id="loginEmail" class="form-input"
                           value="{{ old('email', 'admin@pens.ac.id') }}"
                           placeholder="Contoh: nama@pens.ac.id" required autofocus>
                </div>
                @error('email')
                    <div class="error-hint">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Password -->
            <div class="form-group">
                <div class="form-label">
                    <span>Kata Sandi</span>
                    <a href="javascript:void(0)" onclick="alert('Hubungi admin perpustakaan di admin@pens.ac.id untuk reset kata sandi Anda.')" class="forgot-link">Lupa Kata Sandi?</a>
                </div>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </span>
                    <input type="password" name="password" id="loginPassword" class="form-input"
                           value="password" placeholder="••••••••" required>
                    <button type="button" class="password-toggle" onclick="togglePasswordVisibility('loginPassword', this)">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
                @error('password')
                    <div class="error-hint">{{ $message }}</div>
                @enderror
            </div>

            <!-- Checkbox Ingat Saya -->
            <label class="form-check">
                <input type="checkbox" name="remember" id="rememberMe" checked>
                <span>Ingat saya di perangkat ini</span>
            </label>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit" id="loginSubmitBtn">
                <span id="btnSubmitText">MASUK SEBAGAI SISWA</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </button>
        </form>

        <!-- 1-Klik Akses Cepat (Demo Mode dari screenshot HP) -->
        <div class="quick-access-box">
            <div class="quick-access-header">
                <span>⚡</span> AKSES CEPAT TANPA KETIK (1-KLIK DEMO):
            </div>

            <!-- Demo 1: Admin Perpustakaan -->
            <div class="quick-user-card">
                <div class="quick-user-info">
                    <div class="quick-avatar" style="background:#fef3c7; color:#92400e;">BS</div>
                    <div class="quick-user-text">
                        <h4>Bambang Sutrisno</h4>
                        <p>Admin Utama (Akses Lengkap)</p>
                    </div>
                </div>
                <button type="button" class="btn-try" onclick="applyDemoLogin('admin@pens.ac.id', 'password', 'guru')">Coba Sekarang</button>
            </div>

            <!-- Demo 2: Petugas Sirkulasi -->
            <div class="quick-user-card">
                <div class="quick-user-info">
                    <div class="quick-avatar" style="background:#e0e7ff; color:#3730a3;">SR</div>
                    <div class="quick-user-text">
                        <h4>Siti Rahmawati</h4>
                        <p>Petugas Sirkulasi & Pinjaman</p>
                    </div>
                </div>
                <button type="button" class="btn-try" onclick="applyDemoLogin('petugas1@pens.ac.id', 'password', 'guru')">Coba Sekarang</button>
            </div>

            <!-- Demo 3: Siswa / Mahasiswa -->
            <div class="quick-user-card">
                <div class="quick-user-info">
                    <div class="quick-avatar">AP</div>
                    <div class="quick-user-text">
                        <h4>Alya Putri / Faiz</h4>
                        <p>Siswa / Mahasiswa Aktif</p>
                    </div>
                </div>
                <button type="button" class="btn-try" onclick="applyDemoLogin('petugas2@pens.ac.id', 'password', 'siswa')">Coba Sekarang</button>
            </div>
        </div>

        <!-- Social Divider -->
        <div class="divider-row">atau masuk dengan</div>

        <!-- Social Buttons -->
        <div class="social-buttons">
            <button type="button" class="btn-social" onclick="alert('Autentikasi Google terintegrasi siap diaktifkan.')">
                <svg viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
                Google
            </button>
            <button type="button" class="btn-social" onclick="alert('Autentikasi Apple ID terintegrasi siap diaktifkan.')">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.37c.62-.75 1.04-1.8 0.93-2.85-.9.04-1.99.6-2.63 1.35-.56.65-.96 1.7-0.84 2.73 1.01.08 2.05-.51 2.54-1.23z"/></svg>
                Apple
            </button>
        </div>

        <div class="auth-footer">
            Belum memiliki akun terdaftar?
            <a href="javascript:void(0)" onclick="switchMainTab('register')">Daftar Akun Baru Sekarang</a>
        </div>
    </div>

    <!-- ==================== TAB 2: FORM REGISTRASI (PDF Hal 2 & 3) ==================== -->
    <div id="registerViewSection" class="hidden">
        <div class="welcome-title">Form Pendaftaran Baru 📝</div>
        <p class="welcome-desc">Lengkapi data Anda untuk mendaftar sebagai Siswa, Orang Tua, atau Guru.</p>

        <!-- Role Pendaftaran (Siswa vs Guru vs Orangtua) -->
        <div class="role-selector" style="grid-template-columns: 1fr 1fr 1fr; margin-bottom: 16px;">
            <button type="button" class="role-btn active" id="regRoleSiswa" onclick="selectRegRole('siswa')">
                Siswa
            </button>
            <button type="button" class="role-btn" id="regRoleGuru" onclick="selectRegRole('guru')">
                Guru
            </button>
            <button type="button" class="role-btn" id="regRoleOrtu" onclick="selectRegRole('ortu')">
                Orang Tua
            </button>
        </div>

        <form action="{{ route('register') }}" method="POST" id="mainRegisterForm">
            @csrf
            <input type="hidden" name="role_type" id="hiddenRegRole" value="siswa">

            <!-- Field Nama -->
            <div class="form-group">
                <label class="form-label" id="regNameLabel">Nama Lengkap (sesuai KTP / Kartu Pelajar)</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </span>
                    <input type="text" name="name" id="regName" class="form-input" placeholder="Masukkan nama lengkap Anda" required>
                </div>
            </div>

            <!-- Field TTL & Alamat (PDF Hal 2 & 3) -->
            <div class="form-group">
                <label class="form-label">Tempat & Tanggal Lahir (TTL)</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </span>
                    <input type="text" name="ttl" class="form-input" placeholder="Contoh: Surabaya, 15 Mei 2005">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Alamat Domisili</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </span>
                    <input type="text" name="alamat" class="form-input" placeholder="Jl. Raya Sukolilo No. 10, Surabaya">
                </div>
            </div>

            <!-- Izin Lokasi Switch (PDF Hal 2 & 3) -->
            <div class="switch-row">
                <div>
                    <div class="switch-label">Izinkan Deteksi Lokasi</div>
                    <div class="switch-sub">Gunakan titik koordinat saat ini untuk verifikasi</div>
                </div>
                <label class="switch">
                    <input type="checkbox" id="locationPermToggle" onchange="handleLocationToggle(this)">
                    <span class="slider"></span>
                </label>
            </div>

            <!-- Khusus Siswa: NIM / NISN & Lembaga -->
            <div id="fieldSiswaSpecific">
                <div class="form-group">
                    <label class="form-label">NIM / NISN / No. Induk Pelajar</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                        </span>
                        <input type="text" name="nim" class="form-input" placeholder="Contoh: 312250001">
                    </div>
                </div>
            </div>

            <!-- Khusus Guru: Detail Kualifikasi (PDF Hal 3) -->
            <div id="fieldGuruSpecific" class="hidden">
                <div class="form-group">
                    <label class="form-label">Bidang Studi / Mata Pelajaran yang Diajar</label>
                    <div class="input-wrapper">
                        <span class="input-icon">📚</span>
                        <select name="bidang_studi" class="form-select">
                            <option value="Teknologi Informasi">Teknologi Informasi & Pemrograman</option>
                            <option value="Sains & Matematika">Sains & Matematika</option>
                            <option value="Bahasa & Sastra">Bahasa & Sastra Indonesia</option>
                            <option value="Sejarah & Sosial">Sejarah & Ilmu Sosial</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Status Ijazah & Pendidikan Terakhir</label>
                    <div class="input-wrapper">
                        <span class="input-icon">🎓</span>
                        <select name="ijazah" class="form-select">
                            <option value="S1 - Berijazah">S1 / Sarjana (Terverifikasi Ijazah Resmi)</option>
                            <option value="S2 - Magister">S2 / Magister (Poin Plus Aplikasi)</option>
                            <option value="Mahasiswa Aktif">Mahasiswa Tingkat Akhir (Non-Ijazah / Asisten)</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Kelamin</label>
                    <div class="input-wrapper">
                        <span class="input-icon">👤</span>
                        <select name="gender" class="form-select">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Khusus Orang Tua: Form Nama Anak (PDF Hal 2) -->
            <div id="fieldOrtuSpecific" class="hidden">
                <div id="childrenContainer">
                    <div class="form-group">
                        <label class="form-label">Nama Anak Anda (Siswa)</label>
                        <div class="input-wrapper">
                            <span class="input-icon">👶</span>
                            <input type="text" name="anak_nama[]" class="form-input" placeholder="Nama lengkap anak">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenjang Pendidikan Terakhir Anak</label>
                        <div class="input-wrapper">
                            <span class="input-icon">🏫</span>
                            <input type="text" name="anak_jenjang[]" class="form-input" placeholder="Contoh: SMA Kelas 11 / Mahasiswa Semester 3">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-try" style="margin-bottom: 14px; width: 100%;" onclick="tambahAnakField()">
                    + Tambah Data Anak Lainnya
                </button>
            </div>

            <!-- Informasi Kontak & Akun -->
            <div class="form-group">
                <label class="form-label">Email Kampus / Aktif</label>
                <div class="input-wrapper">
                    <span class="input-icon">✉️</span>
                    <input type="email" name="email" class="form-input" placeholder="nama@domain.com" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Nomor WhatsApp / HP</label>
                <div class="input-wrapper">
                    <span class="input-icon">📱</span>
                    <input type="text" name="nomor_telepon" class="form-input" placeholder="08xxxxxxxxxx">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Kata Sandi Akun Baru</label>
                <div class="input-wrapper">
                    <span class="input-icon">🔒</span>
                    <input type="password" name="password" id="regPassword" class="form-input" placeholder="Minimal 6 karakter" required>
                    <button type="button" class="password-toggle" onclick="togglePasswordVisibility('regPassword', this)">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-submit" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
                DAFTAR SEKARANG
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </form>

        <div class="auth-footer" style="margin-top: 16px;">
            Sudah memiliki akun terdaftar?
            <a href="javascript:void(0)" onclick="switchMainTab('login')">Masuk ke Akun</a>
        </div>
    </div>
</div>

<script>
    // Tab Mode Utama: 'login' atau 'register'
    function switchMainTab(mode) {
        const loginBtn = document.getElementById('tabLoginBtn');
        const regBtn = document.getElementById('tabRegisterBtn');
        const loginSection = document.getElementById('loginViewSection');
        const regSection = document.getElementById('registerViewSection');

        if (mode === 'login') {
            loginBtn.classList.add('active');
            regBtn.classList.remove('active');
            loginSection.classList.remove('hidden');
            regSection.classList.add('hidden');
        } else {
            regBtn.classList.add('active');
            loginBtn.classList.remove('active');
            regSection.classList.remove('hidden');
            loginSection.classList.add('hidden');
        }
    }

    // Role Selector pada Login
    let currentLoginRole = 'siswa';
    function selectLoginRole(role) {
        currentLoginRole = role;
        const btnSiswa = document.getElementById('loginRoleSiswa');
        const btnGuru = document.getElementById('loginRoleGuru');
        const guruSub = document.getElementById('guruSubSegment');
        const submitText = document.getElementById('btnSubmitText');
        const greeting = document.getElementById('loginGreeting');
        const subDesc = document.getElementById('loginSubDesc');
        const emailLabel = document.getElementById('emailInputLabel');

        if (role === 'siswa') {
            btnSiswa.classList.add('active');
            btnGuru.classList.remove('active');
            guruSub.classList.add('hidden');
            submitText.textContent = 'MASUK SEBAGAI SISWA';
            greeting.textContent = 'Selamat Datang Siswa 👋';
            subDesc.textContent = 'Login untuk meminjam buku, akses modul belajar, & ruang kelas digital.';
            emailLabel.textContent = 'Email atau NISN / Nomor Handphone';
        } else {
            btnGuru.classList.add('active');
            btnSiswa.classList.remove('active');
            guruSub.classList.remove('hidden');
            submitText.textContent = 'MASUK SEBAGAI GURU / PETUGAS';
            greeting.textContent = 'Login Guru / Petugas Perpustakaan 👨‍🏫';
            subDesc.textContent = 'Login untuk mengelola sirkulasi buku, verifikasi anggota, & input data materi.';
            emailLabel.textContent = 'NIP atau Email Dinas (@pens.ac.id)';
        }
    }

    function setGuruSub(type) {
        const ijazahBtn = document.getElementById('subBtnIjazah');
        const nonIjazahBtn = document.getElementById('subBtnNonIjazah');
        if (type === 'ijazah') {
            ijazahBtn.classList.add('active');
            nonIjazahBtn.classList.remove('active');
        } else {
            nonIjazahBtn.classList.add('active');
            ijazahBtn.classList.remove('active');
        }
    }

    // 1-Klik Akses Cepat (Demo Mode)
    function applyDemoLogin(email, password, role) {
        selectLoginRole(role);
        const emailInput = document.getElementById('loginEmail');
        const passwordInput = document.getElementById('loginPassword');

        emailInput.value = email;
        passwordInput.value = password;

        // Visual flash highlight
        emailInput.style.backgroundColor = '#ecfdf5';
        passwordInput.style.backgroundColor = '#ecfdf5';
        setTimeout(() => {
            emailInput.style.backgroundColor = '#ffffff';
            passwordInput.style.backgroundColor = '#ffffff';
        }, 500);

        // Submit form otomatis setelah 250ms
        setTimeout(() => {
            document.getElementById('mainLoginForm').submit();
        }, 300);
    }

    // Password Visibility Toggle
    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = `<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`;
        } else {
            input.type = 'password';
            btn.innerHTML = `<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
        }
    }

    // Role Pendaftaran (Siswa vs Guru vs Orangtua)
    function selectRegRole(role) {
        const btnSiswa = document.getElementById('regRoleSiswa');
        const btnGuru = document.getElementById('regRoleGuru');
        const btnOrtu = document.getElementById('regRoleOrtu');
        const hiddenRole = document.getElementById('hiddenRegRole');

        const fieldSiswa = document.getElementById('fieldSiswaSpecific');
        const fieldGuru = document.getElementById('fieldGuruSpecific');
        const fieldOrtu = document.getElementById('fieldOrtuSpecific');
        const nameLabel = document.getElementById('regNameLabel');

        [btnSiswa, btnGuru, btnOrtu].forEach(b => b.classList.remove('active'));
        fieldSiswa.classList.add('hidden');
        fieldGuru.classList.add('hidden');
        fieldOrtu.classList.add('hidden');

        hiddenRole.value = role;

        if (role === 'siswa') {
            btnSiswa.classList.add('active');
            fieldSiswa.classList.remove('hidden');
            nameLabel.textContent = 'Nama Lengkap (sesuai Kartu Pelajar)';
        } else if (role === 'guru') {
            btnGuru.classList.add('active');
            fieldGuru.classList.remove('hidden');
            nameLabel.textContent = 'Nama Lengkap Guru (sesuai KTP)';
        } else {
            btnOrtu.classList.add('active');
            fieldOrtu.classList.remove('hidden');
            nameLabel.textContent = 'Nama Lengkap Orang Tua / Wali';
        }
    }

    // Tambah Field Anak Dinamis (PDF Hal 2)
    function tambahAnakField() {
        const container = document.getElementById('childrenContainer');
        const newGroup = document.createElement('div');
        newGroup.style.borderTop = '1px dashed #cbd5e1';
        newGroup.style.paddingTop = '10px';
        newGroup.style.marginTop = '10px';
        newGroup.innerHTML = `
            <div class="form-group">
                <label class="form-label">Nama Anak Tambahan</label>
                <div class="input-wrapper">
                    <span class="input-icon">👶</span>
                    <input type="text" name="anak_nama[]" class="form-input" placeholder="Nama lengkap anak berikutnya">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Pendidikan Terakhir Anak</label>
                <div class="input-wrapper">
                    <span class="input-icon">🏫</span>
                    <input type="text" name="anak_jenjang[]" class="form-input" placeholder="Jenjang kelas / semester">
                </div>
            </div>
        `;
        container.appendChild(newGroup);
    }

    // Lokasi Switch
    function handleLocationToggle(toggle) {
        if (toggle.checked && navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (pos) => console.log('Lokasi terdeteksi:', pos.coords.latitude, pos.coords.longitude),
                (err) => console.warn('Izin lokasi ditolak.')
            );
        }
    }
</script>

</body>
</html>
