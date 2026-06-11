# SIMRS RSUD Kota Malang - Quick Reference Guide

## 🚀 Getting Started

### Installation
```bash
cd c:\laragon\SIMRO-SIMRS KOTA MALANG\simrs-rsud-malang
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```

### Access System
- **URL**: http://localhost:8000/login
- **Default Username**: (varies by seeder - check database)
- **Default Password**: (varies by seeder - check database)

---

## 👥 Login by Role

Each role has different dashboard redirects:

| Role | Redirect | Primary Modules |
|------|----------|-----------------|
| **admin** | `/admin/pengguna` | User Management |
| **dokter** | `/dashboard` | Dashboard, Profile |
| **dokter_bedah** | `/jadwal-operasi` | Surgery Schedules |
| **dokter_anestesi** | `/jadwal-operasi` | Surgery Schedules |
| **perawat** | `/bed-manager` | Bed Management |
| **farmasi** | `/farmasi` | Pharmacy |
| **gizi** | `/gizi` | Nutrition |

---

## 📋 Module Quick Access

### Main Modules (Sidebar Navigation)
- 🏠 **Dashboard** - `/dashboard`
- 📅 **Jadwal Operasi** - `/jadwal-operasi`
- 🛏️ **Bed Manager** - `/bed-manager-list`
- 💊 **Farmasi** - `/farmasi`
- 🍽️ **Gizi** - `/gizi`
- 📝 **Janji Temu** - `/janji-temu` or `/janji-temu/list`
- 👥 **Admin** - `/admin/pengguna`
- 📞 **Rapat Koordinasi** - `/bedah/rapat-koordinasi`
- 📊 **Statistik** - `/statistik/tindakan-kunjungan`
- 🚚 **Logistik** - `/logistik/ringkasan-cepat`

### User Options
- 👤 **Profile** - `/profile`
- 🔐 **Change Password** - `/profile/password`
- 🔔 **Notifications** - `/notifications`
- 🔍 **Quick Search** - Searchbar in navbar
- 🚪 **Logout** - `/logout`

---

## 🔍 Quick Search Usage

**Search Location**: Top navigation bar

**Searchable Items**:
- Surgery schedules (by patient/surgeon/anesthesiologist)
- Appointments (by patient/doctor/clinic)
- Beds (by location)
- Coordination meetings (by title/leader)

**Example Queries**:
- `Ahmad Sutrisno` → Find surgeries with that surgeon
- `Bedah A 01` → Find bed in Bedah A room
- `Rapat Koordinasi` → Find meetings with that keyword

---

## 📊 Common Tasks

### Create New Surgery Schedule
1. Navigate to **Jadwal Operasi**
2. Click **Tambah Jadwal Operasi**
3. Fill form:
   - Patient name & RM number
   - Select surgeon, anesthesiologist
   - Select operating room
   - Set date, start time
   - Enter procedure type
   - Set initial status
4. Click **Simpan**

### Add New Bed
1. Navigate to **Bed Manager**
2. Scroll to **Form Tambah Tempat Tidur**
3. Fill in:
   - Building (Gedung)
   - Floor (Lantai)
   - Room (Ruangan)
   - Bed Number (No Bed)
   - Room Type (Jenis Kamar)
4. Click **Simpan Bed Baru**
5. New bed appears in list with status "Tersedia"

### Create Appointment
1. Navigate to **Janji Temu**
2. Fill in form:
   - Patient name (required)
   - RM number (optional)
   - Date & time of appointment
   - Clinic/department
   - Target doctor
   - Type of visit
   - Priority (Normal/Urgent/Emergency)
   - Optional notes
3. Click **Buat Janji Temu**

### Order Menu for Patient
1. Navigate to **Gizi** → **Pemesanan Menu**
2. Click button to open create form
3. Fill in:
   - Patient name & room/class
   - Meal time (Pagi/Siang/Sore)
   - Select date
   - Add notes if needed
4. Click **Simpan**

### Add Medicine to Pharmacy
1. Navigate to **Farmasi**
2. Scroll to **Formulir Tambah Obat**
3. Fill in:
   - Medicine name
   - Type of medicine
   - Stock quantity
   - Composition (optional)
   - Expiry date
   - Price
   - Status (Tersedia/Menipis/Habis)
4. Click **Simpan Obat**

