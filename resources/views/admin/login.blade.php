<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Alfi & Ibad</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Montserrat', sans-serif; }</style>
</head>
<body class="bg-slate-900 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl p-8 space-y-6 border border-sky-100">
        <div class="text-center space-y-2">
            <div class="w-14 h-14 mx-auto bg-sky-600 text-white rounded-2xl flex items-center justify-center text-xl font-bold shadow-lg">
                A&amp;I
            </div>
            <h1 class="font-bold text-xl text-slate-800">Login Dashboard Admin</h1>
            <p class="text-xs text-slate-500">Pernikahan Alfi &amp; Ibad</p>
        </div>

        @if($errors->any())
            <div class="p-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl text-center font-medium">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Kata Sandi (Password)</label>
                <input type="password" name="password" required placeholder="Masukkan kata sandi admin..." class="w-full px-4 py-2.5 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>

            <button type="submit" class="w-full py-3 bg-sky-600 hover:bg-sky-700 text-white rounded-xl text-xs font-bold shadow-md transition flex items-center justify-center gap-2">
                <i class="fas fa-sign-in-alt"></i> Masuk ke Dashboard
            </button>
        </form>

        <div class="text-center pt-2">
            <a href="{{ route('undangan.index') }}" class="text-xs text-slate-500 hover:text-sky-600 transition">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Halaman Undangan
            </a>
        </div>
    </div>

</body>
</html>