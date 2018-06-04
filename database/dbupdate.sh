#!/bin/bash
echo Downloading DMR-IDs from RadioID database
#curl 'https://www.ham-digital.org/status/users.csv' 2>/dev/null | sed -e 's/\t//g' | awk -F"," '/,/{gsub(/ /, "", $2); printf "%s;%s;%s\n", $1, $2, $3}' | sed -e 's/\(.\) .*/\1/g' > dmrids.dat
curl 'https://ham-digital.org/status/dmrid.dat' 2>/dev/null > dmrids.dat

echo Removing IDs from local database
echo -e 'delete from callsign where 1;' | sqlite3 callsigns.db

echo inserting new ID-list into local database
echo -e '.separator ";" \n.import dmrids.dat callsign' | sqlite3 callsigns.db

