# ⚖️ Law Pro – System Reference & Developer Guide (`Gemini.md`)

> **النظام:** Law Pro — نظام إدارة مكاتب المحاماة
> **المطور:** عمار النجار — Full-Stack Software Engineer
> **الهدف من هذا الملف:** وثيقة مرجعية موحدة وشاملة تُوجِّه كل عملية تطوير أو صيانة أو تحسين للمشروع.
> **المصدر:** مُعتمَد على قراءة وتحليل الكود المصدري الفعلي بالكامل.
> **آخر كوميت موثَّق:** `0b1c3bb` — `refactor: update alert instance to toast and improve breadcrumb semantic accessibility`

---

## 📑 فهرس المحتويات

1. [Tech Stack & Tools](#1-️-tech-stack--tools)
2. [System Architecture](#2--system-architecture)
3. [Docker Services & Infrastructure](#3--docker-services--infrastructure)
4. [User Roles & Permissions (RBAC)](#4--user-roles--permissions-rbac)
5. [Business Rules, Constraints & Conditions](#5--business-rules-constraints--conditions)
6. [Database Schema & Relationships](#6--database-schema--relationships)
7. [Middleware Pipeline](#7--middleware-pipeline)
8. [Required Skills & Developer Guidelines](#8--required-skills--developer-guidelines)
9. [Key Commands Reference](#9--key-commands-reference)
10. [Future Roadmap](#10--future-roadmap)
11. [UI/UX Design System](#11--uiux-design-system)
12. [أخطاء شائعة وحلولها](#-أخطاء-شائعة-وحلولها)

---

## 1. 🛠️ Tech Stack & Tools

### 🔧 Backend

| التقنية | الإصدار / التفاصيل |
|---------|-------------------|
| **Language** | PHP 7.1 – 7.3 (مُقيَّد بـ `^7.1.3` في `composer.json`) |
| **Framework** | Laravel 5.7.* |
| **Architecture Pattern** | Layered MVC (5 طبقات) |
| **Database** | MySQL 5.7 |
| **Cache Driver** | Redis (مُعرَّف في `.env`: `CACHE_DRIVER=redis`) |
| **Session Driver** | Redis (مُعرَّف في `.env`: `SESSION_DRIVER=redis`) |
| **Queue Driver** | Redis (مُعرَّف في `.env`: `QUEUE_CONNECTION=redis`) |
| **ORM** | Eloquent ORM (Laravel) |

### 📦 PHP Packages (من `composer.json`)

| الحزمة | الإصدار | الاستخدام |
|--------|---------|-----------|
| `laravel/framework` | 5.7.* | إطار العمل الأساسي |
| `barryvdh/laravel-dompdf` | ^0.8.5 | تصدير الفواتير والتقارير بصيغة PDF |
| `hesto/multi-auth` | ^2.0 | إدارة حارس مصادقة مستقل (`admin` guard) |
| `wladmonax/laravel-db-backup` | ^1.1 | نسخ احتياطية تلقائية لقاعدة البيانات |
| `fideloper/proxy` | ^4.0 | دعم Trusted Proxies خلف Nginx |
| `laravel/tinker` | ^1.0 | REPL تفاعلي للتطوير |

### 🎨 Frontend

| التقنية | الاستخدام |
|---------|-----------|
| HTML5 / CSS3 | بنية الصفحات والتنسيق |
| Bootstrap (من vendor) | نظام التخطيط (Grid) والمكونات البصرية — يُحمَّل من `assets/admin/vendors/` |
| **Law Pro Design System** | `/public/css/lawpro-theme.css` — CSS Variables، بطاقات KPI، Badges، Breadcrumb |
| jQuery / AJAX | التفاعلية وتحديث البيانات دون إعادة تحميل |
| SweetAlert2 (Swal) | إشعارات Toast للنجاح/الخطأ في `app.blade.php` |
| Morris.js | مخططات بيانية (Charts) في لوحة التحكم |
| DataTables (Server-side) | جداول تفاعلية عبر ملفات `assets/js/<module>/` بخارج Mix |
| Multilingual Support | العربية (RTL) + الإنجليزية (LTR) عبر `$dir` و `$current_locale` |
| Google Fonts | Cairo (RTL) + Inter (LTR) — يُحدَّد تلقائياً في `app.blade.php` |

> [!NOTE]
> **حالة Build Pipeline:** لا يوجد حالياً `npm run dev` / `mix-manifest.json`. ملف `public/css/lawpro-theme.css` يُخدَم مباشرةً عبر `asset('css/lawpro-theme.css')` بدون Sass/Mix pipeline. `package.json` موجود ولكن pipeline لم يُفعَّل.

### 🖥️ DevOps & Infrastructure

| الأداة | الاستخدام |
|--------|-----------|
| Docker & Docker Compose | بيئة تطوير معزولة متعددة الحاويات |
| Nginx (Alpine) | خادم الويب (Reverse Proxy) |
| PHP-FPM | معالج PHP داخل Docker |
| phpMyAdmin | إدارة قاعدة البيانات رسومياً |
| Git / GitHub | إدارة الإصدارات ومستودع الكود |
| PHPUnit ^7.0 | اختبارات الوحدات والميزات |
| Laravel Debugbar | تحليل الأداء ومعالجة الأخطاء أثناء التطوير |

---

## 2. 🏗️ System Architecture

### نمط المعمارية: Layered MVC

```
┌─────────────────────────────────────────────────────────┐
│ LAYER 1: Infrastructure (Docker)                        │
│  Nginx:8090 ─ PHP-FPM ─ MySQL:3309 ─ Redis ─ Queue     │
├─────────────────────────────────────────────────────────┤
│ LAYER 2: HTTP Pipeline (12 Middleware)                  │
│  SecureHeaders ─ CSRF ─ XSS ─ Auth ─ SetLocale         │
├─────────────────────────────────────────────────────────┤
│ LAYER 3: Application (Controllers)                      │
│  26 Admin Controller + AdminAuth Controllers            │
├─────────────────────────────────────────────────────────┤
│ LAYER 4: Domain (Models + Traits + Helpers)             │
│  47 Eloquent Models ─ HasPermissionsTrait ─ LogActivity │
├─────────────────────────────────────────────────────────┤
│ LAYER 5: Data (MySQL via Eloquent ORM)                  │
│  30 Migrations ─ Seeds ─ backup.sql (76 KB)             │
└─────────────────────────────────────────────────────────┘
          ↕ Views (Blade) تقطع عبر Layers 2,3,4
```

### دورة حياة الطلب (Request Lifecycle)

```
Browser → Nginx:8090 → public/index.php → Middleware Pipeline
→ routes/web.php → Admin\Controller → Model (Eloquent)
→ MySQL DB → Controller → Blade View → HTML Response
```

### ملاحظة مهمة: فصل المصادقة (Dual Auth Guard)

- **جدول `admins`:** يستخدم guard اسمه `admin` (عبر حزمة `hesto/multi-auth`)
- **جدول `users`:** يستخدم guard اسمه `web` (الافتراضي في Laravel)
- كل المستخدمين الفعليين (المدير، المحامي، الموظف) محفوظون في جدول `admins`

---

## 3. 🐳 Docker Services & Infrastructure

### خدمات `docker-compose.yml` (6 حاويات)

| اسم الحاوية | الصورة | المنفذ | الوظيفة |
|------------|--------|--------|---------|
| `lawpro_app` | Custom PHP-FPM Dockerfile | داخلي | تشغيل كود Laravel عبر PHP-FPM |
| `lawpro_web` | `nginx:alpine` | `8090:80` | خادم ويب وموجه عكسي |
| `lawpro_queue` | Custom PHP-FPM Dockerfile | داخلي | معالج طوابير المهام الخلفية |
| `lawpro_db` | `mysql:5.7` | `3309:3306` | قاعدة البيانات الرئيسية |
| `lawpro_redis` | `redis:alpine` | **داخلي فقط** ⚠️ | Cache + Queue + Session |
| `lawpro_phpmyadmin` | `phpmyadmin/phpmyadmin` | `8091:80` | إدارة DB رسومياً |

> ⚠️ **تصحيح هام:** Redis مُعزَّل بلا منفذ خارجي عن قصد لمنع التضارب مع خدمات Redis أخرى على الجهاز.

### أمر Queue Worker (من `docker-compose.yml` فعلياً)

```bash
php artisan queue:work redis --sleep=3 --tries=3 --timeout=90
```

### متغيرات البيئة الجوهرية (`.env`)

```dotenv
APP_URL=http://localhost:8090
DB_HOST=lawpro_db          # اسم الحاوية وليس localhost
DB_PORT=3306               # المنفذ الداخلي (ليس 3309)
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
REDIS_HOST=lawpro_redis    # اسم الحاوية
REDIS_PORT=6379
```

### إعداد أولي للمشروع (Docker)

```bash
docker compose up -d --build
docker exec -it lawpro_app composer self-update --1
docker exec -it lawpro_app composer install
docker exec -it lawpro_app php artisan key:generate
docker exec -it lawpro_app php artisan storage:link
docker exec -it lawpro_app ln -sf /var/www/html/assets /var/www/html/public/assets
docker exec -it lawpro_app chown -R www-data:www-data storage bootstrap/cache public
docker exec -it lawpro_app chmod -R 775 storage bootstrap/cache
docker exec -i lawpro_db mysql -u root -proot lawpro_db < backup.sql
```

---

## 4. 👥 User Roles & Permissions (RBAC)

### أنواع المستخدمين (محفوظة في حقل `is_user_type` بجدول `admins`)

| الدور | قيمة `is_user_type` | المسؤوليات الرئيسية |
|-------|---------------------|-------------------|
| **Super Admin** | `ADVOCATE` (advocate_id=0) | تحكم مطلق: الإعدادات العامة، مراجعة جميع العمليات |
| **Admin (المدير)** | `ADVOCATE` | إدارة العمليات اليومية، إنشاء المستخدمين، الأدوار والصلاحيات |
| **Lawyer (المحامي)** | `ADVOCATE` | إدارة القضايا والجلسات، متابعة الموكلين، تعيين المهام |
| **Employee (الموظف)** | `STAFF` (يملك `advocate_id`) | مهام إدارية: جدولة المواعيد، تسجيل الموكلين |

> **ملاحظة مهمة (تصحيح):** كلٌّ من Admin وLawyer يحملان نفس قيمة `is_user_type = 'ADVOCATE'`، والفرق يُحدَّد عبر الأدوار (`roles`) والصلاحيات (`permissions`) فقط. الموظف (`STAFF`) يملك حقل `advocate_id` يشير للمحامي المالك.

### كيفية عمل نظام RBAC (من الكود الفعلي)

```
جداول: permissions, roles, permission_role, admin_role
    ↓ يُقرأ عند بدء التشغيل
PermissionsServiceProvider::boot()
    ↓ يُسجِّل كل صلاحية
Gate::define($permission->slug, fn($user) => $user->hasPermissionTo($permission))
    ↓ يُعرِّف Blade Directives
@role('admin') ... @endrole
    ↓ يُستدعى في Controllers/Views
HasPermissionsTrait::hasRole() / hasPermissionThroughRole()
```

### مصفوفة الصلاحيات (فئات الصلاحية لكل وحدة)

- **View** — عرض البيانات
- **Add** — إضافة سجل جديد
- **Edit** — تعديل سجل موجود
- **Delete** — حذف سجل

---

## 5. 📜 Business Rules, Constraints & Conditions

### 🔐 قواعد الأمان (Security)

| القاعدة | التطبيق في الكود |
|---------|-----------------|
| تشفير كلمات المرور | `bcrypt` (Laravel الافتراضي) |
| حماية CSRF | `VerifyCsrfToken` Middleware على كل Forms |
| حماية XSS | `XSS` Middleware يُنقِّي المدخلات |
| HTTP Security Headers | `SecureHeaders`: `X-Frame-Options: DENY`، `X-XSS-Protection: 1; mode=block`، `X-Content-Type-Options: nosniff`، `Strict-Transport-Security` |
| إخفاء معلومات السيرفر | `SecureHeaders` يحذف رأسَي `X-Powered-By` و`Server` |
| حماية المسارات | `RedirectIfNotAdmin` Middleware على كل مسارات `/admin/*` |
| Session عبر Redis | `SESSION_DRIVER=redis` لمنع هجمات Session Fixation |

### 🌐 قواعد التعريب والواجهة (i18n / L10n)

- **إلزامي:** كل ميزة جديدة **يجب** أن تدعم العربية والإنجليزية
- ملفات الترجمة في `resources/lang/ar/` و `resources/lang/en/`
- اتجاه الصفحة يُحدَّد تلقائياً عبر `SetLocale` Middleware:
  - عربي → `dir="rtl"` | إنجليزي → `dir="ltr"`
- يتم مشاركة `$dir` و `$current_locale` مع كل Views تلقائياً عبر `View::share()`
- تبديل اللغة: `GET /admin/language/{locale}` حيث `locale` = `ar` أو `en`

### ��️ قواعد القضايا (Case Management)

- القضية تملك حقل `is_nb` للتمييز بين القضايا العادية وقضايا **NB** (Not Before)
- حقل `priority` لتحديد أولوية القضية (عادي، مهم، عاجل)
- القضية تمر بحالات محددة مسبقاً (`case_statuses`) — **لا يُحذف سجل القضية نهائياً** (يُؤرشَف)
- نقل القضية لمحكمة أخرى يُسجَّل في جدول `case_transfers`
- نوع القضية يدعم هيكل أب-ابن (`parent_id` في `case_types`) للتصنيف الفرعي

### 💰 قواعد الإدارة المالية (Financial)

- الفاتورة ترتبط بـ: موكل، بنود (`invoice_items`)، مدفوعات (`payment_receiveds`)
- المصروف يرتبط بـ: مورد (`vendors`)، بنود (`expense_items`)، مدفوعات (`payment_mades`)
- الضرائب تُدار عبر جدول `all_taxes` وتُربط بالفواتير ديناميكياً
- الفواتير تُصدَّر كـ PDF عبر حزمة `barryvdh/laravel-dompdf`

### ⚙️ قواعد الإعدادات الديناميكية (مهم جداً!)

> **قاعدة جوهرية:** إعدادات SMTP والتوقيت الزمني **لا تُقرأ من `.env`** بل من **قاعدة البيانات**:

```php
// AppServiceProvider::register() — يُنفَّذ عند كل بدء تشغيل
$mail = DB::table('mailsetups')->first();
Config::set('mail', [...]); // يُطبَّق فورًا على بريد النظام

$timezone = DB::table('zone')->where('zone_id', $time)->first()->zone_name;
config::set(['app.timezone' => $timezone]);
```

هذا يعني أن تغيير إعدادات البريد والمنطقة الزمنية يتم **من واجهة النظام** دون لمس الكود أو السيرفر.

### 🚀 قواعد النشر (Deployment)

- **Docker أولاً:** كل التطوير والاختبار يتم في بيئة Docker لتجنب مشاكل الإصدارات
- صلاحيات مجلدي `storage/` و `bootstrap/cache/` يجب أن تكون `775` مملوكة لـ `www-data`
- المنفذ الخارجي للتطبيق: **8090** | phpMyAdmin: **8091** | MySQL: **3309**
- **لا تُعدِّل قاعدة البيانات مباشرة** — استخدم دائماً Migrations

---

## 6. 🗃️ Database Schema & Relationships

### الجداول الرئيسية (30 جدول)

```
admins (المستخدمون)
│   is_user_type: ADVOCATE | STAFF
│   advocate_id: 0 للمدير الرئيسي، أو ID المحامي للموظفين
│
├── admin_role (pivot) → roles
│       └── permission_role (pivot) → permissions
│
court_cases (القضايا) — الجدول الأكثر ارتباطاً
├── → advocate_clients (الموكل)
├── → case_types (نوع القضية + النوع الفرعي parent_id)
├── → case_statuses (حالة القضية)
├── → court_types (نوع المحكمة)
├── → courts (المحكمة)
├── → judges (القاضي)
├── ← case_logs (سجل جلسات القضية)
├── ← case_members (أعضاء الفريق)
├── ← case_transfers (سجل نقل القضية)
└── ← case_parties_involves (أطراف القضية)

invoices (الفواتير)
├── → advocate_clients
├── ← invoice_items
└── ← payment_receiveds

expenses (المصروفات)
├── → vendors (الموردون)
├── ← expenses_items
└── ← payment_mades

tasks (المهام)
└── ← task_members (pivot)

advocate_clients (الموكلون)
├── → countries
├── → states
└── → cities
```

### نظام التحقق من التكرار الموحد

يوفر `Controller.php` (Base Controller) دالة موحدة للتحقق من تكرار القيم عبر AJAX:
```php
Route::post('common_check_exist', 'Controller@common_check_exist');
// تتحقق ديناميكياً من أي جدول وأي حقل دون كتابة كود مكرر
```

---

## 7. 🔒 Middleware Pipeline

### الترتيب الفعلي في `app/Http/Kernel.php`

**Global Middleware (يُطبَّق على كل طلب):**

1. `CheckForMaintenanceMode` — وضع الصيانة
2. `ValidatePostSize` — التحقق من حجم البيانات المُرسَلة
3. `TrimStrings` — حذف المسافات الزائدة
4. `ConvertEmptyStringsToNull` — تحويل الفراغات إلى NULL
5. `TrustProxies` — دعم Nginx كـ Reverse Proxy
6. `SecureHeaders` — إضافة HTTP Security Headers

**Web Group Middleware:**

7. `EncryptCookies` — تشفير الكوكيز
8. `StartSession` — بدء الجلسة (عبر Redis)
9. `ShareErrorsFromSession` — مشاركة أخطاء Validation
10. `VerifyCsrfToken` — حماية CSRF
11. `SubstituteBindings` — ربط معاملات Routes
12. `SetLocale` ← **تحديد اللغة + اتجاه الصفحة (RTL/LTR)**

**Route Middleware (مُطبَّق على مسارات محددة):**

- `admin` → `RedirectIfNotAdmin` (يحمي كل مسارات `/admin/*`)
- `admin.guest` → `RedirectIfAdmin`
- `auth` → `Authenticate`
- `XSS` → تنقية من Cross-Site Scripting

---

## 8. 🧠 Required Skills & Developer Guidelines

### معايير الكود النظيف (Clean Code Standards)

**✅ المطلوب دائماً:**

- اتباع نمط MVC صارماً: منطق العمل في Controller، التخزين في Model، العرض في Blade
- استخدام Eloquent ORM — **لا تكتب Raw SQL في Controllers**
- تطبيق مبدأ **Fat Model, Skinny Controller**: ضع الـ scopes والعلاقات في الـ Model
- استخدام `DatatablTrait` لتوحيد بناء جداول DataTables (دوال: `image`, `action`, `status`, `checkbox`)
- استخدام `HasPermissionsTrait` للتحقق من الصلاحيات: `$user->hasRole('admin')`
- استخدام `LogActivity` لتسجيل أنشطة المستخدمين في جدول `activity_logs`

**❌ المحظور:**

- كتابة Business Logic داخل ملفات Blade
- تعديل قاعدة البيانات مباشرة دون Migration
- Hard-coding قيم CSS للاتجاه (استخدم متغير `$dir`)
- إضافة ميزة أحادية اللغة (إنجليزي فقط)

### الأداء والتحسين (Performance)

```php
// ✅ صحيح — Eager Loading لتجنب N+1 problem
$cases = CourtCase::with(['client', 'caseStatus', 'court'])->get();

// ❌ خطأ — يُولِّد N+1 queries
$cases = CourtCase::all();
foreach ($cases as $case) {
    echo $case->client->name; // استعلام لكل سجل!
}
```

- استخدم **Redis** للتخزين المؤقت للاستعلامات الثقيلة (لوحة التحكم، الإحصائيات)
- فوِّض المهام الثقيلة (PDF، بريد جماعي) إلى **Queue Worker** (`lawpro_queue`)
- استخدم `paginate()` بدل `->get()` في قوائم البيانات الكبيرة

### معايير التسمية (Naming Conventions)

| العنصر | المعيار | مثال |
|--------|---------|------|
| Controllers | PascalCase + `Controller` | `CaseRunningController` |
| Models | PascalCase | `CourtCase`, `AdvocateClient` |
| Migrations | snake_case بتاريخ | `2025_03_15_121502_create_court_cases_table` |
| Routes | kebab-case | `case-running`, `client-user` |
| Blade Views | snake_case | `index.blade.php`, `change_password.blade.php` |
| Database Tables | snake_case جمع | `court_cases`, `advocate_clients` |

---

## 9. ⌨️ Key Commands Reference

### Docker

```bash
# تشغيل جميع الحاويات
docker compose up -d

# إعادة البناء
docker compose up -d --build

# إيقاف الحاويات
docker compose down

# عرض Logs حاوية
docker logs lawpro_app -f
docker logs lawpro_queue -f

# الدخول لـ shell الحاوية
docker exec -it lawpro_app bash
```

### Laravel Artisan

```bash
# توليد مفتاح التطبيق
docker exec -it lawpro_app php artisan key:generate

# مسح جميع أنواع الـ Cache
docker exec -it lawpro_app php artisan cache:clear
docker exec -it lawpro_app php artisan view:clear
docker exec -it lawpro_app php artisan route:clear
docker exec -it lawpro_app php artisan config:clear

# ربط Storage
docker exec -it lawpro_app php artisan storage:link

# تشغيل Queue Worker يدوياً
docker exec -it lawpro_app php artisan queue:work redis --sleep=3 --tries=3 --timeout=90

# تشغيل Migrations
docker exec -it lawpro_app php artisan migrate

# إنشاء Migration جديد
docker exec -it lawpro_app php artisan make:migration create_table_name

# تشغيل الاختبارات
docker exec -it lawpro_app php artisan test
```

### قواعد البيانات

```bash
# استيراد النسخة الاحتياطية
docker exec -i lawpro_db mysql -u root -proot lawpro_db < backup.sql

# تصدير نسخة احتياطية
docker exec lawpro_db mysqldump -u root -proot lawpro_db > backup_$(date +%Y%m%d).sql

# الدخول لـ MySQL CLI
docker exec -it lawpro_db mysql -u root -proot lawpro_db
```

---

## 10. 🚀 Future Roadmap (التطوير المستقبلي)

| الأولوية | الميزة | الوصف |
|---------|--------|-------|
| 🔴 عالية | API Layer | بناء RESTful API لدعم تطبيق الجوال |
| 🔴 عالية | Mobile App (Android/iOS) | تطبيق للمحامين والموكلين |
| 🟡 متوسطة | تكامل البريد والتقويم | ربط Gmail / Outlook بالمواعيد |
| 🟡 متوسطة | لوحة تقارير متقدمة | إحصائيات مالية وقانونية تفاعلية |
| 🟡 متوسطة | رفع وثائق قانونية | نظام إدارة المستندات (DMS) |
| 🟢 مستقبلية | تكامل الذكاء الاصطناعي | تحليل قانوني بالذكاء الاصطناعي |
| 🟢 مستقبلية | نظام دردشة داخلي | تواصل فوري بين أفراد الفريق |

---

## 11. 🎨 UI/UX Design System

> **الحالة الحالية:** تم تطبيق Phase 0 (Laravel Mix بدون Tailwind) وتحديث تصميم صفحة تسجيل الدخول (Login).

> **المرجع الرئيسي:** `public/css/lawpro-theme.css` — يُحمَّل مباشرةً عبر `asset('css/lawpro-theme.css')` كآخر stylesheet في `<head>`.

### ما تم تطبيقه فعلياً

| المرحلة | الوصف | الحالة |
|---------|-------|--------|
| Phase 1 | Design Tokens (CSS Variables) + Sidebar Active State + Breadcrumb Navigation | ✅ مُطبَّق |
| Phase 2 | Page Title styling + RTL/LTR infrastructure | ✅ مُطبَّق |
| Phase 3 | Dashboard KPI Cards (`.lp-card`) + Counter Animation (`IntersectionObserver`) | ✅ مُطبَّق |
| Phase 4 | Status Badges (`badge()` في `DatatablTrait`) + Empty State Component | ✅ مُطبَّق |
| Phase 5 | Toast Notifications (Swal mixin) + Accessibility (`aria-label`, `aria-current`) | ✅ مُطبَّق |
| Phase 0 | Safe Build System Migration (Laravel Mix, No Tailwind) | ✅ مُطبَّق |
| Phase 1 (Auth) | Login Page Restyle (Law Pro UI/UX) | ✅ مُطبَّق |

### CSS Variables الرئيسية (`--lp-*`)

| المتغير | القيمة | الاستخدام |
|---------|--------|----------|
| `--lp-primary` | `#1A3C5E` | الألوان الرئيسية للعناوين والنصوص |
| `--lp-accent` | `#E8A838` | اللون المميز (Sidebar active, icons) |
| `--lp-secondary` | `#2E86AB` | الروابط والأزرار الثانوية |
| `--lp-success` / `--lp-warning` / `--lp-danger` / `--lp-info` | — | ألوان الحالات (Badges, Alerts) |
| `--font-arabic` | `'Cairo','Tajawal'` | خط RTL العربي |
| `--font-english` | `'Inter','Roboto'` | خط LTR الإنجليزي |
| `--card-clients/cases/urgent/archived` | ألوان خلفية البطاقات | متغيرات خاصة بـ Dashboard |

### الكلاسات الرئيسية

| الكلاس | الاستخدام |
|--------|-----------|
| `.lp-card`, `.lp-card--clients/cases/urgent/archived` | بطاقات KPI في Dashboard مع `border-top` ملون |
| `.lp-counter` | عداد رقمي — يُفعِّل Counter Animation بـ `IntersectionObserver` في `script.js` |
| `.badge-lp.badge-active/inactive/pending/info/urgent` | شارات حالة موحدة للجداول — `.badge-urgent` تنبض |
| `.lp-btn`, `.lp-btn-primary/secondary/danger` | أزرار موحدة مع hover effect |
| `.lp-empty-state`, `.lp-empty-state__icon/title/desc` | حالة الفراغ عند غياب البيانات |
| `.lp-skeleton` | مؤشر تحميل Skeleton shimmer |
| `.lp-breadcrumb-bar`, `.lp-breadcrumb` | شريط التنقل الهرمي (Breadcrumb) |
| `.page-title` | عنوان الصفحة مع خط فاصل سفلي |

### الملفات المُعدَّلة في Phases 1–5

| الملف | التعديل |
|-------|---------|
| `resources/sass/lawpro-theme.scss` | ملف CSS Design System الكامل (يُترجم بـ Mix) (94 سطراً) |
| `resources/views/admin/layout/app.blade.php` | Toast Notifications + Google Fonts conditional + رابط CSS |
| `resources/views/admin/layout/header.blade.php` | Breadcrumb navigation + `aria-label` |
| `resources/views/admin/layout/sidebar.blade.php` | Active state + `aria-current` + `role` attributes |
| `resources/views/admin/index.blade.php` | بطاقات Dashboard → `.lp-card` classes + `.lp-counter` |
| `app/Traits/DatatablTrait.php` | إضافة دالة `badge($text, $type)` |
| `app/Http/Controllers/Admin/CaseRunningController.php` | استخدام `$this->badge()` في `allCaseList` |
| `assets/js/script.js` | Counter Animation بـ `IntersectionObserver` |
| `resources/views/component/empty-state.blade.php` | مكوِّن Empty State جديد |

### قواعد عمل التصميم

- **أولوية CSS**: `lawpro-theme.css` يُحمَّل **أخيراً** في `<head>` ليتغلب على كل CSS سابق.
- **RTL/LTR**: كل كلاس يدعم الاتجاهين عبر `html[dir='rtl']` و `body.rtl`.
- **الخطوط**: يُختار الخط تلقائياً في `app.blade.php` بناءً على `$dir`.
- **Badge**: استخدم `$this->badge($text, $type)` من `DatatablTrait` — أنواع: `active`, `inactive`, `pending`, `info`, `urgent`.
- **Empty State**: `@include('component.empty-state', ['icon'=>'fa-inbox', 'title'=>'لا توجد بيانات', 'description'=>'...'])`
- **Toast**: يُشغَّل تلقائياً من `session('success')` و `session('error')` في `app.blade.php`.


---

## 🐛 أخطاء شائعة وحلولها

### أخطاء البيئة والإعداد

| المشكلة | السبب | الحل |
|---------|-------|------|
| `500 Server Error` عند التشغيل | ملف `.env` مفقود أو مفتاح التطبيق فارغ | `cp .env.example .env && php artisan key:generate` |
| لا تظهر الصور المرفوعة | `storage:link` لم يُنفَّذ | `php artisan storage:link` |
| خطأ في الاتصال بـ MySQL | `DB_HOST` يجب أن يكون `lawpro_db` وليس `localhost` | تحقق من `.env` |
| الـ Queue لا تعمل | `QUEUE_CONNECTION` خاطئ | تأكد من `QUEUE_CONNECTION=redis` |
| خطأ صلاحيات Storage | ملفات تعذَّر كتابتها | `chown -R www-data:www-data storage bootstrap/cache` |
| صفحة بيضاء بعد التعديل | ملفات View مُخزَّنة في Cache | `php artisan view:clear` |

### أخطاء CSS والتصميم

| المشكلة | السبب | الحل |
|---------|-------|------|
| تعذَّر تعديل `lawpro-theme.css` مباشرة | الملف مملوك لـ `www-data` داخل Docker | `docker exec lawpro_app chown 1000:1000 /var/www/html/public/css/lawpro-theme.css` ثم أعِد التملُّك بعد التعديل |
| تغييرات CSS لا تظهر | البراوزر يُخزِّن الملف في Cache | أضف `?v=2` لرابط CSS أو استخدم `Ctrl+Shift+R` |
| كلاسات `lp-card` لا تطبَّق | `tile-stats` القديم يُلغي التصميم | تأكد أن `tile-stats` و`lp-card` موجودان معاً في نفس العنصر |
| الـ Breadcrumb لا يظهر بشكل صحيح | تعارض padding مع `.nav.toggle` | `lawpro-theme.css` يُعيد تعريف `.lp-breadcrumb-bar` بـ `display:inline-flex` |

### أخطاء JavaScript

| المشكلة | السبب | الحل |
|---------|-------|------|
| Counter Animation لا يعمل | `IntersectionObserver` غير مدعوم في متصفح قديم | استخدم متصفحاً حديثاً (Chrome 58+) أو أضف polyfill |
| `toast` غير معرَّف | `Swal` لم يُحمَّل قبل `script.js` | تحقق من ترتيب السكريبتات في `app.blade.php` |
| `commonJsLang` غير معرَّف | block JS يُحمَّل قبل تعريف المتغير | المتغير يُعرَّف في `app.blade.php` L181، يجب أن يكون قبل `script.js` |

### أخطاء Docker

| المشكلة | السبب | الحل |
|---------|-------|------|
| ملف CSS لا يُحدَّث داخل الحاوية | الملف مُخزَّن في Docker layer | الملف مربوط بـ volume مباشرة، أي تعديل خارج الحاوية ينعكس فوراً |
| `script.js` لا يُخدَم (404) | `asset('assets/js/script.js')` يبحث في `public/assets/js/` | الملف في `/var/www/html/assets/js/` وهو متاح مباشرة من nginx (HTTP 200 ✅) |
| تغييرات PHP لا تنعكس | OPcache مُفعَّل | `docker exec lawpro_app php artisan optimize:clear` |

---

*هذا الملف يُمثِّل المرجع التقني الموحد لمشروع Law Pro. يجب تحديثه عند إجراء أي تغيير جوهري في البنية أو الأدوات أو قواعد العمل.*

*المطور: عمار النجار | تم التحديث ليعكس الانتقال الناجح لـ Laravel Mix وتصميم صفحة تسجيل الدخول*

---

# Law Pro System - Session Notes (Phase 0 & Phase 1)

## Overview
This session focused on safely modernizing the build process and redesigning the login page of the Law Pro System, strictly adhering to the project's custom design system without introducing external frameworks like Tailwind or Alpine.js.

## Phase 0: Foundation Prompts (Safe Build System Migration)
* **CSS Architecture Migration**: 
  * Moved the hand-maintained `public/css/lawpro-theme.css` into the Laravel Mix build pipeline at `resources/sass/lawpro-theme.scss`.
  * Updated `webpack.mix.js` to compile this file as a standalone asset and updated `app.blade.php` to reference it via the `mix()` helper.
* **Layout Cleanup**: Removed all dead and commented-out stylesheet references in `resources/views/admin/layout/app.blade.php`.
* **Vue Dependency Purge**: Confirmed Vue was completely unused. Removed `vue` and `vue-loader` from `package.json` and stripped the default Vue scaffolding from `resources/js/app.js`.
* **Webpack Build Fixes**: 
  * Upgraded `package.json` scripts to Laravel Mix v6 standards (e.g., using `mix` directly).
  * Resolved a Webpack schema error by explicitly downgrading `webpack` to `5.97.1` (bypassing a breaking change in Webpack 5.98+ where `SizeFormatHelpers` was removed).
  * Removed the stale `app.scss` task and deleted the orphaned `public/css/app.css` output to keep the project clean.
  * Verified a perfect, zero-error `npm run dev` execution.
* **Inventory**: Cataloged all `*.blade.php` files in the admin views and noted routing for the top 5 business-critical screens.

## Phase 1: Login Page Restyle (Law Pro UI/UX)
* **Audit**: Audited `login.blade.php` to map out essential form functionality (CSRF, element IDs/names, language switcher, password toggle).
* **Theme Extension**: Added a minimal, localized `.lp-auth-*` styling block into `lawpro-theme.scss` to handle the centralized login card, error feedback, and logical properties (`padding-inline-end`) for seamless LTR/RTL rendering.
* **Markup Overhaul**: 
  * Replaced the legacy `.login_wrapper` structure with the modern `.lp-card` component layout.
  * Preserved all critical `<form>` logic and the `togglePassword` jQuery functionality.
  * Safely removed a dead `$(".fill-login")` script.
* **Completion**: The final CSS was compiled successfully, resulting in a responsive, theme-compliant authentication page for both Arabic and English locales.

## Commits
All changes for Phase 0 and Phase 1 have been actively verified and pushed to the `main` branch.

## Phase 2: Auth Pages Completion & Password Reset Fixes (Law Pro UI/UX)
* **Email Request Page Restyle**: 
  * Redesigned `resources/views/admin/auth/passwords/email.blade.php` to completely match the `.lp-auth-*` design language established in `login.blade.php`.
  * Preserved the original `<form action="{{ url('/admin/password/email') }}">`, `csrf_field()`, and `.lp-error-feedback` logic.
  * Preserved the `session('status')` alert block but restyled it to fit neatly inside the new `.lp-card`.
* **Missing Password Reset View Creation**:
  * Identified that `resources/views/admin/auth/passwords/reset.blade.php` was missing from the repository.
  * Created the missing view using the exact `.lp-auth-*` visual hierarchy, including the dynamic language switcher and dual-font injection.
  * Ensured the form met the strict `ResetsPasswords` contract expectations: `route('password.email')` action, hidden `token` input, and `email`/`password`/`password_confirmation` inputs.
* **Email Configuration Fix (SMTP to Log)**:
  * Discovered that `AppServiceProvider::register()` was aggressively hardcoding the `'driver' => 'SMTP'` by pulling values from the `mailsetups` database table, bypassing the local `.env` completely.
  * Modified `AppServiceProvider.php` to fallback using `env('MAIL_DRIVER', 'smtp')` so local developers can test emails without real SMTP credentials.
  * Changed `MAIL_DRIVER=log` in `.env`.
  * Hard-restarted the Docker containers (`lawpro_app` and `lawpro_queue`) to flush OPcache and ensure the web process picked up the new `log` driver, fixing a blocking `Swift_TransportException` when sending the reset email.
* **Verification**: Successfully generated a password reset token locally and verified its output in `storage/logs/laravel-2026-09-03.log` (due to the `daily` stack logging channel).
