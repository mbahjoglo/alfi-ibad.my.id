<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Undangan Walimatul 'Ursy Alfi & Ibad</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('image/Logo AI Arab 1 white.png') }}">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Cinzel:wght@500;600;700&family=Montserrat:wght@300;400;500;600;700&family=Sacramento&display=swap" rel="stylesheet">
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- SweetAlert2 CDN untuk Pop-up Alert Sopan & Modern -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sky: {
                            50: '#f0f8ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38b6ff',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    },
                    fontFamily: {
                        arabic: ['Amiri', 'serif'],
                        title: ['Cinzel', 'serif'],
                        latin: ['Montserrat', 'sans-serif'],
                        script: ['Sacramento', 'cursive']
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #0f172a;
            color: #334155;
            overflow-x: hidden;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(186, 230, 253, 0.5);
        }

        .islamic-arch {
            border-top-left-radius: 120px;
            border-top-right-radius: 120px;
        }

        .morph-bg {
            background: linear-gradient(135deg, #e0f2fe 0%, #ffffff 50%, #bae6fd 100%);
            background-size: 200% 200%;
            animation: morphGradient 20s ease infinite;
        }

        @keyframes morphGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .spin-slow {
            animation: spin 15s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Custom Styling SweetAlert2 agar selaras dengan desain */
        .swal2-popup {
            border-radius: 1.5rem !important;
            font-family: 'Montserrat', sans-serif !important;
        }
    </style>
</head>
<body class="antialiased selection:bg-sky-200 selection:text-sky-900">

    <div class="min-h-screen bg-slate-900 flex justify-center items-center">
        <!-- Main Mobile Container -->
        <div id="main-container" class="w-full max-w-md min-h-screen bg-sky-50 shadow-2xl relative overflow-hidden pb-24">

            <!-- Music Floating Control -->
            <button id="musicToggle" onclick="toggleAudio()" class="fixed top-5 right-5 z-40 bg-white/80 backdrop-blur border border-sky-300 text-sky-700 p-3 rounded-full shadow-lg hidden hover:scale-110 transition duration-300">
                <i id="musicIcon" class="fas fa-music spin-slow"></i>
            </button>
            <audio id="bgMusic" loop src="{{ asset('audio/NASHEED.mp3') }}"></audio>

            <!-- SECTION 1: OPENING COVER -->
            <div id="openingCover" class="fixed inset-0 z-50 max-w-md mx-auto bg-gradient-to-b from-sky-900 via-sky-800 to-sky-950 text-white flex flex-col justify-between items-center p-8 text-center transition-all duration-1000 ease-in-out">
                <div class="mt-8 space-y-3" data-aos="fade-down">
                    <p class="text-sky-200 tracking-widest text-xs uppercase font-semibold">Undangan Walimatul 'Ursy</p>
                    <div class="w-24 h-24 mx-auto border border-sky-400/40 rounded-full flex items-center justify-center my-2 overflow-hidden p-2">
                        <img src="{{ asset('image/Logo AI Arab 1 white.png') }}" alt="Logo AI" class="w-full h-full object-contain">
                    </div>
                    <!-- <h1 class="font-title text-3xl tracking-wide font-bold text-white">Alfi & Ibad</h1> -->
                     <h1 class="font-title text-3xl tracking-wide font-bold text-white" dir="rtl">
  ألفية الرحمنية & إرشاد العباد
            </h1>
                    <p class="text-xs text-sky-200/80">Jum'at, 26 Maret 2027</p>
                    <p class="text-xs text-sky-200/80">17 Syawal 1448 H</p>
                </div>

                <div class="my-auto space-y-4 w-full" data-aos="zoom-in">
                    <div class="p-6 glass-card rounded-2xl text-slate-800 border border-white/40 shadow-xl">
                        <p class="text-xs text-slate-500 mb-2">Kepada Yth. Bapak/Ibu/Saudara/i:</p>
                        <h3 class="text-xl font-bold text-sky-800 capitalize mb-1">{{ $guestName }}</h3>
                        <p class="text-[11px] text-slate-500 italic">*Mohon maaf bila ada kesalahan penulisan nama/gelar</p>
                    </div>

                    <button onclick="openInvitation()" class="w-full py-3.5 px-6 bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white font-medium rounded-full shadow-lg hover:shadow-sky-500/50 transition-all duration-300 flex items-center justify-center gap-2 group">
                        <i class="fas fa-envelope-open transition-transform group-hover:scale-110"></i>
                        <span>Buka Undangan</span>
                    </button>
                </div>

                <div class="mb-4 text-xs text-sky-300/70">
                    <p>Design by Alfi & Ibad</p>
                </div>
            </div>

            <!-- MAIN CONTENT -->
            <div id="invitationContent" class="opacity-0 transition-opacity duration-1000">

                <!-- SECTION 2: WELCOME GATE -->
                <section id="welcome" class="min-h-screen morph-bg relative flex flex-col justify-center items-center px-6 py-12 text-center overflow-hidden">
                    <div class="absolute inset-4 border border-sky-200 rounded-3xl pointer-events-none"></div>
                    <div class="absolute inset-6 border border-sky-300/40 rounded-3xl pointer-events-none"></div>

                    <div data-aos="fade-down" class="mb-6">
                        <p class="font-arabic text-2xl text-sky-800 mb-2">بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ</p>
                        <span class="text-xs tracking-widest text-sky-600 uppercase font-semibold">Walimatul 'Ursy</span>
                    </div>

                    <div data-aos="zoom-in" class="relative my-4">
                        <!-- <div class="w-48 h-64 mx-auto islamic-arch border-4 border-white shadow-xl overflow-hidden bg-sky-200 relative flex items-center justify-center">
                            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=600&q=80" alt="Alfi & Ibad" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-sky-900/20"></div>
                        </div> -->
                        <div class="w-32 h-32 mx-auto border border-sky-400/40 rounded-full flex items-center justify-center my-2 overflow-hidden p-2">
                            <img src="{{ asset('image/Logo AI Arab 1 blue.png') }}" alt="Logo AI" class="w-full h-full object-contain">
                        </div>
                    </div>

                    <div data-aos="fade-up" class="space-y-2 mt-4">
                        <h2 class="font-title text-3xl font-bold text-sky-900" dir="rtl">
                            ألفية الرحمنية & إرشاد العباد
                        </h2>
                        <p class="text-sm font-medium text-sky-700">26 Maret 2027 / 17 Syawal 1448 H</p>
                    </div>
                </section>

                <!-- SECTION 4: SURAT QS. AR-RUM : 21 -->
                <section class="py-12 px-6 morph-bg text-center">
                    <div data-aos="fade-up" class="glass-card p-6 rounded-3xl shadow-md border border-sky-100 space-y-4">
                        <div class="w-10 h-10 mx-auto bg-sky-100 rounded-full flex items-center justify-center text-sky-700">
                            <i class="fas fa-quran text-lg"></i>
                        </div>
                        <!-- <p class="font-arabic text-xl text-slate-800 leading-loose text-right dir-rtl" dir="rtl">
                            وَمِنْ اٰيٰتِهٖٓ اَنْ خَلَقَ لَكُمْ مِّنْ اَنْفُسِكُمْ اَزْوَاجًا لِّتَسْكُنُوْٓا اِلَيْهَا وَجَعَلَ بَيْنَكُمْ مَّوَدَّةً وَّرَحْمَةً ۗ اِنَّ فِيْ ذٰلِكَ لَاٰيٰتٍ لِّقَوْمٍ يَّتَفَكَّرُوْنَ
                        </p> -->
                        <p class="text-xs text-slate-600 leading-relaxed italic">
                            "Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang. Sungguh, pada yang demikian itu benar-benar terdapat tanda-tanda bagi kaum yang berpikir."
                        </p>
                        <span class="inline-block text-xs font-semibold text-sky-700 bg-sky-100 px-3 py-1 rounded-full">(QS. Ar-Rum: 21)</span>
                    </div>
                </section>

                <!-- SECTION 5: BRIDE & GROOM -->
                <section id="mempelai" class="py-12 px-6 bg-white text-center space-y-10">
                    <div data-aos="fade-up" class="space-y-2">
                        <span class="text-xs uppercase tracking-widest text-sky-600 font-bold">Mempelai Pria & Wanita</span>
                        <h2 class="font-title text-2xl font-bold text-slate-800">Pasangan Pengantin</h2>
                    </div>

                    <!-- Groom -->
                    <div data-aos="fade-up" class="space-y-4">
                        <!-- <div class="w-36 h-48 mx-auto islamic-arch border-2 border-sky-400 p-1 shadow-lg">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80" alt="Irsyadul Ibad" class="w-full h-full object-cover islamic-arch">
                        </div> -->
                        <div>
                            <h3 class="font-title text-xl font-bold text-sky-900">Irsyadul Ibad, S.Tr.Kom., M.Kom.</h3>
                            <a href="https://instagram.com/ibadirsyadul33" target="_blank" class="inline-block text-xs font-semibold text-sky-700 bg-sky-100 px-3 py-1 rounded-full"><i class="fa-brands fa-instagram"></i> ibadirsyadul33</a>
                            <br>
                            <p class="text-xs text-slate-500 mt-1">Putra dari Pasangan:</p>
                            <p class="text-xs font-semibold text-slate-700">Bapak H.Mat Kharis & Ibu Hj.Nuryati</p>
                        </div>
                    </div>

                    <div class="text-sky-400 font-script text-4xl">&</div>

                    <!-- Bride -->
                    <div data-aos="fade-up" class="space-y-4">
                        <!-- <div class="w-36 h-48 mx-auto islamic-arch border-2 border-sky-400 p-1 shadow-lg">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80" alt="Alfiyatur Rohmaniyah" class="w-full h-full object-cover islamic-arch">
                        </div> -->
                        <div>
                            <h3 class="font-title text-xl font-bold text-sky-900">Alfiyatur Rohmaniyah</h3>
                            <a href="https://www.instagram.com/alfiyatur313" target="_blank" class="inline-block text-xs font-semibold text-sky-700 bg-sky-100 px-3 py-1 rounded-full"><i class="fa-brands fa-instagram"></i> alfiyatur313</a>
                            <br>
                            <p class="text-xs text-slate-500 mt-1">Putri dari Pasangan:</p>
                            <p class="text-xs font-semibold text-slate-700">Bapak Ahmad Adib & Ibu Saiqotun</p>
                        </div>
                    </div>
                </section>

                <!-- SECTION 6: COUNTDOWN TIMER -->
                <section class="py-12 px-6 bg-gradient-to-br from-sky-800 to-sky-950 text-white text-center">
                    <div data-aos="fade-up" class="space-y-6">
                        <h3 class="font-title text-xl font-semibold">Menghitung Hari</h3>
                        <div class="grid grid-cols-4 gap-2 max-w-xs mx-auto">
                            <div class="bg-white/10 backdrop-blur rounded-xl p-3 border border-white/20">
                                <span id="days" class="block text-2xl font-bold text-sky-200">00</span>
                                <span class="text-[10px] uppercase tracking-wider text-slate-300">Hari</span>
                            </div>
                            <div class="bg-white/10 backdrop-blur rounded-xl p-3 border border-white/20">
                                <span id="hours" class="block text-2xl font-bold text-sky-200">00</span>
                                <span class="text-[10px] uppercase tracking-wider text-slate-300">Jam</span>
                            </div>
                            <div class="bg-white/10 backdrop-blur rounded-xl p-3 border border-white/20">
                                <span id="minutes" class="block text-2xl font-bold text-sky-200">00</span>
                                <span class="text-[10px] uppercase tracking-wider text-slate-300">Menit</span>
                            </div>
                            <div class="bg-white/10 backdrop-blur rounded-xl p-3 border border-white/20">
                                <span id="seconds" class="block text-2xl font-bold text-sky-200">00</span>
                                <span class="text-[10px] uppercase tracking-wider text-slate-300">Detik</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- SECTION 7 & 8: AKAD NIKAH & UNDUH MANTU -->
                <section id="acara" class="py-10 px-6 morph-bg space-y-6">
                    <div data-aos="fade-up" class="text-center mb-4 space-y-1">
                        <span class="text-xs uppercase tracking-widest text-sky-600 font-bold">Rangkaian Acara</span>
                        <h2 class="font-title text-2xl font-bold text-slate-800">Tanggal & Lokasi</h2>
                    </div>

                    <!-- Akad Nikah -->
                    <div data-aos="fade-up" class="glass-card p-6 rounded-3xl shadow-lg space-y-4 border-l-4 border-sky-600">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-sky-600 text-white rounded-full flex items-center justify-center">
                                <i class="fas fa-ring"></i>
                            </div>
                            <div>
                                <h3 class="font-title font-bold text-lg text-sky-900">Akad Nikah</h3>
                                <p class="text-xs text-sky-700">Kediaman Pengantin Wanita</p>
                            </div>
                        </div>
                        <hr class="border-sky-200">
                        <div class="space-y-2 text-xs text-slate-700">
                            <p class="flex items-center gap-2"><i class="far fa-calendar text-sky-600"></i> <strong>Jumat, 26 Maret 2027</strong></p>
                            <p class="flex items-center gap-2"><i class="far fa-clock text-sky-700"></i> <span>08.00 WIB s.d. Selesai</span></p>
                            <p class="flex items-center gap-2"><i class="far fa-moon text-sky-600"></i> <span>17 Syawal 1448 H</span></p>
                            <p class="flex items-start gap-2 mt-2">
                                <i class="fas fa-map-marker-alt text-sky-600 mt-1"></i>
                                <span>Kedungmutih, RT/RW: 01/01, Kec. Wedung, Kabupaten Demak, Jawa Tengah 59554</span>
                            </p>
                        </div>
                        <a href="https://maps.app.goo.gl/FEdiGbCVDkvg4rBH7" target="_blank" class="block w-full py-2.5 text-center bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-medium text-xs shadow-md transition">
                            <i class="fas fa-map-marked-alt mr-1"></i> Google Maps Akad Nikah
                        </a>
                    </div>

                    <!-- Unduh Mantu -->
                    <div data-aos="fade-up" class="glass-card p-6 rounded-3xl shadow-lg space-y-4 border-l-4 border-sky-800">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-sky-800 text-white rounded-full flex items-center justify-center">
                                <i class="fas fa-glass-cheers"></i>
                            </div>
                            <div>
                                <h3 class="font-title font-bold text-lg text-sky-900">Unduh Mantu</h3>
                                <p class="text-xs text-sky-700">Kediaman Pengantin Pria</p>
                            </div>
                        </div>
                        <hr class="border-sky-200">
                        <div class="space-y-2 text-xs text-slate-700">
                            <p class="flex items-center gap-2"><i class="far fa-calendar text-sky-700"></i> <strong>Ahad, 28 Maret 2027</strong></p>
                            <p class="flex items-center gap-2"><i class="far fa-clock text-sky-700"></i> <span>10.00 WIB - Selesai</span></p>
                            <p class="flex items-center gap-2"><i class="far fa-moon text-sky-700"></i> <span>19 Syawal 1448 H</span></p>
                            <p class="flex items-start gap-2 mt-2">
                                <i class="fas fa-map-marker-alt text-sky-700 mt-1"></i>
                                <span>Jl. Bugel-Jepara, Bugel, RT/RW: 12/03, Kec. Kedung, Kabupaten Jepara, Jawa Tengah 59463</span>
                            </p>
                        </div>
                        <a href="https://maps.app.goo.gl/5y1r4e9VtGCcVmAL7" target="_blank" class="block w-full py-2.5 text-center bg-sky-800 hover:bg-sky-900 text-white rounded-xl font-medium text-xs shadow-md transition">
                            <i class="fas fa-map-marked-alt mr-1"></i> Google Maps Unduh Mantu
                        </a>
                    </div>
                </section>

                <!-- SECTION 3: SAVE THE DATE BANNER -->
                <section class="bg-sky-900 text-white py-8 px-6 text-center relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 text-sky-800/30 text-9xl">
                        <i class="fas fa-mosque"></i>
                    </div>
                    <div data-aos="fade-up" class="relative z-10 space-y-3">
                        <i class="far fa-calendar-check text-sky-300 text-3xl mb-1"></i>
                        <h3 class="font-title text-xl font-bold tracking-wider">SAVE THE DATE</h3>
                        <p class="text-xs text-sky-200">Momen Bahagia Pernikahan Kami</p>

                        <div class="pt-2">
                            <button onclick="openCalendarModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 hover:bg-white/20 border border-sky-300/40 rounded-full text-xs font-medium text-sky-100 backdrop-blur transition hover:scale-105 shadow-md">
                                <i class="fab fa-google text-sky-300"></i>
                                <span>Simpan ke Google Calendar</span>
                            </button>
                        </div>
                    </div>
                </section>

                <!-- SECTION 9: LOVE STORY -->
                <section id="story" class="py-12 px-6 bg-white">
                    <div data-aos="fade-up" class="text-center mb-8 space-y-1">
                        <span class="text-xs uppercase tracking-widest text-sky-600 font-bold">Kisah Kami</span>
                        <h2 class="font-title text-2xl font-bold text-slate-800">Love Story</h2>
                    </div>

                    <div class="relative border-l-2 border-sky-200 ml-4 space-y-8">
                        <div data-aos="fade-left" class="relative pl-6">
                            <div class="absolute -left-2.5 top-0 w-5 h-5 bg-sky-500 rounded-full border-4 border-white"></div>
                            <span class="text-[10px] font-bold text-sky-600 bg-sky-100 px-2 py-0.5 rounded">Awal Ta’aruf</span>
                            <h4 class="font-bold text-sm text-slate-800 mt-1">Kisah kami bermula dari sebuah perjodohan</h4>
                            <p class="text-xs text-slate-600 mt-1">Bukan karena kami saling mencari, bahkan sebelumnya kami tidak pernah membayangkan akan dipertemukan satu sama lain. Namun, kami percaya bahwa terkadang Allah menghadirkan seseorang bukan melalui jalan yang kita pilih, melainkan melalui jalan yang telah Dia siapkan.</p>
                            <p class="text-xs text-slate-600 mt-1">Pada 29 April 2026, kami memulai ta’aruf. Tidak dengan janji tentang masa depan, hanya dengan niat untuk saling mengenal dan keyakinan bahwa jika memang Allah menakdirkan, semuanya akan menemukan jalannya.</p>
                        </div>

                        <div data-aos="fade-left" class="relative pl-6">
                            <div class="absolute -left-2.5 top-0 w-5 h-5 bg-sky-500 rounded-full border-4 border-white"></div>
                            <span class="text-[10px] font-bold text-sky-600 bg-sky-100 px-2 py-0.5 rounded">Nadzhar</span>
                            <h4 class="font-bold text-sm text-slate-800 mt-1">Pada 3 Mei 2026</h4>
                            <p class="text-xs text-slate-600 mt-1">Tibalah saatnya kami dipertemukan dalam nadzhar. Pertemuan yang sederhana, tetapi menyimpan keputusan yang tidak sederhana.</p>
                            <p class="text-xs text-slate-600 mt-1">Saat itu, kami belajar bahwa memilih pasangan bukan hanya tentang apa yang terlihat oleh mata, tetapi tentang kepada siapa hati bersedia percaya. Dengan keyakinan yang perlahan tumbuh dan hati yang sepenuhnya pasrah kepada Allah, kami menyerahkan apa pun hasilnya kepada-Nya.</p>
                            <p class="text-xs text-slate-600 mt-1">Jika bukan dia, semoga Allah menggantinya dengan yang lebih baik. Namun jika dia adalah jawaban dari doa-doa yang selama ini kami langitkan, semoga Allah mudahkan langkah kami untuk saling menemukan.</p>
                        </div>

                        <div data-aos="fade-left" class="relative pl-6">
                            <div class="absolute -left-2.5 top-0 w-5 h-5 bg-sky-500 rounded-full border-4 border-white"></div>
                            <span class="text-[10px] font-bold text-sky-600 bg-sky-100 px-2 py-0.5 rounded">Lamaran</span>
                            <h4 class="font-bold text-sm text-slate-800 mt-1">Enam hari kemudian</h4>
                            <p class="text-xs text-slate-600 mt-1">Pada 9 Mei 2026, kami melangkah menuju sebuah ikatan melalui lamaran.</p>
                            <p class="text-xs text-slate-600 mt-1">Begitu singkat perjalanan kami, tetapi mungkin memang begitulah cara Allah menunjukkan bahwa sebuah pertemuan tidak selalu membutuhkan waktu yang panjang untuk menghadirkan keyakinan.</p>
                        </div>

                        <div data-aos="fade-left" class="relative pl-6">
                            <div class="absolute -left-2.5 top-0 w-5 h-5 bg-sky-500 rounded-full border-4 border-white"></div>
                            <span class="text-[10px] font-bold text-sky-600 bg-sky-100 px-2 py-0.5 rounded">Tumbuhnya Cinta</span>
                            <h4 class="font-bold text-sm text-slate-800 mt-1">Yang awalnya hanya sebuah perjodohan</h4>
                            <p class="text-xs text-slate-600 mt-1">Perlahan berubah menjadi penerimaan. Dari penerimaan, tumbuh rasa nyaman. Dari rasa nyaman, lahir keyakinan. Dan tanpa kami sadari, cinta pun tumbuh di antara dua hati yang awalnya bahkan tidak saling mencari.</p>
                            <p class="text-xs text-slate-600 mt-1">Kami akhirnya mengerti, cinta tidak selalu harus ditemukan terlebih dahulu untuk kemudian dipertahankan. Ada kalanya cinta justru tumbuh setelah kita memilih untuk percaya kepada takdir Allah.</p>
                        </div>

                        <div data-aos="fade-left" class="relative pl-6">
                            <div class="absolute -left-2.5 top-0 w-5 h-5 bg-sky-500 rounded-full border-4 border-white"></div>
                            <span class="text-[10px] font-bold text-sky-600 bg-sky-100 px-2 py-0.5 rounded">Menuju Pernikahan</span>
                            <h4 class="font-bold text-sm text-slate-800 mt-1">Kini kami sampai pada satu titik di mana kami tidak lagi bertanya, “Mengapa harus dia?”</h4>
                            <p class="text-xs text-slate-600 mt-1">Sebab kami mulai memahami, mungkin bukan kami yang sejak awal memilih jalan ini. Allah-lah yang mempertemukan, mendekatkan, lalu menumbuhkan keyakinan di dalam hati kami.</p>
                            <p class="text-xs text-slate-600 mt-1">Berawal dari sebuah perjodohan, dimulai dengan ta’aruf, dipertemukan dalam nadzhar dengan penuh keyakinan dan kepasrahan, lalu tumbuh menjadi cinta.</p>
                            <p class="text-xs text-slate-600 mt-1">Dan jika kelak ada yang bertanya bagaimana kisah kami dimulai, mungkin jawabannya sederhana:</p>
                            <p class="text-xs text-slate-600 mt-1">Kami tidak saling mencari. Kami hanya sedang menjalani takdir, hingga akhirnya Allah mempertemukan kami.</p>
                        </div>
                    </div>
                </section>

                <!-- SECTION 10: AMPLOP DIGITAL & GIFT -->
                <section id="gift" class="py-12 px-6 morph-bg text-center space-y-6">
                    <div data-aos="fade-up" class="space-y-2">
                        <i class="fas fa-gift text-3xl text-sky-600"></i>
                        <h2 class="font-title text-2xl font-bold text-slate-800">Amplop Digital & Kado</h2>
                        <p class="text-xs text-slate-600 max-w-xs mx-auto">Doa restu Anda merupakan karunia terindah bagi kami. Namun jika ingin memberi hadiah, Anda dapat menggunakannya di bawah ini:</p>
                    </div>

                    <!-- Rekening Bride -->
                    <div data-aos="zoom-in" class="p-5 bg-gradient-to-r from-teal-700 to-teal-900 text-white rounded-2xl shadow-xl relative overflow-hidden text-left">
                        <div class="flex justify-between items-start mb-4">
                            <span class="font-bold tracking-wider text-sm">BSI</span>
                            <i class="fas fa-credit-card text-xl opacity-80"></i>
                        </div>
                        <p class="text-xs opacity-80">Nomor Rekening</p>
                        <p class="text-lg font-mono font-bold tracking-widest my-1">7334358288</p>
                        <p class="text-xs font-medium">a.n Alfiyatur Rohmaniyah</p>
                        <button onclick="copyToClipboard('7334358288', 'Rekening BSI')" class="mt-4 w-full py-2 bg-white/20 hover:bg-white/30 rounded-lg text-xs font-semibold backdrop-blur transition flex items-center justify-center gap-1">
                            <i class="far fa-copy"></i> Salin Nomor Rekening
                        </button>
                    </div>

                    <!-- Rekening Groom -->
                    <div data-aos="zoom-in" class="p-5 bg-gradient-to-r from-blue-700 to-indigo-900 text-white rounded-2xl shadow-xl relative overflow-hidden text-left">
                        <div class="flex justify-between items-start mb-4">
                            <span class="font-bold tracking-wider text-sm">BCA</span>
                            <i class="fas fa-credit-card text-xl opacity-80"></i>
                        </div>
                        <p class="text-xs opacity-80">Nomor Rekening</p>
                        <p class="text-lg font-mono font-bold tracking-widest my-1">2471123589</p>
                        <p class="text-xs font-medium">a.n Irsyadul Ibad</p>
                        <button onclick="copyToClipboard('2471123589', 'Rekening BCA')" class="mt-4 w-full py-2 bg-white/20 hover:bg-white/30 rounded-lg text-xs font-semibold backdrop-blur transition flex items-center justify-center gap-1">
                            <i class="far fa-copy"></i> Salin Nomor Rekening
                        </button>
                    </div>

                    <!-- Physical Gift -->
                    <div data-aos="fade-up" class="glass-card p-5 rounded-2xl shadow text-left space-y-2 border border-sky-200">
                        <div class="flex items-center gap-2 text-sky-800 font-bold text-sm">
                            <i class="fas fa-box"></i>
                            <span>Kado Fisik</span>
                        </div>
                        <p class="text-xs text-slate-600">Alamat Pengiriman Hadiah:</p>
                        <p class="text-xs font-medium text-slate-800">Jl. Bugel-Jepara, Rw. III, Bugel, Kec. Kedung, Kabupaten Jepara, Jawa Tengah 59463 (Penerima: Alfi & Ibad)</p>
                        <button onclick="copyToClipboard('Jl. Bugel-Jepara, Rw. III, Bugel, Kec. Kedung, Kabupaten Jepara, Jawa Tengah 59463 (Penerima: Alfi & Ibad)', 'Alamat Kado')" class="mt-2 w-full py-2 bg-sky-100 hover:bg-sky-200 text-sky-800 rounded-lg text-xs font-semibold transition flex items-center justify-center gap-1">
                            <i class="far fa-copy"></i> Salin Alamat Kado
                        </button>
                    </div>
                </section>

                <!-- SECTION 11: RSVP & WISHES WITH POLITE INDONESIAN ALERT -->
                <section id="rsvp" class="py-12 px-6 bg-white space-y-6">
                    <div data-aos="fade-up" class="text-center space-y-1">
                        <i class="far fa-comments text-3xl text-sky-600"></i>
                        <h2 class="font-title text-2xl font-bold text-slate-800">Ungkapkan Sesuatu</h2>
                        <p class="text-xs text-slate-500">Kirimkan Doa & Konfirmasi Kehadiran Anda</p>
                    </div>

                    <form id="rsvpForm" onsubmit="handleLaravelRSVP(event)" class="glass-card p-5 rounded-2xl shadow space-y-4" data-aos="fade-up">
                        
                        <!-- Honeypot Anti-Spam Field -->
                        <div class="hidden" aria-hidden="true">
                            <input type="text" id="rsvpWebsite" name="website_url" tabindex="-1" autocomplete="off">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Nama Lengkap</label>
                            <input type="text" id="rsvpName" value="{{ $guestName !== 'Tamu Undangan' ? $guestName : '' }}" maxlength="50" required placeholder="Masukkan nama Anda (max 50 karakter)" class="w-full px-3 py-2 text-xs border border-sky-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Konfirmasi Kehadiran</label>
                            <select id="rsvpStatus" class="w-full px-3 py-2 text-xs border border-sky-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400">
                                <option value="Hadir">Hadir</option>
                                <option value="Tidak Hadir">Tidak Hadir</option>
                                <option value="Ragu-ragu">Ragu-ragu</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Ucapan & Doa Restu</label>
                            <textarea id="rsvpMessage" rows="3" maxlength="500" required placeholder="Tuliskan pesan doa & ucapan (max 500 karakter)..." class="w-full px-3 py-2 text-xs border border-sky-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400"></textarea>
                        </div>
                        <button type="submit" id="btnSubmitRsvp" class="w-full py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-lg text-xs font-semibold shadow transition flex items-center justify-center gap-1">
                            <i class="fas fa-paper-plane"></i>
                            <span>Kirim Ucapan</span>
                        </button>
                    </form>

                    <!-- Wishes Display Area -->
                    <div id="wishesList" class="space-y-3 max-h-60 overflow-y-auto pr-1" data-aos="fade-up">
                        @foreach($wishes as $item)
                        <div class="bg-sky-50/80 p-3 rounded-xl border border-sky-100 text-left text-xs">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-bold text-sky-900">{{ $item->nama }}</span>
                                <span class="text-[10px] px-2 py-0.5 rounded-full {{ $item->status === 'Hadir' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">{{ $item->status }}</span>
                            </div>
                            <p class="text-slate-600 text-[11px]">{{ $item->pesan }}</p>
                        </div>
                        @endforeach
                    </div>
                </section>

                <!-- SECTION 12: PENUTUP -->
                <section class="py-12 px-6 bg-gradient-to-b from-sky-900 to-slate-950 text-white text-center space-y-6">
                    <div data-aos="fade-up" class="space-y-3">
                        <p class="text-xs text-sky-200">Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.</p>
                        <p class="font-arabic text-lg text-sky-300">جَزَاكُمُ اللهُ خَيْرًا كَثِيْرًا</p>
                        <p class="text-xs text-sky-300">Wassalamu'alaikum Warahmatullahi Wabarakatuh</p>
                    </div>

                    <div data-aos="zoom-in" class="pt-6 border-t border-sky-800">
                        <p class="text-xs text-sky-400 mb-1">Kami yang berbahagia,</p>
                        <!-- <h3 class="font-script text-3xl text-sky-200">Alfi & Ibad</h3> -->
                         <h3 class="font-script text-3xl text-sky-200" dir="rtl">
  ألفية الرحمنية & إرشاد العباد
</h3>
                        <p class="text-[10px] text-slate-400 mt-4">Beserta Keluarga Besar Kedua Mempelai</p>
                    </div>
                </section>

            </div>

            <!-- BOTTOM NAVIGATION BAR -->
            <nav id="bottomNavbar" class="fixed bottom-3 left-1/2 -translate-x-1/2 w-[calc(100%-2rem)] max-w-sm z-40 bg-white/90 backdrop-blur-md border border-sky-200 shadow-2xl rounded-2xl py-2 px-3 hidden transition-all duration-300">
                <div class="flex justify-around items-center">
                    <a href="#welcome" class="flex flex-col items-center gap-0.5 text-slate-500 hover:text-sky-600 transition group">
                        <i class="fas fa-home text-base group-hover:scale-110 transition-transform"></i>
                        <span class="text-[10px] font-medium">Beranda</span>
                    </a>
                    <a href="#mempelai" class="flex flex-col items-center gap-0.5 text-slate-500 hover:text-sky-600 transition group">
                        <i class="fas fa-user-friends text-base group-hover:scale-110 transition-transform"></i>
                        <span class="text-[10px] font-medium">Mempelai</span>
                    </a>
                    <a href="#acara" class="flex flex-col items-center gap-0.5 text-slate-500 hover:text-sky-600 transition group">
                        <i class="fas fa-calendar-alt text-base group-hover:scale-110 transition-transform"></i>
                        <span class="text-[10px] font-medium">Acara</span>
                    </a>
                    <a href="#story" class="flex flex-col items-center gap-0.5 text-slate-500 hover:text-sky-600 transition group">
                        <i class="fas fa-heart text-base group-hover:scale-110 transition-transform"></i>
                        <span class="text-[10px] font-medium">Story</span>
                    </a>
                    <a href="#gift" class="flex flex-col items-center gap-0.5 text-slate-500 hover:text-sky-600 transition group">
                        <i class="fas fa-gift text-base group-hover:scale-110 transition-transform"></i>
                        <span class="text-[10px] font-medium">Kado</span>
                    </a>
                    <a href="#rsvp" class="flex flex-col items-center gap-0.5 text-slate-500 hover:text-sky-600 transition group">
                        <i class="fas fa-comment-dots text-base group-hover:scale-110 transition-transform"></i>
                        <span class="text-[10px] font-medium">RSVP</span>
                    </a>
                </div>
            </nav>

        </div>
    </div>

    <!-- MODAL POP-UP: SAVE TO GOOGLE CALENDAR -->
    <div id="calendarModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300">
        <div id="calendarModalCard" class="bg-white rounded-3xl p-6 max-w-xs w-full shadow-2xl border border-sky-100 text-center space-y-4 transform scale-95 transition-transform duration-300 relative">
            <button onclick="closeCalendarModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 p-1">
                <i class="fas fa-times text-lg"></i>
            </button>
            <div class="w-12 h-12 mx-auto bg-sky-100 text-sky-600 rounded-full flex items-center justify-center text-xl shadow-inner">
                <i class="far fa-calendar-plus"></i>
            </div>
            <div>
                <h3 class="font-title text-lg font-bold text-slate-800">Simpan ke Kalender</h3>
                <p class="text-xs text-slate-500 mt-1">Pilih jadwal acara yang ingin Anda simpan ke Google Calendar:</p>
            </div>
            <div class="space-y-2.5 pt-1">
                <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=Akad+Nikah+Alfi+%26+Ibad&dates=20270326T010000Z/20270326T040000Z&details=Pernikahan+Alfiyatur+Rohmaniyah+%26+Irsyadul+Ibad&location=Kedungmutih%2C+RT%2FRW%3A+01%2F01%2C+Kec.+Wedung%2C+Kabupaten+Demak%2C+Jawa+Tengah+59554" target="_blank" onclick="closeCalendarModal()" class="flex items-center gap-3 p-3.5 rounded-2xl bg-sky-50 border border-sky-200 hover:bg-sky-100 transition text-left group">
                    <div class="w-9 h-9 bg-sky-600 text-white rounded-xl flex items-center justify-center shrink-0 shadow">
                        <i class="fas fa-ring text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-800 group-hover:text-sky-700">Akad Nikah</p>
                        <p class="text-[10px] text-slate-500">Jumat, 26 Maret 2027</p>
                    </div>
                    <i class="fas fa-chevron-right text-xs text-slate-400 group-hover:text-sky-600 transition-transform group-hover:translate-x-0.5"></i>
                </a>
                <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=Unduh+Mantu+Alfi+%26+Ibad&dates=20270328T020000Z/20270328T060000Z&details=Resepsi+Unduh+Mantu+Alfiyatur+Rohmaniyah+%26+Irsyadul+Ibad&location=Jl.+Bugel-Jepara%2C+Rw.+III%2C+Bugel%2C+Kec.+Kedung%2C+Kabupaten+Jepara%2C+Jawa+Tengah+59463" target="_blank" onclick="closeCalendarModal()" class="flex items-center gap-3 p-3.5 rounded-2xl bg-sky-50 border border-sky-200 hover:bg-sky-100 transition text-left group">
                    <div class="w-9 h-9 bg-sky-800 text-white rounded-xl flex items-center justify-center shrink-0 shadow">
                        <i class="fas fa-glass-cheers text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-800 group-hover:text-sky-700">Unduh Mantu</p>
                        <p class="text-[10px] text-slate-500">Minggu, 28 Maret 2027</p>
                    </div>
                    <i class="fas fa-chevron-right text-xs text-slate-400 group-hover:text-sky-600 transition-transform group-hover:translate-x-0.5"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Toast Notification Ringkas -->
    <div id="toast" class="fixed bottom-20 left-1/2 -translate-x-1/2 z-50 bg-slate-900 text-white text-xs px-4 py-2.5 rounded-full shadow-2xl opacity-0 transition-opacity pointer-events-none flex items-center gap-2 border border-sky-400">
        <i class="fas fa-check-circle text-sky-400" id="toastIcon"></i>
        <span id="toastMsg">Teks berhasil disalin!</span>
    </div>

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });

        let isAudioPlaying = false;
        const audio = document.getElementById('bgMusic');
        const musicToggle = document.getElementById('musicToggle');
        const bottomNavbar = document.getElementById('bottomNavbar');

        function openInvitation() {
            document.getElementById('openingCover').classList.add('-translate-y-full', 'opacity-0');
            document.getElementById('invitationContent').classList.remove('opacity-0');
            musicToggle.classList.remove('hidden');
            bottomNavbar.classList.remove('hidden');
            
            audio.play().then(() => { isAudioPlaying = true; }).catch(e => console.log(e));
            setTimeout(() => { AOS.refresh(); }, 500);
        }

        function toggleAudio() {
            const icon = document.getElementById('musicIcon');
            if (isAudioPlaying) {
                audio.pause();
                icon.classList.remove('spin-slow');
                icon.classList.replace('fa-music', 'fa-volume-mute');
            } else {
                audio.play();
                icon.classList.add('spin-slow');
                icon.classList.replace('fa-volume-mute', 'fa-music');
            }
            isAudioPlaying = !isAudioPlaying;
        }

        // Calendar Modal Functions
        function openCalendarModal() {
            const modal = document.getElementById('calendarModal');
            const card = document.getElementById('calendarModalCard');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                card.classList.remove('scale-95');
                card.classList.add('scale-100');
            }, 10);
        }

        function closeCalendarModal() {
            const modal = document.getElementById('calendarModal');
            const card = document.getElementById('calendarModalCard');
            modal.classList.add('opacity-0');
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Countdown Timer
        const weddingDate = new Date("March 26, 2027 08:00:00").getTime();
        setInterval(function() {
            const now = new Date().getTime();
            const distance = weddingDate - now;

            if (distance > 0) {
                document.getElementById("days").innerText = Math.floor(distance / (1000 * 60 * 60 * 24));
                document.getElementById("hours").innerText = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                document.getElementById("minutes").innerText = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                document.getElementById("seconds").innerText = Math.floor((distance % (1000 * 60)) / 1000);
            }
        }, 1000);

        function copyToClipboard(text, label) {
            navigator.clipboard.writeText(text);
            showToast(`${label} berhasil disalin!`);
        }

        function showToast(msg, isError = false) {
            const toast = document.getElementById('toast');
            const icon = document.getElementById('toastIcon');
            document.getElementById('toastMsg').innerText = msg;
            
            if (isError) {
                icon.className = 'fas fa-exclamation-circle text-rose-400';
            } else {
                icon.className = 'fas fa-check-circle text-sky-400';
            }

            toast.classList.remove('opacity-0');
            setTimeout(() => { toast.classList.add('opacity-0'); }, 3000);
        }

        // Helper Sanitisasi XSS
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.innerText = text;
            return div.innerHTML;
        }

        // SYSTEM ALERT RSVP BAHASA INDONESIA DENGAN BAHASA SOPAN
        async function handleLaravelRSVP(e) {
            e.preventDefault();

            // Proteksi Honeypot
            const honeypot = document.getElementById('rsvpWebsite').value;
            if (honeypot !== "") {
                return false;
            }

            // Proteksi Cooldown Spam (60 detik)
            const COOLDOWN_TIME = 60000;
            const lastSubmitTime = localStorage.getItem('last_rsvp_submit');
            const now = Date.now();

            if (lastSubmitTime && (now - parseInt(lastSubmitTime)) < COOLDOWN_TIME) {
                const remainingSeconds = Math.ceil((COOLDOWN_TIME - (now - parseInt(lastSubmitTime))) / 1000);
                
                Swal.fire({
                    icon: 'warning',
                    title: 'Mohon Menunggu Sejenak',
                    html: `Terima kasih atas antusiasme Anda.<br>Mohon tunggu <b>${remainingSeconds} detik</b> lagi sebelum mengirimkan ucapan baru.`,
                    confirmButtonText: 'Baik, Saya Mengerti',
                    confirmButtonColor: '#0284c7'
                });
                return false;
            }

            const btn = document.getElementById('btnSubmitRsvp');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Sedang Mengirim...';

            const nama = document.getElementById('rsvpName').value.trim();
            const status = document.getElementById('rsvpStatus').value;
            const pesan = document.getElementById('rsvpMessage').value.trim();
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await fetch("{{ route('rsvp.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ nama, status, pesan, website_url: honeypot })
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    localStorage.setItem('last_rsvp_submit', Date.now().toString());

                    Swal.fire({
                        icon: 'success',
                        title: 'Terima Kasih',
                        html: `
                            <p style="font-size: 13px; color: #475569; margin-top: 8px; line-height: 1.6;">
                                Terima kasih banyak atas konfirmasi kehadiran dan doa restu yang Bapak/Ibu/Saudara/i berikan kepada <b>Alfi & Ibad</b>.
                            </p>
                            <p style="font-size: 12px; color: #0284c7; margin-top: 10px; font-style: italic;">
                                Semoga Allah SWT membalas kedermawanan dan kebaikan Anda dengan keberkahan yang berlipat ganda. Amin.
                            </p>
                        `,
                        confirmButtonText: 'Sama-sama',
                        confirmButtonColor: '#0284c7'
                    });

                    document.getElementById('rsvpMessage').value = '';

                    const safeNama = escapeHtml(result.data.nama);
                    const safeStatus = escapeHtml(result.data.status);
                    const safePesan = escapeHtml(result.data.pesan);

                    const container = document.getElementById('wishesList');
                    const newWishHtml = `
                        <div class="bg-sky-50/80 p-3 rounded-xl border border-sky-100 text-left text-xs">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-bold text-sky-900">${safeNama}</span>
                                <span class="text-[10px] px-2 py-0.5 rounded-full ${safeStatus === 'Hadir' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700'}">${safeStatus}</span>
                            </div>
                            <p class="text-slate-600 text-[11px]">${safePesan}</p>
                        </div>
                    `;
                    container.insertAdjacentHTML('afterbegin', newWishHtml);
                } else {
                    // Tampilkan pesan error spesifik dari Laravel jika ada
                    let detailError = result.message || 'Terjadi kendala saat menyimpan ucapan Anda.';
                    if (result.errors) {
                        detailError = Object.values(result.errors).flat().join('<br>');
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Mohon Maaf',
                        html: detailError,
                        confirmButtonText: 'Periksa Isian',
                        confirmButtonColor: '#e11d48'
                    });
                }
            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Kendala Sistem',
                    text: 'Mohon maaf, terjadi kesalahan pada server atau koneksi jaringan. Silakan coba lagi.',
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#e11d48'
                });
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane mr-1"></i> Kirim Ucapan';
            }
        }
    </script>
</body>
</html>