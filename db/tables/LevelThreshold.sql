CREATE TABLE LevelThreshold (
Species_name 	CHAR(10),
level 			INTEGER,
exp 			INTEGER,
PRIMARY KEY (Species_name, level),
FOREIGN KEY (Species_name)
  REFERENCES Species(name)
  ON DELETE CASCADE)
