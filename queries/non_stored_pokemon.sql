SELECT I.*
FROM PokemonInstance I, PokemonOwnership O
WHERE I.id = O.Pokemon_id AND O.Trainer_id = $_SESSION['ID'] AND O.is_stored = 0;