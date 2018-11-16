CREATE TABLE Biome_Location (
Biome_name 		CHAR(13),
Latitude		FLOAT(8,6),
Longitude		FLOAT(8,6),
PRIMARY KEY (Biome_name, latitude, longitude),
FOREIGN KEY (Biome_name)
  REFERENCES Biome(name)
  ON DELETE CASCADE,
FOREIGN KEY (latitude, longitude)
  REFERENCES Location(latitude, longitude)
  ON DELETE CASCADE);
