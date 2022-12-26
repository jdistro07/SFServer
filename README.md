# Script Forte Server (Thesis Project of Year 2018)

### Description
Server for the project entitled [Script Forte](https://github.com/skildfrix/SFServer) written on PHP and MySQL server.

### Prerequisites
1. MySQL server
2. Apache for PHP (PHP 5 recommended)

### Installation:
1. Install MySQL server and open MySQL server UI panel.
2. Put the SFServer cloned on your web directory.
3. Navigate to `<SFServer dir>/db` and import the `db_scriptforte` database schema to your server.
4. Run your server. You can network it if you want.

### Docker:
1. Build the Docker image
```
2. docker build -t sfserver .
```

3. Run the container to bounded to the available port of your PC
```
# Example: docker run -p 41061:80 sfserver
docker run -p [your port no.]:80 sfserver
```

### Configuring the server API to the game:
1. Launch the game and open the settings windows found on the bottom left of the screen. 
2. Paste `SF Server` home URL.
```
// Example: If the SF Server is ran through Docker at port 41061
http://localhost:41061/sfserver
```

There are included sample user accounts you can use on the Docker demo environment. Please see the [wiki](https://github.com/jdistro07/SFServer/wiki/DOCKER:-Sample-Accounts).
