# Admin panel quick style change


You can quickly change some parameters of the admin panel display  
The parameters are set in the configuration file. Its location is ***dashboard/config/dashboard.php***   
This config file has an ***Admin panel style section***
in which you can change the following list of parameters:

- **No Navbar border** (***no_navbar_border*** key) removes the border between header (top menu) and content-wrapper 
- **Body small text** (***small_text*** key) all elements inside the body decrease the font
- **Navbar small text** (***small_text*** key) reduces the font of the top menu
- **Sidebar nav small text** (***small_text*** key) reduces the text for menu items
- **Footer small text** (***small_text*** key) reduces the text in the footer
- **Sidebar nav flat style** (***flat*** key) changes the appearance of menu items
- **Sidebar nav legacy style** (***legacy*** key) changes the appearance of menu items
- **Sidebar nav compact** (***compact*** key) changes the view of the menu to a more concise sidebar
- **Sidebar nav child indent** (***child_indent*** key) adds padding for menu items
- **Main Sidebar disable hover/focus auto expand** (***auto_expand*** key)when the menu is collapsed, then on a hover DOES NOT expand it
- **Brand small text** (***small_text*** key) reduces the text for the logo

all these parameters takes ***true*** or ***false*** values (default: false)

### You also can change default colors for:

**Default links font** (***accent_color_variants*** key)

available values: *primary, warning, info, danger, success, indigo, navy, purple, fuchsia, pink, maroon, orange, lime, teal, olive*  
(default: nothing. Font color will be white)

**Font in Navbar** (***font_color*** key)

available values: *dark, light*  
(default: light)

**Theme in Sidebar** (***theme_color*** key)

available values: *dark, light*  
(default: dark)  

**Background in Navbar** (***theme_color*** key)

available values: *primary, secondary, info, success, danger, indigo, purple, pink, teal, cyan, gray-dark, gray, warning, white, orange*  
(default: white)

**Background in Sidebar** to active menu item (***background_color*** key)

available values: *primary, warning, info, danger, success, indigo, navy, purple, fuchsia, pink, maroon, orange, lime, teal, olive*  
(default: primary)

**Background for Logo** (***color*** key)

available values: *primary, secondary, info, success, danger, indigo, purple, pink, teal, cyan, dark, gray-dark, gray, light, white, orange*    
(default: primary)
