# wikiCommunity blog 
Resurrecting the wikiCommunity blog and map to live forever!!!

This was a web app I developed with the help of a friend in the spring of 2008 in preparation for a across-the-US bicycle trip. I had a Blackberry (:black_circle: :strawberry: - remember those?!) that updated our location by posting to a URL our latitude, longitude, and altitude which in turn wrote to a MySQL database.  

In converting to GitHub pages, I converted the ~23,500 lat/lon points in the MySQL to a CSV file. Since we no longer have the need to write data, the js now reads from the static file. Removing the need for the database is what allows for hosting on GitHub pages. 
