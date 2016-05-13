#!/bin/bash

export COMPOSER_HOME="$OPENSHIFT_DATA_DIR/.composer"

if [ ! -f "$OPENSHIFT_DATA_DIR/composer.phar" ]; then
        echo 'Installing Composer'
        curl -s https://getcomposer.org/installer | php -- --quiet --install-dir=$OPENSHIFT_DATA_DIR
else
        echo 'Updating Composer'
        php $OPENSHIFT_DATA_DIR/composer.phar -q --no-ansi self-update
fi

if [ -d "$OPENSHIFT_REPO_DIR/vendor" ]; then
        echo 'Dependencies already installed, Moving on...'
else
        echo 'Hang in there, we are getting ready to Install/Update dependencies'
        echo 'Installing/Updating dependencies'; 
        unset GIT_DIR ; 
        cd $OPENSHIFT_REPO_DIR ; 
        php $OPENSHIFT_DATA_DIR/composer.phar -q --no-ansi install ;
fi