### Manage Users
1. Navigate to **Admin** → **Pengguna**
2. **To Add**: Click form at top, fill details, set role, click **Simpan User**
3. **To Edit**: Click ✏️ button on user row
4. **To Delete**: Click 🗑️ button (confirm deletion)
5. **To Reset Password**: Edit user and change password field

---

## 🎨 System Branding

- **Hospital Name**: RSUD Kota Malang
- **Logo**: Hospital icon (Font Awesome)
- **Primary Color**: Emerald Green (#10b981, #0b7d4c)
- **Secondary Color**: Gray shades
- **Font**: Outfit (headings), Inter (body)

---

## 🗄️ Database Reference

### Main Tables
- `users` - System users (7 roles)
- `surgery_schedules` - Surgeries
- `inpatient_beds` - Hospital beds
- `medicines` - Drug inventory
- `appointments` - Patient appointments
- `pemesanan_menu` - Meal orders
- `coordination_meetings` - Department meetings

### Lookup Tables
- `operating_rooms` - OR master data
- `dokter_bedah` - Surgeon list
- `dokter_anestesi` - Anesthesiologist list

---

## 🔧 Useful Console Commands

```bash
# Serve application
php artisan serve

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Fresh migration (DESTRUCTIVE)
php artisan migrate:fresh

# Run seeders
php artisan db:seed

# Clear cache
php artisan cache:clear

# Generate app key
php artisan key:generate

# Check database connection
curl http://localhost:8000/db-check
```

---

## 🐛 Troubleshooting

### Can't Login
- **Check**: Database has users table
- **Check**: User credentials match
- **Reset**: Run `php artisan db:seed`

### Missing Tables
- **Fix**: `php artisan migrate`
- **Check**: Database name in `.env`

### Blank Dashboard
- **Check**: User role is set
- **Check**: Database tables exist
- **Fix**: Run migrations

### Images Not Loading
- **Check**: `/public` folder exists
- **Fix**: Run `php artisan storage:link`

### Permission Denied
- **Fix**: `chmod -R 755 storage bootstrap/cache`

### Port Already in Use
- **Fix**: `php artisan serve --port=8001`

---

## 📱 Mobile Responsiveness

System is fully responsive:
- ✅ Desktop (1920px+)
- ✅ Tablet (768px - 1024px)
- ✅ Mobile (320px - 767px)

**Mobile Tips**:
- Sidebar collapses to hamburger menu
- Forms stack vertically
- Tables become scrollable cards
- All buttons remain accessible

---

## 🔐 Security Notes

- All forms have CSRF protection
- Passwords are bcrypt hashed
- SQL queries use parameterized statements
- Session timeout after inactivity
- User roles control page access

---

## 📞 API Endpoints

### Quick Search (JSON)
```
GET /quick-search?q=search_term

Response:
[
  {
    "title": "Item Title",
    "link": "/path/to/item",
    "meta": "Additional info",
    "type": "Module Name"
  }
]
```

### Database Check
```
GET /db-check

Response:
{
  "status": "Connected!",
  "database": "simpleok_db",
  "tables": [...]
}
```

---

## 📚 File Locations

```
config/          - Configuration files
database/        - Migrations and seeders
app/             - Application code
resources/views/ - Blade templates
routes/          - Web routes
public/          - Public assets
storage/         - Logs and cache
```

---

## 🆘 Support Resources

- **Logs**: `storage/logs/laravel.log`
- **Database**: `database/migrations/`
- **Routes**: `routes/web.php`
- **Views**: `resources/views/`

---

## ✅ System Health Check

Run this sequence to verify system:

1. ✅ Access login: `http://localhost:8000/login`
2. ✅ View DB check: `http://localhost:8000/db-check`
3. ✅ Login with test user
4. ✅ Navigate to each module
5. ✅ Create test record in each module
6. ✅ Edit test record
7. ✅ Delete test record
8. ✅ Logout and login with different role

If all pass → **System Ready for Production** ✅

---

## 📅 Maintenance Schedule

| Task | Frequency | Command |
|------|-----------|---------|
| Database Backup | Daily | Manual backup script |
| Log Cleanup | Weekly | `storage/logs` cleanup |
| Cache Clear | As needed | `php artisan cache:clear` |
| Security Updates | Monthly | `composer update` |

---

## Quick Stats

- **Total Routes**: 100+
- **Database Tables**: 50+
- **User Roles**: 7
- **Blade Templates**: 28
- **Models**: 24
- **CRUD Modules**: 13

---

**Last Updated**: 2026-01-01  
**Version**: 1.0  
**Status**: ✅ Production Ready
