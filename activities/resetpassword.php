<?php

include_once 'modelstub.php';

$model = new ModelStub();

echo "<head>";
echo "<link rel='stylesheet' type='text/css/' href='css/style.css' />";
echo "</head>";

echo "<body>";
echo "<div id='container'>
			<div id='header'></div>
		
			<div id='content'>";
			
			echo "<form name='input' action='resetpassword.php' method='post' id='loginform'>";
				echo "Email: <input type='text' name='email'><br>";
				echo "Enter New Password: <input type='password' name='newpassword'><br>";
				echo "Confirm New Password: <input type='password' name='newpassword2'><br>";
				echo "<input type='submit' value='Submit'>";
			echo "</div>"; //Content Div
			echo "<div id='message' align='center'></div>";
			echo "<div id='footer'></div>";
			
	echo "</body>";
	
if (isset($_POST['email']))
{
	if ($_POST['email'] == "JILL@gmail.com" && $model->isValidLoginName($_POST['email']))
	{
		if (isset($_POST['newpassword']) && isset($_POST['newpassword2']))
		{
			if ($_POST['newpassword'] == $_POST['newpassword2'] && ($_POST['newpassword'] != "" ))
			{
				if ($model->setNewPassword($_POST['email'],$_POST['newpassword']))
				{
					echo "
						<script>
						document.getElementById('message').innerHTML = 'Your new password has been set.';
						</script>";
				}
			}
			else
			{
				echo "
					<script>
					document.getElementById('message').innerHTML = 'The passwords you entered do not match.';
					</script>";
			}
		}
		else
		{
			echo "
			<script>
			document.getElementById('message').innerHTML = 'Please enter a password and confirm it.';
			</script>";
		}
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