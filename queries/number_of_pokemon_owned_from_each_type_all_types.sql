SELECT name, COALESCE (num,0)
From pType
LEFT JOIN
(SELECT ST.Type_name, COUNT(*) as num
FROM PokemonOwnership O, PokemonInstance I, Species_Type ST
WHERE O.Pokemon_id = I.id AND I.Species_name = ST.Species_name AND O.Trainer_id = $trainer_id
GROUP BY ST.Type_name)
ON Type_name = name;