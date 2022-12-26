# Script Forte Server (Thesis Project of Year 2018)

### Description
Server for the project entitled [Script Forte](https://github.com/skildfrix/SFServer) written on PHP and works with MySQL server engine.

### Prerequisites
1. MySQL server
2. Apache for PHP (PHP 5 recommended)

### Installation:
1. Install MySQL server and open MySQL server UI panel.
2. Put the SFServer cloned on your web directory.
3. Navigate to `<SFServer dir>/db` and import the `db_scriptforte` database schema to your server.
4. Run your server. You can network it if you want.

### Docker:
Build the Docker image
```
docker build -t sfserver .
```

Run the container to bounded to the available port of your PC
```
# Example: docker run -p 41061:80 sfserver
docker run -p [your port no.]:80 sfserver
```
