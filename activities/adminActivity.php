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
	 
	 
	 	// constructor
	 	function __construct() {
	 		
	 		$this->model = new Model();
	 		
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
	 	private function getActiveUsers() {
	 		
	 		return "<div class='module active_users'>
				
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
					<tbody>
						<!-- These <tr> blocks will be generated by Model code -->
						<tr>
							<td class='email'>user1@gmail.com</td>
							<td class='last'>3/15/2014</td>
							<!-- link to password reset screen with email address in GET array. Populate email field with this. -->
							<td class='reset'><a href='/Quartz/reset.php?user1@gmail.com' target='_blank'>reset password</a></td>
							<td class='x'><button type='submit' action='delete_email_from_active_users()' class='link_lookalike''>x</button>
						</tr>
					</tbody>
				</table>
			
				<a href='/Quartz/register.php' class='button_link'>Add Users</a>
		
		
			</div> <!--/module-->";
	 	
	 	}
	 	
	 	// Valid Users
	 	private function getValidUsers() {

			return "<div class='module valid_users'>
							
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
					<tbody>
						<!-- These <tr> blocks will be generated by Model code -->
						<tr>
							<td class='email'>user1@gmail.com</td>
							<td class='status'>active</td>
							<!-- Figure out how we are going to send the email -->
							<td class='send'><a href='/Quartz/send_email.php' target='_blank'>send email</a></td>
							<td class='x'><button type='submit' action='delete_email_from_valid_users()' class='link_lookalike'>x</button>
						</tr>
					</tbody>
				</table>
		
				<form>
					<input type='text' id='valid_email' />
					<!-- Use the model's function to add new user to the list -->
					<button type='submit' class='button' action='add_user_email_to_list_of_valid_users()'>Add User</button>
				</form>
	
	
			</div> <!--/module-->";
}
	 
	 	// My Account
	 	private function getMyAccount() {
	 		
			return "<div class='module my_account'>
				
				<h2 class='mod_title'>My Account</h2>
			
				<form>
					<!--use javascript to hide/unhide the input box. the form will always be there, it just won't be visible unless you click 'edit'-->
					<label for='username'>Username</label>
					<p class='hidden_input visible inline_padding'>John Keklak</p> 
					<input class='hidden' type='text' value='John Keklak' />
					<button type='submit' action='edit_username()' class='link_lookalike'>edit</button>
				</form>
			
				<a href='/Quartz/reset.php?user1@gmail.com' target='_blank'>reset password</a>
		
		
			</div> <!--/module-->";
			
			
		}
		
		// Mail Server
		private function getMailServer() {
		
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
			
			return "<div class='module recent_activity'>
				<h2 class='mod_title'>Recent Activity</h2>
			
				<table>
					<thead>
						<tr>
							<td class='email'>Email</td>
							<td class='action'>Action</td>
							<td class='date'>Date</td>							
						</tr>
					</thead>
					<tbody>
						<!-- These <tr> blocks will be generated by Model code -->
						<tr>
							<td class='email'>user1@gmail.com</td>
							<td class='action'>edited course content</td>
							<td class='date'>3/15/2014</td>
						</tr>
					</tbody>
				</table>
			
				<h5>Viewing last 20 entries</h5>
		
		
			</div> <!--/module-->";
		}
		
		// Backup User Data
		private function getBackupUserData() {
			
			return "<div class='module backup_user_data'>
			
				<h2 class='mod_title'>Backup User Data</h2>
			
				<form>
					<!--use javascript to hide/unhide the input box. the form will always be there, it just won't be visible unless you click 'edit'-->
					<button action='select_file_location_from_computer'>Browse</button>
					<!-- use javascript to change the content of this <p>tag to show the destination that the user selected-->
					<p class='hidden_input visible inline_padding'>Choose Destination</p> 
					<!-- use model function to backup all data-->
					<button type='submit' action='backup_user_data()'>Backup</button>
				</form>
		
		
				</div> <!--/module-->";
		}
		
		// Quartz Version
		private function getQuartzVersion() {
			
			return "<div class='module Quartz_Version'>
			
				<!-- will the version number be hardcoded in? -->
				<h2 class='mod_title'>Quartz Version 2.0</h2>
			
			
				</div> <!--/module-->";
		}
	 
	 }


?>