#Tournament Signup System by Team AG2-2 for CS 358-002

##Setup for local development:

  ###Install GIT
    https://git-scm.com/downloads

  ###Install Xampp (for PHP):
    https://www.apachefriends.org/download.html
    
  ###Install VS Code:
    https://code.visualstudio.com/download
    
  ###Install the 'PHP' and 'PHP Server extentions':
    Use CTRL + SHIFT + X to open up extentions menu
    Search for the extentions and install

  ###Clone the repository in VS Code

  ###Set the proper VS Code Settings:
    File > Preferences > Settings
    Search and Uncheck the 'PHP > Validate: Enable' setting
    Search and edit the 'PHP > Validate: Executable Path' setting to include the following lines withing the curly braces: 
      "php.validate.executablePath": "C:/xampp/php/php.exe",
      "phpserver.phpPath": "C:\\xampp\\php\\php.exe",
      "phpserver.phpConfigPath": "C:\\xampp\\php\\php.ini"
    *Note the path to php.exe may be different on you computer*

  ###Create you env.config
    Open a powershell terminal in VS Code with CTRL + `
    Create your env.config file with the following command
      touch env.config
    *note the grayed out appreatrance of the file to indicate git will ignore the file while pushing*
    Go into the created file
    Enter the DB connection settings in this format
      host = 'IP_HERE'
      db = 'DB_HERE'
      user = 'USER_HERE'
      pass = 'PASSWORD_HERE'

  ###Run the project
    Go to index.php
    right click enywhere on the code
    Click 'PHP Server: Serve project'
