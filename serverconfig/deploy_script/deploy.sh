#!/bin/bash

ReleaseTime=$(/bin/date "+%Y%m%d%H%M%S")
DeployDir="/var/www/html/jaymart/releases/${ReleaseTime}"
RootDir="/var/www/html/jaymart/"
RealUploadDir="/var/www/html/jaymart/uploads"

echo "Checking out the code from git repository"
git clone https://bitbucket.org/nattakorn145/jaymart.git ${DeployDir}
chmod -Rf 755 ${DeployDir}


if [ ! -d "$DeployDir" ]; then
  # Control will enter here if $DIRECTORY doesn't exist.
  echo "Fail to checkout the code from repository"
  exit
fi


echo "Preparing the cache folder"
rm -Rf ${DeployDir}/code/application/cache
mkdir ${DeployDir}/code/application/cache
chmod 777 ${DeployDir}/code/application/cache
echo "Preparing the cache folder: Done"

echo "Associate the uploads folder"
rm -Rf ${DeployDir}/code/assets/uploads
chmod 777 ${RealUploadDir}
ln -s ${RealUploadDir} ${DeployDir}/code/assets/uploads
echo "Associate the upload folder: Done"

echo "Copy config and database file"
rm -Rf ${DeployDir}/code/application/config/config.php
rm -Rf ${DeployDir}/code/application/config/database.php
cp  ${RootDir}config/config.php ${DeployDir}/code/application/config/config.php
cp  ${RootDir}config/database.php ${DeployDir}/code/application/config/database.php
echo "Copy config and database file: Done"


cd ${RootDir}

echo "Update code owner to www-data"
chown -Rf www-data:www-data ${DeployDir}

echo "publishing the site"
rm -Rf current
su -s /bin/sh www-data -c "ln -s ${DeployDir} current"
#ln -s ${DeployDir} current

echo "Done"
