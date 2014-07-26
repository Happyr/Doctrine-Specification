#!/bin/bash

# make sure we use a different config file on HHVM

if [ "$TRAVIS_PHP_VERSION" == "hhvm" ]; then
  ./vendor/bin/phpspec run -c travis/phpspec.hhvm.yml
else
  ./vendor/bin/phpspec run -c travis/phpspec.yml
fi