.PHONY: install lint test build format

install:
	composer install
	npm ci

lint:
	npm run lint
	npm run format
	composer lint:php
	composer stan

test:
	npm run test
	composer test:php

build:
	npm run typecheck
	npm run build

format:
	npm run format:write
	composer format:php
