CREATE TABLE PokemonInstance (
id 					INTEGER,
Species_name 		CHAR(10),
exp 				INTEGER,
pokelevel 			INTEGER,
weight 				DECIMAL(18,2),
height 				DECIMAL(18,2),
nickName 			CHAR(15),
PRIMARY KEY (id),
FOREIGN KEY (Species_name)
  REFERENCES Species(name)
  ON DELETE CASCADE);
