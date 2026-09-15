# Studio — сайт веб-студии

Премиальный сайт веб-студии на Laravel 12. Исходное ТЗ — [prompt.md](prompt.md). Бренд пока заглушка.
Интерфейс и контент на русском, общение с владельцем — на русском.

## Стек

- Laravel 12, PHP 8.3, MySQL 8
- Blade-фронт без SPA; Vite собирает `resources/css/app.css` и `resources/js/app.js`
- CSS написан вручную, Tailwind **не используется** (зависимости остались от шаблона Laravel):
  `base.css` → `components.css` → `sections.css` → `pages.css` (импорты в `app.css`)
- Админка: Filament v3 на `/admin` — ресурсы Lead (заявки), Project (кейсы), Testimonial (отзывы)

## Где что лежит

- **Контент сайта** (услуги, цены, FAQ, процесс, контакты) — `config/studio.php`, не в БД.
  У каждой услуги: `slug`, `h1`, `seo_title`, `seo_description`, `intro`, `audience`, `includes`,
  `benefits`, `faq`, `pricing_types`, `project_categories`.
- **Проекты и отзывы** — в БД, начальные данные в `database/seeders/StudioContentSeeder.php`.
  Картинки проектов — `storage/app/public/projects/*.webp` (в git не попадают).
- **Медиа hero** (видео, постер, сгенерированы в Higgsfield) — `public/media/`, лежат в git.
- Главная собирается из `resources/views/sections/*`; общие куски — `resources/views/partials/*`.

## Маршруты

| URL | Что |
|---|---|
| `/` | главная (`HomeController`) |
| `/uslugi` | список услуг |
| `/uslugi/{slug}` | SEO-страница услуги (`ServiceController@show`, 404 на неизвестный slug) |
| `/work/{project:slug}` | кейс |
| `POST /leads` | заявка, throttle 6/мин; без JS — редирект назад на `#contact` |
| `/sitemap.xml`, `/robots.txt` | генерируются в `SeoController` (статичного `public/robots.txt` нет) |

SEO: canonical, OG, JSON-LD (Organization/Service/FAQPage/BreadcrumbList) на страницах.

## Подводные камни

- В анонимных Blade-компонентах выражение в `:attr="..."` вычисляется несколько раз —
  не использовать там счётчики, только идемпотентные вычисления (см. `$num()` в `services/show.blade.php`).
- Нумерация секций на странице услуги зависит от того, какие секции показаны (нет тарифов/кейсов — номера сдвигаются).
- Форма заявки: сообщение об успехе показывается только после реальной отправки — не ломать это при правках.

## Локально

- Laragon, БД `studio`, пользователь `root` / пароль `root`
- `composer install && npm install && npm run dev`, `php artisan migrate --seed` (или `db:seed --class=StudioContentSeeder`)

## Продакшен

- Сервер `185.194.217.14` (Ubuntu 24.04, nginx, PHP 8.3-FPM, MySQL 8, Node 22). Вход по SSH-ключу: `ssh root@185.194.217.14`.
- Сайт: **http://185.194.217.14:8084** (домена пока нет), админка `/admin`.
- Проект: `/var/www/studio`, владелец `www-data`, клон с `github.com/Shahiahmed/studio` (ветка `main`).
- nginx: `/etc/nginx/sites-available/studio` (порт 8084, `server_name _`).
- БД `studio`, отдельный MySQL-пользователь `studio`; пароль только в `/var/www/studio/.env` на сервере.
- На этом же сервере другие проекты владельца — **не трогать**: ave-vitae (:8080), qr-menu (:8082), qr-demo (:8083)
  и сайты с доменами на 80/443.
- `APP_TIMEZONE` пока UTC.

### Обновление после `git push`

```bash
ssh root@185.194.217.14
cd /var/www/studio && git pull && composer install --no-dev -o && npm ci && npm run build && rm -rf node_modules \
  && php artisan migrate --force && php artisan optimize && chown -R www-data:www-data .
```

Артизан-команды от root создают файлы с владельцем root (например `storage/logs/laravel.log`) — после них делать `chown -R www-data:www-data storage bootstrap/cache`.

### Когда появится домен

1. A-запись домена → `185.194.217.14`.
2. В nginx-конфиге `listen 8084` → `listen 80`, `server_name домен www.домен`; `nginx -t && systemctl reload nginx`.
3. `.env`: `APP_URL=https://домен`, затем `php artisan optimize`.
4. `certbot --nginx -d домен -d www.домен`.
