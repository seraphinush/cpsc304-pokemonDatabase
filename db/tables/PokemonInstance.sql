CREATE TABLE PokemonInstance (
id 					INTEGER,
Species_name 		CHAR(10),
exp 				INTEGER,
gender 				BIT,
level 				INTEGER,
minLevelToEvolve 	INTEGER,
weight 				DECIMAL(3,2),
height 				DECIMAL(3,2),
nickName 			CHAR(10),
PRIMARY KEY (id),
FOREIGN KEY (Species_name)
  REFERENCES Species(name)
  ON DELETE CASCADE)
