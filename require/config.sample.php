<?php
/**
 * @var array $_CONFIG
 */
# ============================================
# Thanks for installing Shadow's Dash!
# This is your configuration file. You can learn
# more about what you can do in the documentation.
# 
# <!> This is not the place to edit eggs or nodes.
# There should be a table for the respective features.
#
$_CONFIG["name"] = ""; // Name of your host
$_CONFIG["logo_white"] = ""; // White version of your text logo (Image URL)
$_CONFIG["logo_black"] = ""; // Black version of your text logo (Image URL)
$_CONFIG["website"] = ""; // Main website link, not client
$_CONFIG["statuspage"] = ""; // Status page link
$_CONFIG["discordserver"] = ""; // Discord server invite link
$_CONFIG["privacypolicy"] = ""; // Privacy policy - If you want to start an host, please do this or you'll get drama.gg'ed ;)
$_CONFIG["termsofservice"] = ""; // Terms of service - NOT RULES! :) - If you want to start an host, please do this or you'll get drama.gg'ed ;)
$_CONFIG["home_background"] = "https://i.imgur.com/ksvpSN3.jpeg"; // The background of the home page
$_CONFIG["home_color"] = "warning"; // The card colors of the home page
$_CONFIG["favicon"] = ""; // A .png image link for your favicon.

// HOME NEWS
// The news showing next to the "Hello username#tag!" in the home page.
// Exemple: https://i.imgur.com/7a8QR5c.png
$_CONFIG["homeNews_show"] = true;
$_CONFIG["homeNews_title"] = "News title";
$_CONFIG["homeNews_content"] = "News content";
$_CONFIG["homeNews_bgimage"] = ""; // Leave empty for none | we recommend a darken background image, for better text reading on light images
$_CONFIG["homeNews_bgcolor"] = ""; // Leave empty for the default color
$_CONFIG["homeNews_buttonLink"] = "";
$_CONFIG["homeNews_buttonText"] = "Read more";

$_CONFIG["vipqueue"] = "30"; // price of the vip queue
// LOGIN QUEUE
// The login cooldown. If the cooldown is for exemple 30 seconds, only one user per 30 seconds can login.
// Others will see a page indicating that they need to wait to login. /!\ Longer cooldown times = longer wait and more people in queue!
// Set this to 0 to disable the cooldown. (If you change this live, it will take effect on the next user leaving the queue)
$_CONFIG["loginCooldown"] = 0;


//
// WEB CONFIGURATIONS
//
$_CONFIG["proto"] = "http://"; // protocol for the client area. Must be http or https with the :// at the end.
$_CONFIG["ptero_url"] = "https://pterodactyl.baguette"; // the url to your pterodactyl web server. This will be used for API.
$_CONFIG["ptero_apikey"] = ""; // [!] Must be an application api key with all rights.

//
// DATABASE AND API KEYS RELATED STUFF, CONFIDENTIAL
//
$_CONFIG["db_host"] = "localhost";
$_CONFIG["db_name"] = "shadowsdash";
$_CONFIG["db_username"] = "shadowsdash";
$_CONFIG["db_password"] = "";

//
// oAuth stuff
//
// >>> Discord
$_CONFIG["dc_clientid"] = ""; // The client ID of the Discord oAuth application
$_CONFIG["dc_clientsecret"] = ""; // The client secret of the Discord oAuth application
$_CONFIG["dc_guildid"] = ""; // Your Discord guild ID

// EARNING METHODS
// Each line is a new earning method showing into the "Select a method to earn coins" screen.
// Template: $_CONFIG["earningMethods"][] = array("icon" => "", "name" => "", "link" => "");
$_CONFIG["earningMethods"][] = array("icon" => "https://i.imgur.com/ckEZ16D.png", "name" => "Native miner", "link" => "#"); // Maybe redirect this to a download page, with explenations etc... Ok ok, I mean this is your installation not mine... :)
$_CONFIG["earningMethods"][] = array("icon" => "https://i.imgur.com/K6S8u5h.png", "name" => "AFK earning", "link" => "afk"); // SOON GONNA BE ADDED TO SHADOWSDASH! Stay tuned!!!!