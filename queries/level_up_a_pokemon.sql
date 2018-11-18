UPDATE PokemonInstance
SET exp = 0, pokelevel = (SELECT pokelevel + 1 from PokemonInstance where id = :poke_id)
WHERE id = :poke_id;