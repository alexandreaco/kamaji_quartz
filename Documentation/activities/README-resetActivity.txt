//********README-resetActivity**********

- This file is written in PHP, with an HTML form for the user

- The purpose of this file is to allow the user to reset their
existing Quartz password with a new one, provided they are already
logged in.

- The user provides their email and their new password (which they confirm).

- If all goes well, the Model interface, via the method resetPassword(), sets
a new password for the user.

[ReA.001]

- This line of code changes the context to "activating". When this occurs, the program retrieves the
PHP GET variable "id" for later use. It also allows the user to access the Reset Password form.


[ReA.002]

- This line of code puts the program into the "submit" context, which takes the user's email AND password.
There is a distinction between "submit" and "submiT", which will be explained below.

[ReA.003]

- The submiT context is needed when the program has confirmed a user's email, but NOT their password.

[ReA.004]

- The "reset" context signifies that the process has been successful. This context eventually is used to
redirect the user to a confirmation message.

[ReA.005]

- The "showingform" context allows the user to see an HTML form with which to input their information.

[ReA.006]

- This variable gives the program a reference as to which account is currently operating.

[ReA.007]

- This chunk of code is used to check if the given email matches the one found on the Model. If so,
an id is created and used for a confirmation email.

[ReA.008]

- This Model function resets the password given an email and a new password.