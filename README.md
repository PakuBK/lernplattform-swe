# Lernplattform SWE - Learning Management System

A Laravel 11 learning platform with role-based access control, quiz functionality, and educational content management.

## Features

- **Authentication**: Laravel Breeze with email/password authentication
- **Roles**: Student, Teacher, Parent, Admin
- **Subjects**: Create and manage subjects with assigned teachers
- **Themes**: Organize content into themes within subjects
- **Materials**: Upload and manage PDF learning materials
- **Quizzes**: Create quizzes with multiple-choice questions
- **Quiz Player**: Interactive quiz taking with automatic scoring
- **Random Quiz**: Take random quizzes per subject
- **Dashboards**: Role-specific dashboards for each user type
- **Progress Tracking**: View quiz attempts and scores

## Technology Stack

- Laravel 11
- PHP 8.3
- Bootstrap 5
- MySQL
- Blade Templates
- Vite

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd lernplattform-swe
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install NPM dependencies:
```bash
npm install
```

4. Copy the environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lernplattform
DB_USERNAME=root
DB_PASSWORD=your_password
```

7. Create the database:
```bash
mysql -u root -p -e "CREATE DATABASE lernplattform"
```

8. Run migrations:
```bash
php artisan migrate
```

9. Seed the database with demo data:
```bash
php artisan db:seed
```

10. Build frontend assets:
```bash
npm run build
```

11. Start the development server:
```bash
php artisan serve
```

12. Visit `http://localhost:8000` in your browser.

## Demo Users

After seeding, you can log in with these demo accounts:

### Admin
- **Email**: admin@example.com
- **Password**: password

### Teacher
- **Email**: teacher@example.com
- **Password**: password

### Student
- **Email**: student@example.com
- **Password**: password

### Parent
- **Email**: parent@example.com
- **Password**: password

## Database Entities

- **users**: User accounts with roles
- **students**: Student profiles linked to users
- **parents**: Parent profiles linked to users
- **parent_child**: Relationship between parents and students
- **subjects**: Academic subjects
- **themes**: Topics within subjects
- **materials**: PDF learning materials
- **quizzes**: Quiz definitions
- **questions**: Quiz questions
- **question_options**: Multiple choice options
- **attempts**: Quiz attempt records
- **attempt_answers**: Student answers for each question

## Key Features by Role

### Student
- View available subjects and materials
- Take quizzes
- View quiz history and scores
- Take random quizzes per subject

### Teacher
- Create and manage subjects
- Create themes and upload materials
- Create and manage quizzes
- View all subjects they teach

### Parent
- View children's progress
- Monitor quiz attempts and scores

### Admin
- Full system access
- Manage all subjects, themes, materials, and quizzes
- View system statistics

## Development

To run in development mode with hot reloading:
```bash
npm run dev
```

In another terminal:
```bash
php artisan serve
```

## Testing

Run tests:
```bash
php artisan test
```

## License

This project is open-sourced software licensed under the MIT license.
