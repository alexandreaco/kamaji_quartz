//********README-uninstallActivity************

- The uninstall function is written in PHP with an HTML form for the user

- The user is greeted by a large block of text, asking the user to backup
their data and confirm that they want Quartz deleted. All the user has to do
is click Yes or No.

[UNA.001]

- This Model function takes no input. If the Quartz database exists on the computer,
MySQL drops it. Its as simple as that.
- Also: if assets/profpics (the folder that holds user pictures) exists, it is 
deleted.

[UNA.002]

- This line of code removes info.txt from the folder system. This is the file that holds
such information as the MySQL Database Name, local server name, etc.