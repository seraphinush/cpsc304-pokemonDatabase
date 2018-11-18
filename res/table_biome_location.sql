CREATE TABLE Biome_Location (
Biome_name 		CHAR(30),
Latitude		NUMBER(8,6),
Longitude		NUMBER(9,6),
PRIMARY KEY (Biome_name, latitude, longitude),
FOREIGN KEY (Biome_name)
  REFERENCES Biome(name)
  ON DELETE CASCADE,
FOREIGN KEY (latitude, longitude)
  REFERENCES Location(latitude, longitude)
  ON DELETE CASCADE);
