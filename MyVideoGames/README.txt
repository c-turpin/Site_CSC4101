Projet de Clément TURPIN

Ce projet est un site web qui permet à des membres de renseigner les jeux vidéo qu'ils ont en leur possession.

Modèle de données:
- Objet = Jeu (Jeu vidéo)
	-> Id
	-> Nom
	-> Année de sortie
	-> Bibliothèque (dont il fait partie)

- Inventaire = Bibliothèque
	-> Id
	-> Nom
	-> Description
	-> Jeux (Collection des jeux que contient la bibliothèque)
	-> Membre (à qui appartient la bibliothèque)

- Membre
	-> Id
	-> Email
	-> Roles (Non utilisé pour l'instant)
	-> Password (Non utilisé pour l'instant)
	-> Bibliothèque (qui lui appartient)

Relations :

	- Bibliothèque (1)--(0..n) Jeu
	- Bibliothèque (1)--(1) Membre
	
Pages disponibles :

- / : 
	-> Liste des bibliothèques dans la base de données.

- /bibliothèque/{id} : 
	-> Détail de la bibliothèque d'id {id}. 
	-> Accessible à partir de /.
- /jeu/{id} : 
	-> Détail du jeu d'id {id}. 
	-> Accessible à partir de /bibliothèque/{id}.