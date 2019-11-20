# PipelineDB Docker Demo

## Overview

A simple demo of PipelinDB server, with a web frontend. For more information see the [PipelineDB website](https://www.pipelinedb.com/).

Full documentation can be found [here](http://docs.pipelinedb.com/).

## Installation

    $ docker-compose up

You now have a PipelineDB server running, and a webserver available here: [http://localhost:8088/](http://localhost:8088/)

The database password is set in `docker-compose.yml`, if you change it, rebuild the containers with:

    docker-compose rm &&  docker-compose pull &&  docker-compose build --no-cache &&  docker-compose up -d --force-recreate
