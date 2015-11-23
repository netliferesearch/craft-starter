#!/bin/bash
# Import database credentials
DB=`grep DATABASE .env`
export $DB

heroku local & PIDPHP=$!
gulp & PIDGULP=$!

function cleanit {
    jobs -p | xargs kill
}

trap cleanit SIGINT

wait $PIDPHP
wait $PIDGULP
