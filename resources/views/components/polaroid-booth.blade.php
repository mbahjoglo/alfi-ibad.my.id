@props(['guestName' => request()->query('to', 'Tamu Undangan'), 'guestSlug' => request()->query('slug', '')])

<div class="w-full max-w-xl mx-auto my-10 p-6 bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border border-rose-100 font-sans">
    <!-- Header Section -->
    <div class="text-center mb-6">
        <span class="inline-block px-3 py-1 bg-rose-100 text-rose-700 text-xs font-semibold rounded-full uppercase tracking-wider mb-2">
            📸 Photo Booth & Upload
        </span>
        <h3 class="text-2xl font-serif font-bold text-slate-800">Polaroid Album Kenangan</h3>
        <p class="text-xs text-slate-500 mt-1">Abadikan momen dan bagikan ucapan manis Anda (Maksimal 3 Foto).</p>
        
        <!-- Indicator Kuota Foto -->
        <div class="mt-3 inline-flex items-center gap-2 px-3 py-1 bg-slate-100 rounded-lg text-xs font-medium text-slate-600">
            <span>Sisa Kuota Unggah:</span>
            <span id="quota-badge" class="px-2 py-0.5 bg-rose-500 text-white font-bold rounded-full text-[10px]">3/3</span>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="space-y-5">
        <!-- Input Form Identitas -->
        <div id="input-step" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Pengirim</label>
                <input type="text" id="polaroid-nama" value="{{ $guestName }}" 
                       class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-400 font-medium text-slate-700" 
                       placeholder="Nama Anda">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Pesan / Caption Foto (Opsional)</label>
                <input type="text" id="polaroid-caption" maxLength="60" 
                       class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-400 text-slate-700" 
                       placeholder="Contoh: Happy Wedding Alfi & Ibad! 💕">
            </div>
        </div>

        <!-- Live Camera View Container -->
        <div id="camera-container" class="relative w-full aspect-[3/4] bg-slate-900 rounded-2xl overflow-hidden shadow-inner flex flex-col items-center justify-center">
            <video id="camera-video" autoplay playsinline class="w-full h-full object-cover"></video>
            
            <!-- Shutter Button (Ambil Foto) -->
            <div class="absolute bottom-4 left-0 right-0 flex justify-center items-center">
                <button type="button" id="btn-capture" onclick="takeSnapshot()"
                        class="w-16 h-16 bg-white hover:bg-rose-50 rounded-full shadow-lg border-4 border-rose-500 flex items-center justify-center transition transform active:scale-95 focus:outline-none">
                    <div class="w-12 h-12 bg-rose-500 rounded-full"></div>
                </button>
            </div>
            
            <!-- Pesan & Tombol Cadangan jika kamera tidak ada -->
            <div id="camera-error" class="hidden absolute inset-0 bg-slate-900 text-white p-6 flex flex-col items-center justify-center text-center">
                <p class="text-sm font-semibold mb-1">Kamera Tidak Terdeteksi / Diblokir</p>
                <p class="text-xs text-slate-400 mb-4">Karena Anda menggunakan peangkat tanpa kamera, silakan gunakan tombol unggah file di bawah ini.</p>
                
                <!-- Input File Cadangan untuk Komputer Tanpa Kamera -->
                <input type="file" id="polaroid-file-fallback" accept="image/*" class="hidden" onchange="processFallbackImage(this)">
                <button type="button" onclick="document.getElementById('polaroid-file-fallback').click()" 
                        class="px-4 py-2.5 bg-rose-500 hover:bg-rose-600 text-white text-xs font-semibold rounded-xl shadow transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Pilih Foto dari Perangkat
                </button>
            </div>
        </div>

        <!-- Canvas Frame Polaroid & Action (Hidden until captured) -->
        <div id="preview-wrapper" class="hidden flex-col items-center justify-center p-4 bg-slate-50 rounded-2xl border border-slate-200">
            <p class="text-xs font-semibold text-slate-500 mb-2">Pratinjau Foto Polaroid Anda:</p>
            
            <!-- Canvas Render Frame -->
            <canvas id="polaroid-canvas" class="max-w-full h-auto shadow-2xl rounded-sm bg-white"></canvas>

            <!-- Action Buttons -->
            <div class="mt-4 flex flex-wrap gap-2 w-full">
                <!-- Retake / Ulangi Foto -->
                <button type="button" onclick="retakePhoto()" 
                        class="flex-1 py-2.5 px-3 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium text-xs rounded-xl shadow transition duration-200 flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Ulangi
                </button>

                <!-- Download Button -->
                <button type="button" onclick="downloadPolaroid()" 
                        class="flex-1 py-2.5 px-3 bg-slate-800 hover:bg-slate-900 text-white font-medium text-xs rounded-xl shadow transition duration-200 flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Simpan
                </button>

                <!-- Submit Button -->
                <button type="button" id="btn-upload" onclick="uploadPolaroid()" 
                        class="flex-1 py-2.5 px-3 bg-rose-500 hover:bg-rose-600 text-white font-semibold text-xs rounded-xl shadow transition duration-200 flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Kirim
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Engine -->
<script>
    let currentBlob = null;
    let mediaStream = null;
    const guestSlug = "{{ $guestSlug }}";

    document.addEventListener("DOMContentLoaded", function () {
        checkQuota();
        startCamera();
    });

    function startCamera() {
        const videoElement = document.getElementById('camera-video');
        const errorElement = document.getElementById('camera-error');
        errorElement.classList.add('hidden');

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            errorElement.classList.remove('hidden');
            return;
        }

        navigator.mediaDevices.getUserMedia({ video: { width: { ideal: 1280 }, height: { ideal: 1280 } }, audio: false })
            .then(stream => {
                mediaStream = stream;
                videoElement.srcObject = stream;
            })
            .catch(err => {
                console.warn("Kamera tidak tersedia:", err);
                errorElement.classList.remove('hidden');
            });
    }

    function takeSnapshot() {
        const video = document.getElementById('camera-video');
        if (!video.srcObject) {
            alert("Kamera tidak aktif. Silakan gunakan tombol unggah file di komputer.");
            return;
        }

        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth || 720;
        canvas.height = video.videoHeight || 720;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        const img = new Image();
        img.onload = function () {
            renderPolaroidCanvas(img);
        };
        img.src = canvas.toDataURL('image/jpeg', 0.95);
    }

    // Fungsi tambahan untuk memproses foto dari file komputer
    function processFallbackImage(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            const img = new Image();
            img.onload = function () {
                renderPolaroidCanvas(img);
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    function checkQuota() {
        const nama = document.getElementById('polaroid-nama').value;
        fetch(`/polaroid/check-quota?nama=${encodeURIComponent(nama)}&slug=${encodeURIComponent(guestSlug)}`)
            .then(res => res.json())
            .then(data => {
                const badge = document.getElementById('quota-badge');
                if (badge) {
                    badge.innerText = `${data.remaining}/3`;
                    if (data.remaining <= 0) {
                        badge.className = "px-2 py-0.5 bg-slate-400 text-white font-bold rounded-full text-[10px]";
                    }
                }
            })
            .catch(err => console.error("Error check quota:", err));
    }

    function renderPolaroidCanvas(img) {
        const canvas = document.getElementById('polaroid-canvas');
        const ctx = canvas.getContext('2d');

        const width = 600;
        const height = 750;
        canvas.width = width;
        canvas.height = height;

        ctx.fillStyle = '#FFFFFF';
        ctx.fillRect(0, 0, width, height);

        ctx.strokeStyle = '#E2E8F0';
        ctx.lineWidth = 2;
        ctx.strokeRect(1, 1, width - 2, height - 2);

        const photoX = 40;
        const photoY = 40;
        const photoSize = 520;

        let srcX = 0, srcY = 0, srcWidth = img.width, srcHeight = img.height;
        if (img.width > img.height) {
            srcWidth = img.height;
            srcX = (img.width - img.height) / 2;
        } else {
            srcHeight = img.width;
            srcY = (img.height - img.width) / 2;
        }

        ctx.drawImage(img, srcX, srcY, srcWidth, srcHeight, photoX, photoY, photoSize, photoSize);

        ctx.strokeStyle = '#F1F5F9';
        ctx.lineWidth = 1;
        ctx.strokeRect(photoX, photoY, photoSize, photoSize);

        const caption = document.getElementById('polaroid-caption').value || "Happy Wedding Ibad & Alfi";
        const pengirim = document.getElementById('polaroid-nama').value || "Tamu Undangan";

        ctx.fillStyle = '#1E293B';
        ctx.font = 'italic 500 24px Georgia, serif';
        ctx.textAlign = 'center';
        ctx.fillText(`"${caption}"`, width / 2, 615);

        ctx.fillStyle = '#94A3B8';
        ctx.font = '500 16px sans-serif';
        ctx.fillText(`Dari: ${pengirim}`, width / 2, 655);

        ctx.fillStyle = '#E11D48';
        ctx.font = 'bold 12px sans-serif';
        ctx.fillText(`IBAD & ALFI WEDDING ALBUM`, width / 2, 700);

        document.getElementById('camera-container').classList.add('hidden');
        document.getElementById('preview-wrapper').classList.remove('hidden');
        document.getElementById('preview-wrapper').classList.add('flex');

        if (mediaStream) {
            mediaStream.getTracks().forEach(track => track.stop());
        }

        canvas.toBlob(function (blob) {
            currentBlob = blob;
        }, 'image/jpeg', 0.9);
    }

    function retakePhoto() {
        document.getElementById('preview-wrapper').classList.add('hidden');
        document.getElementById('preview-wrapper').classList.remove('flex');
        document.getElementById('camera-container').classList.remove('hidden');
        currentBlob = null;
        startCamera();
    }

    function downloadPolaroid() {
        const canvas = document.getElementById('polaroid-canvas');
        const link = document.createElement('a');
        const nama = document.getElementById('polaroid-nama').value || 'Tamu';
        
        link.download = `Polaroid_Alfi_Ibad_${nama.replace(/\s+/g, '_')}.jpg`;
        link.href = canvas.toDataURL('image/jpeg', 0.95);
        link.click();
    }

    function uploadPolaroid() {
        if (!currentBlob) {
            alert("Silakan ambil atau pilih foto terlebih dahulu.");
            return;
        }

        const btnUpload = document.getElementById('btn-upload');
        btnUpload.disabled = true;
        btnUpload.innerText = "Mengunggah...";

        const formData = new FormData();
        formData.append('foto', currentBlob, 'polaroid.jpg');
        formData.append('nama_pengirim', document.getElementById('polaroid-nama').value);
        formData.append('caption', document.getElementById('polaroid-caption').value);
        formData.append('guest_slug', guestSlug);

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

        fetch("{{ route('polaroid.upload') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async res => {
            const data = await res.json();
            if (!res.ok || !data.success) {
                throw new Error(data.message || 'Gagal mengunggah foto.');
            }
            return data;
        })
        .then(data => {
            alert("Terima kasih! Foto Polaroid Anda berhasil dikirim ke album kenangan Alfi & Ibad.");
            document.getElementById('polaroid-caption').value = '';
            currentBlob = null;
            checkQuota();
            retakePhoto();
        })
        .catch(err => {
            alert(err.message);
        })
        .finally(() => {
            btnUpload.disabled = false;
            btnUpload.innerText = "Kirim";
        });
    }
</script>