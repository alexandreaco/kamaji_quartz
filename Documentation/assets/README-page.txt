//********README-Page************

- This file is written in PHP, but it methods return HTML tags
for use by the Activity Functions.

- This file is located in the assets folder of Quartz.

- "Page" is instantiated as an Object within every Activity Page in Quartz.

- The public "Page" functions are used to make HTML formatting easier.

function beginDoc():

	Input: None
	Output: prints openHTML, getHead, openBody, getBeginContent
	
	- The beginDoc() function returns a large block of HTML which includes the intro HTML
	tag, a selection of CSS stylesheets, body tags, and a special HTML Div for the "Container" Class.
	- It is called at the start of every "show()" function in every Activity Class.

function endDoc():

	Input: None
	Output: prints getEndContent, getCloseBody, closeHTML
	
	- The endDoc() function returns a large block of HTML which included the end of the "Container"
	Class HTML Div, the end of the body tag, and the HTML close tag.
	- It is called at the end of every "show()" function in every Activity Class.
	
	
[PG.001]

- The global variable "title" is used to hold the title of the requested HTML page. This title is
eventually stored in the head of the HTML. It is also occasionally used to generate a special set
of HTML divs for special pages like "My Site" and "My Manage".

[PG.002]

- The getOpenHTML function returns the necessary <html> tag.

[PG.003]

- The getCloseHTML function returns the necessary </html> tag.

[PG.004]
	
- The getHead function gives the page a title, imports CSS style-sheets from the assets folder,
and imports JavaScript script from the assets folder.

[PG.005]

- The function returns a <body> tag.

[PG.006]	
	
- The function returns a </body> tag.

[PG.007]
	
- Depending on the given Page Title, the function returns a speciality set of
HTML Div tags.
- The MySite Page gets a MyManage link and logout button.
- The MyManage Page gets a logout button.
- Every other page gets a Login/Logout button
- All pages get a class="content" HTML Div

[PG.008]
	
- The function ends the content div, creates a footer, and ends the container div.
	
	
	
	
	
	
	