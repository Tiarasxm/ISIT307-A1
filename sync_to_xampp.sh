#!/bin/bash
echo "Syncing files from GitHub to XAMPP..."
cp *.php /Applications/XAMPP/xamppfiles/htdocs/ISIT307-A1/
cp -r includes /Applications/XAMPP/xamppfiles/htdocs/ISIT307-A1/
cp -r data /Applications/XAMPP/xamppfiles/htdocs/ISIT307-A1/
cp css/style.css /Applications/XAMPP/xamppfiles/htdocs/ISIT307-A1/css/
echo "Sync complete! Visit http://localhost/ISIT307-A1/"
