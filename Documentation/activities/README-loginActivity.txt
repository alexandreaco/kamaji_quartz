//********README-loginActivity*********

- This page is used to Log the user into their Quartz account. It checks to see
if their name and password match. If so, they are allowed access.

- This page is written in PHP, with an HTML form for the user.

- It accesses a Model object to communicate indirectly with the Database.



[LA.001]

- This line of code refers to the "submission" context. When the user enters an input for both the name
and password field, this context allows the program to validate the login. The run() function will then
access "getInput()" and alter the global variables for name and password. THe process function then uses
the model to check if the login is valid.

[LA.002]

- After the user has submitted a name and password, this line of code passes said name and password to the Model
interface, where the database will either confirm or deny access.

[LA.003]

- This line of code creates the SESSION variable "id". This variable is created to allow the other activities
(i.e. "MyManage") to know which user is currently using Quartz.

[LA.004]

- THis line of code checks whether the user is a regular Quartz user or a Quartz admin. 
This check is performed by the Model Interface. If the user is an admin, they are redirected to "admin.php".
If not, they are directed to "mymanage.php".

[LA.005]

- This HTML Div is used for printing error messages (for example, the user enters the incorrect password).
