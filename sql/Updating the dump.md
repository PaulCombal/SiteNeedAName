If ever you need to update this dump, here's the way I always do it.

* Open MySQL Workbench
* Data Export
* Select Structure only
* Check "Include funtions and stored procedures"
* Check "Include create schema"
* Check "Create dump in single Transaction"

I used to work with PHPMyAdmin in the past on previous projects, and the dumps were terrible. I have no idea how different they are now, but I would recommend
always using MySQL Workbench for better compatibility.