OS := $(shell uname)

start:
ifeq ($(OS),Darwin)
	docker volume create --name=techknowledgence-app-sync
	docker volume create --name=techknowledgence-db-sync
	docker-compose -f docker-compose.yml up -d
	docker-sync start
else
	docker-compose up -d
endif

stop:           ## Stop the Docker containers
ifeq ($(OS),Darwin)
	docker-compose stop
	docker-sync stop
else
	docker-compose stop
endif