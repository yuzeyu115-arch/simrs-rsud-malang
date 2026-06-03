<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Appointment - SimpleOK RSUD</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'hospital-green': '#006d32',
                        'hospital-green-light': '#e8f5e9',
                        'hospital-green-soft': '#f0fdf4',
                    },
                    fontFamily: {
                        'outfit': ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .sidebar-item { transition: all 0.2s ease; }
        .sidebar-active {
            background-color: #e8f5e9;
            color: #006d32;
            font-weight: 700;
        }
        .form-input {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            width: 100%;
            font-weight: 500;
            color: #1e293b;
            transition: all 0.2s;
        }
        .form-input:focus {
            outline: none;
            border-color: #006d32;
            box-shadow: 0 0 0 4px rgba(0, 109, 50, 0.1);
        }
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 8px;
        }
        .input-icon-wrapper {
            position: relative;
        }
        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }
        .breadcrumb-item:not(:last-child)::after {
            content: ">";
            margin: 0 8px;
            color: #94a3b8;
        }
    </style>
</head>
<body class="flex h-screen text-slate-800 overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-72 bg-white border-r border-slate-100 flex flex-col flex-shrink-0 z-20 shadow-sm">
        <div class="p-8 pb-4 flex items-center space-x-3">
            <div class="w-12 h-12 bg-hospital-green rounded-2xl flex items-center justify-center text-white shadow-lg shadow-green-900/20">
                <i class="fa-solid fa-hand-holding-medical text-2xl"></i>
            </div>
            <div>
                <h1 class="text-lg font-extrabold text-hospital-green leading-tight">RS SAHABAT SEHAT</h1>
                <p class="text-[10px] font-semibold text-slate-400">Pelayanan Ramah, Kesehatan Optimal</p>
            </div>
        </div>

        <nav class="flex-1 px-6 mt-6 space-y-1 overflow-y-auto pb-10">
            <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] px-4 mt-4 mb-2">UTAMA</p>
            <a href="{{ url('/dashboard') }}" class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 transition-all text-sm font-bold">
                 <div class="w-8 flex justify-center text-lg"><i class="fa-solid fa-house"></i></div>
                 <span>Dashboard</span>
            </a>

            <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] px-4 mt-8 mb-2">GIZI</p>
            <a href="{{ url('/gizi') }}" class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 transition-all text-sm font-bold">
                 <div class="w-8 flex justify-center text-lg"><i class="fa-solid fa-cart-shopping"></i></div>
                 <span>Pemesanan Menu</span>
            </a>
              <a href="#" data-title="Laporan Pemesanan" data-body="Halaman laporan pemesanan belum diimplementasikan." class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 transition-all text-sm font-bold">
                  <div class="w-8 flex justify-center text-lg"><i class="fa-solid fa-file-invoice"></i></div>
                  <span>Laporan Pemesanan</span>
              </a>
              <a href="#" data-title="Jadwal Makan" data-body="Halaman jadwal makan belum tersedia." class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 transition-all text-sm font-bold">
                  <div class="w-8 flex justify-center text-lg"><i class="fa-solid fa-calendar-days"></i></div>
                  <span>Jadwal Makan</span>
              </a>

            <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] px-4 mt-8 mb-2">JANJI TEMU</p>
            <a href="{{ url('/janji-temu') }}" class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl sidebar-active shadow-sm transition-all text-sm">
                 <div class="w-8 flex justify-center text-lg"><i class="fa-solid fa-circle-plus"></i></div>
                 <span>Add Appointment</span>
            </a>
              <a href="#" data-title="Daftar Janji Temu" data-body="Daftar janji temu belum tersedia di UI saat ini." class="sidebar-item flex items-center space-x-3 p-3.5 rounded-2xl text-slate-500 hover:bg-slate-50 transition-all text-sm font-bold">
                  <div class="w-8 flex justify-center text-lg"><i class="fa-solid fa-list-ul"></i></div>
                  <span>List Appointment</span>
              </a>

            <div class="pt-12 px-4">
                <a href="{{ url('/logout') }}" class="flex items-center space-x-3 text-red-500 font-extrabold text-sm hover:underline">
                    <i class="fa-solid fa-right-from-bracket text-lg"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto bg-slate-50/50">
        <!-- Topbar -->
        <header class="px-10 py-6 flex justify-between items-center bg-white/50 backdrop-blur-md sticky top-0 z-10 border-b border-slate-100/50">
            <div class="relative w-96">
                <input type="text" placeholder="Pencarian Cepat..." class="w-full bg-slate-100 border-none rounded-full py-2.5 px-6 text-sm font-medium focus:ring-2 focus:ring-hospital-green/20 placeholder-slate-400">
                <i class="fa-solid fa-magnifying-glass absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            </div>
            
            <div class="flex items-center space-x-6">
                <!-- Notifications -->
                <div class="relative cursor-pointer group">
                    <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-500 group-hover:text-hospital-green transition-colors">
                        <i class="fa-solid fa-bell text-lg"></i>
                    </div>
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 border-2 border-white text-white text-[10px] font-black flex items-center justify-center rounded-full">3</span>
                </div>

                <!-- User Profile -->
                <div class="flex items-center space-x-3 pl-6 border-l border-slate-200">
                    <img src="https://ui-avatars.com/api/?name=Devia+Amanda&background=006d32&color=fff" class="w-11 h-11 rounded-full border-2 border-hospital-green/10 shadow-sm" alt="Profile">
                    <div class="hidden md:block">
                        <p class="text-sm font-bold text-slate-800 leading-tight flex items-center">
                            Dr. Devia Amanda
                            <i class="fa-solid fa-chevron-down ml-2 text-[10px] text-slate-400"></i>
                        </p>
                        <p class="text-[11px] text-slate-400 font-bold mt-0.5">Kepala Bedah Umum</p>
                    </div>
                </div>
            </div>
        </header>

        <div class="p-10 max-w-7xl mx-auto space-y-8">
            <!-- Header & Breadcrumbs -->
            <div>
                <h2 class="text-3xl font-extrabold text-hospital-green tracking-tight">Add Appointment</h2>
                <div class="flex items-center mt-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                    <span class="breadcrumb-item">Dashboard</span>
                    <span class="breadcrumb-item">Janji Temu</span>
                    <span class="text-hospital-green">Add Appointment</span>
                </div>
            </div>
            
            <!-- Add Appointment Card -->
            <div class="bg-white rounded-[32px] shadow-2xl shadow-slate-200/50 overflow-hidden border border-slate-100">
                <div class="px-10 py-8 border-b border-slate-50">
                    <h3 class="text-xl font-extrabold text-hospital-green">{{ isset($appointment) ? 'Edit Appointment' : 'Form Appointment' }}</h3>
                    <p class="text-sm font-semibold text-slate-400 mt-1">Lengkapi data untuk {{ isset($appointment) ? 'memperbarui' : 'membuat' }} janji temu pasien.</p>
                </div>
                <div class="p-10">
                    @if(session('success'))
                        <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-100 p-4 text-emerald-700 font-semibold">{{ session('success') }}</div>
                    @endif
                    @php
                        $appointmentAction = isset($appointment)
                            ? route('janji-temu.update', $appointment->id)
                            : route('janji-temu.store');
                    @endphp
                    <form action="{{ $appointmentAction }}" method="POST">
                        @csrf
                        @if(isset($appointment))
                            @method('PUT')
                        @endif
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                            <!-- Row 1 -->
                            <div>
                                <label class="form-label">Nama Pasien <span class="text-red-500">*</span></label>
                                <input name="nama_pasien" value="{{ old('nama_pasien', $appointment->nama_pasien ?? '') }}" type="text" class="form-input" placeholder="Masukkan nama pasien">
                                @error('nama_pasien') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">No. Rekam Medis</label>
                                <input name="nomor_rm" value="{{ old('nomor_rm', $appointment->nomor_rm ?? '') }}" type="text" class="form-input" placeholder="Masukkan no. rekam medis">
                                @error('nomor_rm') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>
                            
                            <!-- Row 2 -->
                            <div>
                                <label class="form-label">Tanggal Janji Temu <span class="text-red-500">*</span></label>
                                <div class="input-icon-wrapper">
                                    <input name="tanggal_janji" value="{{ old('tanggal_janji', $appointment->tanggal_janji ?? '') }}" type="date" class="form-input pr-12">
                                    <i class="fa-solid fa-calendar input-icon"></i>
                                </div>
                                @error('tanggal_janji') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">Jam Janji Temu <span class="text-red-500">*</span></label>
                                <div class="input-icon-wrapper">
                                    <input name="jam_janji" value="{{ old('jam_janji', $appointment->jam_janji ?? '') }}" type="time" class="form-input pr-12">
                                    <i class="fa-solid fa-clock input-icon"></i>
                                </div>
                                @error('jam_janji') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>

                            <!-- Row 3 -->
                            <div>
                                <label class="form-label">Ruang / Poliklinik <span class="text-red-500">*</span></label>
                                <div class="input-icon-wrapper">
                                    <select name="poliklinik" class="form-input appearance-none bg-transparent pr-12">
                                        <option value="">Pilih ruang / poliklinik</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->nama_ruang }}" {{ old('poliklinik', $appointment->poliklinik ?? '') == $room->nama_ruang ? 'selected' : '' }}>{{ $room->nama_ruang }}</option>
                                        @endforeach
                                        <option value="Penyakit Dalam" {{ old('poliklinik', $appointment->poliklinik ?? '') == 'Penyakit Dalam' ? 'selected' : '' }}>Penyakit Dalam</option>
                                        <option value="Anak" {{ old('poliklinik', $appointment->poliklinik ?? '') == 'Anak' ? 'selected' : '' }}>Anak</option>
                                    </select>
                                    <i class="fa-solid fa-chevron-down input-icon"></i>
                                </div>
                                @error('poliklinik') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">Dokter / Pelaksana <span class="text-red-500">*</span></label>
                                <div class="input-icon-wrapper">
                                    <select name="dokter_tujuan" class="form-input appearance-none bg-transparent pr-12">
                                        <option value="">Pilih dokter</option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->nama }}" {{ old('dokter_tujuan', $appointment->dokter_tujuan ?? '') == $doctor->nama ? 'selected' : '' }}>{{ $doctor->nama }}</option>
                                        @endforeach
                                    </select>
                                    <i class="fa-solid fa-chevron-down input-icon"></i>
                                </div>
                                @error('dokter_tujuan') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>

                            <!-- Row 4 -->
                            <div>
                                <label class="form-label">Jenis Janji Temu <span class="text-red-500">*</span></label>
                                <div class="input-icon-wrapper">
                                    <select name="jenis" class="form-input appearance-none bg-transparent pr-12">
                                        <option value="">Pilih jenis janji temu</option>
                                        <option value="Kontrol" {{ old('jenis', $appointment->jenis ?? '') == 'Kontrol' ? 'selected' : '' }}>Kontrol</option>
                                        <option value="Konsultasi Baru" {{ old('jenis', $appointment->jenis ?? '') == 'Konsultasi Baru' ? 'selected' : '' }}>Konsultasi Baru</option>
                                        <option value="Tindakan" {{ old('jenis', $appointment->jenis ?? '') == 'Tindakan' ? 'selected' : '' }}>Tindakan</option>
                                    </select>
                                    <i class="fa-solid fa-chevron-down input-icon"></i>
                                </div>
                                @error('jenis') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">Prioritas</label>
                                <div class="input-icon-wrapper">
                                    <select name="prioritas" class="form-input appearance-none bg-transparent pr-12">
                                        <option value="Normal" {{ old('prioritas', $appointment->prioritas ?? 'Normal') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                        <option value="Urgent" {{ old('prioritas', $appointment->prioritas ?? '') == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                                        <option value="Emergency" {{ old('prioritas', $appointment->prioritas ?? '') == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                                    </select>
                                    <i class="fa-solid fa-chevron-down input-icon"></i>
                                </div>
                                @error('prioritas') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mt-8">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea name="catatan" class="form-input h-32 resize-none" placeholder="Masukkan catatan jika ada...">{{ old('catatan', $appointment->catatan ?? '') }}</textarea>
                            @error('catatan') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                        </div>

                        @if(isset($appointment))
                            <div class="mt-6">
                                <label class="form-label">Status</label>
                                <div class="input-icon-wrapper">
                                    <select name="status" class="form-input appearance-none bg-transparent pr-12">
                                        <option value="Terjadwal" {{ old('status', $appointment->status ?? 'Terjadwal') == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                                        <option value="Selesai" {{ old('status', $appointment->status ?? '') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="Menunggu" {{ old('status', $appointment->status ?? '') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="Dibatalkan" {{ old('status', $appointment->status ?? '') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                    <i class="fa-solid fa-chevron-down input-icon"></i>
                                </div>
                                @error('status') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>
                        @endif
                        <div class="mt-10 flex justify-end space-x-4">
                            @if(isset($appointment))
                                <a href="{{ route('janji-temu') }}" class="px-10 py-3.5 rounded-2xl border border-slate-200 text-slate-500 font-bold hover:bg-slate-50 transition-all">Batal</a>
                            @endif
                            <button type="submit" class="px-10 py-3.5 rounded-2xl bg-hospital-green text-white font-bold hover:bg-green-800 shadow-lg shadow-green-900/20 transition-all">{{ isset($appointment) ? 'Perbarui' : 'Simpan' }}</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Keterangan Box -->
            <div class="bg-hospital-green-soft border border-hospital-green/10 rounded-2xl p-6 flex items-start space-x-4">
                <div class="w-8 h-8 bg-hospital-green rounded-full flex items-center justify-center text-white flex-shrink-0 mt-0.5">
                    <i class="fa-solid fa-circle-info text-sm"></i>
                </div>
                <div>
                    <h4 class="text-hospital-green font-extrabold text-sm uppercase tracking-wider">Keterangan</h4>
                    <p class="text-slate-600 text-sm font-semibold mt-1">Pastikan semua data sudah benar sebelum menyimpan appointment.</p>
                </div>
            </div>

            <!-- Alur Input Section -->
            <div class="bg-[#f2f7f2] rounded-[32px] p-10 border border-green-100 mt-12">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="text-hospital-green font-black text-base uppercase tracking-widest">ALUR INPUT (ADD APPOINTMENT)</h4>
                        <ol class="mt-6 space-y-3">
                            <li class="flex items-center space-x-3 text-slate-700 font-bold text-sm">
                                <span class="w-6 h-6 bg-white border border-green-200 rounded-full flex items-center justify-center text-hospital-green text-xs">1</span>
                                <span>Klik menu "Add Appointment"</span>
                            </li>
                            <li class="flex items-center space-x-3 text-slate-700 font-bold text-sm">
                                <span class="w-6 h-6 bg-white border border-green-200 rounded-full flex items-center justify-center text-hospital-green text-xs">2</span>
                                <span>Isi form appointment (nama pasien, tanggal, jam, ruang, dokter, dll)</span>
                            </li>
                            <li class="flex items-center space-x-3 text-slate-700 font-bold text-sm">
                                <span class="w-6 h-6 bg-white border border-green-200 rounded-full flex items-center justify-center text-hospital-green text-xs">3</span>
                                <span>Klik tombol "Simpan"</span>
                            </li>
                            <li class="flex items-center space-x-3 text-slate-700 font-bold text-sm">
                                <span class="w-6 h-6 bg-white border border-green-200 rounded-full flex items-center justify-center text-hospital-green text-xs">4</span>
                                <span>Data berhasil disimpan</span>
                            </li>
                            <li class="flex items-center space-x-3 text-slate-700 font-bold text-sm">
                                <span class="w-6 h-6 bg-white border border-green-200 rounded-full flex items-center justify-center text-hospital-green text-xs">5</span>
                                <span>Data akan muncul di menu "List Appointment"</span>
                            </li>
                        </ol>
                    </div>
                    <div class="hidden lg:block">
                        <i class="fa-solid fa-arrow-right text-hospital-green text-4xl opacity-20"></i>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>
