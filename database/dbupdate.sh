#!/bin/bash
echo Downloading DMR-IDs from MARC-database
curl 'http://dmr-marc.net/cgi-bin/trbo-database/datadump.cgi?table=users&format=csv&header=0' 2>/dev/null | sed -e 's/\t//g' | awk -F"," '/,/{gsub(/ /, "", $2); printf "%s;%s;%s\n", $1, $2, $3}' | sed -e 's/\(.\) .*/\1/g' > dmrids.dat

echo Removing IDs from local database
echo -e 'delete from callsign where 1;' | sqlite3 callsigns.db

echo inserting new ID-list into local database
echo -e '.separator ";" \n.import dmrids.dat callsign' | sqlite3 callsigns.db

