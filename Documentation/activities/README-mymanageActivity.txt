//********README-mymanageActivity.php*********

- This file is written in PHP, though most of its functionality
occurs through JavaScript. The user sees a large HTML screen/form,
and there's some AJAX functionality thrown in for the function
"saveChanges()" (see below).

- This file is called by "mymanage.php", which creates a
MyManageActivity Object (which is found in this file) and runs it.

Function List:

function __construct():

Input: None
Output: None

- The constructor of the MyManageActivity Object starts a Session, creates Model
and Page objects, and sets the global context to "showingform".


function run():

Input: None
Output: None

- The run() method calls process() and show().

function getInput():

Input: None
Output: None

function process():

Input: None
Output: None

- If the context = "showingform", then the function accesses the Model and sets
The global variables for a professor's set of information. This information is later
used to fill the form in show().

function show():

Input: None
Output: None (Shows an HTML form).

- The show() function displays a large block of HTML code (styled with CSS). The HTML also
accesses Global PHP variables filled from the process() function.

- The function also spits out a series of JavaScript functions to help the user edit and save
information. These functions and their purposes are listed below.


		function showResearchEdit():

		Input: None
		Output: None

		- Simply displays the hidden text field for the Research Area.

		function showPublicationsEdit():

		Input: None
		Output: None

		- Simply displays the hidden text field for the Publications Area.

		function showPersonalInfoEdit():

		Input: None
		Output: None

		- Simply displays the hidden text field for the PersonalInformation Area.

		function showCourseEdit():

		Input: None
		Output: None

		- Simply displays the hidden text field for the two Course Edit Areas.
		- Also hides the "finalized" versions of the Course Information Boxes.

		function saveChanges():

		Input: None
		Output: None

		- The saveChanges() function first concatenates the user's information as entered
		into the HTML form. The resulting string is of the form "user=XXXX&&jobtitle=XXX&&...".
		The large string is passed through an AJAX function ('mymanageAJAXHelper.php') which
		sends this information to the Model to be stored.
		
The code in the show() function is sandwiched by the beginDoc() and endDoc() HTML from the
Page Object (see 'Page' documentation for more information).



