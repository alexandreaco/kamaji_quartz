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
	 	var $title;
	 	
	 	
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
	 	private function getOpenHTML() {	
	 	
	 		$html ="<!doctype html>
							<html lang='en'>";
							
	 		return $html;
	 		
	 		
	 	}
	 	
	 	
	 	// get close HTML
	 	private function getCloseHTML() {
	 	
	 		$html = "</HTML>";

	 		return $html;
	 		
	 		
	 	}
	 	
	 	// get head	
	 	private function getHead() {		 	// requires a page title
	 	
	 		$html = "<head>
	 							<meta charset='utf-8'>
	 							
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
	 	private function getOpenBody() {
	 	
	 		$html = "<body>";
	 		
	 		return $html;
	 		
	 		
	 	}
	 	
	 	
	 	// get close Body
	 	private function getCloseBody() {
	 	
	 		$html = "</body>";

	 		return $html;
	 		
	 		
	 	}

	 
		// get begin content
		private function getBeginContent() {
		
			if ($this->title == "My Site") {	// My Site
			
				$html = "<div id='container'>
				<div id='header'></div>
				<div class='content mysite'>";
				
			} else {
				$html = "<div id='container'>
				<div id='header'>
					<div id='login_btn'><a href='login.php'>Login</a></div>
					</div>
				<div class='content'>";
			}
	 		
	 		return $html;
	 		
	 		
		}
		
		
		// get end content
		private function getEndContent() {
		
			$html = "</div><!-- /content-->
			<div id='footer'></div>
			</div><!-- /container -->";	

			return $html;
			
	 		
		 }



	 }


?>