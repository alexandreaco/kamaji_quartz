function connect()

	This function connects to Quartz's master database and returns the connection.

	Input

		None

	Output

		returns a MySQL connection that can be used to perform MySQL operations.



function getAdminStatus()
	
	This function is used to discover if a given user has admin privileges

	Input

		String email - The email of the user whose admin status you want to check.

	Output

		Returns a String that specifies that admin status of the given user.  A '1' signifies that the user has admin privileges.  A '0' signifies that the user does not have admin privileges.



function createDatabase()

	This function creates a database.  Uses the information provided from the install page. Also creates a directory for the admin photos.
	
	Input

		String server - The name of the server where the MySql database will be created.

		String rootPass - The password for the root user of MySQL.  If input is a 0, createDatabase will use an empty string as the root password.

		String adminName - The username for the admin of Quartz.  The admins login information will be automatically entered into the database upon its creation.

		String adminPass - The password for the admin of Quartz.  The admins login information will be automatically entered into the database upon its creation.

		String emails - An initial list of emails approved to use Quartz by the Quartz admin. The input is a single string containing emails delimited by semicolons.

	Output

		None



function deleteDatabase()

	Deletes Quartz's master database. Used for uninstall.

	Input

		None

	Output

		None


function addEmail()

	Adds an email to a the list of approved users.

	Input

		String email - An email address that will be added to the list of emails approved to use Quartz.

	Output

		None



function removeEmail()

	Deletes a specified email from the list of approved emails.

	Input

		String email - An email address that will be removed from the list of emails approved to use Quartz. 

	Output

		None



function getEmails()

	Returns all approved emails as a string separated by ";"s

	Input

		None

	Output

		Returns a single string containing all approved emails in the database.  The emails are separated by semicolons.



function checkEmail()

	This function returns true if the email is approved by the admin and false if it is not.

	Input

		String email - The email to be checked against the list of approved emails.

	Output

		Returns a Boolean value specifying whether the given email is found in the list of approved emails.



function createUser()

	This function adds a new user to the database. This populates Job Title, Address, Telephone, Fax, Office Hours, Biography, Research, Publications, and Personal information with default copy.

	Input

		String name - The name of the user for the new account. 

		String email - The email of the user for the new account.

		String password - The password for the new account.

		String adminStatus - An input that represents the admin status of the user.  A '1' signifies that the user will have admin privileges and a '0' signifies that the user will not have admin privileges.

	Output

		None
		
		

function deleteUser()

	Deletes a user from the database. Uses the user's email address to identify the user in the table. 

	Input

		String email - The email of the user whose account is going to be deleted.

	Output

		None
		
		

function getName()

	This function returns the username associated with a Quartz account based on the specified email address.

	Input

		String email - email of the user whose name will be retrieved.

	Output

		Returns a String that contains the name of the user.



function getAllUsers()

	This function retrieves all user emails form the database. It returns them as a string of emails separated by semicolons

	Input

		None

	Output

		Returns a single String containing the emails of all registered users.  The emails are separated by semicolons.



function changeName()

	Changes the display name of a Quartz user. The function finds the user by matching the email address

	Input

		String email - Email of the user whose name will be changed.
		String newName - The new name of the user.

	Output

		None



function changeEmail()

	This function changes the email associated with the user and saves it in the database. This also updates the account name because it is based off of the email 

	Input

		String oldEmail - The old email of the user.  Will be user to look up the account information.

		String newEmail - The new email of the user.

	Output

		None
		
		

function changePassword()

	This function changes a user's password and updates it in the database. This is used when the user forgets their password and needs to create a new one.

	Input

		String email - The email of the user whose password will be changed.
		String newPassword - The new password of the user

	Output

		None
		
		

function addCourse()

	This function adds a course to the database. It requires a course name, url, and description.

	Input

		String email - Email of the user whose courese will be added
		String name - Name of the users course.
		String url - url the course's website.
		String description - Description of the users course

	Output

		Returns a boolean value that specifies whether or not the course was successfully added into the database.



function deleteCourse()

	This function deletes a course from the database.

	Input

		String name - Name of the course that will be deleted.

	Output

		None
		

function changeCourseTitle()

	This function changes the course title associated with a given course in the database.

	Input

		String email - The email of the user of the desired course.
		String course - The course name
		String newTitle - The new Title of the course.

	Output

		None

function changeCourseDescription()

	This functions changes the course description associates with a given course in the database.

	Input

		String email - The email of the user of the course.
		String course - The course name.
		String newDescription - The new Description of the course.

	Output

		None
		
		

function setJobtitle()

	This function saves the job title in the database associated with a Quartz user's email.

	Input

		String email - Email of the user.

		String title - The job title to be saved.

	Output

		None
		
		

function setAddress()

	This function saves the address in the database associated with a Quartz user's email.

	Input

		String email - The Email of the User.
		String address - The Address of the User.

	Output

		None



function setTelephone()

	This function saves the telephone number in the database associated with a Quartz user's email.

	Input

		String email - The Email of the User. 
		String telephone - The telephone number of the User.

	Output

		None



function setFax()

	This function saves the fax number in the database associated with a Quartz user's email.

	Input

		String email - The Email of the User. 
		String fax - The fax number of the User.

	Output

		None



function setOfficeHours()

	This function saves the office hours in the database associated with a Quartz user's email.
	
	Input

		String email - The Email of the User. 
		String officeHours - The Office Hours of the User.

	Output

		None



function setBiography()

	This function saves the biography field in the database associated with a Quartz user's email.

	Input

		String email - The Email of the User. 
		String biography - The Biography of the User.

	Output

		None



function setResearch()

	This function saves the research field in the database associated with a Quartz user's email.

	Input

		String email - The Email of the User.
		String research - The Research that the user has done.

	Output

		None



