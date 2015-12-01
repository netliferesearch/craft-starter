#!/bin/bash
# Import database credentials
DB=`grep DATABASE .env`
export $DB

php -S localhost:8080 -t public & PIDPHP=$!
gulp & PIDGULP=$!

function cleanit {
    jobs -p | xargs kill
}

trap cleanit SIGINT

wait $PIDPHP
wait $PIDGULP
