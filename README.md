# LA15 – Deciding Who May (Roles and Policies)

## Part F – Reflection Questions

### 1. How is Lesson 14 different from Lesson 15? Where is the first question answered?

Lesson 14 answers the question "Who are you?" through authentication, which verifies the identity of the user during login. Lesson 15 answers "What may you do?" through authorization using roles and policies. In this project, the LoginController handles authentication, while the BookPolicy determines which actions an authenticated user may perform.

### 2. Why can the role be changed through Tinker even though it is not included in the User model's $fillable array?

The role can be changed through Tinker because I used direct property assignment, such as `$u->role = 'admin'`, followed by `$u->save()`. The `$fillable` property protects against mass assignment, but it does not prevent direct assignment to a model property.

### 3. What is the difference between a normal user receiving a 403 error and a guest being redirected to the login page?

A normal user is already authenticated, but the BookPolicy does not allow that user to create, update, or delete books, so Laravel returns a 403 Forbidden response. A guest is not authenticated, so the authentication middleware redirects the guest to the login page before the protected action can be accessed.

### 4. Why can guests still view the book list and individual book details?

The book list and individual book details are intentionally available for public viewing. The index and show actions do not require authentication, allowing guests and registered users to browse the books without being able to manage them.

### 5. Why should the controller and Blade views use the same policy instead of separate role checks?

Using the same BookPolicy keeps authorization rules consistent throughout the application. The controller uses `Gate::authorize()` to protect actions on the server, while Blade uses `@can` and `@cannot` to control which buttons and messages are displayed. This avoids duplicating role-checking conditions that could become inconsistent.

### 6. What does SESSION_LIFETIME measure, and why is there no warning before a session expires?

SESSION_LIFETIME measures how many minutes a session can remain inactive before it expires. It does not measure the total time a user has been logged in. Laravel detects the expired session when the browser makes another request, which is why the user is redirected to the login page without receiving an advance warning.

## Project Information

**Activity:** LA15 – Deciding Who May (Roles and Policies)  
**Framework:** Laravel 12  
**Database:** SQLite  
**Repository:** https://github.com/jhttatel-sketch/-itrackb4-la15-tatel-johnhermie