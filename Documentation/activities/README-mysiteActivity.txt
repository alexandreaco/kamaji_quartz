//********README-mysiteActivity*************

- This file is written in PHP, using SESSION variables and some HTML for the user.

- The purpose of this file is to allow the user to "View" a Quartz Page.
This page lists a professor's general information, teaching information,
research, publications, and personal information. The user can access this information
through the aide of the "Navigation Side Bar."

- When the user clicks a link in the side bar, the page reloads with the desired information
appearing in the main portion of the page.

[MSA.001]

- This portion of code deals with a PHP SESSION.
- If the user has spent too much time without performing an action
(i.e. Refreshing the Page), the program will redirect to the login page to
ensure that it is still the same user accessing the page.

[MSA.002]

- To determine the information the user is shown, the program makes the use of
PHP GET variables. If a certain variable is set, the representative information is loaded
to the page.

[MSA.003]

- This line prepares the user email from the SESSION variable into a usable form. The email
is preceded by a giant mess of special characters, and the preg_replace function gets rid
of them.

[MSA.004]

- The user's email is stored in the PHP $_SESSION['id'] variable. By accessing this
variable, we can make a Model Interface reference to get user information.
This block of code repeats the process of getting the user email via SESSION and
referencing the Model Object.

[MSA.005]

- The PHP "explode" function takes a large String and creates an array of substrings,
all separated by a delimiter. In this case, it takes the list of courses and separates
them at every instance of a semicolon (;).

[MSA.006]

- The PHP "count" function counts the total number of elements in the array. The program
uses this amount to iterate through each course.

[MSA.007]

- For every instance of a course, the while loop takes a course url, title, and description.
Once all three have been taken, the loop prints out an HTML div with that information.
The cycle repeats.

[MSA.008]

- The given code prints out the Navigation Side Bar.
This sidebar has links to the same page, but with different GET variables.
These variables are accounted for in the constructor to load the desired information
(see [MSA.002])
