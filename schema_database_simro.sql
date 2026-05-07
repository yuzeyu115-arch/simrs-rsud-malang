-- =========================================================
-- DATABASE SCHEMA SIMRO (SIMRS KOTA MALANG)
-- =========================================================

-- 1. TABEL PENGGUNA (AUTHENTIKASI & AUTHORISASI)
-- Mendukung login berbagai platform dan peran.
CREATE TABLE users (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    email VARCHAR(255) UNIQUE,
    no_hp VARCHAR(20) UNIQUE,
    google_id VARCHAR(255),
    facebook_id VARCHAR(255),
    wechat_id VARCHAR(255),
    password_hash VARCHAR(255),
    role VARCHAR(50) NOT NULL CHECK (role IN ('admin', 'dokter', 'perawat', 'anestesi', 'ka_bedah', 'ahli_gizi', 'farmasi', 'rekam_medis', 'pasien')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. TABEL BIODATA KARYAWAN/STAFF MEDIS
CREATE TABLE profil_karyawan (
    user_id UUID PRIMARY KEY REFERENCES users(id) ON DELETE CASCADE,
    nama_lengkap VARCHAR(255) NOT NULL,
    jenis_kelamin VARCHAR(20),
    tanggal_lahir DATE,
    spesialisasi VARCHAR(255), -- "Ahli Bedah Apa" atau bagian staf
    alamat TEXT,
    foto_profil VARCHAR(255)
);

-- 3. TABEL PASIEN
-- Rekam medis memasukkan data ke sini.
CREATE TABLE pasien (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    user_id UUID REFERENCES users(id), -- Pasien bisa juga punya akun di tabel users
    no_rekam_medis VARCHAR(50) UNIQUE NOT NULL,
    nama_lengkap VARCHAR(255) NOT NULL,
    tanggal_lahir DATE,
    jenis_kelamin VARCHAR(20),
    golongan_darah VARCHAR(5),
    alamat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. TABEL RUANG OPERASI & KETERSEDIAAN BED
CREATE TABLE ruang_operasi (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    nama_ruangan VARCHAR(100) NOT NULL,
    status VARCHAR(50) DEFAULT 'tersedia', -- tersedia, digunakan, pemeliharaan
    kapasitas_bed INT,
    catatan TEXT
);

CREATE TABLE bed (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    ruang_operasi_id UUID REFERENCES ruang_operasi(id) ON DELETE CASCADE,
    kode_bed VARCHAR(20) NOT NULL,
    status VARCHAR(50) DEFAULT 'tersedia' -- tersedia, diisi_pasien, sedang_dibersihkan
);

-- 5. TABEL JADWAL OPERASI
CREATE TABLE jadwal_operasi (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    pasien_id UUID REFERENCES pasien(id),
    ruang_operasi_id UUID REFERENCES ruang_operasi(id),
    bed_id UUID REFERENCES bed(id),
    jenis_operasi VARCHAR(255) NOT NULL, -- Operasi "Ahli bedah apa"
    waktu_mulai TIMESTAMP NOT NULL,
    waktu_selesai TIMESTAMP,
    status VARCHAR(50) DEFAULT 'dijadwalkan' -- dijadwalkan, berlangsung, selesai, dibatalkan
);

-- 6. TABEL TIM OPERASI
-- Menyimpan siapa saja Dokter, Perawat, Anestesi, Ka Bedah pada suatu jadwal operasi.
CREATE TABLE tim_operasi (
    jadwal_operasi_id UUID REFERENCES jadwal_operasi(id) ON DELETE CASCADE,
    user_id UUID REFERENCES users(id),
    peran VARCHAR(50), -- Dokter Utama, Perawat, Ahli Anestesi, Ka Bedah (Pengawas)
    PRIMARY KEY (jadwal_operasi_id, user_id)
);

-- 7. TABEL INVENTARIS (FARMASI & LOGISTIK)
CREATE TABLE inventaris (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    nama_barang VARCHAR(255) NOT NULL,
    kategori VARCHAR(50), -- obat, alat_bedah, obat_bius, cairan_infus
    stok_saat_ini INT DEFAULT 0,
    satuan VARCHAR(50)
);

-- 8. TABEL PENGGUNAAN OBAT & ALAT (SAAT OPERASI)
-- Mencatat jumlah bius, cairan infus per operasi (diisi Anestesi / Farmasi)
CREATE TABLE pemakaian_operasi (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    jadwal_operasi_id UUID REFERENCES jadwal_operasi(id),
    inventaris_id UUID REFERENCES inventaris(id),
    jumlah_dipakai INT NOT NULL,
    dicatat_oleh UUID REFERENCES users(id), -- User Anestesi/Farmasi
    waktu_pencatatan TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 9. TABEL AUDIT INVENTARISASI (LOGISTIK CEPAT)
CREATE TABLE audit_inventaris (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    inventaris_id UUID REFERENCES inventaris(id),
    jenis_aktivitas VARCHAR(50), -- masuk, keluar, penyesuaian (tambah/kurang)
    jumlah INT NOT NULL,
    keterangan TEXT,
    waktu_audit TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    diaudit_oleh UUID REFERENCES users(id) -- Staf Farmasi
);

-- 10. TABEL GIZI & MENU MAKANAN (AHLI GIZI)
CREATE TABLE gizi_pasien (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    pasien_id UUID REFERENCES pasien(id),
    jadwal_operasi_id UUID REFERENCES jadwal_operasi(id),
    tipe_diet VARCHAR(100), -- Diet Pasca Bedah, Makanan Cair, dll
    menu_makanan TEXT NOT NULL,
    ditentukan_oleh UUID REFERENCES users(id), -- Ahli Gizi
    waktu_pemberian TIMESTAMP
);

-- 11. TABEL APPOINTMENT (JANJI TEMU)
CREATE TABLE appointments (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    pasien_id UUID REFERENCES pasien(id),
    dokter_id UUID REFERENCES users(id),
    keluhan TEXT,
    waktu_janji TIMESTAMP NOT NULL,
    status VARCHAR(50) DEFAULT 'menunggu' -- menunggu, disetujui, selesai, dibatalkan
);

-- 12. TABEL RAPAT KOORDINASI KA BEDAH
CREATE TABLE rapat_koordinasi (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    judul_rapat VARCHAR(255) NOT NULL,
    waktu_pelaksanaan TIMESTAMP NOT NULL,
    lokasi VARCHAR(100),
    deskripsi TEXT,
    dibuat_oleh UUID REFERENCES users(id) -- Ka Bedah
);

CREATE TABLE peserta_rapat (
    rapat_id UUID REFERENCES rapat_koordinasi(id) ON DELETE CASCADE,
    user_id UUID REFERENCES users(id),
    status_kehadiran VARCHAR(50) DEFAULT 'diundang',
    PRIMARY KEY (rapat_id, user_id)
);

-- 13. TABEL NOTIFIKASI
CREATE TABLE notifikasi (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    user_id UUID REFERENCES users(id),
    judul VARCHAR(255),
    pesan TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    waktu_notifikasi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================================================
-- QUERY UNTUK STATISTIK & DASHBOARD (VIEWS)
-- =========================================================

-- View: Total Ruang Operasi
CREATE VIEW v_total_ruang_operasi AS
SELECT COUNT(id) AS total_ruangan FROM ruang_operasi;

-- View: Ketersediaan Bed
CREATE VIEW v_ketersediaan_bed AS
SELECT 
    (SELECT COUNT(*) FROM bed) AS total_bed,
    (SELECT COUNT(*) FROM bed WHERE status = 'tersedia') AS bed_tersedia,
    (SELECT COUNT(*) FROM bed WHERE status = 'diisi_pasien') AS bed_terisi;

-- View: Operasi Hari Ini
CREATE VIEW v_operasi_hari_ini AS
SELECT 
    j.id, p.nama_lengkap AS pasien, r.nama_ruangan, j.jenis_operasi, j.waktu_mulai, j.status
FROM jadwal_operasi j
JOIN pasien p ON j.pasien_id = p.id
JOIN ruang_operasi r ON j.ruang_operasi_id = r.id
WHERE DATE(j.waktu_mulai) = CURRENT_DATE;
