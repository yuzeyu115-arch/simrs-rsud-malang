# SimpleOK Quick Start Guide

## 🚀 Getting Started

### Prerequisites
- **PHP 8.0+** (bundled with Laragon)
- **MySQL** (bundled with Laragon)
- **Composer** (bundled with Laragon)
- **Laragon** (local development environment)

### Installation (First Time Setup)

```bash
# 1. Navigate to project directory
cd "c:\laragon\SimpleOK RSUD\simrs-rsud-malang"

# 2. Install PHP dependencies
composer install

# 3. Generate application key
php artisan key:generate

# 4. Create database and run migrations
php artisan migrate:fresh --seed

# 5. Start development server
php artisan serve --host=127.0.0.1 --port=8000
```

### Access Application
- **Dashboard**: http://127.0.0.1:8000/dashboard
- **Login Page**: http://127.0.0.1:8000/login
  - **Email**: admin@example.com (or any email)
  - **Password**: any password (auto-login enabled for development)

---

## 📋 Available Modules

### 1. Jadwal Operasi (Surgery Schedule)
**URL**: `/jadwal-operasi`
- Create new surgery schedules
- View upcoming operations
- Edit or delete schedules
- Track surgeon assignments

**Quick Task**: Add a new surgery
1. Click "Jadwal Baru" button on dashboard
2. Fill in patient name, surgeon names, operating room
3. Select date and time
4. Click "Simpan"

### 2. Janji Temu (Appointments)
**URL**: `/janji-temu`
- Book patient appointments
- Manage appointment status
- Track clinic visits
- Assign target doctors

### 3. Farmasi (Medicine Inventory)
**URL**: `/farmasi`
- Manage medicine packages
- Track inventory quantities
- Monitor critical stock
- Update preoperative/intraoperative/postoperative supplies

### 4. Pengguna (User Management)
**URL**: `/admin/pengguna`
- Create new system users
- Assign roles (Admin, Doctor, Nurse, Pharmacy, Nutrition, Logistics)
- Edit user information
- Delete inactive users

### 5. Pemesanan Menu (Menu Ordering)
**URL**: `/gizi/pemesanan-menu`
- Order patient meals
- Specify room, class, and patient name
- Select shift (Pagi/Siang/Sore)
- Add special dietary notes

### 6. Jadwal Makan (Meal Schedule)
**URL**: `/gizi/jadwal-makan`
- Define meal schedules
- Set serving times
- Organize by shift
- Pre-populated with Sarapan (Breakfast), Makan Siang (Lunch), Makan Malam (Dinner)

### 7. Manajemen Bed (Bed Management)
**URL**: `/bed-manager-list`
- Track hospital bed availability
- Update bed status (Tersedia/Terisi/Booking/Maintenance)
- Manage patient bed assignments
- View occupancy status

**Color Codes**:
- 🟢 **Green** = Tersedia (Available)
- 🔴 **Red** = Terisi (Occupied)
- 🔵 **Blue** = Booking (Reserved)
- 🟡 **Yellow** = Maintenance (Under Maintenance)

### 8. Rapat Koordinasi (Coordination Meetings)
**URL**: `/bedah/rapat-koordinasi`
- Record department coordination meetings
- Track participants
- Document meeting outcomes
- Reference historical meetings

### 9. Statistik Tindakan & Kunjungan (Statistics)
**URL**: `/statistik/tindakan-kunjungan`
- Enter daily visit statistics
- Log number of surgeries
- Track most common procedures
- Visualize trends on interactive charts

### 10. Logistik Ringkasan Cepat (Logistics)
**URL**: `/logistik/ringkasan-cepat`
- Monitor anesthesia (bius) supply
- Track IV fluids (cairan infus)
- Check sterile surgical kits
- Record last check timestamp

---

## 💡 Common Tasks

