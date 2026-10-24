# AL HASM Properties v3 — Premium Redesign

Double-click `OPEN_WEBSITE_DEMO.bat` for the interactive public design; use `OPEN_DASHBOARD_DEMO.bat` for the separate admin demo. The public website has no dashboard button. Public pages include About, Services, Contact, property search, Buy, Rent, Off-plan, Team, Blog and Saved. The Laravel templates were updated alongside the offline preview. This is **source code**, not a deployed production instance; Composer dependencies and DB setup are necessary for full Laravel operation. Offline preview stores example data in browser localStorage only. The original logo retains wording related to metal supply; confirm official real estate branding before launch.

---

# AL HASM Properties — Laravel 13 source package

This ZIP contains the source code for a bilingual real-estate portal, custom management dashboard, properties, CRM, viewing requests, contracts, manual payment ledger, blog/CMS, and simple public read-only API.

**Requirements:** PHP 8.3+, Composer 2, MySQL, and Laravel-required extensions. Install dependencies on an internet-connected PHP environment; `vendor/` is intentionally excluded.

```bash
cp .env.example .env
composer install
php artisan key:generate
# Configure MySQL credentials in .env
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan alhasm:admin admin@example.com
php artisan serve
```

Admin panel: `/admin`  •  Login: `/login`  •  Public site: `/`.

Preview the visual design offline via `preview/index.html` and `preview/dashboard.html`. These are static previews and do not run the Laravel backend.

**Important:** Sample property listings, articles, images, and prices are illustrative, **not actual property offers**. Replace demo content before launch, complete legal/privacy review, configure SSL and real company details, and test the application against an actual database. The original supplied logo still contains metal-supply wording. This package has not been integration-tested with Composer dependencies in the build environment, which does not provide them. No real payment gateway, automatic WhatsApp, signed-contract solution, or mobile application is included. See `README_AR.md` and `docs/` for details.
