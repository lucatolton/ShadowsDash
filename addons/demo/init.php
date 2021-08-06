<?php
// Demonstration of what does an init.php file looks like.

// (1). Include the things you need:
#require("../../require/navbar.php"); // If you require to edit the navbar. Usage to add item to the navbar: $_NAVBAR[] = array("icon" => "font awesome icon", "text" => "text for the item", "link" => "link on click");
#require("../../require/sql.php"); // If you require a connection to the database. The $cpconn variable is a MySQLi object.
#require("../../require/config.php"); // If you want to edit or access to configuration variables. Use $_CONF["setting"] to access a configuration setting.

// (2). Session variables
#$_SESSION["user"]; // The Discord login return. Basically, main options are $_SESSION["user"]->id, $_SESSION["user"]->discriminator, $_SESSION["user"]->username...

// (3). Add pages (if you need!)
# You can add pages to the dashboard if you want, like the credentials page or creation page. Basically, all you have to do is to add any php file in the root folder of Shadow's Dash, or
# in a sub folder, then link it with the navbar method.

// (4). Execute your code