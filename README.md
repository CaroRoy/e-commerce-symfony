#Mon fichier README.md

#1.
#Aller dans le terminal, à la racine du projet Symfony.
#Taper : composer install

#2.
#Configurer la base de donnée.

#3.
#Jouer les migrations.

---

CONSTRUCTION DE LA FACTURE

Une facture se compose de plusieurs lignes de description

Chaque ligne de description est reliée à un produit

Chaque facture est reliée à un utilisateur

CONCLUSION :

- création de l'entity : Purchase

---

Propriétés :
date
customer
total

- création de l'entity : LinePurchase

---

Propriétés :
product
quantity
total
purchase

RELATION ENTRE LinePurchase et Purchase = ManyToOne
RELATION ENTRE LinePurchase et Product = ManyToOne
