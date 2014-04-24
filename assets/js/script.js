
/*	script.js
 *
 *	Author: @alexandreaco
 *	Date: 4/22/2014
 * 
 */
 

// For Admin Activity

	function addValidUser() {

		var email = document.getElementById('valid_email').value;
		var status = 'pending';
		var table = document.getElementById('validUserTable');
		var row = table.insertRow(0);
	
		var cellEmail = row.insertCell(0);
		var cellStatus = row.insertCell(1);
		var cellSend = row.insertCell(2);
		var cellX = row.insertCell(3);
	
		cellEmail.innerHTML = email;
		cellStatus.innerHTML = status;
		cellSend.innerHTML = "<a href='/Quartz/send_email.php' target='_blank'>send email</a>";
		cellX.innerHTML = "<button type='submit' action='delete_email_from_valid_users()' class='link_lookalike'>x</button>";

		cellEmail.className += 'email';
		cellStatus.className += 'status';
		cellSend.className += 'send';
		cellX.className += 'x';
	
		// AJAX to add valid user
		var sender = 'email=' + email + '&&status=' + status;
		var xmlhttp;

		if (window.XMLHttpRequest) {
			
			xmlhttp=new XMLHttpRequest();

		}
		
		xmlhttp.open('POST','activities/adminAJAX_addUser.php',true);
		xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlhttp.send(sender);
	}
		

// For Admin Activity

	function edit_username() {
		document.getElementById('input').style.display='inline';
		document.getElementById('save').style.display='inline';
		document.getElementById('username').style.display='none';
		document.getElementById('edit').style.display='none';
	}
	
// For Admin Activity

	function save_username() {
		document.getElementById('input').style.display='none';
		document.getElementById('save').style.display='none';
	
		var newName = document.getElementById('input').value;
		document.getElementById('username').innerHTML = newName;
	
		document.getElementById('username').style.display='inline-block';
		document.getElementById('edit').style.display='inline';
	
		var sender = 'email=email newname=newName';
		var xmlhttp;

		if (window.XMLHttpRequest) {
			xmlhttp=new XMLHttpRequest();

		}

		xmlhttp.onreadystatechange=function() {
			
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				document.getElementById('welcome_title').innerHTML=xmlhttp.responseText;
			}
			
		}
		
		xmlhttp.open('POST','activities/adminAJAX_saveUsername.php',true);
		xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlhttp.send(sender);
	}
