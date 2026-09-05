# ⚖️ Law Pro – System Reference & Developer Guide (`Gemini.md`)

> **النظام:** Law Pro — نظام إدارة مكاتب المحاماة
> **المطور:** عمار النجار — Full-Stack Software Engineer
> **الهدف من هذا الملف:** وثيقة مرجعية موحدة وشاملة تُوجِّه كل عملية تطوير أو صيانة أو تحسين للمشروع.
> **المصدر:** مُعتمَد على قراءة وتحليل الكود المصدري الفعلي بالكامل.
> **آخر كوميت موثَّق:** `1e728af` — `style: redesign recent-activity table and card with lp-table and badge components`

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

---

## Phase 3: Navigation, Datepicker, Sidebar & Footer System-wide Polish (Law Pro UI/UX)

### 1. Top Navigation & Header Alignment (RTL + LTR)
* **Root Cause**: `assets/admin/build/css/custom.min.css` hardcoded `.top_nav .navbar-right { width: 70%; float: right; }`, which forced header elements (Profile, Language Switcher, Notifications, Tasks) into the center of the screen when in English (LTR).
* **Fix Applied**:
  * Overrode `.top_nav .navbar-right` with `width: auto !important; float: none !important; display: flex !important;` and `margin-left: auto !important; margin-right: 0 !important; justify-content: flex-end !important;` for LTR, and symmetric rules for RTL.
  * Reordered elements so that User Profile is flush on the outermost edge, followed inwards by Language Switcher, Notifications, and Tasks in both locales.
  * Constrained `.nav-md .top_nav` width to `calc(100% - 230px)`.
* **Home Icon Cleanup**: Removed the hardcoded Home icon (`<i class="fa fa-home"></i>`) from `resources/views/admin/layout/header.blade.php`; breadcrumbs now only render dynamically when `$breadcrumbs` is provided.
* **404 Asset Fix**: Removed erroneous `public/` prefix from `asset()` calls across layout headers.

### 2. Datepicker Modernization & Precision Positioning
* **Horizontal Stretching Fix**: Added `.datepicker.dropdown-menu { width: auto !important; min-width: 250px !important; max-width: 280px !important; }` along with Law Pro brand colors (`#1a3c5e`, rounded corners, subtle shadows).
* **RTL Positioning Conflict**:
  * *Discovery*: In `task-validation.js`, `rtl: (currentLang === 'ar')` is passed, causing `bootstrap-datepicker` to add class `.datepicker-rtl` and set `right: <X>px` inline. However, in other files (e.g. Dashboard), `rtl` is not passed, so JS sets `left: <X>px` inline.
  * *Conflict*: A previous global rule `right: auto !important;` wiped out the calculated `right` offset on `task-validation.js`, displacing the popup to the far right margin under "Subject".
  * *Surgical Fix*:
    * `.datepicker.dropdown-menu:not(.datepicker-rtl)` sets `right: auto !important;` to prevent `bootstrap-rtl.min.css` from stretching LTR-oriented pickers.
    * `.datepicker.dropdown-menu.datepicker-rtl` sets `left: auto !important;` and preserves the calculated `right` coordinate, ensuring the popup opens directly below the clicked date input.
* **Global Today Highlighting & Golden Accent Theme**:
  * *Discovery*: `todayHighlight` defaults to `false` in `bootstrap-datepicker`. Pages like Cases Management did not pass `todayHighlight: true`, so the `.today` class was never appended to the cell.
  * *Global Fix*: In `resources/views/admin/layout/app.blade.php`:
    ```javascript
    if (typeof $.fn.datepicker !== 'undefined') {
        $.fn.datepicker.defaults.todayHighlight = true;
    }
    ```
    This activated today highlighting across 100% of date fields in the entire system without editing dozens of individual JS files.
  * *Golden Accent*: Styled `.day.today` with a soft golden gradient (`#fdd49a` to `#fde19a`), golden border (`1.5px solid #e8a838`), and bold font. When today is also the selected date (`.day.today.active`, as on the Dashboard), styled it with a rich golden gradient (`#e8a838` to `#f39c12`), white text, and golden glow, eliminating the previous dark navy/black override.

