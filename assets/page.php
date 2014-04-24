<?php

	/*	page.php
	 *
	 *	Author: @alexandreaco
	 *	Date: 4/10/2014
	 *	
	 *	Notes: This document returns HTML code that will be duplicated across many
	 *		.php files within the project. 
	 *
	 *	Public Functions:
	 *		beginDoc() 
	 *		endDoc()
	 * 
	 */
	 
	 
	 class Page {
	 	
	 	// data members
	 	var $title;											//[PG.001]
	 	
	 	
	 	// constructor
	 	function __construct($title) {
	 	
	 		$this->title = $title;
	 		
	 		
	 	}
	 	
	 	
	 	// begin doc PUBLIC
	 	public function beginDoc() {
	 	
	 		print($this->getOpenHTML());
	 		
	 		print($this->getHead());
	 		
	 		print($this->getOpenBody());
	 		
	 		print($this->getBeginContent());
	 		
	 		
	 	}
	 	
	 	
	 	// end doc PUBLIC
	 	public function endDoc() {
	 	
	 		print($this->getEndContent());
	 	
	 		print($this->getCloseBody());
	 		
	 		print($this->getCloseHTML());
	 	
	 	}
	 	
	 
	 	
	 	// get Open HTML
	 	private function getOpenHTML() {					//[PG.002]
	 	
	 		$html ="<!doctype html>
							<html lang='en'>";
							
	 		return $html;
	 		
	 		
	 	}
	 	
	 	
	 	// get close HTML
	 	private function getCloseHTML() {					//[PG.003]
	 	
	 		$html = "</HTML>";

	 		return $html;
	 		
	 		
	 	}
	 	
	 	// get head	
	 	private function getHead() {		 	// requires a page title				//[PG.004]
	 	
	 		$html = "<head>
	 							<meta charset='utf-8'>
	 							
	 							<!--Javascript-->
	 							<script src='assets/js/script.js'></script>
	 							
								<!--Stylesheet-->
								<link rel='stylesheet' href='assets/css/style.css'>
								<link rel='stylesheet' href='assets/css/layout.css'>
								
								<link rel='stylesheet' href='assets/css/my_site.css'>
								<link rel='stylesheet' href='assets/css/admin_mymanage.css'>	
								<link rel='stylesheet' href='assets/css/login.css'>							
				
								<title>$this->title</title>
			
							</head>";
							
			return $html;
	 	
	 	
	 	}
	 	
	 	
	 	// get open body
	 	private function getOpenBody() {						//[PG.005]
	 	
	 		$html = "<body>";
	 		
	 		return $html;
	 		
	 		
	 	}
	 	
	 	
	 	// get close Body
	 	private function getCloseBody() {							//[PG.006]
	 	
	 		$html = "</body>";

	 		return $html;
	 		
	 		
	 	}

	 
		// get begin content
		private function getBeginContent() {						//[PG.007]
		
			if ($this->title == "My Site") {	// My Site
			
				$html = "<div id='container'>
				<div id='header'>
					<div id='login_btn'>
						<a href='mymanage.php'>My Manage</a>
						<a href='login.php?logout'>Logout</a>
					</div>
				</div>
				<div class='content mysite'>";
				
			} elseif ($this->title == "My Manage") {
			
				$html = "<div id='container'>
				<div id='header'>
					<div id='login_btn'>
						<a href='mysite.php'>View My Site</a>
						<a href='login.php?logout'>Logout</a>
					</div>
				</div>
				<div class='content'>";
			
			} else {
				$html = "<div id='container'>
				<div id='header'>
					<div id='login_btn'><a href=login.php'>Login</a>
						<a href='login.php?logout'>Logout</a></div>
					</div>
				<div class='content'>";
			}
	 		
	 		return $html;
	 		
	 		
		}
		
		
		// get end content
		private function getEndContent() {					//[PG.008]
		
			$html = "</div><!-- /content-->
			<div id='footer'></div>
			</div><!-- /container -->";	

			return $html;
			
	 		
		 }



	 }


?>