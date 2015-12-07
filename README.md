# GroupMe
GroupMe is a graduate student project designed to help make group projects in academic settings easier for both students and instructors.

# Development
GroupMe is being jointly developed by three graduate students with the College of Education at the University of Missouri.  We aren't professional web app developers, but we do think we have a cool idea and can give it enough life for a proof of concept.  In order to make development easier across platforms, we are using XAMPP 5.5.28-0 to create and test the proof of concept locally.

# Deploying GroupMe Locally
You'll need to do two things in order to deploy the GroupMe web application:
  1. Once you've installed XAMPP, place the repository in the "htdocs" folder of your XAMPP installation and name the repository folder "GroupMe".
  
  2. You need to setup the authentication database by performing the following steps:
    a. Start your Apache Web Server and MySQL Database in XAMPP
    b. Visit "localhost/phpmyadmin" using your web browser
    c. In the upper lefthand corner, under the "phpMyAdmin" banner, click "New"
    d. Type "phpauth" for the database name and click "Create"
    e. Click on the "phpauth" database you just created from the list on the left
    f. Along the top row of buttons, click "Import"
    g. Click the "Choose file" button and select the "phpauth.sql" file in the "databases" folder of the repository
    h. Click "Go"

  3. Follow similar steps to those above in order to create the "groupme" database and import the "groupme.sql" file

That's it!  You can visit the main page by visiting "localhost/GroupMe/index.php" in your web browser.  Either register your own account, or use the default credentials:

  Username: test@test.com
  Password: test

#Supported Actions
Below is a list of the currently implemented functionality:
  1. Create an account
  2. Login
  3. Create group
  4. Join group
  5. Leave group
  6. Set alert preferences
  7. Upload files
  8. Logout
