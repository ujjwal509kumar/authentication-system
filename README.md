
## Documentation

This is a straightforward php authentication system that verifies the account before logging in by sending an otp to the user who wishes to register. For sending the message, we combine Google's SMTP service with the PHP mailer. The specifics of deploying this system have been described in the deployment section.

## Author

- [@ujjwal](https://www.github.com/ujjwal509kumar)


## Deployment

You must adhere to the instructions listed below in order to deploy this project.

- Run sqlfile.sql first to generate the tables we'll be using for this project.
- ## To complete this project properly, you must alter a few credentials that i removed for safety reasons. These modifications include:
  - Change connect.php
  - Write your own SMTP username and password in forgotpass.php in  lines 18 and 19, and write the email address you'll be sending emails from in line 24's '' block. yourwebsite should be replaced with your domain name at lines 32 and 34.
  - Write your SMTP username and password to lines 71, 73, and 113, 115 of signupprocess.php.  Inside of '' in lines 77, 79, and 119, 121, type the email which you will be using to send emails.
  - To receive donations, we incorporated razorpay. Change supportus.php to use that, line 84's key should be replaced with your own secret razorpay key.Change lines 87 and 88, then enter the requested information.
## Demo


- [click here ](http://backup.infinityfreeapp.com/) to visit the live demo of this project
