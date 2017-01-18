#!/bin/sh

# Full path to DMR ID file
DMRIDFILE=/var/www/html/DMRIds.dat

# How many DMR ID files do you want backed up (0 = do not keep backups)
DMRFILEBACKUP=1

# Create backup of old file
if [ ${DMRFILEBACKUP} -ne 0 ]
then
        cp ${DMRIDFILE} ${DMRIDFILE}.$(date +%d%m%y)
fi

# Prune backups
BACKUPCOUNT=$(ls ${DMRIDFILE}.* | wc -l)
BACKUPSTODELETE=$(expr ${BACKUPCOUNT} - ${DMRFILEBACKUP})

if [ ${BACKUPCOUNT} -gt ${DMRFILEBACKUP} ]
then
        for f in $(ls -tr ${DMRIDFILE}.* | head -${BACKUPSTODELETE})
        do
                rm $f
        done
fi

curl 'http://www.dmr-marc.net/cgi-bin/trbo-database/datadump.cgi?table=users&format=csv&header=0' 2>/dev/null | sed -e 's/\t//g' | awk -F"," '/,/{gsub(/ /, "", $2); printf "%s\t%s\t%s\n", $1, $2, $3}' | sed -e 's/\(.\) .*/\1/g' > /tmp/DMRIds.dat.$(date +%d%m%y)
mv /tmp/DMRIds.dat.$(date +%d%m%y) ${DMRIDFILE}
rm -f /tmp/DMRIds.dat.$(date +%d%m%y)
