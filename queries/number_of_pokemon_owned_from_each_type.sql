SELECT T. Type_name, COUNT(*)
FROM PokemonOwnership O, PokemonInstance I, Species_Type T
WHERE O.Pokemon_id = I.id AND I.Species_name = T.Species_name AND O.Trainer_id = $_SESSION['ID']
GROUP BY T.Type_name;