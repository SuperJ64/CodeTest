#Create tables for the Data Store
#Users = registered users
#Addresses = verified addresses
#user_address = pivot table linking addresses and users

USE scotchbox;

CREATE TABLE users (id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY, email VARCHAR(30) UNIQUE , password VARCHAR(20) NOT NULL,
  First_Name VARCHAR(20) NOT NULL, Last_Name VARCHAR(20) NOT NULL );

CREATE TABLE addresses (id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY, street VARCHAR(50) NOT NULL ,
  city VARCHAR(20) NOT NULL , state VARCHAR(10) NOT NULL);

#A user can have multiple addresses, and an address can belong to multiple users.
CREATE TABLE user_address (user_id INTEGER NOT NULL, address_id INTEGER NOT NULL,
  created TIMESTAMP DEFAULT current_timestamp ON UPDATE current_timestamp,
  FOREIGN KEY(user_id) REFERENCES users(id), FOREIGN KEY(address_id) REFERENCES addresses(id));

SHOW TABLES;