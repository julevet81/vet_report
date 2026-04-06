# Hostinger Deployment Guide (Laravel)

هذا الدليل مخصص لنشر المشروع على Hostinger Shared Hosting.

## 1) التحضير محليًا قبل الرفع

شغّل هذه الأوامر داخل المشروع:

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan optimize:clear
```

ثم أنشئ ملف رفع ZIP جاهز:

```powershell
powershell -ExecutionPolicy Bypass -File scripts/build-hostinger-package.ps1
```

سينتج ملف: `hostinger-deploy.zip`

## 2) رفع الملفات على Hostinger

1. ارفع `hostinger-deploy.zip` إلى مجلد home (مثل: `/home/USERNAME/`).
2. فك الضغط بحيث يصبح المشروع مثل:

```text
/home/USERNAME/vet_reports
```

3. من هذا المشروع، انسخ محتوى:

```text
deploy/hostinger/public_html/
```

إلى:

```text
/home/USERNAME/public_html/
```

مهم: إذا كان اسم مجلد المشروع مختلفًا عن `vet_reports` عدّل المسار داخل:

```text
public_html/index.php
```

## 3) إعداد `.env` للإنتاج

في ملف `.env` على السيرفر:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://your-domain.com`
- اضبط `DB_*` على قاعدة بيانات MySQL الخاصة بـ Hostinger
- أضف `OPENAI_API_KEY` إذا كنت تستخدم ملخص الذكاء الاصطناعي

## 4) أوامر ما بعد النشر (عبر SSH إن توفر)

```bash
php artisan key:generate --force
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

إذا لم يتوفر SSH:

- ولّد `APP_KEY` محليًا عبر:

```bash
php artisan key:generate --show
```

ثم ضع القيمة يدويًا في `.env` على السيرفر.

## 5) صلاحيات المجلدات

تأكد من صلاحيات الكتابة:

- `storage/`
- `bootstrap/cache/`

عادة: `775`

## 6) أسباب الفشل الشائعة على Hostinger

- لم يتم رفع `vendor/`
- لم يتم بناء `public/build/`
- `APP_KEY` فارغ
- إعدادات قاعدة البيانات خاطئة
- `public_html/index.php` يشير لمسار مشروع غير صحيح

## 7) فحص سريع بعد النشر

- صفحة الدخول تعمل بدون خطأ 500
- التبديل بين العربية/الفرنسية يعمل
- إنشاء تقرير يعمل ويحفظ في قاعدة البيانات
- عرض التقرير لا يظهر JSON بل جداول مقروءة