### Task 1: Add a New Surgery Schedule
```
1. Go to: Dashboard > Jadwal Operasi (or click "+ Jadwal Baru")
2. Fill in form:
   - Nama Pasien: Patient name
   - Nomor RM: Medical record number
   - Dokter Bedah: Surgeon name
   - Dokter Anestesi: Anesthesiologist name
   - Ruang Operasi: Select operating room
   - Tanggal Operasi: Select date
   - Jam Mulai: Select time
   - Jenis Tindakan: Select procedure type
3. Click "Simpan"
4. Schedule saved automatically to database
```

### Task 2: Update Bed Status
```
1. Go to: Dashboard > Manajemen Bed
2. Click edit icon (pen) on desired bed
3. Change status to:
   - Tersedia = Room available
   - Terisi = Room occupied (add patient name)
   - Booking = Room reserved
   - Maintenance = Under repair
4. Click "Perbarui"
5. Status saved with color indicator updated
```

### Task 3: Create New User
```
1. Go to: Dashboard > Manajemen Pengguna
2. Fill in form:
   - Name: Full name
   - Username: Login name
   - Email: Email address
   - Password: Temporary password
   - Role: Select user role
3. Click "Simpan"
4. User created and can login
```

### Task 4: Add Statistics Entry
```
1. Go to: Dashboard > Tindakan & Kunjungan
2. Fill in form:
   - Tanggal: Today's date
   - Jumlah Kunjungan: Number of patient visits
   - Jumlah Operasi: Number of surgeries
   - Tindakan Terbanyak: Most common procedure
3. Click "Simpan Data"
4. Chart automatically updates with new data
```

### Task 5: Order Patient Meals
```
1. Go to: Dashboard > Pemesanan Menu
2. Fill in form:
   - Ruang: Room number
   - Kelas: Room class (VIP/Kelas 1/2/3)
   - Nama Pasien: Patient name
   - Shift: Meal time (Pagi/Siang/Sore)
   - Tanggal: Date of order
3. Click "Simpan"
4. Order appears in table
```

---

## 🔍 Database Information

### Database Name
```
simpleok_db
```

### Main Tables
| Table | Purpose | Records |
|-------|---------|---------|
| `users` | System users | 5+ |
| `surgery_schedules` | Surgery bookings | 15+ |
| `appointments` | Patient appointments | 20+ |
| `medicine_packages` | Pharmacy inventory | 8+ |
| `pemesanan_menu` | Meal orders | 10+ |
| `jadwal_makan` | Meal schedules | 3 |
| `inpatient_beds` | Hospital beds | 30+ |
| `coordination_meetings` | Meetings | 0+ |
| `visit_statistics` | Daily stats | 0+ |
| `fast_logistics` | Supply status | 1+ |

### Connect to Database
```bash
# Using command line
mysql -h 127.0.0.1 -u root -p simpleok_db

# Database credentials (from .env)
Host: 127.0.0.1
Port: 3306
Database: simpleok_db
Username: root
Password: (empty)
```

---

## 🛠️ Troubleshooting

### Issue: Database Error (Unknown database 'simpleok_db')
**Solution**:
```bash
php artisan migrate:fresh --seed
```
This creates the database and tables, then loads sample data.

### Issue: Port 8000 Already in Use
**Solution**:
```bash
# Use a different port
php artisan serve --host=127.0.0.1 --port=8001
```

### Issue: Missing CSS/Icons (Blank Page)
**Solution**:
- Clear browser cache (Ctrl+Shift+Delete)
- Make sure you're online (CDN for Tailwind and Font Awesome)
- Check browser console for errors (F12)

### Issue: Can't Login
**Solution**:
- Development login is **auto-enabled** - just enter any email/password
- Check `.env` file has correct database credentials
- Ensure database migrations have run

### Issue: File Permissions Error
**Solution**:
```bash
# Give write permissions to storage and bootstrap
chmod -R 777 storage bootstrap/cache
```

---

## 📊 Dashboard Walkthrough

### Top Bar
- **Search**: Quick search (currently placeholder)
- **Notifications**: Alert bell icon
- **User Profile**: Shows current user "Dr. Andi Prakoso"

