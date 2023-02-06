SHELL := /usr/bin/env bash
PROJECT_ROOT := $(dir $(lastword $(MAKEFILE_LIST)))

#build: up
#	export UID && docker-compose -f docker-compose-build.yml build --no-cache --pull

bash:
	export UID && docker-compose exec wordpress sh

up:
	export UID && docker-compose up -d
	bin/wait_for_docker.sh "ready to handle connections"
	bin/wait_for_docker.sh "mysqld: ready for connections"

down:
	docker-compose down

tail:
	docker-compose logs -f

status:
	docker-compose ps

#push: registry_login
#	docker-compose -f docker-compose-build.yml push

#registry_login:
#	docker login -u bizmate -p "${REGISTRY_PASSWORD}" repo.tobedecided.com

#docker_clean_dangling_images_and_volumes:
docker_clean:
	docker rmi $(docker images --filter "dangling=true" -q --no-trunc)
#docker volume rm $(docker volume ls -qf dangling=true)

