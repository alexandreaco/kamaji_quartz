//********README-installActivity*************

- This file is written in PHP, with a large HTML form and explanation
of said form.

- The purpose of this file is to install a Quartz database in MySQL
onto the admin's computer.

- The file takes in a MySQL serverName, MySQL Root Password, adminName,
adminPassword, URL, subfolder, and a list of approved emails.

[INA.001]

- This line of code creates a path, which will be used to create 
"info.txt" in the assets folder.

[INA.002]

- The PHP function fopen, given a 'w' parameter, creates a file in the
given location (as described in [INA.001])

[INA.003]

- The PHP function fwrite, given a file and a string, will append the string
to the given file. In this case, it writes the user's information from the HTML
form to the file "info.txt"

[INA.004]

- The PHP function fclose closes the given file.
