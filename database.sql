-- if the table exists delete it
-- TEMPORARILY DISABLING AND ENABLING FOREIGN KEY CONSTRAINTS
SET FOREIGN_KEY_CHECKS = 0;

-- ADMIN TABLE
DROP table if exists `superusers`;
CREATE TABLE superusers(USERNAME VARCHAR(50) NOT NULL UNIQUE, PASSWORD VARCHAR(400) NOT NULL,SUPERUSER_ID INT AUTO_INCREMENT, PRIMARY KEY(SUPERUSER_ID));

-- ADDING SUPERUSERS INTO THE TABLE
INSERT INTO superusers(username,password) values('admin@gmail.com',password('!Gingerbread237'));


DROP table if exists `users`;
DROP table if exists `posts`;
DROP table if exists `comments`;

SET FOREIGN_KEY_CHECKS = 1;



-- create a new table


create table users(username varchar(50) not null UNIQUE,password varchar(400) not null,fname varchar(50) not null, lname varchar(50) not null,gender varchar(10) not null, DOB DATE not null,date_joined DATETIME DEFAULT NOW(),user_id int AUTO_INCREMENT, Primary Key (user_id));


create table posts(post_id int AUTO_INCREMENT, post_msg varchar(100) not null, user_id int not null,date_posted DATETIME not null DEFAULT NOW(),PRIMARY KEY (post_id), FOREIGN KEY (user_id) REFERENCES users(user_id));

create table comments(comment_id int AUTO_INCREMENT, post_id int, comment_msg varchar(80) not null,date_commented DATETIME DEFAULT NOW(), user_id int, PRIMARY KEY(comment_id), FOREIGN KEY (post_id) REFERENCES posts(post_id), FOREIGN KEY (user_id) REFERENCES posts(user_id)); 





