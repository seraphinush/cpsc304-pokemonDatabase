CREATE TABLE Move (
name			CHAR(10),
Type_name 		CHAR(8), 
power 			INTEGER,
PRIMARY KEY (name),
FOREIGN KEY (Type_name)
  REFERENCES Type(name)
  ON DELETE CASCADE)
