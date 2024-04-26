VERSION := $(shell awk '/Version/ {print $$3}' repo-demo.php)

all:
	rm -rf build/repo-demo build/repo-demo.zip && mkdir -p build/repo-demo
	cp -a *.php *.json plugin-update-checker build/repo-demo/
	cd build && zip -r repo-demo.zip repo-demo
.PHONY: all

version:
	@echo $(VERSION)
.PHONY: version

%:
	rm -rf build/repo-demo build/repo-demo-$@.zip && mkdir -p build/repo-demo
	cp -a *.php *.json plugin-update-checker build/repo-demo/
	cd build/repo-demo && sed -i .bak 's/1.0.0/$@/' repo-demo.php
	cd build && zip -r repo-demo-$@.zip repo-demo
