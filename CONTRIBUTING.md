# 🤝 Contributing to the Learning Platform

Welcome! This guide will help you contribute to the project effectively as part of our development team.

## 🎯 Our Development Principles

1. **Keep it simple** - Write code that other novice programmers can understand
2. **Comment your code** - Explain what and why, not just how
3. **Test before committing** - Always test your changes
4. **Ask for help** - No question is too small
5. **Review together** - Learn from each other's code

## 🔄 Git Workflow

### Before You Start

1. **Make sure you have the latest code**:
   ```bash
   git pull origin main
   ```

2. **Create a new branch for your feature**:
   ```bash
   git checkout -b feature/your-feature-name
   ```
   
   Examples:
   - `feature/add-math-quiz`
   - `fix/login-error`
   - `update/improve-css`

### While Working

1. **Make small, focused commits**:
   ```bash
   git add .
   git commit -m "Add math quiz with 5 questions"
   ```

2. **Write clear commit messages**:
   - ✅ Good: "Fix login bug when password is empty"
   - ✅ Good: "Add new science learning material"
   - ❌ Bad: "Fixed stuff"
   - ❌ Bad: "Update"

3. **Commit often**:
   - After completing a small feature
   - After fixing a bug
   - Before taking a break

### Ready to Share

1. **Push your branch**:
   ```bash
   git push origin feature/your-feature-name
   ```

2. **Create a Pull Request (PR)**:
   - Go to GitHub
   - Click "New Pull Request"
   - Select your branch
   - Write a description of what you changed
   - Request a review from a team member

3. **Wait for review**:
   - Team members will review your code
   - They might suggest changes
   - Don't take it personally - we're all learning!

4. **Make requested changes**:
   ```bash
   # Make your changes
   git add .
   git commit -m "Address review comments"
   git push origin feature/your-feature-name
   ```

5. **Merge**:
   - Once approved, your branch will be merged
   - Delete your feature branch after merging

## 📝 Code Style Guidelines

### PHP Style

```php
<?php
/**
 * Always add a file comment explaining what the file does
 */

// Use clear variable names
$userName = "student1";  // Good
$un = "student1";        // Bad

// Add comments for complex logic
if ($score >= 90) {
    // Give excellent grade message
    $message = "Excellent!";
}

// Use functions for repeated code
function calculatePercentage($score, $total) {
    return ($score / $total) * 100;
}
?>
```

### CSS Style

```css
/* Group related styles together */
.card {
    background: white;
    padding: 20px;
    border-radius: 10px;
}

/* Use clear class names */
.quiz-question { }  /* Good */
.q1 { }            /* Bad */

/* Add comments for complex styles */
/* Gradient background for header */
.header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
```

### HTML Style

```html
<!-- Use semantic HTML -->
<header>...</header>  <!-- Good -->
<div class="header">  <!-- Less good -->

<!-- Always close tags -->
<p>Text here</p>

<!-- Use meaningful IDs and classes -->
<div id="quiz-container">  <!-- Good -->
<div id="qc">             <!-- Bad -->
```

## 🧪 Testing Your Changes

### Before Committing

Always test:

1. **Does it work?**
   - Test the feature you added
   - Try different inputs
   - Test edge cases (empty fields, wrong data, etc.)

2. **Did you break anything?**
   - Log in and out
   - Navigate to different pages
   - Try existing features

3. **Is it responsive?**
   - Resize your browser window
   - Test on mobile view (F12 → Toggle Device Toolbar)

4. **Check for errors**
   - Look at browser console (F12 → Console)
   - Check PHP errors in the terminal

### Testing Checklist

- [ ] Code runs without errors
- [ ] Feature works as expected
- [ ] Existing features still work
- [ ] Works on mobile view
- [ ] No console errors
- [ ] Database queries work correctly

## 🐛 Reporting Bugs

If you find a bug:

1. **Check if it's already reported** in Issues
2. **Create a new issue** with:
   - Clear title: "Login fails when password is empty"
   - Steps to reproduce:
     1. Go to login page
     2. Enter username only
     3. Click login
   - Expected behavior: "Should show error message"
   - Actual behavior: "Page goes blank"
   - Screenshots if possible

## ✨ Adding New Features

### Before Starting

1. **Discuss with the team** - Make sure it's needed
2. **Check existing code** - Maybe it already exists
3. **Keep it simple** - Start with basic version

### Types of Features to Add

#### Easy (Good for beginners):
- Add new learning materials
- Create new quizzes
- Change colors or styling
- Add text content
- Fix typos

#### Medium:
- Add new fields to forms
- Modify database structure
- Add new pages
- Improve UI components

#### Advanced:
- Add new user roles (teacher/admin)
- Implement file uploads
- Add email notifications
- Create API endpoints

## 📚 Learning Resources

### When You're Stuck

1. **Read the error message** - It usually tells you what's wrong
2. **Google the error** - Someone has probably solved it
3. **Check PHP documentation** - [php.net](https://www.php.net/)
4. **Ask the team** - We're here to help!

### Good Resources

- [PHP Tutorial](https://www.w3schools.com/php/)
- [MySQL Tutorial](https://www.w3schools.com/mysql/)
- [Git Tutorial](https://www.atlassian.com/git/tutorials)
- [CSS Flexbox Guide](https://css-tricks.com/snippets/css/a-guide-to-flexbox/)

## 🎓 Code Review Guidelines

### When Reviewing Others' Code

Be kind and constructive:

- ✅ "Good use of functions here! Consider adding a comment explaining what this does."
- ✅ "This works great! For next time, we could make this more efficient by..."
- ❌ "This is wrong."
- ❌ "Why did you do it this way?"

### Look For

1. **Functionality**: Does it work?
2. **Readability**: Can you understand the code?
3. **Simplicity**: Is it overcomplicated?
4. **Comments**: Are complex parts explained?
5. **Security**: Any SQL injection or XSS risks?

## ⚠️ Common Mistakes to Avoid

1. **Committing directly to main** - Always use a branch
2. **Not testing** - Always test before pushing
3. **Large commits** - Keep commits small and focused
4. **No comments** - Explain complex code
5. **Leaving debug code** - Remove console.log, var_dump, etc.
6. **Hardcoding credentials** - Use config.php
7. **Not asking for help** - Ask when stuck!

## 🎉 Celebrate Success

When your PR is merged:
1. 🎊 Celebrate! You contributed!
2. 📝 Note what you learned
3. 🤝 Help others with similar tasks
4. 🚀 Move on to the next feature

## 📞 Getting Help

- **Stuck on Git?** Ask a team member
- **PHP error?** Share the error message
- **Not sure about design?** Show a screenshot
- **Need clarification?** Better to ask than guess

Remember: We're all learning together! Every expert was once a beginner. Your questions help everyone learn.

Happy coding! 🚀
