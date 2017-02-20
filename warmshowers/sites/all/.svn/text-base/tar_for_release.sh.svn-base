if [ ! -n "$1" ]
then
	echo "You need to provide an argument which is the name of the subdir to tar up"
	exit
fi

basedir=$1

outputdir="/c/tmp";
outputfile=$outputdir/$basedir.$(date +"%Y%m%d.%H%M").tgz

echo "Tarring up files from $basedir into $outputfile";


cd $basedir

tar -czf $outputfile --exclude=".svn" --exclude="CVS" --exclude="settings.php" --exclude="*.zip" --exclude=geonames.txt --exclude=files --exclude=.htaccess .
