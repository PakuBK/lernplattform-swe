<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\ParentModel;
use App\Models\Subject;
use App\Models\Theme;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Teachers
        $teacher1 = User::create([
            'name' => 'John Teacher',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        $teacher2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'teacher2@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        // Create Students
        $student1User = User::create([
            'name' => 'Alice Student',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
        $student1 = Student::create([
            'user_id' => $student1User->id,
            'grade' => '10',
            'class' => 'A',
        ]);

        $student2User = User::create([
            'name' => 'Bob Johnson',
            'email' => 'student2@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
        $student2 = Student::create([
            'user_id' => $student2User->id,
            'grade' => '10',
            'class' => 'B',
        ]);

        // Create Parents
        $parent1User = User::create([
            'name' => 'Parent One',
            'email' => 'parent@example.com',
            'password' => Hash::make('password'),
            'role' => 'parent',
        ]);
        $parent1 = ParentModel::create([
            'user_id' => $parent1User->id,
            'phone' => '+1234567890',
        ]);
        $parent1->children()->attach($student1->id);

        // Create Subjects
        $mathSubject = Subject::create([
            'name' => 'Mathematics',
            'description' => 'Advanced mathematics course covering algebra, geometry, and calculus.',
            'teacher_id' => $teacher1->id,
        ]);

        $physicsSubject = Subject::create([
            'name' => 'Physics',
            'description' => 'Introduction to physics concepts including mechanics and thermodynamics.',
            'teacher_id' => $teacher2->id,
        ]);

        $csSubject = Subject::create([
            'name' => 'Computer Science',
            'description' => 'Programming fundamentals and software development.',
            'teacher_id' => $teacher1->id,
        ]);

        // Create Themes for Mathematics
        $algebraTheme = Theme::create([
            'subject_id' => $mathSubject->id,
            'name' => 'Algebra',
            'description' => 'Linear equations, quadratic equations, and polynomials.',
            'order' => 1,
        ]);

        $geometryTheme = Theme::create([
            'subject_id' => $mathSubject->id,
            'name' => 'Geometry',
            'description' => 'Shapes, angles, and spatial reasoning.',
            'order' => 2,
        ]);

        // Create Themes for Physics
        $mechanicsTheme = Theme::create([
            'subject_id' => $physicsSubject->id,
            'name' => 'Mechanics',
            'description' => 'Newton\'s laws, motion, and forces.',
            'order' => 1,
        ]);

        // Create Themes for Computer Science
        $programmingTheme = Theme::create([
            'subject_id' => $csSubject->id,
            'name' => 'Programming Basics',
            'description' => 'Variables, loops, and functions.',
            'order' => 1,
        ]);

        // Create Materials
        Material::create([
            'theme_id' => $algebraTheme->id,
            'title' => 'Introduction to Algebra',
            'description' => 'Basic concepts and formulas',
            'file_path' => 'materials/algebra_intro.pdf',
        ]);

        Material::create([
            'theme_id' => $geometryTheme->id,
            'title' => 'Geometry Fundamentals',
            'description' => 'Shapes and angles guide',
            'file_path' => 'materials/geometry_basics.pdf',
        ]);

        Material::create([
            'theme_id' => $mechanicsTheme->id,
            'title' => 'Newton\'s Laws',
            'description' => 'Understanding motion and forces',
            'file_path' => 'materials/newtons_laws.pdf',
        ]);

        Material::create([
            'theme_id' => $programmingTheme->id,
            'title' => 'Python Basics',
            'description' => 'Introduction to Python programming',
            'file_path' => 'materials/python_intro.pdf',
        ]);

        // Create Quizzes
        $algebraQuiz = Quiz::create([
            'subject_id' => $mathSubject->id,
            'theme_id' => $algebraTheme->id,
            'title' => 'Algebra Quiz 1',
            'description' => 'Test your knowledge of basic algebra',
            'time_limit' => 30,
        ]);

        $geometryQuiz = Quiz::create([
            'subject_id' => $mathSubject->id,
            'theme_id' => $geometryTheme->id,
            'title' => 'Geometry Quiz 1',
            'description' => 'Test your understanding of shapes and angles',
            'time_limit' => 25,
        ]);

        $mechanicsQuiz = Quiz::create([
            'subject_id' => $physicsSubject->id,
            'theme_id' => $mechanicsTheme->id,
            'title' => 'Mechanics Quiz 1',
            'description' => 'Newton\'s laws and motion',
            'time_limit' => 30,
        ]);

        $programmingQuiz = Quiz::create([
            'subject_id' => $csSubject->id,
            'theme_id' => $programmingTheme->id,
            'title' => 'Programming Basics Quiz',
            'description' => 'Test your programming knowledge',
            'time_limit' => 20,
        ]);

        // Create Questions for Algebra Quiz
        $q1 = Question::create([
            'quiz_id' => $algebraQuiz->id,
            'question_text' => 'What is 2x + 3 = 11? Solve for x.',
            'points' => 5,
            'order' => 1,
        ]);
        QuestionOption::create(['question_id' => $q1->id, 'option_text' => 'x = 4', 'is_correct' => true, 'order' => 1]);
        QuestionOption::create(['question_id' => $q1->id, 'option_text' => 'x = 5', 'is_correct' => false, 'order' => 2]);
        QuestionOption::create(['question_id' => $q1->id, 'option_text' => 'x = 7', 'is_correct' => false, 'order' => 3]);
        QuestionOption::create(['question_id' => $q1->id, 'option_text' => 'x = 8', 'is_correct' => false, 'order' => 4]);

        $q2 = Question::create([
            'quiz_id' => $algebraQuiz->id,
            'question_text' => 'Which of the following is a quadratic equation?',
            'points' => 5,
            'order' => 2,
        ]);
        QuestionOption::create(['question_id' => $q2->id, 'option_text' => 'x + 2 = 5', 'is_correct' => false, 'order' => 1]);
        QuestionOption::create(['question_id' => $q2->id, 'option_text' => 'x² + 3x + 2 = 0', 'is_correct' => true, 'order' => 2]);
        QuestionOption::create(['question_id' => $q2->id, 'option_text' => '2x = 10', 'is_correct' => false, 'order' => 3]);
        QuestionOption::create(['question_id' => $q2->id, 'option_text' => 'x³ + x = 5', 'is_correct' => false, 'order' => 4]);

        // Create Questions for Geometry Quiz
        $q3 = Question::create([
            'quiz_id' => $geometryQuiz->id,
            'question_text' => 'What is the sum of angles in a triangle?',
            'points' => 5,
            'order' => 1,
        ]);
        QuestionOption::create(['question_id' => $q3->id, 'option_text' => '90°', 'is_correct' => false, 'order' => 1]);
        QuestionOption::create(['question_id' => $q3->id, 'option_text' => '180°', 'is_correct' => true, 'order' => 2]);
        QuestionOption::create(['question_id' => $q3->id, 'option_text' => '270°', 'is_correct' => false, 'order' => 3]);
        QuestionOption::create(['question_id' => $q3->id, 'option_text' => '360°', 'is_correct' => false, 'order' => 4]);

        // Create Questions for Mechanics Quiz
        $q4 = Question::create([
            'quiz_id' => $mechanicsQuiz->id,
            'question_text' => 'What is Newton\'s First Law of Motion?',
            'points' => 5,
            'order' => 1,
        ]);
        QuestionOption::create(['question_id' => $q4->id, 'option_text' => 'F = ma', 'is_correct' => false, 'order' => 1]);
        QuestionOption::create(['question_id' => $q4->id, 'option_text' => 'An object at rest stays at rest', 'is_correct' => true, 'order' => 2]);
        QuestionOption::create(['question_id' => $q4->id, 'option_text' => 'Action and reaction', 'is_correct' => false, 'order' => 3]);
        QuestionOption::create(['question_id' => $q4->id, 'option_text' => 'E = mc²', 'is_correct' => false, 'order' => 4]);

        // Create Questions for Programming Quiz
        $q5 = Question::create([
            'quiz_id' => $programmingQuiz->id,
            'question_text' => 'What keyword is used to define a function in Python?',
            'points' => 5,
            'order' => 1,
        ]);
        QuestionOption::create(['question_id' => $q5->id, 'option_text' => 'function', 'is_correct' => false, 'order' => 1]);
        QuestionOption::create(['question_id' => $q5->id, 'option_text' => 'def', 'is_correct' => true, 'order' => 2]);
        QuestionOption::create(['question_id' => $q5->id, 'option_text' => 'func', 'is_correct' => false, 'order' => 3]);
        QuestionOption::create(['question_id' => $q5->id, 'option_text' => 'define', 'is_correct' => false, 'order' => 4]);

        $q6 = Question::create([
            'quiz_id' => $programmingQuiz->id,
            'question_text' => 'Which loop is used to iterate over a sequence in Python?',
            'points' => 5,
            'order' => 2,
        ]);
        QuestionOption::create(['question_id' => $q6->id, 'option_text' => 'while', 'is_correct' => false, 'order' => 1]);
        QuestionOption::create(['question_id' => $q6->id, 'option_text' => 'for', 'is_correct' => true, 'order' => 2]);
        QuestionOption::create(['question_id' => $q6->id, 'option_text' => 'do-while', 'is_correct' => false, 'order' => 3]);
        QuestionOption::create(['question_id' => $q6->id, 'option_text' => 'foreach', 'is_correct' => false, 'order' => 4]);
    }
}
