CREATE TABLE Species_Biome (
Biome_name 		CHAR(13),
Species_name 	CHAR(10),
PRIMARY KEY (Biome_name, Species_name),
FOREIGN KEY (Biome_name)
  REFERENCES Biome(name)
  ON DELETE CASCADE,
FOREIGN KEY (Species_name)
  REFERENCES Species(name)
  ON DELETE CASCADE);
