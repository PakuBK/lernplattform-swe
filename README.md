# 🎓 Learning Platform (Lernplattform)

A responsive PHP-based learning platform designed for young students to access learning materials and take quizzes. Built with simplicity in mind for easy understanding and maintenance by novice programmers.

## ✨ Features

- **📚 Learning Materials**: Browse and study various educational content
- **📝 Interactive Quizzes**: Test knowledge with multiple-choice quizzes
- **📊 Progress Tracking**: View quiz results and performance history
- **🔐 User Authentication**: Secure login system for students
- **📱 Responsive Design**: Works perfectly on desktop, tablet, and mobile devices
- **🎨 Modern UI**: Clean and intuitive interface designed for young learners

## 🚀 Quick Start

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher (or MariaDB)
- Web server (Apache/Nginx) or PHP built-in server
- Basic understanding of PHP and MySQL

### Installation Steps

You can find the installtion steps in the **SETUP.md** file.


## 🎯 How It Works

### For Students

1. **Login**: Students log in with their credentials
2. **Browse**: View available learning materials and quizzes
3. **Study**: Read through learning materials
4. **Take Quizzes**: Test knowledge with interactive quizzes
5. **View Results**: See scores and track progress

### For Developers

The application follows a simple structure:

- **Public Pages** (`public/`): User-facing pages
- **Includes** (`includes/`): Reusable PHP code
- **Database**: MySQL database with 5 main tables
- **Styling**: CSS-based responsive design

## 📝 Database Schema

- **users**: Student accounts
- **learning_materials**: Educational content
- **quizzes**: Quiz information
- **questions**: Quiz questions and answers
- **quiz_attempts**: Student quiz history

## 🔒 Security Features

- Password hashing with `password_hash()`
- SQL injection prevention with prepared statements
- XSS protection with input sanitization
- Session-based authentication

## 🛠️ Adding Content

### Adding a Learning Material

Insert into the `learning_materials` table:
```sql
INSERT INTO learning_materials (title, description, content, category, difficulty_level) 
VALUES ('Your Title', 'Description', '<p>HTML Content</p>', 'Category', 'beginner');
```

### Adding a Quiz

1. Insert the quiz:
```sql
INSERT INTO quizzes (title, description, material_id, time_limit) 
VALUES ('Quiz Title', 'Description', 1, 15);
```

2. Add questions:
```sql
INSERT INTO questions (quiz_id, question_text, option_a, option_b, option_c, option_d, correct_answer, points) 
VALUES (1, 'Question?', 'A', 'B', 'C', 'D', 'A', 1);
```

## 🤝 Team Collaboration

This project is designed for a team of novice programmers:

- **Clear Code Comments**: Every file has explanatory comments
- **Simple Structure**: Easy-to-understand folder organization
- **Modular Design**: Functions are separated and reusable
- **Documentation**: Comprehensive README and inline comments

## 📚 Learning Resources

For team members new to the technologies:

- [PHP Basics](https://www.php.net/manual/en/tutorial.php)
- [MySQL Tutorial](https://dev.mysql.com/doc/mysql-tutorial-excerpt/8.0/en/)
- [HTML & CSS](https://www.w3schools.com/html/)
- [Responsive Design](https://www.w3schools.com/css/css_rwd_intro.asp)

## 🐛 Troubleshooting

### Database Connection Error
- Check that MySQL is running
- Verify database credentials in `includes/config.php`
- Ensure the database exists

### Page Not Found (404)
- Make sure you're accessing through the `public/` directory
- Check that mod_rewrite is enabled (if using Apache)

### Session Issues
- Ensure the web server has write permissions
- Check PHP session configuration

## 📄 License

This project is created for educational purposes.

## 👥 Contributing

This is a team project. Team members should:
1. Create a feature branch
2. Make changes with clear commits
3. Test thoroughly
4. Submit a pull request
5. Get code review from team members

## 📞 Support

For questions or issues, contact the development team or create an issue in the repository.
