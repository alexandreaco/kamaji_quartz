//********README-mymanageAJAXHelper**********

- The purpose to the 'mymanageAJAXHelper' file is to
allow the 'mymanageActivity' page's JavaScript to communicate
with the PHP-coded Model.

- The entire file is written in PHP, and it uses POST variables
to access user information.

- The only time this file is called and executed is during the
"saveChanges()" JavaScript function in 'mymanageActivity.php'.

Input:
username, jobtitle, address, telephone, fax, officehours, biography,
research, publications, personalinfo
- all of which are provided through $_POST[].

Output:
"Welcome, <user>".
- The purpose of this line is to communicate to the original page
('mymanage') that the AJAXHelper file was successful.
- The AJAXHelper sets every given variable to the Model interface.

[MMAH.001]
- These lines take $_SESSION variables submitted by 'mymanageActivity.php' and communicates
to the model using a 'set()' function. This allows a user to set their personal
information.

[MMAH.002]
- This line of code gives the AJAX caller in 'mymanageActivity' some response text.
To the user, it will appear as if nothing has happened; The "Welcome" message
at the top of the page is reprinted. However, this code is essentially used for upkeep
purposes. If this line goes off as expected, it means that communication with the Model
was successful.
