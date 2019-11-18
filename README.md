# PipelineDB Docker Demo


## Installation

    $ docker-compose up

You now have a PipelineDB server running, and a webserver available here: [http://localhost:8088/](http://localhost:8088/)

The database password is set in `docker-compose.yml`, if you change it, rebuild the containers with:

    docker-compose rm --all &&  docker-compose pull &&  docker-compose build --no-cache &&  docker-compose up -d --force-recreate
