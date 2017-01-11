#Documentation API REST#

##Simple REST API##
Ceci est une Api REST simple qui fonctionne avec un serveur web standard.
Technologies utilisées : 
*PHP
*AltoRouter (http://altorouter.com/)
Pour la mise en place du serveur il fonctionne soit sans localhost dans un dossier ‘webservice’ (configurable dans le fichier config.php). Soit via un hôte virtuel dans ce cas il suffit de laisser la variable ‘foldername’ vide dans le fichier config.php
Ci-dessous toutes les mentions d’id de villes correspondra au champ ‘code insee’ de la base de donnée. 
##Requêtes GET##
*Obtentions de toutes les villes via l’url : 
  */villes
*Obtentions des noms de toutes les villes via l’url : 
  */villes/noms/
*Obtentions de toutes les villes dont le nom contient ‘X’ via l’url : 
  */villes/X
*Obtentions de la région de la ville ayant l’id ‘id’ via l’url : 
  */ville/id/region/
*Obtentions via l’url : 
  */villes/id/gps/
*Obtentions de toutes les villes via l’url : 
  */ville/id
##Requêtes PATCH##
*Mise à jour du nombre d’habitant d’une ville via l’url : 
  */ville/id/nb_habitant
##Requêtes DELETE##
*Suppression d’une ville via l’url : 
  */ville/id
