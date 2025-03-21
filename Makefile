all: prepare benchmark-table

.PHONY: prepare
prepare: clean vendor src/Generated generate_containers autoloader integration-autoloaders

.PHONY: generate_containers
generate_containers: kaspi-di-definitions_cache containers/riaf/src/Container.php containers/symfony/src/SymfonyContainer.php containers/php-di/src/CompiledContainer.php containers/zen/src/Container.php

.PHONY: clean
clean:
	rm -rf vendor
	rm -rf src/Generated
	rm -rf containers/riaf/vendor
	rm -rf containers/riaf/src/Container.php
	rm -rf containers/symfony/vendor
	rm -rf containers/symfony/src/SymfonyContainer.php
	rm -rf containers/php-di/vendor
	rm -rf containers/php-di/src/CompiledContainer.php
	rm -rf containers/league/vendor
	rm -rf containers/laminas/vendor
	rm -rf containers/laminas/src/autowire.cache.php
	rm -rf containers/yii/vendor
	rm -rf containers/zen/vendor
	rm -rf containers/zen/src/Container.php
	rm -rf containers/kaspi-di/vendor
	rm -f containers/kaspi-di/var/*.php
	rm -rf containers/spiral/vendor

.PHONY: vendor
vendor:
	composer install --no-dev
	cd containers/riaf && composer install --no-dev
	cd containers/symfony && composer install --no-dev
	cd containers/php-di && composer install --no-dev
	cd containers/league && composer install --no-dev
	cd containers/laminas && composer install --no-dev
	cd containers/yii && composer install --no-dev
	cd containers/zen && composer install --no-dev
	cd containers/kaspi-di && composer install --no-dev
	cd containers/spiral && composer install --no-dev

.PHONY: autoloader
autoloader:
	composer dump-autoload -o -a

.PHONY: integration-autoloaders
integration-autoloaders:
	cd containers/riaf && composer dump-autoload -o -a
	cd containers/symfony && composer dump-autoload -o -a
	cd containers/php-di && composer dump-autoload -o -a
	cd containers/league && composer dump-autoload -o -a
	cd containers/laminas && composer dump-autoload -o -a
	cd containers/yii && composer dump-autoload -o -a
	cd containers/zen && composer dump-autoload -o -a
	cd containers/kaspi-di && composer dump-autoload -o -a
	cd containers/spiral && composer dump-autoload -o -a

.PHONY: autoloader-kaspi
autoloader-kaspi:
	cd containers/kaspi-di && composer dump-autoload -o -a

.PHONY: benchmark
benchmark:
	php -d memory_limit=4096M vendor/bin/phpbench run benchmark --report=aggregate

.PHONY: benchmark-table
benchmark-table:
	php -d memory_limit=4096M vendor/bin/phpbench run benchmark --report=all --group=ContainerBenchmark

.PHONY: benchmark-containers
benchmark-containers:
	php -d memory_limit=4096M vendor/bin/phpbench run benchmark --report=all --group=Container

.PHONY: benchmark-compiled
benchmark-compiled:
	php -d memory_limit=4096M vendor/bin/phpbench run benchmark --report=all --group=Compiled

.PHONY: benchmark-match
benchmark-match:
	php -d memory_limit=4096M vendor/bin/phpbench run benchmark --report=all --group=Match

.PHONY: benchmark-misc
benchmark-misc:
	php -d memory_limit=4096M vendor/bin/phpbench run benchmark --report=all --group=Misc

PHONY: kaspi
kaspi:
	php -d memory_limit=4096M vendor/bin/phpbench run benchmark --report=all --group=KaspiDi

PHONY: runtime
runtime:
	php -d memory_limit=4096M vendor/bin/phpbench run benchmark --report=all --group=Runtime

containers/riaf/src/Container.php:
	cd containers/riaf && composer dump-autoload
	cd containers/riaf && php vendor/bin/compile "\\Config"

containers/symfony/src/SymfonyContainer.php:
	cd containers/symfony && composer dump-autoload
	cd containers/symfony && php ./generate_container.php

containers/php-di/src/CompiledContainer.php:
	cd containers/php-di && composer dump-autoload
	cd containers/php-di && php ./generate_container.php

containers/zen/src/Container.php:
	cd containers/zen && composer dump-autoload
	cd containers/zen && php vendor/bin/zen build src/Container.php "Zen\\CompilerConfig"

src/Generated:
	cd src && mkdir -p Generated
	php ./generate_services.php

kaspi-di-definitions_cache:
	cd containers/kaspi-di && composer dump-autoload
	cd containers/kaspi-di && php ./definitions_cache.php


.PHONY: update-all

update-all: update-spiral update-kaspi-di update-laminas update-league update-phpdi update-riaf update-symfony update-zen

.PHONY: update-riaf
update-riaf:
	cd containers/riaf && composer update

.PHONY: update-symfony
update-symfony:
	cd containers/symfony && composer update

.PHONY: update-phpdi
update-phpdi:
	cd containers/php-di && composer update

.PHONY: update-league
update-league:
	cd containers/league && composer update

.PHONY: update-laminas
update-laminas:
	cd containers/laminas && composer update

.PHONY: update-yii
update-yii:
	cd containers/yii && composer update

.PHONY: update-zen
update-zen:
	cd containers/zen && composer update

.PHONY: update-kaspi-di
update-kaspi-di:
	cd containers/kaspi-di && composer update

.PHONY: update-spiral
update-spiral:
	cd containers/spiral && composer update