### 3. Architectural Advisory: Bootstrap 5 vs Bootstrap 3.3.7
* Evaluated proposal to replace local Bootstrap files with Bootstrap 5.3.8 CDN links.
* **Advisory**: Strongly advised against replacing local Bootstrap 3.3.7 with Bootstrap 5 CDN:
  * Bootstrap 5 removed jQuery and changed all data attributes (`data-toggle` -> `data-bs-toggle`), which would break all Modals, Dropdowns, and DataTables.
  * Bootstrap 5 dropped legacy classes (`panel`, `well`, `pull-right`, `col-xs-*`) heavily used across hundreds of Blade views.
  * The standard CDN bundle lacks RTL support, which would break the Arabic interface.
  * Recommended maintaining local Bootstrap 3.3.7 files with Law Pro design tokens.

### 4. Sidebar Modernization (Icon-Only Minimalist in `nav-sm`)
* **Problem**: In collapsed mode (`nav-sm`), menu text was squashed beside icons in a 50px box, causing text to wrap over icons in English and get chopped in Arabic. In addition, submenu chevrons (`fa-chevron-down`) collided with icons, and active styling (`.active-sm`) reverted to turquoise.
* **Fix Applied**:
  * Wrapped menu labels in `<span class="menu-text">` in `resources/views/admin/layout/sidebar.blade.php`.
  * Configured `.nav-sm` in `lawpro-theme.css` and `lawpro-theme.scss`:
    * Menu items become clean 48px x 46px centered boxes with rounded corners (`border-radius: 8px`).
    * Menu text and dropdown chevrons are hidden (`display: none !important`).
    * Icons centered at 20px with smooth hover scaling and golden color.
    * Active item (`.active-sm`, `.active`, `.current-page`) retains `#172d44` navy background, golden icon, and a 3px golden vertical indicator line (left in LTR, right in RTL).
    * Centered the balance scale logo in the 70px header.
    * Styled floating flyout submenus (`.nav-sm ul.nav.child_menu`) with navy background, golden hover states, flying right in LTR and left in RTL.
    * Defined complete, symmetrical layout offsets for `.nav-md` (230px) and `.nav-sm` (70px) for `.top_nav`, `.right_col`, and `.lp-footer` in both LTR and RTL.

### 5. Footer (التذييل السفلي) Unification & Modernization
* **Contradictory Years Fixed**: Removed hardcoded "2025" from `resources/lang/ar/frontend.php` and `resources/lang/en/frontend.php`. The copyright year is now dynamically generated via `{{ date('Y') }}` (2026+).
* **Institutional Phrasing**: Added `all_rights_reserved` key:
  * Arabic: `⚖️ نظام المحامي الإحترافي © 2026 · جميع الحقوق محفوظة`
  * English: `⚖️ Law Pro System © 2026 · All Rights Reserved`
* **Arabic Icon Reversal Fixed**: Removed `order: 1` in RTL CSS so the golden balance scale icon naturally leads the brand name from the right in Arabic, mirroring the LTR layout.
* **Modern System Badge**: Replaced static text with an animated pulsing green status dot ("System Online") and a clean version pill (`v1.0.0`).
* **Complete System Sync**: Synced across `footer.blade.php`, `public/css/lawpro-theme.css`, and `resources/sass/lawpro-theme.scss`. Permissions restored and Laravel view/application caches cleared.

