#Code Project

Project is built using ScotchBox.

Scotch Box is a vagrant box with a LAMP stack and other technologies preinstalled.
I will be using this as my dev environment.

###Running Project
To run the code make sure you have vagrant and virtualbox installed
and just type `vagrant up`

or you drop the public folder on a server with the following installed
* LAMP
* REDIS
* PREDIS
note: run tables.sql to set up db tables.

###Folder Structure
    Root - vagrant config files
        Public - application
        classes - php classes used in application
        css - bootstrap files
        init - config information
        partials - header and footer for pates
        
Configuration information can be found in the init.php file if you need to change something for any reason.