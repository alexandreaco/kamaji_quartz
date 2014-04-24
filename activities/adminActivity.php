<?php

	/*	adminActivity.php
	 *
	 *	Author: Alex Defreitas
	 *	Date: 4/22/2014
	 * 
	 */

	 
	 class AdminActivity {
	 
	 	// data members
	 	var $page;
	 	var $model;
	 	
	 	var $numActiveUsers;
	 	var $activeUserText;
	 	var $activeEmails;
	 	
	 	var $numValidUsers;
	 	var $validUserText;
	 	var $validEmails;
	 	
	 	var $recentActivityText;
	 
	 	var $server;
	 
	 	// constructor
	 	function __construct() {
	 		

	 		$this->model = new Model();
	 		$this->server = $this->model->getServer();

			session_start();
	 		if(!isset($_SESSION['timeout']) || $_SESSION['timeout'] + 10 < time()) {		//[AA.001]
	 			header("Location: $this->server/kamaji_quartz/login.php");
			}
			
	 		$this->page = new Page("Admin Dashboard");
	
	 		
	 	}
	 
	 
	 	// run
		function run() {
			
			$this->process();
			$this->show();
			
		}
	 
	 
	 	// get input
	 	function getInput() {
	 	
	 	}
	 	
	 	
	 	// process
	 	function process() {
	 		$this->retrieveActiveUsers();
	 		
	 		$this->retrieveValidUsers();
	 	
	 	}
	 	
	 	
	 	// show
	 	function show() {
	 	
	 		$this->page->beginDoc();
	 		
	 		// Title
	 		print "<h1 class='page_title'>User Administration Panel</h1>";
	 		
	 		// Active Users
	 		print($this->getActiveUsers());
				
			// Valid Users
			print($this->getValidUsers());
			
			// My Account
			print($this->getMyAccount());
			
			// Mail Server
			print($this->getMailServer());
			
			// Recent Activity
			print($this->getRecentActivity());
			
			// Backup User Data
			print($this->getBackupUserData());
			
			// Quartz Version
			print($this->getQuartzVersion());
 			
 	 		$this->page->endDoc();
 		
	 	
	 	}
	 	
	 	
	 	// Active Users
	 	private function getActiveUsers() {										//[AA.002]
	 	
			$count = 0;
			$this->activeUserText = "<div class='module active_users'>
				
				<h2 class='mod_title'>Active Users</h2>
			
				<table>
					<thead>
						<tr>
							<td class='email'>Email</td>
							<td class='last'>Last Access</td>
							<td class='reset'></td>
							<td class='x'></td>							
						</tr>
					</thead>
					<tbody>";
			
	 		while ($count < $this->numActiveUsers) {							//[AA.003]
	 			
	 			$email = $this->activeEmails[$count];
	 			$last = "1/1/2000";												//[AA.004]
	 			

	 			$newUserRow = "<tr>
							<td class='email'>$email</td>
							<td class='last'>$last</td>
							<!-- link to password reset screen with email address in GET array. Populate email field with this. -->
							<td class='reset'><a href='/Quartz/reset.php?$email' target='_blank'>reset password</a></td>
							<td class='x'><button type='submit' action='delete_email_from_active_users()' class='link_lookalike''>x</button>
						</tr>";
						
	 			$this->activeUserText .= $newUserRow;	
	 		 			
				$count++;
	 		}
	 		
	 		$this->activeUserText .= "</tbody>
				</table>
			
				<a href='/Quartz/register.php' class='button_link'>Add Users</a>
		
		
			</div> <!--/module-->";
			
			return $this->activeUserText;
	 	
	 	}
	 	
	 	// Model
	 	private function retrieveActiveUsers() {
	 	
	 		$allEmails = $this->model->getEmails();
	 		$this->activeEmails = explode(";", $allEmails); 						//[AA.005]
	 		
// 	 		$this->activeEmails = array("email@gmail.com", "email2@gmail.com", "email3@gmail.com");
// 	 		$this->numActiveUsers = count($this->activeEmails);
	 	

	 	}
	 	
	 	// Valid Users
	 	private function getValidUsers() {
	 		
	 		$count = 0;
	 		$this->validUserText = "<div class='module valid_users'>
							
				<h2 class='mod_title'>Valid Users</h2>
		
				<table>
					<thead>
						<tr>
							<td class='email'>Email</td>
							<td class='status'>Status</td>
							<td class='send'></td>
							<td class='x'></td>							
						</tr>
					</thead>
					<tbody id='validUserTable'>";
					
			while ($count < $this->numValidUsers) {
				
				$email = $this->validEmails[$count];
				//$status = $this->model->getStatus($email);
				$status = "active";
				
				$this->validUserText .= "<tr>
							<td class='email'>$email</td>
							<td class='status'>$status</td>
							<!-- Figure out how we are going to send the email -->
							<td class='send'><a href='/Quartz/send_email.php' target='_blank'>send email</a></td>
							<td class='x'><button type='submit' action='delete_email_from_valid_users()' class='link_lookalike'>x</button>
						</tr>";
				$count++;
			}
				
					
				$this->validUserText .= "</tbody>
				</table>
		
				<form>
					<input type='text' id='valid_email' />
					<!-- Use the model's function to add new user to the list -->
					<button type='button' onclick='addValidUser()' class='button' >Add User</button>
				</form>
	
	
			</div> <!--/module-->";
			
			return $this->validUserText;
	}

		// Model
		private function retrieveValidUsers() {
			$allEmails = $this->model->getEmails();
	 		$this->validEmails = explode(";", $allEmails); 
	 		
// 	 		$this->validEmails = array("email@gmail.com", "email2@gmail.com", "email3@gmail.com");
// 	 		$this->numValidUsers = count($this->validEmails);
		}
	 
	 	// My Account
	 	private function getMyAccount() {
	 		
			return "<div class='module my_account'>
				
				<h2 class='mod_title'>My Account</h2>
			
				<form>
					<!--use javascript to hide/unhide the input box. the form will always be there, it just won't be visible unless you click 'edit'-->
					<label for='username'>Username:</label>
					<p class='hidden_input' id='username' visible inline_padding'>John Keklak</p> 
					<input class='hidden' id='input' type='text' value='John Keklak' />
					<button type='button' onclick='edit_username()' class='link_lookalike' id='edit'>edit</button>
					
					<button type='button' onclick='save_username()' class='link_lookalike hidden' id='save'>save</button>					
				</form>
			
				<a href='/Quartz/reset.php?user1@gmail.com' target='_blank'>reset password</a>
		
		
			</div> <!--/module-->";
			
			
		}
		
		// Mail Server
		private function getMailServer() {							//[AA.006]
		
			return "<div class='module mail_server'>
				<h2 class='mod_title'>Mail Server</h2>
			
				<!-- check the correct way to write radio button links-->
				<form>
					<input type='radio' name='status' value='online' /><label for='online'>Online</label><br />
					<input type='radio' name='status' value='offline'/><label for='offline'>Offline</label>
				</form>
			
				<table>
					<thead>
						<tr>
							<td class='email'>Email</td>
							<td class='purpose'>Purpose</td>
							<td class='send'></td>
							<td class='x'></td>							
						</tr>
					</thead>
					<tbody>
						<!-- These <tr> blocks will be generated by Model code -->
						<tr>
							<td class='email'>user1@gmail.com</td>
							<td class='purpose'>account activation</td>
							<!-- Figure out how we are going to send the email -->
							<td class='send'><a href='/Quartz/send_email.php' target='_blank'>send email</a></td>
							<td class='x'><button type='submit' action='delete_message_from_email_queue()' class='link_lookalike'>x</button>
						</tr>
					</tbody>
				</table>
		
		
				</div> <!--/module-->";
		}
		
		// Recent Activity
		private function getRecentActivity() {
		
// 			$this->model->getRecentActivityEmails();
// 			
// 			$count = 0;
// 			
// 			$this->recentActivityText = "<div class='module recent_activity'>
// 				<h2 class='mod_title'>Recent Activity</h2>
// 			
// 				<table>
// 					<thead>
// 						<tr>
// 							<td class='email'>Email</td>
// 							<td class='action'>Action</td>
// 							<td class='date'>Date</td>							
// 						</tr>
// 					</thead>
// 					<tbody>";
// 			
// 			while ($count < 20) {
// 				
// 				$email = $this->model->getRecentActivity($count);
// 				
// 				$action = $this->model->getRecentAction($email);
// 				$date = $this->model->getRecentDate($email);
// 				
// 				$this->recentActivityText .= "<tr>
// 							<td class='email'$email</td>
// 							<td class='action'>$action</td>
// 							<td class='date'>$date</td>
// 						</tr>";
// 				
// 				$count++;
// 			}
// 			
// 			$this->recentActivityText .= "</tbody>
// 				</table>
// 			
// 				<h5>Viewing last 20 entries</h5>
// 		
// 		
// 			</div> <!--/module-->";
// 			
// 			
// 			return $this->recentActivityText;

				return "<table>recent emails go here</table>";
		}
		
		// Backup User Data
		private function getBackupUserData() {
			
			return "<div class='module backup_user_data'>
			
				<h2 class='mod_title'>Backup User Data</h2>			
					
					<form action='upload_file.php' method='post'
							enctype='multipart/form-data'>
							<input type='file' name='file' id='file'>
							<input type='submit' name='submit' value='Submit'>
					</form>
		
				</div> <!--/module-->";
		}
		
		// Quartz Version
		private function getQuartzVersion() {									//[AA.007]
			
			return "<div class='module Quartz_Version'>
			
				<!-- will the version number be hardcoded in? -->
				<h2 class='mod_title'>Quartz Version 2.0</h2>
			
			
				</div> <!--/module-->";
		}
		
		
	 
	 }


?>