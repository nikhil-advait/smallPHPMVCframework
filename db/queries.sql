CREATE TABLE posts (
id INT NOT NULL AUTO_INCREMENT,
title VARCHAR(100) NOT NULL,
body VARCHAR(300),
PRIMARY KEY (id)
);

create table comments (
	id int not null AUTO_INCREMENT,
	text VARCHAR(200),
	post_id int,
	PRIMARY key(id),
	FOREIGN KEY(post_id) REFERENCES posts(id)
);

insert into posts (title, body) values ("title : manually inserted 1", "Body: manually inserted 1 Body: manually inserted 1 Body: manually inserted 1")