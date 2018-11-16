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
  
  INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Bug', 'taiga');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Bug', 'tropical rain forest');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Bug', 'tempreate rain forest');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Dragon', 'mountain');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Dragon', 'tundra');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Ice', 'tundra');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Ice', 'arctic');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Fighting', 'desert');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Fire', 'desert');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Fire', 'taiga');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Flying', 'mountain');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  (
    'Flying', 'temperate rain forest'
  );
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Flying', 'swamp');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Flying', 'oceanic');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Grass', 'grassland');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Grass', 'taiga');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Ghost', 'tundra');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Ghost', 'arctic');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Ground', 'desert');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Ground', 'grassland');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Ground', 'mountain');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Electric', 'mountain');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  (
    'Electric ', 'tropical rain forest'
  );
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Normal', 'tundra');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  (
    'Normal', 'temprerate rain forest'
  );
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Normal', 'grassland');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Normal', 'desert');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Normal', 'oceanic');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  (
    'Poison', 'tropical rain forest'
  );
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Poison', 'swamp');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Poison', 'mountain');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Psychic', 'desert');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Psychic', 'swamp');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Rock', 'mountain');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Rock', 'grassland');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Rock', 'desert');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Water', 'oceanic');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Water', 'swamp');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Steel', 'mountain');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Steel', 'tundra');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Steel', 'taiga');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  (
    'Fairy', 'temperate rain forest'
  );
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Fairy', 'taiga');
/* INSERT QUERY */
INSERT INTO TABLE_NAME(type, biome) 
VALUES 
  ('Fairy', 'mountain');
