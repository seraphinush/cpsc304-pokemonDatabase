import http.client as httpc
import csv
import re


def get_description(name, conn):
    conn.request("GET", "/pokedex/" + name)
    r = conn.getresponse()
    s = r.read().decode('utf-8')
    m = re.search(
        "<span class=\"igame blue\">Blue</span></th> <td class=\"cell-med-text\">(.*?)</td>", s)
    if m:
        return m.groups()[0]
    else:
        return ""


def get_gendered(name, conn):
    conn.request("GET", "/pokedex/" + name)
    r = conn.getresponse()
    s = r.read().decode('utf-8')
    m = re.search(
        "<td><span class=\"text-blue\">(.*?) male</span>, <span class=\"text-pink\">12.5% female</span></td> </tr>", s)
    if m:
        print(m.groups()[0])


f = open(r"C:\Users\Ofirt\Desktop\CPSC 304\Project\pokemon.csv", 'r')
fout = open(r"C:\Users\Ofirt\Desktop\CPSC 304\Project\pokemonOut.csv", 'w', encoding='utf-8', newline='')
conn = httpc.HTTPSConnection("pokemondb.net")

conn.request("GET", "/pokedex/bulbasaur")
r = conn.getresponse()
s = r.read().decode('utf-8')
print(s)
rows = csv.reader(f)
write_rows = []
for row in rows:
    if row[0] == "id":
        row.append("des")
        write_rows.append(row)
        continue
    if int(row[0]) > 151:
        break
    row.append(get_description(row[1], conn))
    write_rows.append(row)
    print(row[0])
    # get_gendered(row[1], conn)

writer = csv.writer(fout)
for row in write_rows:
    writer.writerow(row)

fout.close()
conn.close()
f.close()
