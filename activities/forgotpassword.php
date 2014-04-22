<?php

echo "<head>";
echo "<link rel='stylesheet' type='text/css/' href='css/style.css' />";
echo "</head>";

echo "<body>";
echo "<div id='container'>
			<div id='header'></div>
		
			<div id='content'>";
			
			echo "<form name='input' action='forgotpassword.php' method='post' id='loginform'>";
				echo "Email: <input type='text' name='email'>";
				echo "<input type='submit' value='Submit'>";
			echo "</div>"; //Content Div
			echo "<div id='message' align='center'></div>";
			echo "<div id='footer'></div>";
			
	echo "</body>";
	
if (isset($_POST['email']))
{
	if ($_POST['email'] == "JILL@gmail.com")
	{
		echo "
			<script>
			document.getElementById('message').innerHTML = 'An email containing your password has been sent to the address you entered.';
			</script>";
		echo "CONTENTS OF EMAIL:<br>";
		echo "Here is your Quartz Password: JILLSPASSWORD<br>";
		echo "<a href='login.php'>Log-In to Quartz</a>";
	}
	else
	{
		echo "
			<script>
			document.getElementById('message').innerHTML = 'We\'re sorry. The account you entered isn\'t registered with Quartz.';
			</script>";
	}
}
?>