function setPublications()

	This function saves the publications field in the database associated with a Quartz user's email. This holds publications and awards.

	Input

		String email - The Email of the User. 
		String publications - The Publications that the user has had.

	Output

		None
		
		

function setPersonal()

	This function saves the personal information field in the database associated with a Quartz user's email.

	Input

		String email - The Email of the User. 
		String personal - Any personal information about the user.

	Output

		None
		

function getJobtitle()

	This function retrieves the job title for the email specified. If no user exists with the given email, it returns an empty string.

	Input

		String email - The Email of the User. 

	Output

		A String containing the Job Title of the User.  An empty String will be returned if no user is found.



function getAddress()

	This function retrieves the address for the email specified. If no user exists with the given email, it returns an empty string.

	Input

		String email - The Email of the User.

	Output

		A String containing the Address of the User.  An empty String will be returned if no user is found.



function getTelephone()

	This function retrieves the telephone number for the email specified. If no user exists with the given email, it returns an empty string.

	Input

		String email - The Email of the User.

	Output

		A String containing the Telephone number of the User.  An empty String will be returned if no user is found.



function getFax()

	This function retrieves the fax number for the email specified. If no user exists with the given email, it returns an empty string.

	Input

		String email - The Email of the User.

	Output

		A String containing the Fax number of the User.  An empty String will be returned if no user is found.



function getOfficeHours()

	This function retrieves the office hours for the email specified. If no user exists with the given email, it returns an empty string.

	Input

		String email - The Email of the User.

	Output

		A String containing the Office Hours of the User.  An empty String will be returned if no user is found.



function getBiography()

	This function retrieves the biography field for the email specified. If no user exists with the given email, it returns an empty string.

	Input

		String email - The Email of the User.

	Output

		A String containing the Biography of the User.  An empty String will be returned if no user is found.



function getResearch()

	This function retrieves the research field for the email specified. If no user exists with the given email, it returns an empty string.

	Input

		String email - The Email of the User.

	Output

		A String containing the user's Research.  An empty String will be returned if no user is found.



function getPublications()

	This function retrieves the publications field for the email specified. If no user exists with the given email, it returns an empty string.

	Input

		String email - The Email of the User.

	Output

		A String containing the user's publications.  An empty String will be returned if no user is found.



function getPersonal()

	This function retrieves the personal information field for the email specified. If no user exists with the given email, it returns an empty string.

	Input

		String email - The Email of the User.

	Output

		A String containing the user's personal information.  An empty String will be returned if no user is found.



function getAwards()

	This function retrieves the awards field for the email specified. If no user exists with the given email, it returns an empty string.

	Input

		String email - The Email of the User.

	Output

		A String containing the user's personal information.  An empty String will be returned if no user is found.



function setImage()

	This function saves a specified image path to the database and associates it with the given email.

	Input

		String image - An image that will be saved to a directory
		String email - The email of the user that will be linked to the image.

	Output
	
	

function getImage()

	This function retrieves the path to an image associated with the given email

	Input

		String email - The email of the user that owns the image.

	Output
	
		A string relative path that points to the user's photo.
	
	
		
function checkCredentials()

	This function makes sure that the user provided valid credentials. First is makes sure that the email is associated with an account, and then checks the password.

	Input

		String email - The user's email address
		String pass -  The user's password

	Output


function storeRegistrationData()

	This function stores the registration data for a user but does not validate the account. It mades a registration id to be used when comparing with the registration email

	Input

		String name - Name of the user to be created.
		String email - Email of the user that will be created.
		String password - Password of the user that will be created. 

	Output
	
	

function activateAccount()

	This function activates a users account if the id provided is valid. It returs 1 if it is successfully activated, or 0 if it isn't

	Input

		String id - Id given by storeRegistrationData().  It is used to retrieve the registration information stored in the database.

	Output



function storeEmail()

	This function adds a user to the registration table. It stores their email and a regid

	Input

		String email - email that will be stored in the database.  It will be retrieved when the password gets reset.

	Output
	
		Returns an md5 hash of the email as a string



function resetPassword()

	This function resets a user's password	

	Input

		String id - The id provided by storeEmail().  This id will be used to look up the information required to reset the users password.

		String password - The new password for the user.

	Output
	
		Returns a 1 if the input username was valid and 0 if it was not.



function getCourses()

	This function accepts the Quartz user's email and returns a string containing all course names associated with that user.

	Input

		String email - The email of the user whose courses will be retrieved

	Output
	
		Returns an empty string if no courses exist or a string containing all course names separated by a semicolon
		
		
function getCourseDescription()

	This function accepts a Quartz user's email and course name and returns the course description 
	
	Input
		
		String email - The email of the Quartz user whose page you are viewing
		
		String course - the name of the course 
	
	Output
	
		Returns empty string if no course exist or a string containing the description.
		

function getCourseURL()

	This function accepts a Quart'z user's email and course name and returns the course URL
	
	Input
		
		String email - The email of the Quartz user whose page you are viewing
		
		String course - String course - the name of the course 
		
	Output
		
		Returns empty string if no course exist or a string containing the URL.
		
		
function getCourseTitle() 

	This function accepts a Quart'z user's email and course name and returns the course title
	
	Input
		
		String email - The email of the Quartz user whose page you are viewing
		
		String course - String course - the name of the course 
		
	Output
		
		Returns empty string if no course exist or a string containing the title.
		

function getServer()

	This function returns the server that the user chose upon installation.
	
	Input
		
	Output
		
		Returns a string containing the root of the website
		

function getSubFolder() 

	This function returns the subfolder that the user chose upon installation.
	
	Input
	
	Output
		
		Returns a string containing the subfolder containing the website
		
		