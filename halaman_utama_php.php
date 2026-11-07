<?php
require_once 'koneksi_database.php';

// Ambil Identitas Sekolah dari DB
$identityStmt = $pdo->query("SELECT * FROM school_identity WHERE id = 1");
$school = $identityStmt->fetch();
$isLoggedIn = isAdminLoggedIn();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($school['school_name']) ?> - Berita & Portal Sekolah</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#003366',
                            gold: '#FFCC00',
                            dark: '#001A33',
                            light: '#F4F6F9',
                            accent: '#D97706'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes ticker {
            0% { transform: translate3d(100%, 0, 0); }
            100% { transform: translate3d(-100%, 0, 0); }
        }
        .ticker-wrap {
            overflow: hidden;
            white-space: nowrap;
        }
        .ticker-move {
            display: inline-block;
            animation: ticker 25s linear infinite;
        }
        .ticker-move:hover {
            animation-play-state: paused;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800 antialiased min-h-screen flex flex-col scroll-smooth">

    <!-- ==================== TOP BAR ==================== -->
    <div class="bg-brand-dark text-white text-xs py-2 px-4 shadow-inner">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <!-- Info Kontak & Alamat -->
            <div class="flex flex-wrap justify-center sm:justify-start items-center gap-4">
                <span class="flex items-center gap-1.5 hover:text-brand-gold transition">
                    <i class="fa-solid fa-location-dot text-brand-gold"></i>
                    <span id="top-address"><?= htmlspecialchars($school['address']) ?></span>
                </span>
                <span class="hidden md:flex items-center gap-1.5 hover:text-brand-gold transition">
                    <i class="fa-solid fa-phone text-brand-gold"></i>
                    <span id="top-phone"><?= htmlspecialchars($school['phone']) ?></span>
                </span>
                <span class="hidden sm:flex items-center gap-1.5 hover:text-brand-gold transition">
                    <i class="fa-solid fa-envelope text-brand-gold"></i>
                    <span id="top-email"><?= htmlspecialchars($school['email']) ?></span>
                </span>
                <span class="hidden lg:flex items-center gap-1.5 bg-brand-blue px-2 py-0.5 rounded text-[11px] font-semibold border border-blue-400">
                    NPSN: <span id="top-npsn"><?= htmlspecialchars($school['npsn']) ?></span>
                </span>
            </div>

            <!-- Sosial Media & Tanggal -->
            <div class="flex items-center gap-4">
                <span id="current-date" class="text-gray-300 hidden md:inline"></span>
                <div class="flex items-center gap-3 border-l border-gray-700 pl-4">
                    <a href="#" class="hover:text-brand-gold transition" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-brand-gold transition" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="hover:text-brand-gold transition" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $school['phone']) ?>" target="_blank" class="hover:text-brand-gold transition" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== MAIN HEADER / BRANDING ==================== -->
    <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            
            <!-- Logo & Nama Sekolah -->
            <a href="#" class="flex items-center gap-3.5 group">
                <div class="w-12 h-14 sm:w-14 sm:h-16 flex-shrink-0 group-hover:scale-105 transition-transform">
                    <svg viewBox="0 0 200 240" class="w-full h-full drop-shadow-md">
                        <path d="M 100 10 L 185 45 C 185 140, 160 195, 100 230 C 40 195, 15 140, 15 45 Z" fill="#003366" stroke="#FFCC00" stroke-width="8" />
                        <circle cx="100" cy="110" r="42" fill="none" stroke="#FFCC00" stroke-width="8" stroke-dasharray="12 6"/>
                        <path d="M 100 50 Q 108 70 100 85 Q 92 70 100 50 Z" fill="#E53E3E"/>
                        <path d="M 94 85 L 106 85 L 103 115 L 97 115 Z" fill="#C53030"/>
                        <path d="M 65 90 Q 80 85 92 95 Q 75 115 65 90 Z" fill="#FFFFFF"/>
                        <path d="M 135 90 Q 120 85 108 95 Q 125 115 135 90 Z" fill="#FFFFFF"/>
                        <path d="M 70 140 Q 100 132 100 145 Q 100 132 130 140 L 130 147 Q 100 139 100 152 Q 100 139 70 147 Z" fill="#FFFFFF" stroke="#001A33" stroke-width="2"/>
                        <text x="100" y="180" font-family="Inter, sans-serif" font-weight="900" font-size="15" fill="#FFCC00" text-anchor="middle">PANCA BHAKTI</text>
                        <text x="100" y="200" font-family="Inter, sans-serif" font-weight="900" font-size="15" fill="#FFCC00" text-anchor="middle">RAKIT</text>
                    </svg>
                </div>
                <div>
                    <span class="text-[10px] sm:text-xs font-bold uppercase tracking-widest text-brand-accent block">Portal Berita Resmi</span>
                    <h1 id="header-school-name" class="text-base sm:text-2xl font-extrabold text-brand-blue tracking-tight leading-none group-hover:text-blue-800 transition uppercase">
                        <?= htmlspecialchars($school['school_name']) ?>
                    </h1>
                    <p class="text-[11px] sm:text-xs text-gray-500 font-medium hidden sm:block mt-1">Cerdas, Terampil, Berkarakter & Siap Kerja</p>
                </div>
            </a>

            <!-- Akses Admin & Login -->
            <div class="flex items-center gap-2 sm:gap-3">
                
                <?php if ($isLoggedIn): ?>
                <!-- State: Logged In Admin -->
                <div id="user-logged-in" class="flex items-center gap-2 sm:gap-3">
                    <button onclick="openIdentityModal()" class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-2 rounded-xl text-xs font-semibold transition shadow flex items-center gap-1.5" title="Kelola Identitas Website">
                        <i class="fa-solid fa-sliders"></i>
                        <span class="hidden md:inline">Identitas Web</span>
                    </button>

                    <button onclick="openAddNewsModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold transition shadow-md flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span>+ Tambah Berita</span>
                    </button>

                    <div class="text-right hidden xl:block border-l border-gray-200 pl-3">
                        <span class="block text-[10px] text-gray-400 font-semibold uppercase">Status Mode</span>
                        <span id="logged-username" class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Admin (CRUD Active)
                        </span>
                    </div>

                    <a href="autentikasi.php?action=logout" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-2 rounded-xl text-xs font-semibold transition border border-red-200 flex items-center gap-1.5" title="Log Out Admin">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="hidden sm:inline">Keluar</span>
                    </a>
                </div>
                <?php else: ?>
                <!-- State: Visitor / Guest Login Button -->
                <button id="btn-login-modal" onclick="openLoginModal()" class="bg-brand-blue hover:bg-brand-dark text-white px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold shadow-md hover:shadow-lg transition flex items-center gap-2 transform active:scale-95 cursor-pointer">
                    <i class="fa-solid fa-user-lock text-brand-gold"></i>
                    <span>Login Admin</span>
                </button>
                <?php endif; ?>

                <!-- Toggle Menu Mobile -->
                <button onclick="toggleMobileMenu()" class="lg:hidden text-gray-700 hover:text-brand-blue p-2 text-xl">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>

        <!-- ==================== NAVIGATION BAR (DESKTOP) ==================== -->
        <nav class="bg-brand-blue text-white hidden lg:block border-t border-blue-900">
            <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
                <ul class="flex items-center font-medium text-xs xl:text-sm tracking-wide">
                    <li>
                        <a href="#" class="inline-block py-3 px-3.5 bg-brand-dark text-brand-gold border-b-2 border-brand-gold font-semibold">
                            <i class="fa-solid fa-house me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="relative group">
                        <a href="#visi-misi-section" class="inline-block py-3 px-3.5 hover:bg-brand-dark hover:text-brand-gold transition flex items-center gap-1">
                            Profil <i class="fa-solid fa-chevron-down text-[10px] opacity-70"></i>
                        </a>
                        <div class="absolute left-0 hidden group-hover:block w-52 bg-white text-gray-800 shadow-xl rounded-b-lg py-2 z-50 border-t-2 border-brand-gold">
                            <a href="#visi-misi-section" class="block px-4 py-2 text-xs hover:bg-gray-100 hover:text-brand-blue font-semibold">Visi & Misi</a>
                            <a href="#identitas-sekolah" class="block px-4 py-2 text-xs hover:bg-gray-100 hover:text-brand-blue">Sejarah & Identitas</a>
                        </div>
                    </li>
                    <li><a href="#identitas-sekolah" class="inline-block py-3 px-3.5 hover:bg-brand-dark hover:text-brand-gold transition">Identitas</a></li>
                    <li><a href="#news-section" class="inline-block py-3 px-3.5 hover:bg-brand-dark hover:text-brand-gold transition">Berita</a></li>
                    <li><a href="#jurusan-section" class="inline-block py-3 px-3.5 hover:bg-brand-dark hover:text-brand-gold transition">Jurusan</a></li>
                    <li><a href="#pengumuman-section" class="inline-block py-3 px-3.5 hover:bg-brand-dark hover:text-brand-gold transition">Pengumuman</a></li>
                    <li><a href="#karir-section" class="inline-block py-3 px-3.5 hover:bg-brand-dark hover:text-brand-gold transition">Karir / BKK</a></li>
                    <li><a href="#identitas-sekolah" class="inline-block py-3 px-3.5 hover:bg-brand-dark hover:text-brand-gold transition">Kontak</a></li>
                    <li>
                        <a href="#spmb-section" class="inline-block py-3 px-3.5 hover:bg-brand-dark text-brand-gold font-bold transition">
                            <i class="fa-solid fa-bullhorn me-1"></i> Info SPMB
                        </a>
                    </li>
                </ul>

                <!-- Form Cari Berita -->
                <div class="relative py-2">
                    <input type="text" id="search-input" onkeyup="filterNews()" placeholder="Cari berita..." class="bg-brand-dark text-white text-xs rounded-full py-1.5 pl-4 pr-8 focus:outline-none focus:ring-1 focus:ring-brand-gold placeholder-gray-400 w-36 focus:w-48 transition-all">
                    <button class="absolute right-2.5 top-3.5 text-gray-400 hover:text-white text-xs">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Mobile Nav Menu -->
        <div id="mobile-menu" class="hidden lg:hidden bg-brand-dark text-white border-t border-gray-700">
            <ul class="divide-y divide-gray-700 text-xs font-medium">
                <li><a href="#" class="block py-2.5 px-4 bg-brand-blue text-brand-gold font-semibold"><i class="fa-solid fa-house me-2"></i> Beranda</a></li>
                <li><a href="#visi-misi-section" onclick="toggleMobileMenu()" class="block py-2.5 px-4 hover:bg-brand-blue">Visi & Misi Sekolah</a></li>
                <li><a href="#identitas-sekolah" onclick="toggleMobileMenu()" class="block py-2.5 px-4 hover:bg-brand-blue">Identitas & Kontak</a></li>
                <li><a href="#news-section" onclick="toggleMobileMenu()" class="block py-2.5 px-4 hover:bg-brand-blue">Berita Terkini</a></li>
                <li><a href="#jurusan-section" onclick="toggleMobileMenu()" class="block py-2.5 px-4 hover:bg-brand-blue">Program Keahlian / Jurusan</a></li>
                <li><a href="#pengumuman-section" onclick="toggleMobileMenu()" class="block py-2.5 px-4 hover:bg-brand-blue">Pengumuman Sekolah</a></li>
                <li><a href="#karir-section" onclick="toggleMobileMenu()" class="block py-2.5 px-4 hover:bg-brand-blue">Karir & Bursa Kerja</a></li>
                <li><a href="#spmb-section" onclick="toggleMobileMenu()" class="block py-2.5 px-4 hover:bg-brand-blue text-brand-gold font-bold"><i class="fa-solid fa-bullhorn me-2"></i> Info SPMB</a></li>
            </ul>
        </div>
    </header>

    <!-- ==================== RUNNING TEXT / BREAKING NEWS ==================== -->
    <section class="bg-gray-200 border-b border-gray-300 py-2">
        <div class="max-w-7xl mx-auto px-4 flex items-center">
            <div class="bg-red-600 text-white text-[11px] font-bold uppercase tracking-wider px-2.5 py-1 rounded me-3 flex items-center gap-1.5 shrink-0 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                Terkini
            </div>
            <div class="ticker-wrap w-full text-xs sm:text-sm font-medium text-gray-700">
                <div class="ticker-move" id="ticker-content">
                    <span class="mx-4"><i class="fa-solid fa-circle text-[8px] text-brand-accent me-1"></i> Pendaftaran SPMB <?= htmlspecialchars($school['school_name']) ?> Tahun Ajaran Baru Resmi Dibuka!</span>
                    <span class="mx-4"><i class="fa-solid fa-circle text-[8px] text-brand-accent me-1"></i> NPSN Sekolah: <?= htmlspecialchars($school['npsn']) ?> | Hubungi WhatsApp: <?= htmlspecialchars($school['phone']) ?></span>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== MAIN CONTENT AREA ==================== -->
    <main class="flex-grow max-w-7xl mx-auto px-4 py-8 w-full space-y-10">

        <!-- Banner Highlight -->
        <div class="bg-gradient-to-r from-brand-blue via-blue-900 to-brand-dark rounded-2xl p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
            <div class="relative z-10 max-w-2xl">
                <span class="bg-brand-gold text-brand-dark text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider mb-3 inline-block">Informasi Utama</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold leading-tight mb-3">Selamat Datang di Portal Berita Resmi <?= htmlspecialchars($school['school_name']) ?></h2>
                <p class="text-blue-100 text-xs sm:text-sm mb-6 leading-relaxed">
                    Mencetak generasi unggul, berdaya saing global, terampil dalam teknologi kejuruan, dan berakhlaq mulia di Banjarnegara.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="#news-section" class="inline-flex items-center gap-2 bg-brand-gold hover:bg-yellow-400 text-brand-dark font-bold px-5 py-2.5 rounded-xl text-xs sm:text-sm transition shadow-lg">
                        Lihat Berita Terbaru <i class="fa-solid fa-arrow-down"></i>
                    </a>
                    <a href="#spmb-section" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2.5 rounded-xl text-xs sm:text-sm transition shadow-lg">
                        <i class="fa-solid fa-user-plus"></i> Info Pendaftaran SPMB
                    </a>
                </div>
            </div>
            <i class="fa-solid fa-graduation-cap absolute -right-6 -bottom-6 text-9xl text-white opacity-10 pointer-events-none"></i>
        </div>

        <!-- ==================== SECTION VISI & MISI ==================== -->
        <section id="visi-misi-section" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
            <div class="border-b border-gray-200 pb-4 mb-6">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-accent">Landasan & Tujuan Pendidikan</span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-brand-blue flex items-center gap-2">
                    <i class="fa-solid fa-bullseye text-brand-gold"></i> Visi & Misi <?= htmlspecialchars($school['school_name']) ?>
                </h2>
                <p class="text-xs text-gray-500 mt-1">Komitmen dalam memberikan mutu pendidikan dan latihan kejuruan terbaik</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Card Visi -->
                <div class="bg-gradient-to-br from-blue-50 to-white border border-blue-100 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-brand-blue text-brand-gold rounded-xl flex items-center justify-center text-xl font-bold mb-4 shadow">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        <span class="text-[10px] font-bold uppercase px-2.5 py-1 bg-brand-gold text-brand-dark rounded-md">Visi Sekolah</span>
                        <h3 class="text-lg font-extrabold text-brand-blue mt-2">Visi</h3>
                        <p class="text-sm text-gray-700 mt-3 leading-relaxed font-medium italic bg-white p-4 rounded-xl border border-blue-100 shadow-inner">
                            "Mewujudkan lulusan yang berakhlak mulia, berkompeten, berdaya saing dan berwawasan global."
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-blue-100 text-xs text-gray-500 flex items-center gap-1.5">
                        <i class="fa-solid fa-check-circle text-brand-gold"></i> Standar Mutu Pendidikan Nasional
                    </div>
                </div>

                <!-- Card Misi -->
                <div class="bg-gradient-to-br from-amber-50 to-white border border-amber-100 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-amber-500 text-white rounded-xl flex items-center justify-center text-xl font-bold mb-4 shadow">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <span class="text-[10px] font-bold uppercase px-2.5 py-1 bg-amber-200 text-amber-900 rounded-md">Misi Sekolah</span>
                        <h3 class="text-lg font-extrabold text-brand-blue mt-2">Misi</h3>
                        <ul class="text-xs text-gray-700 mt-3 space-y-2 leading-relaxed bg-white p-4 rounded-xl border border-amber-100 shadow-inner">
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-circle-dot text-amber-500 text-[8px] mt-1.5 shrink-0"></i>
                                <span>Meningkatkan kualitas layanan pendidikan dan latihan kejuruan tingkat menengah sesuai dengan standar pendidikan nasional.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-circle-dot text-amber-500 text-[8px] mt-1.5 shrink-0"></i>
                                <span>Mewujudkan pendidikan dan pelatihan kejuruan yang efektif dan kreatif.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-circle-dot text-amber-500 text-[8px] mt-1.5 shrink-0"></i>
                                <span>Menciptakan iklim belajar yang kondusif dan budaya kerja yang profesional.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-circle-dot text-amber-500 text-[8px] mt-1.5 shrink-0"></i>
                                <span>Menghasilkan lulusan dengan pengetahuan luas, berakhlak mulia, terampil dalam bidangnya, optimis dalam memasuki dunia kerja dan dunia usaha serta profesional dibidangnya.</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-4 pt-3 border-t border-amber-100 text-xs text-gray-500 flex items-center gap-1.5">
                        <i class="fa-solid fa-check-circle text-amber-600"></i> Profesionalitas & Kesiapan Kerja
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== SECTION INFO SPMB ==================== -->
        <section id="spmb-section" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
            <div class="border-b border-gray-200 pb-4 mb-6">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-accent">Penerimaan Peserta Didik Baru</span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-brand-blue flex items-center gap-2">
                    <i class="fa-solid fa-bullhorn text-brand-gold"></i> Informasi SPMB (Sistem Penerimaan Murid Baru)
                </h2>
                <p class="text-xs text-gray-600 mt-1">Mari bergabung menjadi bagian dari keluarga besar <?= htmlspecialchars($school['school_name']) ?>.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                    <h3 class="font-extrabold text-brand-blue text-sm mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-list-ol text-brand-accent"></i> Alur Pendaftaran
                    </h3>
                    <ol class="space-y-3 text-xs text-gray-700">
                        <li class="flex gap-2">
                            <span class="w-5 h-5 bg-brand-blue text-white rounded-full flex items-center justify-center font-bold text-[10px] shrink-0">1</span>
                            <span>Mengisi formulir pendaftaran secara langsung di Sekretariat SPMB atau via WhatsApp.</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="w-5 h-5 bg-brand-blue text-white rounded-full flex items-center justify-center font-bold text-[10px] shrink-0">2</span>
                            <span>Penyerahan berkas fisik (FC Ijazah/SKL, KK, Akta Kelahiran, Pas Foto).</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="w-5 h-5 bg-brand-blue text-white rounded-full flex items-center justify-center font-bold text-[10px] shrink-0">3</span>
                            <span>Tes Bakat & Minat Jurusan (TKRO / TKJ).</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="w-5 h-5 bg-brand-blue text-white rounded-full flex items-center justify-center font-bold text-[10px] shrink-0">4</span>
                            <span>Pengumuman Kelulusan & Daftar Ulang Siswa Baru.</span>
                        </li>
                    </ol>
                </div>

                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                    <h3 class="font-extrabold text-brand-blue text-sm mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-id-card text-brand-accent"></i> Berkas Persyaratan
                    </h3>
                    <ul class="space-y-2 text-xs text-gray-700">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-600"></i> Fotokopi Ijazah / SKL SMP/MTs (2 Lembar)</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-600"></i> Fotokopi Kartu Keluarga (KK) & Akta Kelahiran</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-600"></i> Pas Foto Ukuran 3x4 (4 Lembar)</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-600"></i> Fotokopi KIP / PKH / KIS (Jika Ada)</li>
                    </ul>
                </div>

                <div class="bg-gradient-to-br from-brand-blue to-blue-900 rounded-xl p-5 text-white flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider bg-brand-gold text-brand-dark px-2 py-0.5 rounded">Layanan SPMB</span>
                        <h4 class="font-bold text-base mt-2">Pendaftaran Gelombang Utama</h4>
                        <p class="text-xs text-blue-100 mt-2 leading-relaxed">Konsultasi jurusan & dapatkan informasi pendaftaran langsung melalui Panitia SPMB.</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-blue-800">
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $school['phone']) ?>?text=Halo%20Panitia%20SPMB%2C%20saya%20ingin%20mendaftar%20di%20<?= urlencode($school['school_name']) ?>" target="_blank" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2.5 rounded-lg text-xs text-center transition flex items-center justify-center gap-2">
                            <i class="fa-brands fa-whatsapp text-base"></i> Daftar / Tanya via WA SPMB
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== SECTION PENGUMUMAN ==================== -->
        <section id="pengumuman-section" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
            <div class="border-b border-gray-200 pb-4 mb-6">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-accent">Pemberitahuan Resmi</span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-brand-blue flex items-center gap-2">
                    <i class="fa-solid fa-scroll text-brand-gold"></i> Pengumuman Sekolah
                </h2>
                <p class="text-xs text-gray-500 mt-1">Informasi penting terkait akademik dan agenda kegiatan sekolah</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition bg-gradient-to-b from-white to-gray-50">
                    <div class="flex justify-between items-center mb-3">
                        <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">Akademik</span>
                        <span class="text-[11px] text-gray-400 font-medium">10 Nov 2026</span>
                    </div>
                    <h3 class="font-bold text-gray-800 text-sm mb-2 hover:text-brand-blue transition">Jadwal Asesmen Sumatif Semester Gasal</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">Pelaksanaan Asesmen Sumatif Semester Gasal Tahun Ajaran 2026/2027 dimulai serentak pada Senin mendatang.</p>
                </div>

                <div class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition bg-gradient-to-b from-white to-gray-50">
                    <div class="flex justify-between items-center mb-3">
                        <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">Praktik Lapangan</span>
                        <span class="text-[11px] text-gray-400 font-medium">08 Nov 2026</span>
                    </div>
                    <h3 class="font-bold text-gray-800 text-sm mb-2 hover:text-brand-blue transition">Pembekalan PKL/Prakerin Gelombang II</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">Seluruh peserta didik kelas XI TKRO dan TKJ wajib mengikuti pembekalan Praktik Kerja Lapangan di Aula Sekolah.</p>
                </div>

                <div class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition bg-gradient-to-b from-white to-gray-50">
                    <div class="flex justify-between items-center mb-3">
                        <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">Beasiswa</span>
                        <span class="text-[11px] text-gray-400 font-medium">01 Nov 2026</span>
                    </div>
                    <h3 class="font-bold text-gray-800 text-sm mb-2 hover:text-brand-blue transition">Pendaftaran Beasiswa Berprestasi 2026</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">Bagi siswa yang memenuhi syarat berprestasi akademik dan non-akademik dapat mengajukan berkas ke Ruang Kesiswaan.</p>
                </div>
            </div>
        </section>

        <!-- ==================== SECTION KARIR & BKK ==================== -->
        <section id="karir-section" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
            <div class="border-b border-gray-200 pb-4 mb-6">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-accent">Bursa Kerja Khusus (BKK)</span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-brand-blue flex items-center gap-2">
                    <i class="fa-solid fa-briefcase text-brand-gold"></i> Informasi Karir & Lowongan Kerja
                </h2>
                <p class="text-xs text-gray-500 mt-1">Peluang karir bagi alumni <?= htmlspecialchars($school['school_name']) ?> dari mitra industri terpercaya</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="border border-blue-100 bg-blue-50/40 rounded-xl p-5 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 bg-blue-200 text-blue-900 rounded">Mitra Otomotif</span>
                            <span class="text-xs font-semibold text-emerald-600"><i class="fa-solid fa-clock me-1"></i> Aktif</span>
                        </div>
                        <h3 class="font-bold text-brand-blue text-base">Teknisi Muda Maintenance Otomotif</h3>
                        <p class="text-xs text-gray-500 font-semibold mb-3">PT Nasmoco & Tefa Mitsubishi Partner</p>
                        <ul class="text-xs text-gray-600 space-y-1 mb-4">
                            <li><i class="fa-solid fa-caret-right text-brand-accent me-1"></i> Kualifikasi: Lulusan TKRO <?= htmlspecialchars($school['school_name']) ?></li>
                            <li><i class="fa-solid fa-caret-right text-brand-accent me-1"></i> Penempatan: Banjarnegara & Purwokerto</li>
                        </ul>
                    </div>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $school['phone']) ?>?text=Halo%20BKK%2C%20saya%20tertarik%20melamar%20Teknisi%20Otomotif" target="_blank" class="inline-block text-center bg-brand-blue hover:bg-brand-dark text-white text-xs font-bold py-2 rounded-lg transition">
                        Daftar via BKK Sekolah
                    </a>
                </div>

                <div class="border border-indigo-100 bg-indigo-50/40 rounded-xl p-5 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 bg-indigo-200 text-indigo-900 rounded">Mitra Teknologi</span>
                            <span class="text-xs font-semibold text-emerald-600"><i class="fa-solid fa-clock me-1"></i> Aktif</span>
                        </div>
                        <h3 class="font-bold text-brand-blue text-base">Junior Network & Server Administrator</h3>
                        <p class="text-xs text-gray-500 font-semibold mb-3">Mikrotik Academy Partner & ISP Mitra</p>
                        <ul class="text-xs text-gray-600 space-y-1 mb-4">
                            <li><i class="fa-solid fa-caret-right text-brand-accent me-1"></i> Kualifikasi: Lulusan TKJ <?= htmlspecialchars($school['school_name']) ?></li>
                            <li><i class="fa-solid fa-caret-right text-brand-accent me-1"></i> Memiliki Pemahaman Dasar Router & LAN</li>
                        </ul>
                    </div>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $school['phone']) ?>?text=Halo%20BKK%2C%20saya%20tertarik%20melamar%20Junior%20Network%20Admin" target="_blank" class="inline-block text-center bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2 rounded-lg transition">
                        Daftar via BKK Sekolah
                    </a>
                </div>
            </div>
        </section>

        <!-- ==================== SECTION IDENTITAS SEKOLAH & KONTAK ==================== -->
        <section id="identitas-sekolah" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-200 pb-4 mb-6 gap-2">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-brand-accent">Profil & Informasi Publik</span>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-brand-blue flex items-center gap-2">
                        <i class="fa-solid fa-school text-brand-gold"></i> Identitas & Detail Kontak Sekolah
                    </h2>
                </div>
                <?php if ($isLoggedIn): ?>
                <button onclick="openIdentityModal()" class="bg-amber-100 hover:bg-amber-200 text-amber-800 text-xs font-bold px-3 py-1.5 rounded-lg border border-amber-300 transition flex items-center gap-1.5">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Identitas
                </button>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-4 bg-gray-50 rounded-2xl p-6 border border-gray-200 flex flex-col items-center text-center">
                    <div id="school-logo-preview" class="w-36 h-44 mb-4">
                        <svg viewBox="0 0 200 240" class="w-full h-full drop-shadow-md">
                            <path d="M 100 10 L 185 45 C 185 140, 160 195, 100 230 C 40 195, 15 140, 15 45 Z" fill="#003366" stroke="#FFCC00" stroke-width="8" />
                            <circle cx="100" cy="110" r="42" fill="none" stroke="#FFCC00" stroke-width="8" stroke-dasharray="12 6"/>
                            <path d="M 100 50 Q 108 70 100 85 Q 92 70 100 50 Z" fill="#E53E3E"/>
                            <path d="M 94 85 L 106 85 L 103 115 L 97 115 Z" fill="#C53030"/>
                            <path d="M 65 90 Q 80 85 92 95 Q 75 115 65 90 Z" fill="#FFFFFF"/>
                            <path d="M 135 90 Q 120 85 108 95 Q 125 115 135 90 Z" fill="#FFFFFF"/>
                            <path d="M 70 140 Q 100 132 100 145 Q 100 132 130 140 L 130 147 Q 100 139 100 152 Q 100 139 70 147 Z" fill="#FFFFFF" stroke="#001A33" stroke-width="2"/>
                            <text x="100" y="180" font-family="Inter, sans-serif" font-weight="900" font-size="15" fill="#FFCC00" text-anchor="middle">PANCA BHAKTI</text>
                            <text x="100" y="200" font-family="Inter, sans-serif" font-weight="900" font-size="15" fill="#FFCC00" text-anchor="middle">RAKIT</text>
                        </svg>
                    </div>
                    <h3 id="display-school-name" class="font-extrabold text-brand-blue text-lg"><?= htmlspecialchars($school['school_name']) ?></h3>
                    <p class="text-xs text-gray-500 font-semibold mt-1">Kabupaten Banjarnegara</p>
                    <span class="mt-3 inline-block bg-blue-100 text-brand-blue text-xs font-bold px-3 py-1 rounded-full border border-blue-200">
                        NPSN: <span id="display-npsn"><?= htmlspecialchars($school['npsn']) ?></span>
                    </span>
                </div>

                <div class="lg:col-span-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 font-bold text-lg">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Telepon / WhatsApp</span>
                            <span id="display-phone" class="font-bold text-gray-800 text-sm block mt-0.5"><?= htmlspecialchars($school['phone']) ?></span>
                            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $school['phone']) ?>" target="_blank" class="text-[11px] text-emerald-600 font-semibold hover:underline flex items-center gap-1 mt-1">
                                <i class="fa-brands fa-whatsapp"></i> Chat Langsung
                            </a>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 text-brand-blue flex items-center justify-center shrink-0 font-bold text-lg">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Email Resmi</span>
                            <span id="display-email" class="font-bold text-gray-800 text-sm block mt-0.5"><?= htmlspecialchars($school['email']) ?></span>
                            <span class="text-[11px] text-gray-500">Pengajuan Informasi & Kerjasama</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center shrink-0 font-bold text-lg">
                            <i class="fa-solid fa-globe"></i>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Situs Web Resmi</span>
                            <span id="display-website" class="font-bold text-gray-800 text-sm block mt-0.5"><?= htmlspecialchars($school['school_name']) ?></span>
                            <span class="text-[11px] text-gray-500"><?= htmlspecialchars($school['website']) ?></span>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center shrink-0 font-bold text-lg">
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Nomor Pokok Sekolah (NPSN)</span>
                            <span id="display-npsn-card" class="font-bold text-gray-800 text-sm block mt-0.5"><?= htmlspecialchars($school['npsn']) ?></span>
                            <span class="text-[11px] text-gray-500">Terverifikasi Kementerian Pendidikan</span>
                        </div>
                    </div>

                    <div class="sm:col-span-2 bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 flex items-center justify-center shrink-0 font-bold text-lg">
                            <i class="fa-solid fa-map-location-dot"></i>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Alamat Lengkap Sekolah</span>
                            <p id="display-address" class="font-semibold text-gray-800 text-xs leading-relaxed mt-0.5">
                                <?= htmlspecialchars($school['address']) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== SECTION JURUSAN / PROGRAM KEAHLIAN ==================== -->
        <section id="jurusan-section" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
            <div class="border-b border-gray-200 pb-4 mb-6">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-accent">Kompetensi Keahlian Unggulan</span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-brand-blue flex items-center gap-2">
                    <i class="fa-solid fa-graduation-cap text-brand-gold"></i> Program Keahlian
                </h2>
                <p class="text-xs text-gray-600 mt-1">Kenali jurusan-jurusan unggulan kami dan mitra industri yang mendukung pendidikan kejuruan di <?= htmlspecialchars($school['school_name']) ?>.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-gray-50 to-blue-50 border border-blue-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-blue-600 text-white rounded-xl flex items-center justify-center text-xl font-bold mb-4 shadow-md">
                            <i class="fa-solid fa-car-rear"></i>
                        </div>
                        <span class="text-[10px] font-bold uppercase px-2.5 py-1 bg-blue-200 text-blue-900 rounded-md">Program Keahlian</span>
                        <h3 class="text-lg font-extrabold text-brand-blue mt-2">Teknik Kendaraan Ringan & Otomotif (TKRO)</h3>
                        <p class="text-xs text-gray-700 mt-2 leading-relaxed">
                            Mempelajari teknik perawatan dan perbaikan mesin kendaraan bermotor, roda empat, sistem kelistrikan otomotif, sasis, serta pemeliharaan berkala kendaraan ringan.
                        </p>
                        <div class="mt-4 pt-3 border-t border-blue-200/60">
                            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block mb-2">Bekerja Sama Dengan:</span>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-white text-blue-900 border border-blue-200 text-[11px] font-semibold px-2.5 py-1 rounded-lg shadow-sm flex items-center gap-1">
                                    <i class="fa-solid fa-handshake text-brand-accent"></i> Tefa Kubota
                                </span>
                                <span class="bg-white text-blue-900 border border-blue-200 text-[11px] font-semibold px-2.5 py-1 rounded-lg shadow-sm flex items-center gap-1">
                                    <i class="fa-solid fa-handshake text-brand-accent"></i> Tefa Mitsubishi
                                </span>
                                <span class="bg-white text-blue-900 border border-blue-200 text-[11px] font-semibold px-2.5 py-1 rounded-lg shadow-sm flex items-center gap-1">
                                    <i class="fa-solid fa-handshake text-brand-accent"></i> Tefa Nasmoco
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-blue-200/60 flex items-center justify-between text-xs font-semibold text-brand-blue">
                        <span><i class="fa-solid fa-circle-check text-emerald-600 me-1"></i> Standar Industri Resmi</span>
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $school['phone']) ?>?text=Halo%2C%20saya%20ingin%20tanya%20tentang%20jurusan%20TKRO" target="_blank" class="bg-brand-blue text-white px-3 py-1.5 rounded-lg hover:bg-brand-dark transition">Daftar TKRO</a>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-gray-50 to-indigo-50 border border-indigo-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-indigo-600 text-white rounded-xl flex items-center justify-center text-xl font-bold mb-4 shadow-md">
                            <i class="fa-solid fa-network-wired"></i>
                        </div>
                        <span class="text-[10px] font-bold uppercase px-2.5 py-1 bg-indigo-200 text-indigo-900 rounded-md">Program Keahlian</span>
                        <h3 class="text-lg font-extrabold text-brand-blue mt-2">Teknik Komputer & Jaringan (TKJ)</h3>
                        <p class="text-xs text-gray-700 mt-2 leading-relaxed">
                            Mempelajari perakitan komputer, instalasi sistem operasi, konfigurasi jaringan LAN/WAN, administrasi server, dan router MikroTik untuk kebutuhan industri teknologi informasi.
                        </p>
                        <div class="mt-4 pt-3 border-t border-indigo-200/60">
                            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block mb-2">Bekerja Sama Dengan:</span>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-white text-indigo-900 border border-indigo-200 text-[11px] font-semibold px-2.5 py-1 rounded-lg shadow-sm flex items-center gap-1">
                                    <i class="fa-solid fa-handshake text-brand-accent"></i> AWS Academy
                                </span>
                                <span class="bg-white text-indigo-900 border border-indigo-200 text-[11px] font-semibold px-2.5 py-1 rounded-lg shadow-sm flex items-center gap-1">
                                    <i class="fa-solid fa-handshake text-brand-accent"></i> Mikrotik Academy
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-indigo-200/60 flex items-center justify-between text-xs font-semibold text-indigo-700">
                        <span><i class="fa-solid fa-circle-check text-emerald-600 me-1"></i> Sertifikasi Internasional</span>
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $school['phone']) ?>?text=Halo%2C%20saya%20ingin%20tanya%20tentang%20jurusan%20TKJ" target="_blank" class="bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700 transition">Daftar TKJ</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== SECTION DAFTAR BERITA (CRUD ACTIVE) ==================== -->
        <section id="news-section">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 border-b border-gray-200 pb-4 gap-3">
                <div>
                    <h3 class="text-xl font-extrabold text-brand-blue flex items-center gap-2">
                        <i class="fa-solid fa-newspaper text-brand-accent"></i> Berita & Informasi Terbaru
                    </h3>
                    <p class="text-xs text-gray-500">Update berita kegiatan, prestasi, dan pengumuman sekolah</p>
                </div>

                <?php if ($isLoggedIn): ?>
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-3 py-1.5 rounded-xl text-xs font-medium flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                    <span>Mode Admin: Anda dapat <strong>Edit</strong> & <strong>Hapus</strong> berita secara realtime</span>
                </div>
                <?php endif; ?>
            </div>

            <!-- Grid Container Berita -->
            <div id="news-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Dynamic Content Loaded via PHP API -->
            </div>
        </section>
    </main>

    <!-- ==================== MODAL READ FULL NEWS ==================== -->
    <div id="read-news-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto transform scale-95 transition-transform duration-300" id="read-news-box">
            <div class="bg-brand-blue text-white p-5 sticky top-0 z-10 flex justify-between items-center">
                <span id="read-news-category" class="bg-brand-gold text-brand-dark font-extrabold text-[10px] px-2.5 py-1 rounded uppercase tracking-wider"></span>
                <button onclick="closeReadModal()" class="text-gray-300 hover:text-white text-xl">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <span id="read-news-date" class="text-xs text-gray-400 font-medium block"></span>
                <h2 id="read-news-title" class="text-xl sm:text-2xl font-extrabold text-gray-900 leading-tight"></h2>
                <div id="read-news-image" class="w-full h-56 sm:h-72 rounded-xl bg-gray-100 overflow-hidden flex items-center justify-center border border-gray-200"></div>
                <div id="read-news-content" class="text-sm text-gray-700 leading-relaxed whitespace-pre-line border-t border-gray-100 pt-4"></div>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL LOGIN ADMIN ==================== -->
    <div id="login-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform scale-95 transition-transform duration-300" id="login-box">
            <div class="bg-brand-blue text-white p-6 relative">
                <button onclick="closeLoginModal()" class="absolute top-4 right-4 text-gray-300 hover:text-white text-xl">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-gold text-brand-dark rounded-lg flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">Login Administrator</h3>
                        <p class="text-xs text-blue-200">Portal Berita <?= htmlspecialchars($school['school_name']) ?></p>
                    </div>
                </div>
            </div>

            <form id="login-form" onsubmit="handleLogin(event)" class="p-6 space-y-4">
                <div id="alert-message" class="hidden p-3 rounded-lg text-xs font-medium flex items-center gap-2"></div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" id="username" required value="admin" class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-transparent transition bg-gray-50 focus:bg-white">
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block">Username: <strong class="text-brand-blue">admin</strong></span>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" id="password" required value="admin123" class="w-full pl-9 pr-10 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-transparent transition bg-gray-50 focus:bg-white" placeholder="Ketik kata sandi">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i class="fa-solid fa-eye" id="toggle-eye"></i>
                        </button>
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block">Password: <strong class="text-brand-blue">admin123</strong></span>
                </div>

                <button type="submit" class="w-full bg-brand-blue hover:bg-brand-dark text-white font-bold py-3 rounded-xl transition shadow-lg hover:shadow-xl text-sm flex items-center justify-center gap-2 mt-2 cursor-pointer">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk Sebagai Admin
                </button>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL FORM BERITA (CREATE & UPDATE) ==================== -->
    <div id="news-form-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto" id="news-form-box">
            
            <div id="modal-form-header" class="bg-emerald-700 text-white p-5 relative flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i id="modal-form-icon" class="fa-solid fa-file-circle-plus text-xl text-emerald-300"></i>
                    <h3 id="modal-form-title" class="text-base font-bold">Tambah Berita Baru</h3>
                </div>
                <button onclick="closeAddNewsModal()" class="text-emerald-200 hover:text-white text-xl">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form onsubmit="handleSaveNews(event)" class="p-6 space-y-4">
                <input type="hidden" id="news-id-input">

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Judul Berita</label>
                    <input type="text" id="news-title" required class="w-full px-3.5 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600" placeholder="Masukkan judul berita">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Kategori</label>
                        <select id="news-category" class="w-full px-3.5 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 bg-white">
                            <option value="Kegiatan">Kegiatan</option>
                            <option value="Prestasi">Prestasi</option>
                            <option value="Pengumuman">Pengumuman</option>
                            <option value="SPMB">Info SPMB</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">URL Gambar (Opsional)</label>
                        <input type="url" id="news-image-url" class="w-full px-3.5 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600" placeholder="https://...">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Isi Berita Lengkap</label>
                    <textarea id="news-content" rows="4" required class="w-full px-3.5 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600" placeholder="Tulis isi berita secara lengkap..."></textarea>
                </div>

                <button type="submit" id="modal-submit-btn" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-xl transition text-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Simpan & Publikasikan
                </button>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL KELOLA IDENTITAS WEBSITE ==================== -->
    <div id="identity-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto" id="identity-box">
            <div class="bg-amber-600 text-white p-5 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-xl text-amber-200"></i>
                    <h3 class="text-base font-bold">Kelola Identitas Website</h3>
                </div>
                <button onclick="closeIdentityModal()" class="text-amber-100 hover:text-white text-xl">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form onsubmit="handleSaveIdentity(event)" class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Nama Sekolah</label>
                    <input type="text" id="edit-school-name" required value="<?= htmlspecialchars($school['school_name']) ?>" class="w-full px-3.5 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">NPSN</label>
                        <input type="text" id="edit-npsn" required value="<?= htmlspecialchars($school['npsn']) ?>" class="w-full px-3.5 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Telepon / WhatsApp</label>
                        <input type="text" id="edit-phone" required value="<?= htmlspecialchars($school['phone']) ?>" class="w-full px-3.5 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Email Resmi</label>
                    <input type="email" id="edit-email" required value="<?= htmlspecialchars($school['email']) ?>" class="w-full px-3.5 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Alamat Lengkap</label>
                    <textarea id="edit-address" rows="3" required class="w-full px-3.5 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"><?= htmlspecialchars($school['address']) ?></textarea>
                </div>
                <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-2.5 rounded-xl transition text-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Identitas
                </button>
            </form>
        </div>
    </div>

    <!-- ==================== FOOTER ==================== -->
    <footer class="bg-brand-dark text-white border-t border-gray-800 text-xs py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <h4 class="font-bold text-brand-gold text-sm mb-2 uppercase"><?= htmlspecialchars($school['school_name']) ?></h4>
                <p class="text-gray-400 text-xs leading-relaxed"><?= htmlspecialchars($school['address']) ?></p>
            </div>
            <div>
                <h4 class="font-bold text-brand-gold text-sm mb-2">KONTAK CEPAT</h4>
                <p class="text-gray-400 text-xs"><i class="fa-solid fa-phone me-1"></i> WA: <?= htmlspecialchars($school['phone']) ?></p>
                <p class="text-gray-400 text-xs mt-1"><i class="fa-solid fa-envelope me-1"></i> <?= htmlspecialchars($school['email']) ?></p>
            </div>
            <div>
                <h4 class="font-bold text-brand-gold text-sm mb-2">IDENTITAS RESMI</h4>
                <p class="text-gray-400 text-xs">NPSN: <?= htmlspecialchars($school['npsn']) ?></p>
                <p class="text-gray-400 text-xs mt-1">Kabupaten Banjarnegara, Jawa Tengah</p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 border-t border-gray-800 pt-4 text-center text-gray-500 text-[11px]">
            &copy; 2026 <?= htmlspecialchars($school['school_name']) ?> - Banjarnegara. All rights reserved.
        </div>
    </footer>

    <!-- ==================== JAVASCRIPT & AJAX LOGIC ==================== -->
    <script>
        const isAdminLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;

        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('current-date').innerText = new Date().toLocaleDateString('id-ID', options);

        // Fetch & Render News via PHP Backend
        function fetchNews(query = '') {
            fetch(`news.php?action=read&q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        renderNewsCards(res.data);
                    }
                })
                .catch(err => console.error('Error fetching news:', err));
        }

        function renderNewsCards(newsList) {
            const container = document.getElementById('news-container');
            container.innerHTML = '';

            if (newsList.length === 0) {
                container.innerHTML = `
                    <div class="col-span-full bg-white p-8 rounded-2xl text-center border border-gray-200">
                        <i class="fa-solid fa-newspaper text-4xl text-gray-300 mb-3 block"></i>
                        <p class="text-sm text-gray-500 font-medium">Tidak ada berita yang ditemukan.</p>
                    </div>
                `;
                return;
            }

            newsList.forEach(news => {
                const card = document.createElement('article');
                card.className = "bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col justify-between";
                
                const imgHTML = news.image_url 
                    ? `<img src="${escapeHtml(news.image_url)}" alt="${escapeHtml(news.title)}" class="w-full h-44 object-cover">`
                    : `<div class="w-full h-44 bg-gradient-to-br from-brand-blue to-blue-900 flex items-center justify-center text-white">
                        <i class="fa-solid fa-newspaper text-5xl opacity-40"></i>
                       </div>`;

                const adminControls = isAdminLoggedIn ? `
                    <div class="flex items-center gap-2 pt-3 border-t border-gray-100 mt-3">
                        <button onclick="openEditNewsModal(${news.id})" class="text-xs bg-amber-50 hover:bg-amber-100 text-amber-700 px-3 py-1.5 rounded-lg font-semibold transition border border-amber-200 flex items-center gap-1">
                            <i class="fa-solid fa-pen"></i> Edit
                        </button>
                        <button onclick="handleDeleteNews(${news.id})" class="text-xs bg-red-50 hover:bg-red-100 text-red-700 px-3 py-1.5 rounded-lg font-semibold transition border border-red-200 flex items-center gap-1">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </div>
                ` : '';

                card.innerHTML = `
                    <div>
                        ${imgHTML}
                        <div class="p-5">
                            <div class="flex justify-between items-center mb-2">
                                <span class="bg-blue-100 text-brand-blue font-bold text-[10px] px-2.5 py-0.5 rounded uppercase tracking-wider">${escapeHtml(news.category)}</span>
                                <span class="text-[11px] text-gray-400 font-medium"><i class="fa-regular fa-clock me-1"></i>${news.formatted_date}</span>
                            </div>
                            <h4 class="font-bold text-gray-900 text-base leading-snug mb-2 hover:text-brand-blue transition line-clamp-2 cursor-pointer" onclick="openReadModal(${news.id})">
                                ${escapeHtml(news.title)}
                            </h4>
                            <p class="text-xs text-gray-600 line-clamp-3 leading-relaxed mb-3">
                                ${escapeHtml(news.content)}
                            </p>
                        </div>
                    </div>
                    <div class="px-5 pb-5 pt-0">
                        <button onclick="openReadModal(${news.id})" class="text-xs text-brand-blue font-bold hover:underline inline-flex items-center gap-1">
                            Baca Selengkapnya <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </button>
                        ${adminControls}
                    </div>
                `;
                container.appendChild(card);
            });
        }

        function filterNews() {
            const query = document.getElementById('search-input').value;
            fetchNews(query);
        }

        // READ MODAL LOGIC
        function openReadModal(id) {
            fetch(`news.php?action=get&id=${id}`)
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        const news = res.data;
                        document.getElementById('read-news-category').innerText = news.category;
                        document.getElementById('read-news-date').innerText = news.formatted_date;
                        document.getElementById('read-news-title').innerText = news.title;
                        document.getElementById('read-news-content').innerText = news.content;

                        const imgContainer = document.getElementById('read-news-image');
                        if (news.image_url) {
                            imgContainer.innerHTML = `<img src="${escapeHtml(news.image_url)}" alt="${escapeHtml(news.title)}" class="w-full h-full object-cover">`;
                            imgContainer.classList.remove('hidden');
                        } else {
                            imgContainer.classList.add('hidden');
                        }

                        const modal = document.getElementById('read-news-modal');
                        const box = document.getElementById('read-news-box');
                        modal.classList.remove('opacity-0', 'pointer-events-none');
                        box.classList.remove('scale-95');
                        box.classList.add('scale-100');
                    }
                });
        }

        function closeReadModal() {
            const modal = document.getElementById('read-news-modal');
            const box = document.getElementById('read-news-box');
            modal.classList.add('opacity-0', 'pointer-events-none');
            box.classList.remove('scale-100');
            box.classList.add('scale-95');
        }

        // CREATE & UPDATE (FORM MODAL) LOGIC
        function openAddNewsModal() {
            document.getElementById('news-id-input').value = '';
            document.getElementById('news-title').value = '';
            document.getElementById('news-category').value = 'Kegiatan';
            document.getElementById('news-image-url').value = '';
            document.getElementById('news-content').value = '';

            document.getElementById('modal-form-title').innerText = 'Tambah Berita Baru';
            document.getElementById('modal-form-header').className = 'bg-emerald-700 text-white p-5 relative flex items-center justify-between';
            document.getElementById('modal-submit-btn').className = 'w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-xl transition text-sm flex items-center justify-center gap-2';

            showFormModal();
        }

        function openEditNewsModal(id) {
            fetch(`news.php?action=get&id=${id}`)
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        const news = res.data;
                        document.getElementById('news-id-input').value = news.id;
                        document.getElementById('news-title').value = news.title;
                        document.getElementById('news-category').value = news.category;
                        document.getElementById('news-image-url').value = news.image_url || '';
                        document.getElementById('news-content').value = news.content;

                        document.getElementById('modal-form-title').innerText = 'Edit Data Berita';
                        document.getElementById('modal-form-header').className = 'bg-amber-600 text-white p-5 relative flex items-center justify-between';
                        document.getElementById('modal-submit-btn').className = 'w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-2.5 rounded-xl transition text-sm flex items-center justify-center gap-2';

                        showFormModal();
                    }
                });
        }

        function showFormModal() {
            const modal = document.getElementById('news-form-modal');
            const box = document.getElementById('news-form-box');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            box.classList.remove('scale-95');
            box.classList.add('scale-100');
        }

        function closeAddNewsModal() {
            const modal = document.getElementById('news-form-modal');
            const box = document.getElementById('news-form-box');
            modal.classList.add('opacity-0', 'pointer-events-none');
            box.classList.remove('scale-100');
            box.classList.add('scale-95');
        }

        function handleSaveNews(e) {
            e.preventDefault();
            const formData = new FormData();
            formData.append('id', document.getElementById('news-id-input').value);
            formData.append('title', document.getElementById('news-title').value);
            formData.append('category', document.getElementById('news-category').value);
            formData.append('image_url', document.getElementById('news-image-url').value);
            formData.append('content', document.getElementById('news-content').value);

            fetch('news.php?action=save', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    closeAddNewsModal();
                    fetchNews();
                } else {
                    alert(res.message);
                }
            });
        }

        function handleDeleteNews(id) {
            if (confirm("Apakah Anda yakin ingin menghapus berita ini secara permanen?")) {
                const formData = new FormData();
                formData.append('id', id);

                fetch('news.php?action=delete', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        fetchNews();
                    } else {
                        alert(res.message);
                    }
                });
            }
        }

        // LOGIN MODAL
        function openLoginModal() {
            const modal = document.getElementById('login-modal');
            const box = document.getElementById('login-box');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            box.classList.remove('scale-95');
            box.classList.add('scale-100');
        }

        function closeLoginModal() {
            const modal = document.getElementById('login-modal');
            const box = document.getElementById('login-box');
            modal.classList.add('opacity-0', 'pointer-events-none');
            box.classList.remove('scale-100');
            box.classList.add('scale-95');
        }

        function handleLogin(e) {
            e.preventDefault();
            const formData = new FormData();
            formData.append('username', document.getElementById('username').value);
            formData.append('password', document.getElementById('password').value);

            const alertMsg = document.getElementById('alert-message');

            fetch('autentikasi.php?action=login', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    alertMsg.className = "p-3 rounded-lg text-xs font-medium bg-green-100 text-green-700 block border border-green-200";
                    alertMsg.innerHTML = `<i class="fa-solid fa-circle-check"></i> ${res.message}`;
                    setTimeout(() => {
                        window.location.reload();
                    }, 800);
                } else {
                    alertMsg.className = "p-3 rounded-lg text-xs font-medium bg-red-100 text-red-700 block border border-red-200";
                    alertMsg.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> ${res.message}`;
                }
            });
        }

        function togglePasswordVisibility() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggle-eye');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // KELOLA IDENTITAS MODAL
        function openIdentityModal() {
            const modal = document.getElementById('identity-modal');
            const box = document.getElementById('identity-box');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            box.classList.remove('scale-95');
            box.classList.add('scale-100');
        }

        function closeIdentityModal() {
            const modal = document.getElementById('identity-modal');
            const box = document.getElementById('identity-box');
            modal.classList.add('opacity-0', 'pointer-events-none');
            box.classList.remove('scale-100');
            box.classList.add('scale-95');
        }

        function handleSaveIdentity(e) {
            e.preventDefault();
            const formData = new FormData();
            formData.append('school_name', document.getElementById('edit-school-name').value);
            formData.append('npsn', document.getElementById('edit-npsn').value);
            formData.append('phone', document.getElementById('edit-phone').value);
            formData.append('email', document.getElementById('edit-email').value);
            formData.append('address', document.getElementById('edit-address').value);

            fetch('identity.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    window.location.reload();
                } else {
                    alert(res.message);
                }
            });
        }

        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }

        function escapeHtml(text) {
            if (!text) return '';
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // Init App
        window.onload = function() {
            fetchNews();
        }
    </script>
</body>
</html>