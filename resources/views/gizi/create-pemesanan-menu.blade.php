<div id="modal-create" class="fixed inset-0 z-50 flex items-start justify-center pt-20 px-4 hidden">
    <div class="absolute inset-0 bg-black/40" data-close-modal></div>
    <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl z-10 overflow-hidden">
        <div class="flex items-center justify-between p-4 border-b">
            <div>
                <h3 class="text-lg font-semibold text-emerald-700">Tambah Jadwal Makan Pasien</h3>
                <p class="text-sm text-gray-500">Isi data pasien dan pilih menu, kelas, serta tanggal.</p>
            </div>
            <button class="text-gray-500" data-close-modal>&times;</button>
        </div>

        <div class="p-6">
            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded p-3">Mohon perbaiki kesalahan pada form.</div>
            @endif

            <form action="{{ route('pemesanan-menu.store') }}" method="POST" class="grid grid-cols-1 gap-4">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Tanggal *</label>
                        <input name="tanggal" type="date" value="{{ old('tanggal') }}" class="w-full border rounded px-3 py-2 bg-gray-50">
                        @error('tanggal') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Waktu Makan *</label>
                        <select name="shift" class="w-full border rounded px-3 py-2 bg-gray-50">
                            <option value="">Pilih</option>
                            <option value="Pagi">Pagi</option>
                            <option value="Siang">Siang</option>
                            <option value="Malam">Malam</option>
                        </select>
                        @error('shift') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Ruang</label>
                        <input name="ruang" value="{{ old('ruang') }}" type="text" class="w-full border rounded px-3 py-2 bg-gray-50" placeholder="Contoh: Bedah A">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Kelas</label>
                        <select name="kelas" class="w-full border rounded px-3 py-2 bg-gray-50">
                            <option value="">Pilih</option>
                            <option value="VIP">VIP</option>
                            <option value="Kelas 1">Kelas 1</option>
                            <option value="Kelas 2">Kelas 2</option>
                            <option value="Kelas 3">Kelas 3</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Nama Pasien *</label>
                    <input name="nama_pasien" type="text" value="{{ old('nama_pasien') }}" class="w-full border rounded px-3 py-2 bg-gray-50">
                    @error('nama_pasien') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Menu</label>
                    <select name="menu_id" class="w-full border rounded px-3 py-2 bg-gray-50">
                        <option value="">Pilih Menu</option>
                        @foreach($menusList ?? [] as $m)
                            <option value="{{ $m->id }}">{{ $m->nama_menu }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Jumlah Porsi</label>
                        <input name="jumlah" type="number" min="1" value="{{ old('jumlah',1) }}" class="w-32 border rounded px-3 py-2 bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Alergi / Pantangan</label>
                        <input name="alergi" type="text" value="{{ old('alergi') }}" class="w-full border rounded px-3 py-2 bg-gray-50" placeholder="(jika ada)">
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Catatan</label>
                    <textarea name="catatan" class="w-full border rounded px-3 py-2 bg-gray-50 h-24">{{ old('catatan') }}</textarea>
                </div>

                <div class="flex justify-end gap-3 mt-2">
                    <button type="button" data-close-modal class="px-4 py-2 border rounded">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-emerald-600 text-white rounded">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>
