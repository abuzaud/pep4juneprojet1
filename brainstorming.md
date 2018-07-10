##SutekinaBox
### Process de la société
Une box par mois est envoyé aux clients / abonnés.

Une box contient des produits différents. 

Le processus est divisé en plusieurs étapes cruciales :
 1. Mise à jour de la liste (json/yaml) des produits (par fournisseur)
     1. Envoi d'un exemplaire de chaque produit
     2. Validation de la conformité des produits par le responsable des achats
     
 2. Création de la box
    1. Choix du budget
    2. Selection des produits
    3. Validation par le service marketing de la box
     
 3. Conditionnement
    1. Vérification auprès du fournisseur de la disponibilité des produits
       * Mise à jour de la liste avec les stock via API ?
       * Demande manuelle auprès du fournisseur ?
    2. Conditionnement des box
 
 4. Expédition des box

###Entity
- Box : containing products
- Product
- Supplier (for product list)
- User
- Workflow
- Definition
- Transition
- Place

- Notification

###Workflow Box
- Ajout des produits en base
- Création d'une box -> marketing
  * Formulaire pour la description de la box
  * Ajout des produits à la box
- Validation de la box
  * Attente de la validation du responsable des achats
- Validation du responsable marketing
- Go