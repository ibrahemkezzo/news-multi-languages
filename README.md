# Multi-Language News Platform
A modular news management system built with Laravel 10. It provides a public news interface and an administrative dashboard for managing users, categories, posts, site settings, and localized content.
The application is configured for Arabic, English, and French content. Translatable fields are stored through dedicated translation models, while the public pages and REST API expose the active locale through Laravel resources.
## Features
- Responsive public website for browsing categories and news posts.
- Multi-language content for Arabic, English, and French.
- Main categories and nested subcategories.
- News articles with title, content, short description, tags, image, and category.
- Dashboard for:
  - Creating and managing users.
  - Assigning `admin` and `writer` roles.
  - Creating, editing, and deleting categories.
  - Creating, editing, and deleting posts.
  - Updating site title, address, contact information, social links, logo, and favicon.
- Role-based authorization using Laravel policies.
- DataTables-powered dashboard listings.
- Image uploads for posts, categories, logos, and favicons.
- Soft deletion support for articles and categories.
- REST API resources for settings, categories, posts, and authenticated users.
- Laravel authentication and Sanctum-based API protection.
## Technology Stack
| Area | Technology |
|---|---|
| Backend | PHP 8.1+, Laravel 10 |
| Database | MySQL by default |
| Authentication | Laravel Auth, Laravel UI, Laravel Sanctum |
| Authorization | Laravel Policies |
| Localization | Astrotomic Laravel Translatable, mcamara Laravel Localization |
| Frontend | Blade, Bootstrap 5, jQuery |
| Dashboard UI | CoreUI assets, Yajra DataTables |
| Asset Build | Vite 4, Sass |
| API Format | JSON and Laravel API Resources |
| Testing | PHPUnit 10, Mockery |
| Code Quality | Laravel Pint |
## Supported Languages
The application currently defines these locales in `config/app.php`:
- Arabic: `ar`
- English: `en`
- French: `fr`
The default locale is English. Translation fields are handled by the translation models associated with posts, categories, and settings.
## Requirements
- PHP 8.1 or newer
- Composer 2
- Node.js and npm
- MySQL or MariaDB
- Common PHP extensions used by Laravel:
  - PDO
  - Mbstring
  - OpenSSL
  - Fileinfo
## Installation
### 1. Clone the repository
```bash
git clone <repository-url>
cd news-multi-languages
```
### 2. Install dependencies
```bash
composer install
npm install
```
### 3. Configure the environment
```bash
cp .env.example .env
php artisan key:generate
```
Update the database and application settings in `.env`:
```dotenv
APP_NAME="News Multi Languages"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=news
DB_USERNAME=root
DB_PASSWORD=
```
### 4. Create the database
Create an empty MySQL database, then run migrations and seed the default account:
```bash
php artisan migrate --seed
```
The database seeder creates:
```text
Email: admin@gmail.com
Password: password
```
Change the default password before deploying the application.
### 5. Start development servers
Run Vite in one terminal:
```bash
npm run dev
```
Run Laravel in another terminal:
```bash
php artisan serve
```
The application is normally available at `http://127.0.0.1:8000`.
Build production assets with:
```bash
npm run build
```
## User Roles and Permissions
The project uses two primary account statuses:
- `admin`: Full administrative access to users, categories, posts, and settings.
- `writer`: Access to dashboard content and permissions to manage eligible posts.
Authorization is enforced with Laravel policies and dashboard middleware. Users with no valid dashboard role are logged out when they attempt to access protected dashboard routes.
## Dashboard
Dashboard routes begin with `/dashboard` and require authentication.
| Route | Purpose |
|---|---|
| `/dashboard` | Dashboard landing page |
| `/dashboard/users` | Manage users |
| `/dashboard/category` | Manage categories |
| `/dashboard/posts` | Manage posts |
| `/dashboard/settings` | Update global site settings |
## Public Website
| Route | Purpose |
|---|---|
| `/` | Home page and category-based post overview |
| `/categories` | Category index |
| `/categories/{category}` | Category page |
| `/post/{post}` | Single post page |
| `/login` | User login |
## REST API
API routes use the `/api` prefix and return JSON.
| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/settings` | Get site settings; protected by Sanctum |
| `GET` | `/api/categories` | Get paginated categories |
| `GET` | `/api/categories/{id}` | Get a category |
| `GET` | `/api/categories-with-posts` | Get categories with related posts |
| `GET` | `/api/post?category_id={id}` | Get posts by category |
| `GET` | `/api/post/{id}` | Get a post |
| `GET` | `/api/user` | Get the authenticated user |
`/api/categoryadmin` is also registered for authorized category administration. API write operations should be added with appropriate validation and Sanctum authorization before production use.
## Project Structure
```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── api/           # REST API controllers
│   │   ├── dashboard/     # Administrative controllers
│   │   ├── website/       # Public website controllers
│   │   └── Auth/          # Authentication controllers
│   ├── Middleware/        # Status and locale middleware
│   └── Resources/         # API resource transformations
├── Models/                # Eloquent and translation models
├── Policies/              # Authorization policies
└── Providers/             # Laravel service providers
database/
├── migrations/            # Database schema
├── seeders/               # Initial application data
└── factories/             # Test data factories
resources/views/
├── website/               # Public-facing Blade views
├── dashboard/             # Admin dashboard views
└── auth/                  # Authentication views
routes/
├── web.php                # Public and authentication routes
├── dashboard.php          # Dashboard routes
└── api.php                # API routes
```
## Testing
Run the test suite:
```bash
php artisan test
```
Or run PHPUnit directly:
```bash
./vendor/bin/phpunit
```
## Code Formatting
Format PHP source code with Laravel Pint:
```bash
./vendor/bin/pint
```
## Production Deployment
Before deployment, update `.env`:
```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```
Then prepare the application:
```bash
composer install --no-dev --optimize-autoloader
npm run build
php artisan optimize
php artisan storage:link
php artisan migrate --force
```
Store environment variables and application secrets outside source control. Configure database backups, application logging, file storage permissions, and HTTPS before exposing the service publicly.
## Contributing
1. Create a feature branch.
2. Keep changes consistent with the existing Laravel structure.
3. Add or update relevant tests.
4. Run the test suite and Pint.
5. Open a pull request with a clear description of the change.
## License
The Laravel framework is distributed under the [MIT License](https://opensource.org/licenses/MIT). This repository does not currently contain a project-level license file.
