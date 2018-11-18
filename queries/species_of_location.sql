SELECT DISTINCT ST.Species_name
FROM Biome_Location BL, Type_Biome TB, Species_Type ST
WHERE BL.Latitude = 1 AND BL.Longitude = 2 AND BL.Biome_name = TB.Biome_name AND TB.Type_name = ST.Type_name; 