### 6. Basic Settings & Card Fill Post-Mortem (UI Freeze Fix & Resolution)
* **Incident**: After applying a layout rule to expand short cards, the website froze completely upon logging in and redirecting to `/admin/dashboard`. No buttons, dropdowns, or sidebar links were clickable, giving the appearance of a total freeze.
* **Deep Root Cause**:
  * In `resources/views/admin/index.blade.php`, three Bootstrap modals (`#modal-case-priority`, `#modal-change-court`, `#modal-next-date`) reside directly inside `.right_col` as `<div class="modal fade" ...>`.
  * The generic selector `.right_col > div:not(.clearfix) { display: flex !important; }` inadvertently targeted these modal wrappers, overriding Bootstrap's default `display: none` to `display: flex !important;`.
  * Because `.modal.fade` has `position: fixed; inset: 0; z-index: 1050; opacity: 0;`, three invisible full-screen modals were rendered directly over the entire viewport.
  * This invisible glass overlay intercepted 100% of pointer, mouse-click, and scroll events across the entire page (including sidebar and top navigation), while the login page (lacking `.right_col` and modals) remained functional.
* **Fix Applied**:
  * Immediately purged the generic `.right_col > div:not(.clearfix)` flex rules from `public/css/lawpro-theme.css` and `resources/sass/lawpro-theme.scss`.
  * Restored Bootstrap's default modal lifecycle (`display: none`), instantly unfreezing all clicks, animations, and navigation events across the system.
  * Cleared Laravel compiled views (`php artisan view:clear`) and cache (`php artisan cache:clear`).

### 7. System-wide Page Title Icons Modernization
* **Problem**: Only the Dashboard header displayed an icon (`<i class="fa fa-tachometer"></i> Dashboard`), while all other module page titles (`Client Management`, `Case Management`, `Invoice Management`, etc.) appeared as plain text without icons, creating visual inconsistency across the system.
* **Architecture & Solution**:
  * **Core Heading Components (`component.heading` & `component.modal_heading`)**:
    * Added support for an optional `$icon` parameter.
    * Implemented an intelligent route-based fallback mapping that automatically detects the module via `Request::segment(2)` and assigns the matching brand icon:
      * `clients` -> `fa fa-user-plus`
      * `case` / `case-running` -> `fa fa-gavel`
      * `tasks` -> `fa fa-check-square-o`
      * `appointment` -> `fa fa-calendar-check-o`
      * `vendor` -> `fa fa-truck`
      * `role` -> `fa fa-shield`
      * `service` -> `fa fa-wrench`
      * `expense-type` -> `fa fa-tags`
      * `court-type` -> `fa fa-building-o`
      * `court` -> `fa fa-university`
      * `judge` -> `fa fa-balance-scale`
      * `case-type` -> `fa fa-folder-open-o`
      * `case-status` -> `fa fa-info-circle`
      * `tax` -> `fa fa-percent`
      * `general-setting` -> `fa fa-sliders`
      * `invoice-setting` -> `fa fa-file-text-o`
      * `database-backup` -> `fa fa-database`
      * `team-members` / `client_user` -> `fa fa-users`
  * **Standalone Views**: Updated all 32 non-component views across the system (Cases running/archived/important, Invoices, Expenses, Client detail/account, Appointments, Settings, Team members, Activity logs, Profile, Change password) with precise FontAwesome icons.
  * **Design System & Typography**:
    * Enhanced `.page-title h3, .page-title h4` in `public/css/lawpro-theme.css` and `resources/sass/lawpro-theme.scss`.
    * All heading icons render in Law Pro's signature golden accent (`#E8A838`), 20px size, vertically centered via flexbox with 10px spacing, ensuring seamless appearance in both RTL (Arabic) and LTR (English).
  * **Cache & Permissions**: Cleared compiled views and application caches; verified permissions with `www-data:www-data`.

---

# Phase 2 — Batch 1: UI/UX Modernization (Service, Role, Vendor, Recent-Activity)

