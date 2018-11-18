CREATE TABLE Move_Species(
Move_name 			CHAR(10), 
Species_name 		CHAR(10),
PRIMARY KEY (Move_name, Species_name),
FOREIGN KEY (Move_name)
  REFERENCES Move(name)
  ON DELETE CASCADE,
FOREIGN KEY (Species_name)
  REFERENCES Species(name)
  ON DELETE CASCADE);
