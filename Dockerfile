FROM tomsik68/xampp:7

COPY . /opt/lampp/htdocs/sfserver

# copy the entrypoint script to the container
COPY docker/create_database.sh /usr/local/bin/

# make the entrypoint script executable
RUN chmod +x /usr/local/bin/create_database.sh

# set the entrypoint script as the default command for the container
ENTRYPOINT ["create_database.sh"]

EXPOSE 80