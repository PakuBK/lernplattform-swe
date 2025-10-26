# 🛠️ Setup Guide for Beginners

This guide will help you set up the Learning Platform on your local computer, even if you're new to web development.

## 📋 What You'll Need

1. **A Computer** running Windows, macOS, or Linux
2. **A Text Editor** (we recommend [VS Code](https://code.visualstudio.com/))
3. **XAMPP** or **MAMP** (for PHP and MySQL)
4. **A Web Browser** (Chrome, Firefox, or Safari)

## 📥 Step 1: Install XAMPP/MAMP

### For Windows & Linux: XAMPP

1. Go to [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Download XAMPP for your operating system
3. Run the installer
4. Install at least these components:
   - Apache (web server)
   - MySQL (database)
   - PHP
   - phpMyAdmin (database management tool)

### For macOS: MAMP

1. Go to [https://www.mamp.info/](https://www.mamp.info/)
2. Download MAMP (free version is fine)
3. Install MAMP
4. Start MAMP and make sure both Apache and MySQL are running (green lights)

## 📂 Step 2: Set Up the Project

### Option A: Clone with Git (Recommended)

1. Install Git: [https://git-scm.com/downloads](https://git-scm.com/downloads)
2. Open Terminal (Mac/Linux) or Command Prompt (Windows)
3. Navigate to your web directory:
   - **XAMPP**: `cd C:\xampp\htdocs` (Windows) or `cd /opt/lampp/htdocs` (Linux)
   - **MAMP**: `cd /Applications/MAMP/htdocs` (Mac)
4. Clone the repository:
   ```bash
   git clone https://github.com/PakuBK/lernplattform-swe.git
   cd lernplattform-swe
   ```

### Option B: Download ZIP

1. Download the project as ZIP from GitHub
2. Extract the ZIP file
3. Move the extracted folder to:
   - **XAMPP**: `C:\xampp\htdocs\lernplattform-swe` (Windows)
   - **MAMP**: `/Applications/MAMP/htdocs/lernplattform-swe` (Mac)

## 🗄️ Step 3: Create the Database

### Using phpMyAdmin (Easier for Beginners)

The XAMPP Apache and MySQL have to be running for this.

1. Open your web browser
2. Go to:
   - **XAMPP**: `http://localhost/phpmyadmin`
   - **MAMP**: `http://localhost:8888/phpMyAdmin`
3. Click on "New" in the left sidebar
4. Enter database name: `lernplattform`
5. Choose "utf8mb4_unicode_ci" as collation
6. Click "Create"
7. Click on the newly created database
8. Click on "Import" tab
9. Click "Choose File"
10. Select `database.sql` from the project folder
11. Scroll down and click "Go"
12. You should see "Import has been successfully finished"

### Using Command Line (Alternative)

```bash
# For XAMPP (Windows)
cd C:\xampp\mysql\bin
mysql.exe -u root -p

# For XAMPP (Linux)
cd /opt/lampp/bin
./mysql -u root -p

# For MAMP (Mac)
/Applications/MAMP/Library/bin/mysql -u root -p

# Then run these commands:
CREATE DATABASE lernplattform;
USE lernplattform;
SOURCE /path/to/database.sql;
EXIT;
```

## ⚙️ Step 4: Configure the Database Connection

This is optional, you need a config.php but currently we don't need to modify these in any way.

1. Open the project in your text editor (VS Code)
2. Navigate to `includes/config.php`
3. Update these lines if needed (default XAMPP/MAMP settings):
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');  // Empty for XAMPP, 'root' for MAMP
   define('DB_NAME', 'lernplattform');
   ```

## 🚀 Step 5: Start the Application

### Method 1: Using XAMPP/MAMP

1. Make sure Apache and MySQL are running (green in control panel)
2. Open your browser
3. Go to:
   - **XAMPP**: `http://localhost/lernplattform-swe/public/`
   - **MAMP**: `http://localhost:8888/lernplattform-swe/public/`

### Method 2: Using PHP Built-in Server

1. Open Terminal/Command Prompt
2. Navigate to the project:
   ```bash
   cd path/to/lernplattform-swe
   ```
3. Start the server:
   ```bash
   php -S localhost:8000 -t public/
   ```
4. Open browser and go to: `http://localhost:8000`

## 🔑 Step 6: Login

Use these demo credentials:

- **Username**: `student1`
- **Password**: `student123`

## ✅ Verify Everything Works

After logging in, you should see:

1. ✅ Dashboard with learning materials
2. ✅ Available quizzes
3. ✅ Ability to click and view materials
4. ✅ Ability to take quizzes

## 🐛 Common Problems and Solutions

### Problem: "Connection failed" error

**Solution**:

- Make sure MySQL is running
- Check username and password in `includes/config.php`
- Verify database name is correct

### Problem: "Page not found" error

**Solution**:

- Make sure you're accessing through the `public/` directory
- Check that Apache is running
- Try using PHP built-in server instead

### Problem: Can't access phpMyAdmin

**Solution**:

- For XAMPP: Make sure Apache and MySQL are both started
- For MAMP: Check that you're using the correct port (usually 8888)
- Try: `http://localhost:8888/MAMP/` for MAMP start page

### Problem: "Table doesn't exist" error

**Solution**:

- The database.sql file wasn't imported correctly
- Go back to Step 3 and re-import the database
- Make sure you selected the correct database before importing

### Problem: Changes don't show up

**Solution**:

- Clear your browser cache (Ctrl+Shift+Delete)
- Do a "hard refresh" (Ctrl+Shift+R or Cmd+Shift+R)
- Restart the web server

## 💡 Tips for Development

### Use Browser Developer Tools

Press F12 in your browser to open developer tools:

- **Console**: See JavaScript errors
- **Network**: See what files are loading
- **Elements**: Inspect HTML and CSS

### Check PHP Errors

If you see a blank page:

1. Add this to the top of `public/index.php`:
   ```php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ```
2. Refresh the page to see errors

### Use Version Control

Make a habit of committing your changes:

```bash
git add .
git commit -m "Description of what you changed"
git push
```

## 📚 Next Steps

Now that you have the platform running:

1. **Explore the Code**: Start with `public/login.php` and follow the flow
2. **Make Small Changes**: Try changing text or colors in `assets/css/style.css`
3. **Add Content**: Create new learning materials or quizzes
4. **Learn More**: Check out the resources in the main README.md

## 🆘 Getting Help

If you're stuck:

1. **Read the error message carefully** - it usually tells you what's wrong
2. **Check the browser console** (F12 → Console tab)
3. **Look at similar code** in the project - see how it's done elsewhere
4. **Ask your team** - someone might have solved the same problem
5. **Search online** - copy the error message into Google
6. **Check the documentation** - PHP, MySQL, and CSS all have great docs

## 🎉 You're Ready!

Congratulations! You now have a working learning platform. Start exploring the code, make changes, and learn by doing. Remember: every expert was once a beginner!

Happy coding! 💻✨
