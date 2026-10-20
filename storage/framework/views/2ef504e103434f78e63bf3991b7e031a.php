<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Alfi & Ibad</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Montserrat', sans-serif; }
    </style>

    <!-- Library JSZip & FileSaver untuk unduh file ZIP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen">

    <!-- Header Navigation -->
    <header class="bg-sky-900 text-white py-4 px-6 shadow-md border-b border-sky-800">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-sky-600 rounded-full flex items-center justify-center font-bold text-lg">A&amp;I</div>
                <div>
                    <h1 class="font-bold text-lg leading-tight">Dashboard Admin Undangan</h1>
                    <p class="text-xs text-sky-200">Pernikahan Alfi &amp; Ibad</p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="<?php echo e(route('admin.guests.index')); ?>" class="text-xs bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2 rounded-xl transition flex items-center gap-1.5 font-bold">
                    <i class="fas fa-address-book"></i> Kelola Tamu
                </a>
                <a href="<?php echo e(route('undangan.pria')); ?>" target="_blank" class="text-xs bg-sky-700 hover:bg-sky-600 text-white px-3 py-2 rounded-xl transition flex items-center gap-1.5">
                    <i class="fas fa-external-link-alt"></i> /ibad
                </a>
                <a href="<?php echo e(route('undangan.wanita')); ?>" target="_blank" class="text-xs bg-sky-700 hover:bg-sky-600 text-white px-3 py-2 rounded-xl transition flex items-center gap-1.5">
                    <i class="fas fa-external-link-alt"></i> /alfi
                </a>
                <form action="<?php echo e(route('admin.logout')); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="text-xs bg-rose-600 hover:bg-rose-700 text-white px-3 py-2 rounded-xl transition flex items-center gap-1.5">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto p-4 md:p-6 space-y-6">

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

        <!-- 1. KARTU STATISTIK RSVP -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-xs font-semibold text-slate-500">Total Respons</span>
                    <i class="fas fa-users text-sky-600 text-lg"></i>
                </div>
                <p class="text-2xl font-bold text-slate-800"><?php echo e($totalRsvp ?? 0); ?></p>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-emerald-200 bg-emerald-50/30">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-xs font-semibold text-emerald-700">Akan Hadir</span>
                    <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
                </div>
                <p class="text-2xl font-bold text-emerald-800"><?php echo e($totalHadir ?? 0); ?></p>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-rose-200 bg-rose-50/30">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-xs font-semibold text-rose-700">Tidak Hadir</span>
                    <i class="fas fa-times-circle text-rose-600 text-lg"></i>
                </div>
                <p class="text-2xl font-bold text-rose-800"><?php echo e($totalAbsen ?? 0); ?></p>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-amber-200 bg-amber-50/30">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-xs font-semibold text-amber-700">Ragu-ragu</span>
                    <i class="fas fa-question-circle text-amber-600 text-lg"></i>
                </div>
                <p class="text-2xl font-bold text-amber-800"><?php echo e($totalRagu ?? 0); ?></p>
            </div>
        </div>

        <!-- 2. TABEL DAFTAR RSVP & UCAPAN -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden space-y-4 p-5">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3 border-b border-slate-100 pb-4">
                <div>
                    <h2 class="font-bold text-slate-800 text-base">Daftar Ucapan &amp; Konfirmasi Tamu</h2>
                    <p class="text-xs text-slate-500">Data realtime dari form RSVP undangan</p>
                </div>
                <a href="<?php echo e(route('admin.rsvp.export', ['category' => request('category')])); ?>" class="py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow transition flex items-center gap-2">
                    <i class="fas fa-file-excel"></i> Export CSV / Excel
                </a>
            </div>

            <!-- Tab Filter Pengantin -->
            <div class="flex border-b border-slate-200 gap-2 text-xs font-semibold overflow-x-auto">
                <a href="<?php echo e(route('admin.dashboard', array_merge(request()->query(), ['category' => '']))); ?>" 
                   class="py-2.5 px-4 border-b-2 transition flex items-center gap-2 whitespace-nowrap <?php echo e(request('category') === null || request('category') === '' ? 'border-sky-600 text-sky-600 bg-sky-50/50 rounded-t-xl' : 'border-transparent text-slate-500 hover:text-slate-800'); ?>">
                    <i class="fas fa-users"></i> Semua Pengantin
                </a>
                <a href="<?php echo e(route('admin.dashboard', array_merge(request()->query(), ['category' => 'pria']))); ?>" 
                   class="py-2.5 px-4 border-b-2 transition flex items-center gap-2 whitespace-nowrap <?php echo e(request('category') === 'pria' ? 'border-amber-700 text-amber-800 bg-amber-50/50 rounded-t-xl' : 'border-transparent text-slate-500 hover:text-slate-800'); ?>">
                    <i class="fas fa-user-tie text-amber-700"></i> Ibad (Pria)
                </a>
                <a href="<?php echo e(route('admin.dashboard', array_merge(request()->query(), ['category' => 'wanita']))); ?>" 
                   class="py-2.5 px-4 border-b-2 transition flex items-center gap-2 whitespace-nowrap <?php echo e(request('category') === 'wanita' ? 'border-sky-500 text-sky-600 bg-sky-50/50 rounded-t-xl' : 'border-transparent text-slate-500 hover:text-slate-800'); ?>">
                    <i class="fas fa-user-dress text-sky-500"></i> Alfi (Wanita)
                </a>
            </div>

            <!-- Filter & Search Form -->
            <form method="GET" action="<?php echo e(route('admin.dashboard')); ?>" class="flex flex-col md:flex-row gap-2">
                <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
                <input type="text" name="search" value="<?php echo e($search ?? ''); ?>" placeholder="Cari nama atau isi ucapan..." class="flex-1 px-3 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                <select name="status" class="px-3 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <option value="">-- Semua Status --</option>
                    <option value="Hadir" <?php echo e(($statusFilter ?? '') === 'Hadir' ? 'selected' : ''); ?>>Hadir</option>
                    <option value="Tidak Hadir" <?php echo e(($statusFilter ?? '') === 'Tidak Hadir' ? 'selected' : ''); ?>>Tidak Hadir</option>
                    <option value="Ragu-ragu" <?php echo e(($statusFilter ?? '') === 'Ragu-ragu' ? 'selected' : ''); ?>>Ragu-ragu</option>
                </select>
                <button type="submit" class="py-2 px-4 bg-sky-600 text-white rounded-xl text-xs font-medium hover:bg-sky-700 transition">
                    <i class="fas fa-search mr-1"></i> Filter
                </button>
                <?php if(!empty($search) || !empty($statusFilter) || request('category')): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="py-2 px-4 bg-slate-200 text-slate-700 rounded-xl text-xs font-medium hover:bg-slate-300 transition text-center">Reset</a>
                <?php endif; ?>
            </form>

            <!-- Table Data RSVP -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-y border-slate-200 text-slate-600 uppercase font-semibold">
                            <th class="py-3 px-3">No</th>
                            <th class="py-3 px-3">Kategori</th>
                            <th class="py-3 px-3">Nama Tamu</th>
                            <th class="py-3 px-3">Status</th>
                            <th class="py-3 px-3">Ucapan &amp; Doa Restu</th>
                            <th class="py-3 px-3">Tanggal &amp; Waktu</th>
                            <th class="py-3 px-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php
                            $wishesData = isset($wishes) ?$wishes : [];
                        ?>
                        <?php if(count($wishesData) > 0): ?>
                            <?php $no = 1; ?>
                            <?php foreach($wishesData as$item): ?>
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-3 text-slate-500"><?php echo $no++; ?></td>
                                <td class="py-3 px-3">
                                    <?php if(($item->category ?? 'pria') === 'pria'): ?>
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">Ibad (Pria)</span>
                                    <?php else: ?>
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-sky-100 text-sky-800 border border-sky-200">Alfi (Wanita)</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-3 font-semibold text-slate-800"><?php echo e($item->nama); ?></td>
                                <td class="py-3 px-3">
                                    <?php if($item->status === 'Hadir'): ?>
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">Hadir</span>
                                    <?php elseif($item->status === 'Tidak Hadir'): ?>
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700">Tidak Hadir</span>
                                    <?php else: ?>
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700">Ragu-ragu</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-3 text-slate-600 max-w-xs leading-relaxed"><?php echo e($item->pesan); ?></td>
                                <td class="py-3 px-3 text-slate-400 text-[11px]"><?php echo e($item->created_at->format('d/m/Y H:i')); ?></td>
                                <td class="py-3 px-3 text-center">
                                    <form action="<?php echo e(route('admin.rsvp.destroy', $item->id)); ?>" method="POST" onsubmit="return confirmDelete(event, this)">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-rose-500 hover:text-rose-700 p-1.5 rounded-lg hover:bg-rose-50 transition" title="Hapus Data">
                                            <i class="far fa-trash-alt text-sm"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400 italic">Belum ada data ucapan atau konfirmasi RSVP untuk kategori ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. GRID ALBUM POLAROID -->
        <div class="mt-10 bg-white rounded-2xl shadow-sm border border-slate-100 p-6 font-sans space-y-4">
            
            <!-- Form Hapus Hidden Helper (Agar tidak bentrok dengan Form ZIP) -->
            <form id="globalDeleteForm" method="POST" class="hidden">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
            </form>

            <form action="<?php echo e(route('admin.polaroid.downloadZip')); ?>" method="POST" id="formBulkZip">
                <?php echo csrf_field(); ?>
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-4 mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Album Foto Polaroid Tamu</h3>
                        <p class="text-xs text-slate-500">Pilih foto untuk mengunduh bersamaan (.zip), edit, atau hapus</p>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <input type="text" id="searchPolaroidAdmin" placeholder="Cari nama pengirim..." onkeyup="filterAdminPolaroid()"
                            class="w-full sm:w-auto px-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-400">
                        <span class="px-3 py-1 bg-rose-50 text-rose-600 font-bold text-xs rounded-full whitespace-nowrap">
                            Total: <?php echo count($polaroids ?? []); ?> Foto
                        </span>
                    </div>
                </div>

                <!-- Toolbar Pilih Foto Massal -->
                <div class="flex flex-wrap items-center justify-between gap-3 bg-slate-50 p-3 rounded-xl border border-slate-200 text-xs mb-4">
                    <div class="flex items-center gap-3">
                        <label class="flex items-center gap-2 font-semibold text-slate-700 cursor-pointer select-none">
                            <input type="checkbox" id="selectAllPolaroid" onchange="toggleSelectAllPolaroid(this)" class="w-4 h-4 rounded text-sky-600 focus:ring-sky-500 border-slate-300">
                            Pilih Semua
                        </label>
                        <span id="selectedCountBadge" class="hidden px-2.5 py-0.5 bg-sky-100 text-sky-800 font-bold rounded-full text-[11px]">
                            0 Dipilih
                        </span>
                    </div>

                    <div>
                        <button type="submit" id="btnBulkDownload" disabled
                                class="px-3 py-1.5 bg-slate-200 text-slate-400 text-xs font-bold rounded-lg transition flex items-center gap-1.5 cursor-not-allowed">
                            <i class="fas fa-file-archive"></i> Unduh Terpilih (.ZIP)
                        </button>
                    </div>
                </div>

                <!-- Grid Foto -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4" id="polaroid-admin-grid">
                    <?php $polaroidsData = isset($polaroids) ? $polaroids : []; ?>
                    <?php if(count($polaroidsData) > 0): ?>
                        <?php foreach($polaroidsData as $foto): ?>
                            <?php $fullImgUrl = asset('storage/' . $foto->foto_path); ?>
                            <div class="polaroid-item relative group bg-white rounded-2xl p-3 border border-slate-200 flex flex-col justify-between shadow-sm hover:shadow-md transition"
                                data-name="<?php echo e(strtolower($foto->nama_pengirim)); ?>">
                                
                                <div>
                                    <!-- Checkbox berisi ID Foto -->
                                    <div class="absolute top-4 left-4 z-10">
                                        <input type="checkbox" name="selected_ids[]" value="<?php echo e($foto->id); ?>"
                                            onchange="updateSelectedPolaroidCount()"
                                            class="polaroid-checkbox w-4 h-4 rounded text-sky-600 focus:ring-sky-500 border-slate-300 shadow bg-white/90 backdrop-blur-sm cursor-pointer">
                                    </div>

                                    <div class="relative w-full aspect-square overflow-hidden rounded-xl bg-slate-100 mb-2 border border-slate-100">
                                        <img src="<?php echo e($fullImgUrl); ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        <div class="absolute top-1 right-1 bg-black/60 backdrop-blur-sm text-white text-[9px] px-2 py-0.5 rounded-full">
                                            <?php echo e($foto->created_at->format('d/m H:i')); ?>
                                        </div>
                                    </div>
                                    <p class="text-xs font-bold text-slate-800 truncate" title="<?php echo e($foto->nama_pengirim); ?>"><?php echo e($foto->nama_pengirim); ?></p>
                                    <p class="text-[10px] text-slate-500 truncate italic mb-3" title="<?php echo e($foto->caption); ?>">"<?php echo e($foto->caption ?? '-'); ?>"</p>
                                </div>

                                <!-- Tombol Aksi Rapi Berjajar -->
                                <div class="space-y-1.5 pt-2 border-t border-slate-100">
                                    <div class="grid grid-cols-2 gap-1.5">
                                        <button type="button" onclick="openEditPolaroidModal('<?php echo e($foto->id); ?>', '<?php echo e(addslashes($foto->nama_pengirim)); ?>', '<?php echo e(addslashes($foto->caption)); ?>')"
                                                class="py-1.5 bg-sky-50 hover:bg-sky-100 text-sky-700 text-[10px] font-bold rounded-lg transition flex items-center justify-center gap-1">
                                            <i class="fas fa-pen"></i> Edit
                                        </button>
                                        <a href="<?php echo e($fullImgUrl); ?>" download="Polaroid_<?php echo e($foto->nama_pengirim); ?>.jpg" target="_blank"
                                        class="py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-lg transition flex items-center justify-center gap-1">
                                            <i class="fas fa-download"></i> Unduh
                                        </a>
                                    </div>

                                    <!-- Tombol Hapus Rapi di Dalam Kartu -->
                                    <button type="button" onclick="deletePolaroid('<?php echo e($foto->id); ?>', '<?php echo e(addslashes($foto->nama_pengirim)); ?>')"
                                            class="w-full py-1 bg-rose-50 hover:bg-rose-100 text-rose-600 text-[10px] font-semibold rounded-lg transition flex items-center justify-center gap-1">
                                        <i class="fas fa-trash-alt text-[9px]"></i> Hapus Foto
                                    </button>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-span-full text-center py-10 text-slate-400 text-xs bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                            <i class="fas fa-camera-retro text-2xl mb-2 opacity-50"></i>
                            <p>Belum ada foto Polaroid yang diunggah oleh tamu.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>

    </main>

    <script>
        function confirmDelete(e, form) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data ucapan ini akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus Data',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        function filterAdminPolaroid() {
            let input = document.getElementById('searchPolaroidAdmin').value.toLowerCase();
            let items = document.getElementsByClassName('polaroid-item');

            for (let i = 0; i < items.length; i++) {
                let name = items[i].getAttribute('data-name');
                if (name.includes(input)) {
                    items[i].style.display = "";
                } else {
                    items[i].style.display = "none";
                }
            }
        }

        function openEditPolaroidModal(id, nama, caption) {
            document.getElementById('edit-nama').value = nama;
            document.getElementById('edit-caption').value = caption;
            document.getElementById('formEditPolaroid').action = `/admin/polaroid/${id}`;
            
            const modal = document.getElementById('editPolaroidModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditPolaroidModal() {
            const modal = document.getElementById('editPolaroidModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }



        
















        function toggleSelectAllPolaroid(master) {
    let checkboxes = document.querySelectorAll('.polaroid-checkbox');
    checkboxes.forEach(cb => {
        let card = cb.closest('.polaroid-item');
        if (card && card.style.display !== 'none') {
            cb.checked = master.checked;
        }
    });
    updateSelectedPolaroidCount();
}

function updateSelectedPolaroidCount() {
    let selected = document.querySelectorAll('.polaroid-checkbox:checked');
    let badge = document.getElementById('selectedCountBadge');
    let btnBulk = document.getElementById('btnBulkDownload');

    if (selected.length > 0) {
        badge.innerText = `${selected.length} Dipilih`;
        badge.classList.remove('hidden');
        
        btnBulk.disabled = false;
        btnBulk.className = "px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow transition flex items-center gap-1.5 cursor-pointer";
    } else {
        badge.classList.add('hidden');
        
        btnBulk.disabled = true;
        btnBulk.className = "px-3 py-1.5 bg-slate-200 text-slate-400 text-xs font-bold rounded-lg transition flex items-center gap-1.5 cursor-not-allowed";
    }
}

function deletePolaroid(id, nama) {
    if (confirm(`Yakin ingin menghapus foto kiriman ${nama} ini secara permanen?`)) {
        let form = document.getElementById('globalDeleteForm');
        form.action = `/admin/polaroid/${id}`;
        form.submit();
    }
}
    </script>
</body>
</html><?php /**PATH D:\Software Developer\Laravel\ud-alfi-ibad-revisi\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>