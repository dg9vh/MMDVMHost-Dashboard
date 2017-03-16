#!/bin/sh
#
###############################################################################
#
# updateDMRIDs.sh
#
# Copyright (C) 2017 by Florian Wolters DF2ET
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
#
###############################################################################
#
# 18/1/17 - This script is a "derivative work" of GPL version 2 code Copyright
# by Tony Corbett G0WFV and is reproduced in this CC0 Universal licensed
# project with the original authors' express consent.
#
###############################################################################
#
#Edit by R2AJV
#Edit by CT2JAY


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

# Uncomment it if you want to get the data from a database of the DMR-MARC network
#curl 'http://www.dmr-marc.net/cgi-bin/trbo-database/datadump.cgi?table=users&format=csv&header=0' 2>/dev/null | sed -e 's/\t//g' | awk -F"," '/,/{gsub(/ /, "", $2); printf "%s\t%s\t%s\n", $1, $2,$
#mv /tmp/DMRIds.dat.$(date +%d%m%y) ${DMRIDFILE}
#rm -f /tmp/DMRIds.dat.$(date +%d%m%y)

# Uncomment it if you want to get the data from database of the BrandMeister network
curl 'http://registry.dstar.su/dmr/DMRIds.php' 2>/dev/null | sed -e 's/[[:space:]]\+/ /g' > ${DMRIDFILE}
mv /tmp/DMRIds.dat.$(date +%d%m%y) ${DMRIDFILE}
rm -f /tmp/DMRIds.dat.$(date +%d%m%y)

