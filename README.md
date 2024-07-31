# How to setup
Make sure when downloading to keep the file/directory structure as is to ensure the code works.

**The hospital webapp files is contained within public directory. This directory contains php files and assets directory to hold the necessary javascripts/css and images needed.**

**the files run on a php server, therefore to run the webapp you must install a php server to run the appropriate files. The normal download from https://www.php.net/ will do if you are only planning to test and see the features of the app. The built in server should be used for production and only deployed for testing and bug fixing**

**Warning this app was setup on windows therefore the files within public are important, especially the php.ini file.
If you wish to run on another operating system then the setup might differ.**

This is a simple web app to manage the triage of a hospital.

**Note there might be some discrepancy with the wait time since the PostgreSQL server is datetime is saved on local time while datetime in php it is calculated on a different time (unix) therefore there will be some difference with the time and the calculations.**

## Requirements
You will need these:
- PostgreSQL 13 or higher.
- Php 7.0 or higher.

## Setup instructions
**Instructions for developers to setup the web app**

- **1.** Install php from [https://www.php.net/]
- **2.** Install PostgreSQL from [https://www.postgresql.org/], make sure to remember the password you put added
	for postgresl
- **3.** Start the server. The server is running by default but if it is not, then enable it in the services tab.
- **4.** Open a console and log in the psql interface with the command psql -U postgres (the password by default is postgres if you don't change it). Then exit the interface using command quit;
- **5.** Optional, create a database.
- **6.** Create the tables and fill the tables with base data using the scripts provided in 
	[db_schema](/db/schema.sql)
	[db_seed](/db/seed.sql)
	To run scripts in console use the following commands:
	psql -U postgres testapp < .\db\schema.sql
	psql -U postgres testapp < .\db\seed.sql
Note: I have already created another database called testapp but by default, the base database is postgres. If you skipped step 5 then the commands will omit testapp like so:
	psql -U postgres < .\db\schema.sql
	psql -U postgres < .\db\seed.sql
- **7.** optional, you may use pgadmin to manage the database as a graphical interface.
- **8.** Open a command in the public directory and start the php server using the command php -S localhost:8000 -c php.ini.

**Note the [db_schema](/db/script.txt) contains the commands to run in the console. Depending on the paths on your system, you may not need some of them. Therefore I recommend adapting commands to your system for the paths.**

**Warning if you don't keep php.ini file then the setup will not run as the file enables pgsql functions which are necessary to query and perform operations on the PostgreSQL database.**

## Instructions on how to manage app as a hospital employee
- The employee or admin will first logging as an employee by clicking on the employee button to switch to employee tab and enter the information the admin/developer has provided to the employee.

- The employee will see two tables, one that lists all patients that ever registered with the hospital and another that shows all current request to see a doctor.

- The patient table will also contain the 3 alphabet code of a patient in case the patient has forgotten his/her code.

- If it is the first time that a patient has made a request to book a doctor then the employee can add the patient using his name (this is just a simple app as complex apps require more information to identify a patient and keep their record but this is sufficient enough for our simple app). Once the patient has been added to the table, a 3 letter code will be generated to him/her so that the employee can inform the patient about.

- The employee can also register a patient for treatment that he/she requests. For simplicity, a button to the right of the patient on the patient table along with choosing the severity of their needs.

- The employee can finish the treatment of a patient by clicking on the button to the right of a patient on the queue table.

- There is also a sign out but it is a small detail. 

## Instructions on how to use the hospital app as a patient
- The patient can see the wait time of each of their requests by logging in through the patient tab with their name and 3 letter code provided to them.

- The last thing the patient can do is logout using the sign out button

## Features
- Patients are not limited to only one treatment as they may request more. It is up to the discretion of the hospital staff to determine to allow such a request.

- The employee managing the web app can manage treatment and doctor appointement using the buttons. (simple app). In addition, he can also add treatments to queue for a patient. Finally he can also add a patient to the list of patients.

- The patient will be given an approximate wait time for each of his treatments, while the staff can see the severity of treatments and how long they waited.

## Instructions to enable app in php
- **1.** Install php from [https://www.php.net/]
- **2.** Set your directory from the GitHub and open a console at the (/public) directory or changing the directory manually from the console.
- **3.** Type in the following command on the console. You may need to add the php directory to your environment variables otherwise you maybe to substitute php with the path you stored/installed the php binary files.
![console](/docs/design_system/console.png)
- **4.** Open a tab on your browser at the ip started by the built in php server, in our case localhost:8000

**Warning this is only for testing purposes but it will serve our needs. This should never be used to deploy for production and you must set up a server if you wish to put on the web**

## Schema for database
![Schema](/docs/design_system/schema.png)
- **1..1 means only one**
- **0..n means 0 or more** 

## Demonstrations

### Login page
![Login](/docs/design_system/intro.png)

### Entering information
![Logging](/docs/design_system/loginexample.png)

### View of an employee
![Employee](/docs/design_system/hospitalview.png)

### View from a patient
![Patient](/docs/design_system/patientview.png)

### Console instructions
![Console](/docs/design_system/console.png)
![Schema](/docs/design_system/consoleschema.png)
![Seed](/docs/design_system/consoleseed.png)

### Important! For windows, you will need the php.ini file!
![Ini](/docs/design_system/phpini.png)

## My Design System
[Design System](/docs/design_system.md)