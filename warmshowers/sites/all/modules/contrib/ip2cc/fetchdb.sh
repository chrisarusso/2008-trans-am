#!/bin/sh

OUTFILE=ipdb.mysql
URL=http://ip-to-country.webhosting.info/downloads/ip-to-country.csv.zip

if [ ! -e ip-to-country.csv ] ; then
	wget $URL
	unzip ip-to-country.csv.zip
	rm ip-to-country.csv.zip
fi

cat ip-to-country.csv | awk -v RS='\r\n' -v FS=',' '{
printf("INSERT INTO {ip2cc} VALUES (%s,%s,%s,\"Unknown\",0);\n",$1,$2,$3);
}' >>$OUTFILE
