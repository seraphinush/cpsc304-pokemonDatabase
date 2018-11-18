CREATE TABLE Species_Type(
Species_name 	CHAR(10),  
Type_name 		CHAR(10),
PRIMARY KEY (Species_name, Type_name),
FOREIGN KEY (Species_name)
  REFERENCES Species(name)
  ON DELETE CASCADE,
FOREIGN KEY (Type_name)
  REFERENCES Type(name)
  ON DELETE CASCADE);
