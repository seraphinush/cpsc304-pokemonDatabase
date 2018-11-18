CREATE TABLE Type_Biome (
Biome_name		CHAR(13),
Type_name		CHAR(8),
PRIMARY KEY (Biome_name, Type_name),
FOREIGN KEY (Biome_name)
  REFERENCES Biome(name)
  ON DELETE CASCADE,
FOREIGN KEY (Type_name)
  REFERENCES pType(name)
  ON DELETE CASCADE);