# almasign

This pops a small timestamped Note into the Alma User Notes area which indicates that the patron has "signed" an agreement. This is visible to the Circulation Desk staff but not the patron. 

Generate an API key at developers.exlibrisgroup.com --

Login to your account
Go to "Build My APIs", then "API Keys"
Generate a new key (I called mine "almasign") and give it permissions for Users, in the Production environment, with Read/Write permissions (fill out any other pertinent information as needed).

Copy & put that API key in the action_page.php file wherever you see YOURAPIKEYHERE
