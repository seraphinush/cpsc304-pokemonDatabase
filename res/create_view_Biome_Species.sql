CREATE VIEW Biome_Specie_View as
SELECT B.name, ST.Species_name
FROM Biome B, Type_Biome TB, Species_Type ST
WHERE B.name = TB.Biome_name AND TB.Type_name = ST.Type_name;