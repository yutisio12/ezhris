# Enterprise HRIS (Human Resource Information System)

A complete enterprise-grade HRIS web application built with Laravel 12, FilamentPHP 3, and PostgreSQL.

## Tech Stack

- **Framework:** Laravel 12
- **PHP:** 8.3+
- **Admin Panel:** FilamentPHP 3
- **Frontend:** Livewire 3 + TailwindCSS
- **Database:** PostgreSQL (SQLite for development)
- **Cache/Queue:** Redis
- **Containerization:** Docker

## Required Packages

- `spatie/laravel-permission` - Role-based access control
- `spatie/laravel-activitylog` - Audit trail system
- `spatie/laravel-medialibrary` - File/media management
- `barryvdh/laravel-dompdf` - PDF generation

## Architecture

- **Clean Architecture** with modular monolith structure
- **Repository Pattern** - Data access abstraction
- **Service Layer** - Business logic encapsulation
- **DTO Pattern** - Data transfer between layers
- **SOLID Principles** throughout
- **Event-Driven** communication
- **Queue-based** heavy processing
- **Policy-based** authorization

## Modules

1. **Authentication & Authorization** - Login, RBAC, policies
2. **Dashboard** - Charts, widgets, summaries
3. **Employee Management** - Full CRUD, document management
4. **Department Management** - Organization structure
5. **Position Management** - Job positions and levels
6. **Shift Management** - Shift templates and assignments
7. **Attendance Management** - Logs, processing, corrections
8. **Leave Management** - Requests, approvals, balances
9. **Overtime Management** - Requests and approvals
10. **Payroll Management** - Generation, calculation, locking
11. **Reimbursement Management** - Expense claims
12. **Approval Workflow Engine** - Multi-level approvals
13. **Notification System** - Database notifications
14. **Role & Permission Management** - RBAC
15. **Audit Logs** - Full activity tracking
16. **Reporting & Export** - Excel, PDF export

## Database

28 tables with proper relationships:
- departments, positions, employees
- roles, permissions, role_permissions, users
- shift_templates, employee_shifts, holidays
- attendance_logs, attendances, attendance_corrections, attendance_audits
- leave_types, leave_balances, leave_requests, leave_approvals
- overtime_requests, overtime_approvals
- payroll_periods, payrolls, payroll_items
- reimbursement_requests, notifications, audit_logs
- approval_workflows, approval_histories

## Installation

### Local Development

```bash
# Clone the repository
git clone <repository-url>
cd hris-app

# Install dependencies
composer install
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Build assets
npm run build

# Start development server
php artisan serve
```

### Docker

```bash
# Build and start containers
docker-compose up -d --build

# Run migrations
docker-compose exec app php artisan migrate

# Seed database
docker-compose exec app php artisan db:seed

# Access the application
# App: http://localhost:8080
# Admin: http://localhost:8080/admin
# Mailpit: http://localhost:8025
```

## Default Credentials

| Role | Username | Password |
|------|----------|----------|
| Super Admin | admin | password |
| HR Manager | hrmanager | password |
| Manager | itmanager | password |
| Employee | employee | password |

## Queue Workers

```bash
# Start queue worker
php artisan queue:work

# Start scheduler
php artisan schedule:work
```

## Scheduled Tasks

- **Daily Attendance Processing** - 1:00 AM
- **Incomplete Attendance Check** - 10:00 PM
- **Monthly Leave Balance Reset** - 1st of each month
- **Attendance Logs Cleanup** - Monthly

## License

MIT License
