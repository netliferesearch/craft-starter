#!/bin/bash

php -S localhost:5000 -t public & PIDPHP=$!
gulp & PIDGULP=$!

function cleanit {
    jobs -p | xargs kill
}

trap cleanit SIGINT

wait $PIDPHP
wait $PIDGULP
