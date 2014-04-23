//********README-registerActivity********

- The purpose of this file is to allow the user to register for a Quartz account,
provided that they give an email address that has been pre-approved for an account.

- This file is written in PHP, and prints an HTML form for the user.

- The user must provide a name, email address, and a password (which must be confirmed).

- This file is called by 'register.php'



function __construct():

Input: None
Output: None

- The constructor creates new Model and Page objects, and checks the current context.

function run():

Input: None
Output: None

- The run() function calls getInput(), process(), and show().

function getInput():

Input: None
Output: None

- The getInput() function first checks the context.
- If the context = "submitting", then the function takes the name, email, and
two passwords from the HTML form (submitted via POST). These variables are stored
globally for access later in the "process()" function.
- If the context = "activating", the function takes a registration id via GET.

function process():

Input: None
Output: None

- For the submission context, the function first checks whether the desired email
has been approved for a Quartz account. Upon a successful check, the function checks
whether the two entered passwords match each other. If so, then the initial part of the
registration is considered a success.
	- If either of the two above tests fails, the the function outputs an error message by
	setting the "emptyFlag" variable to an appropriate message (see show() for details).
- When the tests are passed, the name, email, and password are passed to the Model via the
function "storeRegistrationData(name,email,password)", which returns a registration id. Then,
that id is passes to the function "generateConfirmationEmail(id)".

- For the "activation" context, the function makes one final validation check with the Model.
If this checked is passed, the user is sent to the login screen (via login.php).

function show():

Input: None
Output: None

- After setting the initial HTML via the Page Object, the function checks the context.
-For the submission context, the function checks the "emptyFlag" variable for an error.
If an error is detected, the function prints out an error message to an HTML Div at the
top of the screen. Either way, the Four-field form (name, email, and two passwords) is 
printed.

- For the "submitting" context, the page informs the user that a confirmation email has been sent.

- For the "activating" context, the page gives the user a confirmation message and a link to the
login page.

function generateConfirmationEmail($id):

Input: $id
Output: None

- The function takes the entered email address, and using the mail function, sends an email with a
link to the registration page. This link contains $id as a GET variable. The link sends the user
to the "confirmation page" version of register.php.

[RA.001]
- This line of code refers to the PHP GET variable "activate", which is created in the
confirmation email (see function generateConfirmationEmail($id)). This line of code
allows the program to switch the context to "activating", which is used to finalize the process.

[RA.002]
- The Model function here takes the name, email, and password, and returns an id number, which is
used for further validation.

[RA.003]
- The Model is called to further validate the given information.

[RA.004]
- This HTML div is used to display error messages generated in the function process(). This branch
is avoided if the "emptyFlag" variable hasn't been set (i.e. No errors encountered).







