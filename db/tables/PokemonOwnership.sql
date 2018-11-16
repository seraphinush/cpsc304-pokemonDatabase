CREATE TABLE PokemonOwnership (
Pokemon_id		INTEGER, 
Trainer_id		INTEGER,
PRIMARY KEY (Pokemon_id, Trainer_id),
FOREIGN KEY (Pokemon_id)
  REFERENCES Pokemon(id)
  ON DELETE CASCADE,
FOREIGN KEY (Trainer_id)
  REFERENCES Trainer(id)
  ON DELETE CASCADE);