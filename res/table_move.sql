CREATE TABLE Move (
name			CHAR(20),
Type_name 		CHAR(10), 
power 			INTEGER,
PRIMARY KEY (name),
FOREIGN KEY (Type_name)
  REFERENCES pType(name)
  ON DELETE CASCADE);
