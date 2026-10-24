# النشر على cPanel (توصيات مهمة)

1. أنشئ دومين/ساب دومين للعقارات، وغيّر Document Root إلى مسار المشروع `.../AL_HASM_Properties/public` فقط، وليس الجذر. تأكد أن إعدادات الاستضافة تسمح بتوجيه ذلك المسار. إن لم تسمح، لا تنقل جذر Laravel إلى `public_html`؛ استخدم إعداد نشر منفصلاً آمناً.
2. اختر PHP 8.3 أو أحدث، وفعّل `pdo_mysql, mbstring, openssl, curl, dom, xml, fileinfo` وغيرها المطلوبة.
3. أنشئ قاعدة بيانات واسم مستخدم وصلاحيات في MySQL Databases.
4. ارفع ملفات المصدر وفك ZIP **خارج المسار المكشوف للعامة**. على SSH:

```bash
cd /home/YOUR_CPANEL_USER/AL_HASM_Properties
cp .env.example .env
composer install --no-dev --optimize-autoloader
php artisan key:generate
```

5. حدّث `.env` بمعلومات MySQL والنطاق النهائي. لا تشارك بياناته.
6. نفّذ (للتركيب الأول فقط):

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan alhasm:admin admin@YOUR-DOMAIN
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
php artisan route:cache
```

7. تأكد من الكتابة إلى `storage` و`bootstrap/cache`، ومن خدمة ملفات التخزين عبر الرابط `/storage`.
8. اضبط `APP_DEBUG=false` و`APP_ENV=production` و`APP_URL=https://...` و `SESSION_SECURE_COOKIE=true`.
9. امنح لوحة التحكم لمدير موثوق، فعّل HTTPS ونسخ قاعدة البيانات والملفات احتياطياً، وراجع سجلات الخطأ بعد الاختبار.
10. استبدل المحتوى التجريبي والبيانات القانونية والشعار قبل إطلاق النسخة للجمهور.

> Laravel 13 **لا يعمل بنسخ ملفات PHP فقط**: يلزم `vendor` من Composer. إن لم توفر الاستضافة Composer أو متطلبات PHP، ثبّت التبعيات محلياً في بيئة مشابهة أو استخدم VPS. لا ترفع كلمات المرور الافتراضية ولا تستخدم `php artisan serve` كخادم إنتاج.
