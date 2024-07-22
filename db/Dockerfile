ARG MYSQL_VERSION
FROM mysql:${MYSQL_VERSION}

COPY ./init ./docker-entrypoint-initdb.d/
