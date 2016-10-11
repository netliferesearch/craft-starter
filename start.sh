#!/bin/bash
# Import database credentials
DB=`grep DATABASE .env`
export $DB

# heroku local & PIDPHP=$!
php -S localhost:5000 -t public & PIDPHP=$!
npm run webpack & PIDWEBPACK=$!

function cleanit {
    jobs -p | xargs kill
}

trap cleanit SIGINT

wait $PIDPHP
wait $PIDWEBPACK
