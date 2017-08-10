# Setup instructions

* Install Docker on your local machine (https://docs.docker.com/engine/installation/)
* Make sure to **mount** the drive the project is on under `Settings -> Shared Drives`
* Run `docker-compose up` to run the containers
  * If docker-compose fails, try running it from a PowerShell or CMD as admin
* Go to localhost:8080

## Tips
* When making adjustments to docker-compose.yml / Dockerfile, run `docker-compose up --build`
* To remove a container (e.g. to update host mappings), run `docker-compose rm *image*`
* Remove all (also running) containers: `docker rm -f $(docker ps -a -q)`
* Remove all images: `docker rmi -f $(docker images -q)`
* Remove all volumes (persistent storage): `docker volume rm $(docker volume ls -q)`