### 1. Overview & Architectural Directives
- **Scope**: Modernizing list pages, modal forms, and tables for `service`, `role`, `vendor`, and `recent-activity`.
- **Safe Direction Constraints**:
  - Strictly no Tailwind CSS, no Alpine.js, no new NPM packages.
  - Rely purely on plain Bootstrap 3.3.7 + custom classes from `resources/sass/lawpro-theme.scss` (`.lp-table`, `.lp-card`, `.lp-btn`, `.lp-input`, `.lp-form-group`, `.page-title`).
  - Table styling must be purely additive/cosmetic: sets **no position or display properties** to prevent interfering with DataTables DOM re-rendering on AJAX redraws.

---

### 2. Prompt 1 — Shared Table Styling (`.lp-table`) & Service Module
- **Shared Table Design (`resources/sass/lawpro-theme.scss`)**:
  - Created `.table.lp-table` / `.lp-table`:
    - `border-collapse: separate; border-spacing: 0; width: 100%;`
    - Top header: Background `#f8fafc`, text `--lp-primary` (`#1A3C5E`), 700 bold weight, 2px solid `--lp-primary` bottom border, uppercase tracking.
    - Corners: Rounded top headers with `--radius-md` (12px) and bottom rows, with automated LTR/RTL symmetry.
    - Body rows: Subtle hover highlight (`rgba(26, 60, 94, 0.03)`), transition on background, consistent `12px 16px` padding.
  - Content Panel Wrapper (`.x_panel.lp-card`):
    - Added `cursor: default`, `transform: none` on hover (so entire table containers do not translate up when hovered), `--radius-md`, `--shadow-card`, and `overflow: visible`.
- **Service Module Audit & Refactor (`resources/views/admin/service/service.blade.php`)**:
  - Confirmed `serviceDataTable` has `data-url="{{ route('service.list') }}"` directly on the `<table>` tag.
  - Confirmed exactly 5 columns in `assets/js/service/service-datatable.js` (`id`, `name`, `amount`, `is_active`, `action`). Preserved exact column count and order.
  - Confirmed **no static modals** in `service.blade.php` (uses `<div id="load-modal"></div>` for dynamic AJAX loading).
  - Applied `class="table lp-table"` and `.x_panel.lp-card`.
  - Updated `component.modal_heading` and `component.heading` to apply `.lp-btn.lp-btn-primary` to the create button.
  - **Commit**: `3a5dea5` — `refactor: introduce lp-card and lp-table classes to standardize UI components and table styling`.

---

### 3. Prompt 2 — Role & Vendor Modules + Permission Audit
- **Role Module**:
  - `resources/views/admin/role/index.blade.php`:
    - Confirmed `roleDataTable` with `data-url` on `<table>`, exactly 3 columns (`id`, `slug`, `action`) matching `assets/js/role/role-datatable.js`.
    - Applied `.x_panel.lp-card` and `class="table lp-table"`.
    - Confirmed no static modal exists in `index.blade.php` (uses `#load-modal`).
  - `role/create.blade.php` & `role/edit.blade.php`:
    - Audited modal `#addtag` and preserved all element IDs required by `assets/js/role/role-validation.js` (`#roleForm`, `#slug`, `#description`, `#cl`, `#form-errors`, `#token-value`, `#common_check_exist`).
    - Styled with `lp-form-group`, `form-control lp-input`, `btn btn-danger lp-btn lp-btn-danger`, and `btn btn-success lp-btn lp-btn-primary shadow`.
- **Vendor Module (`resources/views/admin/vendor/vendor.blade.php`)**:
  - Confirmed `Vendordatatable` has `data-url` on `<table>`, exactly 5 columns (`id`, `first_name`, `mobile`, `is_active`, `action`) per `assets/js/vendor/vendor-datatable.js`.
  - Confirmed no static modal exists in `vendor.blade.php`.
  - Applied `.x_panel.lp-card` and `class="table lp-table"`.
