#!/usr/bin/env bash

set -e  # Fail on errors

# Run behat commands in a running behat container
# Have to use `docker exec`, since `docker-compose run` won't work on Windows (TODO: is this still true?)

# --skip-isolators
docker exec $(docker-compose ps -q oro_behat) ./bin/behat --colors --format=pretty --out=std --format=html --out=html_report "$@"

# --skip-isolators=database,cache 
# --format=pretty --out=std --format=html --out=html_report 
echo "To view HTML report visit: http://<your-docker-host-ip>:8000/html_report"
~                                                                            