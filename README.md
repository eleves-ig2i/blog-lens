Création d'un blog

Un billet de blog est rédigé par une personne
Une personne peut rédiger 0 ou plusieurs billets
Un billet peut appartenir à une catégorie
Une catégorie contient 0 à N billets
Un visiteur public peut publier un commentaire sur un billet
Un billet a 0 à N commentaires

Entités : 
* Post
    * id
    * title / string
    * content / text
    * created_at / datetime
    * updated_at / datetime
    * status / boolean 
    * user_id
    * category_id   
    
* Category
    * id
    * title
    
* Comment
    * id
    * content
    * email
    * created_at
    * updated_at
    * post_id 
    
* User 
    * id 
    * username
    * created_at
    * updated_at
    
    
Sur la page d'accueil, je veux les 3 derniers messages de blog, triés par date de création DESC
Je peux cliquer sur le titre d'un message pour lire son contenu. 
Je peux cliquer sur le nom d'une catégorie pour voir les messages appartenant à cette catégorie.