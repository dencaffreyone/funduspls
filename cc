#!/bin/sh

ROOT_DIR=`dirname $0`/

php $ROOT_DIR/bin/console cache:clear $1
php $ROOT_DIR/bin/console_backend cache:clear $1
php $ROOT_DIR/bin/console_frontend cache:clear $1
php $ROOT_DIR/bin/console assets:install --symlink --relative

yarn
yarn encore prod