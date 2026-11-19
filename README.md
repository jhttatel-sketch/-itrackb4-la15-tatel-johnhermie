 LA14 – Locking the Front Door
 F1. Authentication and Authorisation

In my Book Portal, authentication lets the user register and login so the system knows who is using it. Authorisation is still what I need to learn next meeting, because it decides what each user is allowed to do after logging in.

F2. Session Regeneration

After I login successfully, I use `session()->regenerate()` to give my session a new ID. If I skip this, someone might reuse an old session ID and access my account through a session fixation attack.

 F3. Same Login Error Message

In my Book Portal, I use the same error message if the password is wrong or the email is not registered. This is better because strangers will not know if an email is really registered in my users table.

 F4. Public and Protected Book Pages

I keep the books list and book details public so visitors can still view the books even if they are not logged in. But adding, editing, updating, and deleting books are protected because only logged-in users should be able to change my book records.

 F5. Hiding Buttons Is Not Enough

I hide the Add, Edit, and Delete buttons when someone is not logged in, but this does not fully protect the pages because they can still type the URL directly in the browser. The `auth` middleware is what really blocks them and sends them to the login page.
 F6. The Login Route Name

In my screenshot 20, I changed the login route name to `signin` and Laravel showed `Route [login] not defined.` This happens because the `auth` middleware looks for a route named exactly `login` when a guest tries to open a protected page.