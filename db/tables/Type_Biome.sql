CREATE TABLE Type_Biome (
Biome_name		CHAR(13),
Type_name		CHAR(8),
PRIMARY KEY (Biome_name, Type_name),
FOREIGN KEY (Biome_name)
  REFERENCES Biome(name)
  ON DELETE CASCADE,
FOREIGN KEY (Type_name)
  REFERENCES Type(name)
  ON DELETE CASCADE);
  
  INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Bug', 'taiga');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Bug', 'tropical rain forest');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Bug', 'tempreate rain forest');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Dragon', 'mountain');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Dragon', 'tundra');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Ice', 'tundra');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Ice', 'arctic');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Fighting', 'desert');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Fire', 'desert');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Fire', 'taiga');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Flying', 'mountain');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  (
    'Flying', 'temperate rain forest'
  );
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Flying', 'swamp');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Flying', 'oceanic');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Grass', 'grassland');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Grass', 'taiga');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Ghost', 'tundra');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Ghost', 'arctic');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Ground', 'desert');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Ground', 'grassland');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Ground', 'mountain');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Electric', 'mountain');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  (
    'Electric ', 'tropical rain forest'
  );
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Normal', 'tundra');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  (
    'Normal', 'temprerate rain forest'
  );
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Normal', 'grassland');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Normal', 'desert');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Normal', 'oceanic');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  (
    'Poison', 'tropical rain forest'
  );
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Poison', 'swamp');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Poison', 'mountain');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Psychic', 'desert');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Psychic', 'swamp');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Rock', 'mountain');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Rock', 'grassland');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Rock', 'desert');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Water', 'oceanic');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Water', 'swamp');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Steel', 'mountain');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Steel', 'tundra');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Steel', 'taiga');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  (
    'Fairy', 'temperate rain forest'
  );
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Fairy', 'taiga');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(Type_Biome) 
VALUES 
  ('Fairy', 'mountain');
