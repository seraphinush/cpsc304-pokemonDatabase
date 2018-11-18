CREATE TABLE LevelThreshold (
Species_name 	CHAR(10),
pokelevel		INTEGER,
exp 			LONG,
PRIMARY KEY (Species_name, pokelevel),
FOREIGN KEY (Species_name)
  REFERENCES Species(name)
  ON DELETE CASCADE);
