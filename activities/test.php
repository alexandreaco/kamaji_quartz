<?php

	/*	test.php
	 *
	 *	Author: 
	 *	Date:
	 * 
	 */
	 
	 
	 include_once '../assets/page.php';
	 
	 $page = new Page("test page");
	 
	 $page->beginDoc();
	 
	 print("<p>lots of content here!</p>");
	 
	 $page->endDoc();


?>