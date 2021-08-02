# ApiTestingPhp

Created for training PHP and REST API.

Folders:
  Config:
    Contains data regarding the database (local database)
  Model: 
    Contains data regarding the data model of the single table of the database and the repository and interface for accessing data in the context.
  Api:
    Contains data paths that permits adding, deleting, updating, and viewing data in the database.


If given the path of a folder without any index.php file, it will return an overview of all folders and php-files. Might have to be fixed on the server itself. 

The uri is case-sensitive, might be a server thing. Actually, it is because of some code in the index php file, which does not ignore case-sensitivity.