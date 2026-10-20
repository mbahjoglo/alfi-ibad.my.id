<!DOCTYPE html>
<html lang="id">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- TAMBAHKAN META CSRF TOKEN INI -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Manajemen Tamu &amp; Broadcast - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>body { font-family: 'Montserrat', sans-serif; }</style>
</head>
<body class="bg-slate-900 text-slate-800 antialiased min-h-screen p-4 md:p-8">

    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-6 rounded-3xl shadow-xl gap-4">
            <div>
                <h1 class="font-bold text-xl text-slate-800">Manajemen Tamu Undangan</h1>
                <p class="text-xs text-slate-500">Kelola daftar tamu dan kirim undangan otomatis via WhatsApp</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-xs bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2.5 rounded-xl transition font-medium">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
                </a>
                <form action="<?php echo e(route('admin.logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="text-xs bg-rose-600 hover:bg-rose-700 text-white px-4 py-2.5 rounded-xl transition font-medium">
                        <i class="fas fa-sign-out-alt mr-1"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

        <!-- Cards Ringkasan Statistik -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 bg-slate-100 text-slate-700 rounded-xl flex items-center justify-center text-lg shrink-0">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <p class="text-[11px] font-medium text-slate-500">Total Tamu</p>
                    <p class="text-lg font-bold text-slate-800"><?php echo e($totalTamu); ?></p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-amber-200/60 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-100 text-amber-800 rounded-xl flex items-center justify-center text-lg shrink-0">
                    <i class="fas fa-male"></i>
                </div>
                <div>
                    <p class="text-[11px] font-medium text-amber-900/70">Tamu Pria (Ibad)</p>
                    <p class="text-lg font-bold text-amber-950"><?php echo e($tamuPria); ?></p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-sky-200/60 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 bg-sky-100 text-sky-700 rounded-xl flex items-center justify-center text-lg shrink-0">
                    <i class="fas fa-female"></i>
                </div>
                <div>
                    <p class="text-[11px] font-medium text-sky-900/70">Tamu Wanita (Alfi)</p>
                    <p class="text-lg font-bold text-sky-950"><?php echo e($tamuWanita); ?></p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-emerald-200/60 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center text-lg shrink-0">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div>
                    <p class="text-[11px] font-medium text-emerald-900/70">Sudah Kirim WA</p>
                    <p id="countSudahKirim" class="text-lg font-bold text-emerald-950"><?php echo e($sudahKirim); ?></p>
                </div>
            </div>
        </div>

        <?php if(session('success')): ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: "<?php echo e(session('success')); ?>",
                    confirmButtonColor: '#0284c7'
                });
            </script>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Tambah Tamu -->
            <div class="bg-white p-6 rounded-3xl shadow-xl space-y-4 h-fit">
                <h2 class="font-bold text-sm text-slate-800 flex items-center gap-2">
                    <i class="fas fa-user-plus text-sky-600"></i> Tambah Tamu Baru
                </h2>
                <form action="<?php echo e(route('admin.guests.store')); ?>" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Kategori Undangan</label>
                        <select name="category" required class="w-full px-4 py-2.5 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                            <option value="pria" <?php echo e(request('category') === 'pria' ? 'selected' : ''); ?>>Tamu Ibad (Pengantin Pria)</option>
                            <option value="wanita" <?php echo e(request('category') === 'wanita' ? 'selected' : ''); ?>>Tamu Alfi (Pengantin Wanita)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Nama Tamu &amp; Gelar</label>
                        <input type="text" name="nama" required placeholder="Contoh: Budi Santoso, S.T." class="w-full px-4 py-2.5 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">No. WhatsApp (Awali 08 / 62)</label>
                        <input type="text" name="telepon" required placeholder="Contoh: 081234567890" class="w-full px-4 py-2.5 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                    <button type="submit" class="w-full py-3 bg-sky-600 hover:bg-sky-700 text-white rounded-xl text-xs font-bold shadow-md transition">
                        Simpan Tamu
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar Tamu & Broadcast -->
            <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-xl space-y-4">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <h2 class="font-bold text-sm text-slate-800 flex items-center gap-2">
                        <i class="fas fa-users text-sky-600"></i> Daftar Tamu Undangan (<?php echo e(count($guests)); ?>)
                    </h2>
                    
                    <?php if(count($guests) > 0): ?>
                    <button onclick="sendBulkWhatsApp()" class="text-xs bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl font-bold transition flex items-center gap-2 shadow-md">
                        <i class="fab fa-whatsapp text-sm"></i> Kirim WhatsApp Masal
                    </button>
                    <?php endif; ?>
                </div>

                <!-- TAB FILTER KATEGORI TAMU -->
                <div class="flex border-b border-slate-100 gap-2 text-xs font-semibold pt-2">
                    <a href="<?php echo e(route('admin.guests.index')); ?>" 
                       class="pb-2 px-3 border-b-2 transition flex items-center gap-1.5 <?php echo e(request('category') === null || request('category') === '' ? 'border-sky-600 text-sky-600 font-bold' : 'border-transparent text-slate-400 hover:text-slate-600'); ?>">
                        <i class="fas fa-list"></i> Semua
                    </a>
                    <a href="<?php echo e(route('admin.guests.index', ['category' => 'pria'])); ?>" 
                       class="pb-2 px-3 border-b-2 transition flex items-center gap-1.5 <?php echo e(request('category') === 'pria' ? 'border-amber-700 text-amber-800 font-bold' : 'border-transparent text-slate-400 hover:text-slate-600'); ?>">
                        <i class="fas fa-user-tie text-amber-700"></i> Tamu Ibad (Pria)
                    </a>
                    <a href="<?php echo e(route('admin.guests.index', ['category' => 'wanita'])); ?>" 
                       class="pb-2 px-3 border-b-2 transition flex items-center gap-1.5 <?php echo e(request('category') === 'wanita' ? 'border-sky-500 text-sky-600 font-bold' : 'border-transparent text-slate-400 hover:text-slate-600'); ?>">
                        <i class="fas fa-user-dress text-sky-500"></i> Tamu Alfi (Wanita)
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-400 font-semibold uppercase">
                                <th class="py-3 px-2">No</th>
                                <th class="py-3 px-2">Kategori</th>
                                <th class="py-3 px-2">Nama Tamu</th>
                                <th class="py-3 px-2">No WhatsApp</th>
                                <th class="py-3 px-2 text-center">Status Kirim</th>
                                <th class="py-3 px-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600">
                            <?php $__empty_1 = true; $__currentLoopData = $guests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index =>$guest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $category =$guest->category ?? 'pria';
                                $routeName = ($category === 'wanita') ? 'undangan.wanita' : 'undangan.pria';$guestLink = route($routeName, ['to' =>$guest->nama]);
                                $isSent = ($guest->status_kirim === 'Sudah Dikirim');
                            ?>
                            <tr class="guest-row" id="guest-row-<?php echo e($guest->id); ?>" data-id="<?php echo e($guest->id); ?>" data-category="<?php echo e($category); ?>" data-name="<?php echo e($guest->nama); ?>" data-phone="<?php echo e($guest->telepon); ?>" data-link="<?php echo e($guestLink); ?>">
                                <td class="py-3 px-2 font-medium"><?php echo e($index + 1); ?></td>
                                <td class="py-3 px-2">
                                    <?php if($category === 'pria'): ?>
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-100 text-amber-800">Pria</span>
                                    <?php else: ?>
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-sky-100 text-sky-800">Wanita</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-2 font-bold text-slate-800"><?php echo e($guest->nama); ?></td>
                                <td class="py-3 px-2"><?php echo e($guest->telepon); ?></td>
                                
                                <!-- SAKELAR TOGGLE STATUS KIRIM (AUTOMATIS KE DB) -->
                                <td class="py-3 px-2 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" id="toggle-<?php echo e($guest->id); ?>" onchange="handleToggleStatus(<?php echo e($guest->id); ?>)" class="sr-only peer" <?php echo e($isSent ? 'checked' : ''); ?>>
                                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                                        </label>
                                        <span id="text-status-<?php echo e($guest->id); ?>" class="text-[10px] font-semibold <?php echo e($isSent ? 'text-emerald-700' : 'text-slate-400'); ?>">
                                            <?php echo e($isSent ? 'Terkirim' : 'Belum'); ?>

                                        </span>
                                    </div>
                                </td>

                                <td class="py-3 px-2 text-center flex items-center justify-center gap-2">
                                    <!-- Tombol Kirim WA Biasa -->
                                    <button onclick="sendSingleWhatsApp('<?php echo e($guest->telepon); ?>', '<?php echo e($guest->nama); ?>', '<?php echo e($guestLink); ?>', '<?php echo e($category); ?>')" class="bg-emerald-500 hover:bg-emerald-600 text-white p-2 rounded-lg transition" title="Kirim WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </button>

                                    <!-- Hapus -->
                                    <form action="<?php echo e(route('admin.guests.destroy', $guest->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus tamu ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="bg-rose-100 hover:bg-rose-200 text-rose-600 p-2 rounded-lg transition" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 italic">Belum ada data tamu undangan untuk kategori ini.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function formatPhone(phone) {
            let cleaned = phone.replace(/\D/g, '');
            if (cleaned.startsWith('0')) {
                cleaned = '62' + cleaned.slice(1);
            }
            return cleaned;
        }

        function createWaMessage(name, link, category) {
            let coupleLong = (category === 'pria') ? "Irsyadul Ibad & Alfiyatur Rohmaniyah" : "Alfiyatur Rohmaniyah & Irsyadul Ibad";
            let coupleShort = (category === 'pria') ? "Ibad & Alfi" : "Alfi & Ibad";

            return "Kepada Yth.\n" +
            "Bapak/Ibu/Saudara/i\n" +
            "*" + name + "*\n" +
            "____\n\n" +

            "*السَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللَّهِ وَبَرَكَاتُهُ*\n\n" +

            "Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i, teman sekaligus sahabat, untuk menghadiri acara pernikahan kami:\n\n" +

            "*" + coupleLong + "*\n\n" +

            "Berikut tautan undangan digital kami untuk informasi lengkap mengenai acara:\n" +
            link + "\n\n" +

            "Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.\n\n" +

            "*وَالسَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللَّهِ وَبَرَكَاتُهُ*\n\n" +

            "Terima kasih.\n\n" +
            "Hormat kami,\n" +
            "*" + coupleShort + "*";
        }

        // Fungsi AJAX Toggle Status Kirim ke Database
        function handleToggleStatus(guestId) {
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        const token = metaToken ? metaToken.getAttribute('content') : '<?php echo e(csrf_token()); ?>';

        fetch(`/admin/guests/${guestId}/update-status-kirim`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(async res => {
            const data = await res.json();
            if (!res.ok || !data.success) {
                throw new Error(data.message || `HTTP Error ${res.status}`);
            }
            return data;
        })
        .then(data => {
            const textStatus = document.getElementById(`text-status-${guestId}`);
            const toggleInput = document.getElementById(`toggle-${guestId}`);
            const countElem = document.getElementById('countSudahKirim');
            let currCount = parseInt(countElem ? countElem.innerText : '0') || 0;

            if (data.status_kirim === 'Sudah Dikirim') {
                if (textStatus) {
                    textStatus.innerText = 'Terkirim';
                    textStatus.className = 'text-[10px] font-semibold text-emerald-700';
                }
                if (toggleInput) toggleInput.checked = true;
                if (countElem) countElem.innerText = currCount + 1;
            } else {
                if (textStatus) {
                    textStatus.innerText = 'Belum';
                    textStatus.className = 'text-[10px] font-semibold text-slate-400';
                }
                if (toggleInput) toggleInput.checked = false;
                if (countElem && currCount > 0) countElem.innerText = currCount - 1;
            }
        })
        .catch(err => {
            console.error("Gagal update status:", err);
            // Buka sakelar kembali jika gagal
            const toggleInput = document.getElementById(`toggle-${guestId}`);
            if (toggleInput) toggleInput.checked = !toggleInput.checked;
            
            alert("Gagal memperbarui status ke database: " + err.message);
        });
    }

        // Buka WhatsApp Tunggal
        function sendSingleWhatsApp(phone, name, link, category) {
            let formattedPhone = formatPhone(phone);
            let message = createWaMessage(name, link, category);
            let url = "https://api.whatsapp.com/send?phone=" + formattedPhone + "&text=" + encodeURIComponent(message);
            window.open(url, '_blank');
        }

        // Broadcast WhatsApp Masal
        function sendBulkWhatsApp() {
            let rows = document.querySelectorAll('.guest-row');
            let guests = [];

            rows.forEach(row => {
                guests.push({
                    id: row.getAttribute('data-id'),
                    category: row.getAttribute('data-category'),
                    nama: row.getAttribute('data-name'),
                    telepon: row.getAttribute('data-phone'),
                    link: row.getAttribute('data-link')
                });
            });

            if (guests.length === 0) {
                alert('Tidak ada tamu untuk dikirim.');
                return;
            }

            if (!confirm("Sistem akan membuka " + guests.length + " tab WhatsApp secara beruntun. Lanjutkan?")) {
                return;
            }

            guests.forEach((guest, index) => {
                setTimeout(() => {
                    let formattedPhone = formatPhone(guest.telepon);
                    let message = createWaMessage(guest.nama, guest.link, guest.category);
                    let url = "https://api.whatsapp.com/send?phone=" + formattedPhone + "&text=" + encodeURIComponent(message);
                    
                    window.open(url, '_blank');
                    
                    // Otomatis aktifkan toggle status jika belum dikirim
                    const toggleInput = document.getElementById(`toggle-${guest.id}`);
                    if (toggleInput && !toggleInput.checked) {
                        handleToggleStatus(guest.id);
                    }
                }, index * 1500);
            });
        }
    </script>
</body>
</html><?php /**PATH D:\Software Developer\Laravel\ud-alfi-ibad-revisi\resources\views/admin/guests.blade.php ENDPATH**/ ?>