- **Structural Audit of `permission.blade.php` & `permition.js`**:
  - Confirmed typo in JS filename: `assets/js/role/permition.js` (with a single `t`).
  - Confirmed `permission.blade.php` is a 373-line full page (not a modal), rendering a static permissions matrix (not an AJAX DataTable) with 6 columns (`Menu`, `Sub Menu`, `View`, `Add`, `Edit`, `Delete`).
  - Mapped critical JS dependencies in `permition.js`: `.permition_view`, `.permition_add`, `.permition_edit`, `.permition_delete`, `.all_view`, `.all_add`, `.all_edit`, `.all_delete`, and `tr.tr_permition`.
  - Kept `permission.blade.php` untouched as requested for review before modification.
  - **Commit**: `95ee02a` — `style: apply custom lp- classes to UI components, tables, and form elements across admin views`.

---

### 4. Prompt 3 — Recent Activity Redesign
- **File**: `resources/views/admin/recent-activity/recent_activity.blade.php`.
- **Design Overhaul**:
  - Title updated to `@section('title', 'Activity Logs')`.
  - Wrapped inside `.x_panel.lp-card` and `.table.lp-table` with column icons (`fa-user`, `fa-bolt`, `fa-calendar`, `fa-clock-o`, `fa-cog`).
  - Replaced plain activity text with status badges:
    - Login: `<span class="badge-lp badge-active">Login</span>` (soft green pill with status dot).
    - Logged out: `<span class="badge-lp badge-inactive">Logged out</span>` (soft red pill with status dot).
  - Modernized the action trigger into a Bootstrap dropdown triggered by `.lp-btn.lp-btn-secondary` (`<i class="fa fa-ellipsis-h"></i>`).
  - Enhanced `lawpro-theme.scss` with `.lp-table .dropdown-menu` styling (`--shadow-hover`, `--radius-sm`, theme hover colors) and ensured `overflow: visible` on `.x_panel.lp-card` to eliminate clipping.
  - **Commit**: `1e728af` — `style: redesign recent-activity table and card with lp-table and badge components`.

---

### 5. Prompt 4 — Verification, Git Sync & Next Batches Roadmap
- **Asset Compilation**: Executed `npm run dev` with zero errors (36.6 KiB compiled CSS).
- **Git Push Verification**: Pushed to `origin/main`; verified head commit `1e728af`.
- **Container Cleanup**: Reset permissions with `www-data:www-data` and cleared compiled Blade views (`php artisan view:clear`).
- **Roadmap for Upcoming Batches**:
  1. **Batch 2**: **Client Module** (`client.blade.php`, client details, client account).
  2. **Batch 3**: **Task Module** (`task.blade.php`, filters, task status badges).
  3. **Batch 4**: **Settings Sub-pages** (7 modules sharing `tagDataTable`: `case-type`, `court-type`, `court`, `judge`, `case-status`, `tax`, `expense-type`).
  4. **Final Batch**: **High-Complexity Modules** (`case-running`, `case-archived`, `case-important`, `invoice`, `appointment`, `team-members`).






---

# Phase 2 — Batch 2: Client Module (Safe Direction)

### 1. Overview & Architectural Directives
- **Scope**: Redesigning the main client list, client creation/edit forms (handling a complex jQuery repeater), client detail tab navigation, and the client's case history/account tables.
- **Constraints**: 
  - Strictly no Tailwind CSS or Alpine.js.
  - Rely on `lawpro-theme.scss` classes (`.lp-table`, `.lp-card`, `.lp-btn`, `.lp-input`, `.lp-form-group`, `.page-title`).
  - Maintain the integrity of all `id`, `name`, `data-url`, and repeater attributes untouched.

### 2. Prompt 1 — Main Client List
- **File**: `resources/views/admin/client/client.blade.php`.
- **Action**: Applied `.lp-card` to `.x_panel` and `.lp-table` to `.table`.
- **Preserved**: `id="clientDataTable"`, its `data-url` attribute, and the exact 6 `<th>` columns per `client-datatable.js` structure.
- **Commit**: `a664ab2` — `Phase 2 Batch 2 Prompt 1: Refactor main client list UI`

