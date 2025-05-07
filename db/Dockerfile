FROM postgres:latest

ENV POSTGRES_USER=soulab_user
ENV POSTGRES_PASSWORD=soulab_password
ENV POSTGRES_DB=soulab_task

COPY scripts/* /docker-entrypoint-initdb.d/

EXPOSE 5432