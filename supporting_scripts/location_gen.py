import csv
import random

f_biome = open(r"C:\Users\Ofirt\Desktop\CPSC 304\Project\Repo\cpsc304-pokemonDatabase\csv\biome.csv", 'r', encoding='utf-8')
f_out_location = open("location.csv", 'w', encoding='utf-8', newline='')
f_out_b_l = open("biome_location.csv", 'w', encoding='utf-8', newline='')

rows = csv.reader(f_biome)
biomes = []
for row in rows:
    biomes.append(row[0])
biomes = biomes[1:]

write_rows = []
couneter = 0
for i in range(20):
    for j in range(20):
        write_rows.append([i, j, couneter])
        couneter += 1

writer = csv.writer(f_out_location)
for row in write_rows:
    writer.writerow(row)

f_out_location.close()

write_rows = []
for i in range(20):
    for j in range(20):
        write_rows.append([i, j, biomes[random.randint(0, len(biomes) - 1)]])

writer = csv.writer(f_out_b_l)
for row in write_rows:
    writer.writerow(row)

f_out_b_l.close()

f_biome.close()
