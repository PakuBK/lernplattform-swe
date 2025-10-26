/**
 * Learning Platform JavaScript
 * 
 * This file contains client-side functionality for the learning platform.
 * For novice programmers: JavaScript runs in the browser and makes pages interactive.
 */

// This function can be used for future enhancements
document.addEventListener('DOMContentLoaded', function() {
    console.log('Learning Platform loaded successfully!');
});

/**
 * Timer function for quizzes (for future implementation)
 */
function startQuizTimer(minutes) {
    let timeRemaining = minutes * 60; // Convert to seconds
    
    const timerDisplay = document.getElementById('timer');
    if (!timerDisplay) return;
    
    const interval = setInterval(function() {
        const mins = Math.floor(timeRemaining / 60);
        const secs = timeRemaining % 60;
        
        timerDisplay.textContent = `Time Remaining: ${mins}:${secs.toString().padStart(2, '0')}`;
        
        if (timeRemaining <= 0) {
            clearInterval(interval);
            alert('Time is up!');
            document.getElementById('quizForm').submit();
        }
        
        timeRemaining--;
    }, 1000);
}

/**
 * Confirm before submitting quiz
 */
function confirmQuizSubmit() {
    return confirm('Are you sure you want to submit your quiz? Make sure you have answered all questions!');
}