### 3. Prompt 2 — Create/Edit Forms (jQuery Repeater Handled Safely)
- **Files**: `client_create.blade.php` and `client_edit.blade.php`.
- **Action**:
  - Replaced `form-group` with `form-group lp-form-group` and `form-control` with `form-control lp-input`.
  - Replaced `.btn-success` with `.lp-btn .lp-btn-primary` and `.btn-danger` with `.lp-btn .btn-danger`.
  - Applied `.lp-card` to `.x_panel`.
- **Preserved**: 
  - Did NOT touch any `id` or `name` attributes inside `data-repeater-item` or `data-repeater-list`.
  - Kept the DOM structure of `#change_court_div` and radio inputs (`id="test6"/"test7"`, `name="type"`) untouched to ensure the hide/show toggle script works perfectly despite duplicate IDs inside the repeater.
- **Commit**: `af58484` — `Phase 2 Batch 2 Prompt 2: Refactor client create and edit forms UI`

### 4. Prompt 3 — Client Detail Tab Bar
- **File**: `client_detail.blade.php`.
- **Action**: 
  - Wrapped the client info tables in `.lp-card` (converted `.x_panel` to `.x_panel .lp-card`).
  - Created a new CSS class `.lp-tabs` (with `.nav-tabs.lp-tabs` specificity) in `lawpro-theme.scss` that aligns with `.page-title` styling (clean bottom border, transparent background, accent color on active tab).
  - Replaced `.bar_tabs` with `.lp-tabs` on the `<ul>` element.
- **Preserved**: Exactly preserved the three `route()` links (`clients.show`, `clients.case-list`, `clients.account-list`), the `$adminHasPermition` checks wrapping the "cases" and "account" tabs, and the `request()->is(...) ? 'active' : ''` logic.
- **Commit**: `8f038f3` — `Phase 2 Batch 2 Prompt 3: Refactor client detail tab bar UI`

### 5. Prompt 4 — Case History and Account Tables (Within Client View)
- **Files**: `cases_view.blade.php` and `client_account.blade.php`.
- **Action**: Applied `.lp-card` to `.x_panel`, `.lp-table` to `.table`, and `.lp-tabs` to the tab navigation `<ul>`.
- **Preserved**:
  - `cases_view.blade.php`: Preserved `id="clientCaselistDatatable1"`, its `data-url`, and the 7-column structure. Verified that the modal skeletons (`#modal-case-priority`, `#modal-change-court`, `#modal-next-date`) and their target divs were untouched (as chrome is loaded dynamically via AJAX). Kept `#advo_client_id` and `#token-value` hidden inputs.
  - `client_account.blade.php`: Preserved `id="clientAccountlistDatatable"`, its `data-url`, the 8-column structure, and hidden inputs untouched.
- **Commit**: `4267c56` — `Phase 2 Batch 2 Prompt 4: Refactor client case history and account tables UI`

### 6. Verification and Final Refinements
- **Refinements Implemented**:
  - Improved the "Add New" button in the client create/edit repeater to display text instead of just an icon.
  - Added CSS overrides in `lawpro-theme.scss` for `Select2` dropdowns to perfectly match the height, border, and focus states of `.lp-input`.
  - Strengthened `.lp-tabs` styling to fully override Bootstrap's default active tab borders.
  - Ran `npm run dev` to compile `public/css/lawpro-theme.css`.
- **Commit Reversion**: The refinement commit (`fe30a6b`) was later reverted by the user locally using `git reset --hard HEAD^`, returning the local state to Prompt 4's commit (`4267c56`), and the remote repository was synced using `git push -f origin main`. Thus, the finalized and accepted codebase state remains at the conclusion of Prompt 4.