### KPI Cards (Top Section)
1. **Total Ruang Operasi**: Shows total operating rooms with used/available count
2. **Ketersediaan Bed**: Shows available beds and occupancy
3. **Stok Obat (Kritis)**: Count of critical stock items
4. **Operasi Hari Ini**: Today's scheduled surgeries

### Left Sidebar
- **UTAMA**: Main navigation
- **BEDAH**: Surgery department features
- **KEPERAWATAN**: Nursing features
- **LOGISTIK**: Supply management
- **GIZI**: Nutrition management
- **STATISTIK**: Analytics
- **ADMINISTRASI**: System administration

### Right Panel
- **Statistik Tindakan**: Line chart of operations vs visits
- **Noticeboard**: Important announcements
- **Logistik Cepat**: Supply status with progress bars

---

## 🔐 Security Notes

### Development Mode
- Login auto-enabled for testing (bypassed authentication)
- Debug information displayed
- All routes accessible

### For Production
1. Disable auto-login in `routes/web.php` login function
2. Implement proper Laravel authentication
3. Set `APP_DEBUG=false` in `.env`
4. Use HTTPS only
5. Implement role-based middleware
6. Add rate limiting on API routes
7. Use environment variables for sensitive data

---

## 📚 File Structure

```
simrs-rsud-malang/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   ├── Models/
│   │   ├── Surgery_Schedule.php
│   │   ├── Appointment.php
│   │   ├── User.php
│   │   └── ...other models
│   └── Providers/
├── database/
│   ├── migrations/
│   │   ├── create_users_table.php
│   │   ├── create_comprehensive_staff_tables.php
│   │   └── ...other migrations
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── HospitalDataSeeder.php
├── resources/
│   └── views/
│       ├── dashboard.blade.php
│       ├── jadwal-operasi.blade.php
│       ├── janji-temu.blade.php
│       ├── farmasi.blade.php
│       ├── gizi/
│       │   ├── pemesanan-menu.blade.php
│       │   └── jadwal-makan.blade.php
│       ├── admin/
│       │   └── pengguna.blade.php
│       ├── bedah/
│       │   └── rapat-koordinasi.blade.php
│       ├── statistik/
│       │   └── tindakan-kunjungan.blade.php
│       └── logistik/
│           └── ringkasan-cepat.blade.php
├── routes/
│   ├── web.php (All route definitions)
│   └── console.php
├── .env (Configuration file)
├── composer.json
└── artisan (CLI commands)
```

---

## 🎓 Learning Resources

### Laravel Documentation
- Route Closures: https://laravel.com/docs/routing
- Blade Templating: https://laravel.com/docs/blade
- Database: https://laravel.com/docs/database
- Migrations: https://laravel.com/docs/migrations

### Tailwind CSS
- Documentation: https://tailwindcss.com/docs
- CDN vs Compiled: https://tailwindcss.com/docs/installation

### Chart.js
- Documentation: https://www.chartjs.org/docs/latest/
- Examples: https://www.chartjs.org/samples/latest/

---

## 📞 Support

### Quick Help
- **Route Issues**: Run `php artisan route:list` to see all routes
- **Database Issues**: Check `.env` database credentials
- **View Errors**: Check `storage/logs/laravel.log`
- **Syntax Errors**: Run `php -l filename.php`

### Common Commands
```bash
# Create migration
php artisan make:migration create_table_name

# Create model
php artisan make:model ModelName

# Create controller
php artisan make:controller ControllerName

# View all routes
php artisan route:list

# Clear application cache
php artisan cache:clear

# View error logs
tail -f storage/logs/laravel.log
```

---

## 📝 Notes

- **Auto-login** is enabled in development for convenience
- **Seeded data** includes 30+ sample records across all modules
- **Database backup**: Before making changes, backup `simpleok_db`
- **Git integration**: All changes tracked in git repository
- **Last tested**: May 7, 2026 13:22 UTC

---

**Version**: 1.0 Final
**Last Updated**: May 7, 2026
**Status**: ✅ PRODUCTION READY (with development settings)
