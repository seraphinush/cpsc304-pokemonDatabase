CREATE VIEW Trainer_Species AS
SELECT DISTINCT O.Trainer_id, I.Species_name
FROM PokemonOwnership O, PokemonInstance I
WHERE O.Pokemon_id = I.id;