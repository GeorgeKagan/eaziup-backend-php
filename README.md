# Setup instructions

* Install composer (https://getcomposer.org/download/)
  * Composer requires PHP (http://windows.php.net/download)
* Run `composer install` from `src` dir
* Create `src/.env` w/ credentials from `docker-compose.yml`
  * Import an SQL dump  to fill the DB
* Install Docker on your local machine (https://docs.docker.com/engine/installation/)
* Make sure to **mount** the drive the project is on under `Settings > Shared Drives`
  * If you update Docker, you need to re-mount
* Run the containers:
  * Windows: `docker-compose up` **_using PowerShell_** 
  * Linux: `sudo docker-compose up`
* Go to localhost:8080

## Tips
* When making adjustments to docker-compose.yml / Dockerfile, run `docker-compose up --build`
* To remove a container (e.g. to update host mappings), run `docker-compose rm *image*`
* Remove all (also running) containers: `docker rm -f $(docker ps -a -q)`
* Remove all images: `docker rmi -f $(docker images -q)`
* Remove all volumes (persistent storage): `docker volume rm $(docker volume ls -q)`  

## DB schema
Schema only (no data) resides in `src/database/eaziup.sql`  
If schema changes, replace the SQL file.  

How to export schema?  
* In HeidiSQL, right click DB > "Export database as SQL", in the UI do the following:
  * Databases(s): check only "Create"
  * Table(s): check only "Create"
  * Data: select "No data"
  * Options: check "Remove AUTO_INCREMENT clauses"
  * Find the SQL file under source control, replace it
* Check Git diff to see that wanted changes were added
* Commit!


## DB connection from host
Port may not be 3306, check `docker-compose.yml > mysql > ports`

## Error logging
The app error log is at `src/storage/logs/lumen.log`