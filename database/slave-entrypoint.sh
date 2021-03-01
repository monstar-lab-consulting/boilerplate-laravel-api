#!/bin/bash
set -e
echo "Grant slave user!!!"
PGPASSWORD=$POSTGRESQL_PASSWORD psql -v ON_ERROR_STOP=1 --username "$POSTGRESQL_USERNAME" --dbname "$POSTGRESQL_DATABASE" <<-EOSQL
GRANT SELECT ON ALL TABLES IN SCHEMA public TO $POSTGRESQL_REPLICATION_USER;
EOSQL