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
- **Правый блок hero** — не видео, а интерфейс на вёрстке (`.mock` в `sections/hero.blade.php`,
  стили в `sections.css`). Низкий кадр сам прячет лишние строки через `@container`.
  В `public/media/hero/` остался `hero-poster.webp` — он используется как OG-картинка;
  `hero.mp4` больше нигде не подключён.
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

Каждая публичная страница существует ещё и на казахском под префиксом `/kz/` (`/kz`, `/kz/uslugi`, …).

SEO: canonical, OG, JSON-LD (Organization/Service/FAQPage/BreadcrumbList) на страницах,
`hreflang` на обе языковые версии, в `sitemap.xml` обе версии с `xhtml:link`.

## Языки (ru + kk)

Список языков — `config('studio.locales')`; первый (`ru`) основной. Маршруты из `routes/web.php`
регистрируются по разу на язык: русский на «голых» адресах, казахский под `/kz/` с префиксом
в имени маршрута (`home` → `kk.home`). Язык ставит middleware `SetLocale` (+ кука `studio_locale`).

- ссылки во вьюхах — только `locale_route('home')`, не `route()`, иначе потеряется язык;
- контент — `studio('nav')` вместо `config('studio.nav')`;
- **русский оригинал** контента — `config/studio.php`, **казахский перевод** — `lang/kk/studio.php`
  (те же ключи, можно переводить частями: непереведённое берётся из русского);
- **тексты интерфейса** — `__('Обсудить проект')`, переводы в `lang/kk.json`
  (ключ = русская строка; пока значение равно ключу, казахская версия показывает русский текст);
- переключатель — `partials/lang-switch.blade.php` (в шапке и в мобильном меню),
  `modules/lang.js` дописывает к ссылке текущий якорь секции.

## Подводные камни

- В анонимных Blade-компонентах выражение в `:attr="..."` вычисляется несколько раз —
  не использовать там счётчики, только идемпотентные вычисления (см. `$num()` в `services/show.blade.php`).
- Нумерация секций на странице услуги зависит от того, какие секции показаны (нет тарифов/кейсов — номера сдвигаются).
- Форма заявки: сообщение об успехе показывается только после реальной отправки — не ломать это при правках.
- Новый русский текст во вьюхе сразу оборачивать в `__()`, иначе он никогда не переведётся на казахский.

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

### Автодеплой

Пуш в `main` → GitHub Actions ([.github/workflows/deploy.yml](.github/workflows/deploy.yml)) заходит на сервер по SSH и запускает деплой. Руками ничего делать не нужно; тот же workflow можно запустить кнопкой на вкладке Actions.

Как это собрано:

- секрет `DEPLOY_SSH_KEY` в настройках репозитория — приватный ключ от пары `/root/.ssh/github-actions*` на сервере;
- в `/root/.ssh/authorized_keys` этот ключ записан с `restrict,command="/usr/local/bin/studio-deploy"` — по нему нельзя выполнить ничего, кроме деплоя;
- `/usr/local/bin/studio-deploy` лежит вне репозитория (git переписывает рабочую копию) и делает `git fetch` + `git reset --hard origin/main`, после чего передаёт управление в [deploy.sh](deploy.sh);
- [deploy.sh](deploy.sh) — сами шаги сборки, их можно менять пушем;
- лог всех деплоев на сервере: `/var/log/studio-deploy.log`.

`git reset --hard` затирает локальные правки в `/var/www/studio` — чинить продакшен правкой файлов на сервере нельзя, только пушем. Untracked-файлы (`.env`, картинки в `storage/app/public`) не трогаются.

Если Actions недоступен, то же самое руками:

```bash
ssh root@185.194.217.14 /usr/local/bin/studio-deploy
```

### Когда появится домен

1. A-запись домена → `185.194.217.14`.
2. В nginx-конфиге `listen 8084` → `listen 80`, `server_name домен www.домен`; `nginx -t && systemctl reload nginx`.
3. `.env`: `APP_URL=https://домен`, затем `php artisan optimize`.
4. `certbot --nginx -d домен -d www.домен`.
