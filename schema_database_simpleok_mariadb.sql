-- =========================================================
-- DATABASE SCHEMA SimpleOK (SimpleOK KOTA MALANG)
-- Format: MariaDB 10.3+
-- =========================================================

-- SET CHARACTER SET
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;
SET sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- 1. TABEL PENGGUNA (AUTHENTIKASI & AUTHORISASI)
-- Mendukung login berbagai platform dan peran.
CREATE TABLE users (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    email VARCHAR(255) UNIQUE,
    no_hp VARCHAR(20) UNIQUE,
    google_id VARCHAR(255),
    facebook_id VARCHAR(255),
    wechat_id VARCHAR(255),
    password_hash VARCHAR(255),
    role VARCHAR(50) NOT NULL CHECK (role IN ('admin', 'dokter', 'perawat', 'anestesi', 'ka_bedah', 'ahli_gizi', 'farmasi', 'rekam_medis', 'pasien')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    KEY idx_email (email),
    KEY idx_google_id (google_id),
    KEY idx_role (role),
    CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
) ENGINE=InnoDB;

-- 2. TABEL BIODATA KARYAWAN/STAFF MEDIS
CREATE TABLE profil_karyawan (
    user_id CHAR(36) PRIMARY KEY,
    nama_lengkap VARCHAR(255) NOT NULL,
    jenis_kelamin VARCHAR(20),
    tanggal_lahir DATE,
    spesialisasi VARCHAR(255),
    alamat TEXT,
    foto_profil VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    KEY idx_nama (nama_lengkap),
    CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
) ENGINE=InnoDB;

-- 3. TABEL PASIEN
-- Rekam medis memasukkan data ke sini.
CREATE TABLE pasien (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    user_id CHAR(36),
    no_rekam_medis VARCHAR(50) UNIQUE NOT NULL,
    nama_lengkap VARCHAR(255) NOT NULL,
    tanggal_lahir DATE,
    jenis_kelamin VARCHAR(20),
    golongan_darah VARCHAR(5),
    alamat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    KEY idx_no_rekam_medis (no_rekam_medis),
    KEY idx_nama_lengkap (nama_lengkap),
    CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
) ENGINE=InnoDB;

-- 4. TABEL RUANG OPERASI & KETERSEDIAAN BED
CREATE TABLE ruang_operasi (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    nama_ruangan VARCHAR(100) NOT NULL,
    status VARCHAR(50) DEFAULT 'tersedia',
    kapasitas_bed INT,
    catatan TEXT,
    KEY idx_status (status),
    KEY idx_nama_ruangan (nama_ruangan),
    CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
) ENGINE=InnoDB;

CREATE TABLE bed (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    ruang_operasi_id CHAR(36) NOT NULL,
    kode_bed VARCHAR(20) NOT NULL,
    status VARCHAR(50) DEFAULT 'tersedia',
    FOREIGN KEY (ruang_operasi_id) REFERENCES ruang_operasi(id) ON DELETE CASCADE,
    KEY idx_status (status),
    KEY idx_kode_bed (kode_bed),
    CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
) ENGINE=InnoDB;

-- 5. TABEL JADWAL OPERASI
CREATE TABLE jadwal_operasi (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    pasien_id CHAR(36),
    ruang_operasi_id CHAR(36),
    bed_id CHAR(36),
    jenis_operasi VARCHAR(255) NOT NULL,
    waktu_mulai TIMESTAMP NOT NULL,
    waktu_selesai TIMESTAMP NULL,
    status VARCHAR(50) DEFAULT 'dijadwalkan',
    FOREIGN KEY (pasien_id) REFERENCES pasien(id) ON DELETE SET NULL,
    FOREIGN KEY (ruang_operasi_id) REFERENCES ruang_operasi(id) ON DELETE SET NULL,
    FOREIGN KEY (bed_id) REFERENCES bed(id) ON DELETE SET NULL,
    KEY idx_status (status),
    KEY idx_waktu_mulai (waktu_mulai),
    KEY idx_pasien_id (pasien_id),
    CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
) ENGINE=InnoDB;

-- 6. TABEL TIM OPERASI
-- Menyimpan siapa saja Dokter, Perawat, Anestesi, Ka Bedah pada suatu jadwal operasi.
CREATE TABLE tim_operasi (
    jadwal_operasi_id CHAR(36) NOT NULL,
    user_id CHAR(36) NOT NULL,
    peran VARCHAR(50),
    PRIMARY KEY (jadwal_operasi_id, user_id),
    FOREIGN KEY (jadwal_operasi_id) REFERENCES jadwal_operasi(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
) ENGINE=InnoDB;

-- 7. TABEL INVENTARIS (FARMASI & LOGISTIK)
CREATE TABLE inventaris (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    nama_barang VARCHAR(255) NOT NULL,
    kategori VARCHAR(50),
    stok_saat_ini INT DEFAULT 0,
    satuan VARCHAR(50),
    KEY idx_nama_barang (nama_barang),
    KEY idx_kategori (kategori),
    CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
) ENGINE=InnoDB;

-- 8. TABEL PENGGUNAAN OBAT & ALAT (SAAT OPERASI)
-- Mencatat jumlah bius, cairan infus per operasi (diisi Anestesi / Farmasi)
CREATE TABLE pemakaian_operasi (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    jadwal_operasi_id CHAR(36),
    inventaris_id CHAR(36),
    jumlah_dipakai INT NOT NULL,
    dicatat_oleh CHAR(36),
    waktu_pencatatan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (jadwal_operasi_id) REFERENCES jadwal_operasi(id) ON DELETE CASCADE,
    FOREIGN KEY (inventaris_id) REFERENCES inventaris(id) ON DELETE SET NULL,
    FOREIGN KEY (dicatat_oleh) REFERENCES users(id) ON DELETE SET NULL,
    KEY idx_jadwal_operasi_id (jadwal_operasi_id),
    CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
) ENGINE=InnoDB;

-- 9. TABEL AUDIT INVENTARISASI (LOGISTIK CEPAT)
CREATE TABLE audit_inventaris (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    inventaris_id CHAR(36),
    jenis_aktivitas VARCHAR(50),
    jumlah INT NOT NULL,
    keterangan TEXT,
    waktu_audit TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    diaudit_oleh CHAR(36),
    FOREIGN KEY (inventaris_id) REFERENCES inventaris(id) ON DELETE CASCADE,
    FOREIGN KEY (diaudit_oleh) REFERENCES users(id) ON DELETE SET NULL,
    KEY idx_waktu_audit (waktu_audit),
    CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
) ENGINE=InnoDB;

-- 10. TABEL GIZI & MENU MAKANAN (AHLI GIZI)
CREATE TABLE gizi_pasien (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    pasien_id CHAR(36),
    jadwal_operasi_id CHAR(36),
    tipe_diet VARCHAR(100),
    menu_makanan TEXT NOT NULL,
    ditentukan_oleh CHAR(36),
    waktu_pemberian TIMESTAMP NULL,
    FOREIGN KEY (pasien_id) REFERENCES pasien(id) ON DELETE CASCADE,
    FOREIGN KEY (jadwal_operasi_id) REFERENCES jadwal_operasi(id) ON DELETE SET NULL,
    FOREIGN KEY (ditentukan_oleh) REFERENCES users(id) ON DELETE SET NULL,
    CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
) ENGINE=InnoDB;

-- 11. TABEL APPOINTMENT (JANJI TEMU)
CREATE TABLE appointments (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    pasien_id CHAR(36),
    dokter_id CHAR(36),
    keluhan TEXT,
    waktu_janji TIMESTAMP NOT NULL,
    status VARCHAR(50) DEFAULT 'menunggu',
    FOREIGN KEY (pasien_id) REFERENCES pasien(id) ON DELETE CASCADE,
    FOREIGN KEY (dokter_id) REFERENCES users(id) ON DELETE SET NULL,
    KEY idx_status (status),
    KEY idx_waktu_janji (waktu_janji),
    CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
) ENGINE=InnoDB;

-- 12. TABEL RAPAT KOORDINASI KA BEDAH
CREATE TABLE rapat_koordinasi (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    judul_rapat VARCHAR(255) NOT NULL,
    waktu_pelaksanaan TIMESTAMP NOT NULL,
    lokasi VARCHAR(100),
    deskripsi TEXT,
    dibuat_oleh CHAR(36),
    FOREIGN KEY (dibuat_oleh) REFERENCES users(id) ON DELETE SET NULL,
    KEY idx_waktu_pelaksanaan (waktu_pelaksanaan),
    CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
) ENGINE=InnoDB;

CREATE TABLE peserta_rapat (
    rapat_id CHAR(36) NOT NULL,
    user_id CHAR(36) NOT NULL,
    status_kehadiran VARCHAR(50) DEFAULT 'diundang',
    PRIMARY KEY (rapat_id, user_id),
    FOREIGN KEY (rapat_id) REFERENCES rapat_koordinasi(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
) ENGINE=InnoDB;

-- 13. TABEL NOTIFIKASI
CREATE TABLE notifikasi (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    user_id CHAR(36) NOT NULL,
    judul VARCHAR(255),
    pesan TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    waktu_notifikasi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    KEY idx_user_id (user_id),
    KEY idx_is_read (is_read),
    CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
) ENGINE=InnoDB;

-- =========================================================
-- VIEWS UNTUK STATISTIK & DASHBOARD
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
    j.id, 
    p.nama_lengkap AS pasien, 
    r.nama_ruangan, 
    j.jenis_operasi, 
    j.waktu_mulai, 
    j.status
FROM jadwal_operasi j
JOIN pasien p ON j.pasien_id = p.id
JOIN ruang_operasi r ON j.ruang_operasi_id = r.id
WHERE DATE(j.waktu_mulai) = CURDATE();

-- =========================================================
-- INDEXES TAMBAHAN UNTUK PERFORMA
-- =========================================================

CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_jadwal_operasi_status ON jadwal_operasi(status);
CREATE INDEX idx_inventaris_kategori ON inventaris(kategori);
CREATE INDEX idx_gizi_pasien_id ON gizi_pasien(pasien_id);
CREATE INDEX idx_appointments_dokter ON appointments(dokter_id);
CREATE INDEX idx_notifikasi_read ON notifikasi(is_read);
