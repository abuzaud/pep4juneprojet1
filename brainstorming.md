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

###Service


###Workflow Box
- **Retrieving** of product list
  - awaiting product list // from supplier or marketing
- **Validation** of the **list** // [Purchasing Manager]
- **Creation** of the Box and **budget** setting*
- **Reviewing** of the box
  - awaiting validation // [Marketing Manager]
- **Validation** of the **box**
  - awaiting supplier validation
  - awaiting packing (from supplier)
- **Box packed** & available for shipping
