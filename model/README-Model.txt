function connect()

	Input

		None

	Output

		returns a MySQL connection that can be used to perform MySQL operations.

function getAdminStatus()

	Input

		String email - The email of the user whose admin status you want to check.

	Output

		Returns a String that specifies that admin status of the given user.  A '1' signifies that the user has admin privileges.  A '0' signifies that the user does not have admin privileges.

function createDatabase()

	Input

		String server - The name of the server where the MySql database will be created.

		String rootPass - The password for the root user of MySQL.  If input is a 0, createDatabase will use an empty string as the root password.

		String adminName - The username for the admin of Quartz.  The admins login information will be automatically entered into the database upon its creation.

		String adminPass - The password for the admin of Quartz.  The admins login information will be automatically entered into the database upon its creation.

		String emails - An initial list of emails approved to use Quartz by the Quartz admin. The input is a single string containing emails delimited by semicolons.

	Output

		None

function deleteDatabase()

	Input

		None

	Output

		None

function addEmail()

	Input

		String email - An email address that will be added to the list of emails approved to use Quartz.

	Output

		None

function removeEmail()

	Input

		String email - An email address that will be removed from the list of emails approved to use Quartz. 

	Output

		None

function getEmails()

	Input

		None

	Output

		Returns a single string containing all approved emails in the database.  The emails are separated by semicolons.

function checkEmail()

	Input

		String email - The email to be checked against the list of approved emails.

	Output

		Returns a Boolean value specifying whether the given email is found in the list of approved emails.

function createUser()

	Input

		String name - The name of the user for the new account. 

		String email - The email of the user for the new account.

		String password - The password for the new account.

		String adminStatus - An input that represents the admin status of the user.  A '1' signifies that the user will have admin privileges and a '0' signifies that the user will not have admin privileges.

	Output

		None

function deleteUser()

	Input

		String email - The email of the user whose account is going to be deleted.

	Output

		None

function getName()

	Input

		String email - email of the user whose name will be retrieved.

	Output

		Returns a String that contains the name of the user.

function getAllUsers()

	Input

		None

	Output

		Returns a single String containing the emails of all registered users.  the emails are separated by semicolons.

function changeName()

	Input

		String email - Email of the user whose name will be changed.
		String newName - The new name of the user.

	Output

		None

function changeEmail()

	Input

		String oldEmail - The old email of the user.  Will be user to look up the account information.

		String newEmail - The new email of the user.

	Output

		None

function changePassword()

	Input

		String email - The email of the user whose password will be changed.
		String newPassword - The new password of the user

	Output

		None

function addCourse()

	Input

		String email - Email of the user whose courese will be added
		String name - Name of the users course.
		String title - Title of the users course.
		String description - Description of the users course

	Output

		Returns a boolean value that specifies whether or not the course was successfully added into the database.

function deleteCourse()

	Input

		String name - Name of the course that will be deleted.

	Output

		None

function changeCourseTitle()

	Input

		String email - The email of the user of the desired course.
		String course - The course number (i.e. 'CS411').
		String newTitle - The new Title of the course.

	Output

		None

function changeCourseDescription()

	Input

		String email - The email of the user of the course.
		String course - The course number (i.e. 'CS411').
		String newDescription - The new Description of the course.

	Output

		None

function setJobtitle()

	Input

		String email - Email of the user.

		String title - The title of the user.

	Output

		None

function setAddress()

	Input

		String email - The Email of the User.
		String address - The Address of the User.

	Output

		None

function setTelephone()

	Input

		String email - The Email of the User. 
		String telephone - The telephone number of the User.

	Output

		None

function setFax()

	Input

		String email - The Email of the User. 
		String fax - The fax number of the User.

	Output

		None

function setOfficeHours()

	Input

		String email - The Email of the User. 
		String officeHours - The Office Hours of the User.

	Output

		None

function setBiography()

	Input

		String email - The Email of the User. 
		String biography - The Biography of the User.

	Output

		None

function setResearch()

	Input

		String email - The Email of the User.
		String research - The Research that the user has done.

	Output

		None

function setPublications()

	Input

		String email - The Email of the User. 
		String publications - The Publications that the user has had.

	Output

		None

function setPersonal()

	Input

		String email - The Email of the User. 
		String personal - Any personal information about the user.

	Output

		None

function getJobtitle()

	Input

		String email - The Email of the User. 

	Output

		A String containing the Job Title of the User.  An empty String will be returned if no user is found.

function getAddress()

	Input

		String email - The Email of the User.

	Output

		A String containing the Address of the User.  An empty String will be returned if no user is found.

function getTelephone()

	Input

		String email - The Email of the User.

	Output

		A String containing the Telephone number of the User.  An empty String will be returned if no user is found.

function getFax()

	Input

		String email - The Email of the User.

	Output

		A String containing the Fax number of the User.  An empty String will be returned if no user is found.

function getOfficeHours()

	Input

		String email - The Email of the User.

	Output

		A String containing the Office Hours of the User.  An empty String will be returned if no user is found.

function getBiography()

	Input

		String email - The Email of the User.

	Output

		A String containing the Biography of the User.  An empty String will be returned if no user is found.

function getResearch()

	Input

		String email - The Email of the User.

	Output

		A String containing the user's Research.  An empty String will be returned if no user is found.

function getPublications()

	Input

		String email - The Email of the User.

	Output

		A String containing the user's publications.  An empty String will be returned if no user is found.

function getPersonal()

	Input

		String email - The Email of the User.

	Output

		A String containing the user's personal information.  An empty String will be returned if no user is found.

function setImage()

	Input

		String image - An image that will be saved to a directory
		String email - The email of the user that will be linked to the image.

	Output

function getImage()

	Input

		String email - 

	Output

function checkCredentials()

	Input

		String email - 
		String pass - 

	Output

function storeRegistrationData()

	Input

		String name - Name of the user to be created.
		String email - Email of the user that will be created.
		String password - Password of the user that will be created. 

	Output

function activateAccount()

	Input

		String id - Id given by storeRegistrationData().  It is used to retrieve the registration information stored in the database.

	Output

function storeEmail()

	Input

		String email - email that will be stored in the database.  It will be retrieved when the password gets reset.

	Output

function resetPassword()

	Input

		String id - The id provided by storeEmail().  This id will be used to look up the information required to reset the users password.

		String password - The new password for the user.

	Output

function getCourses()

	Input

		String email - The email of the user whose courses will be retrieved

	Output