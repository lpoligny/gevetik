Adresse : http://SERVEUR/EVENEMENT/organisateur

Nécessite un identifiant et un mot de passe

Une fois identifié, plusieurs liens sont accessibles directements :
- synthèse
- communiquer
- vue des participants
- vue des articles
- configuration

h2. Synthèse 

Cette page permet de visualiser les informations de bases de l'événement :
les différentes dates, le nombre de participants, nombre d'auteurs.
Donne le total de frais validé et total (validé et en attente de validation).
Ainsi que le détail des options de l'événement (CD-Rom, repas, catégorie de personnes...)


h2. Communiquer 

Permet d'envoyer un mail aux différentes catégories d'utilisateurs du site :
 -1- Les organisateurs
 -2- Les auteurs (toutes les personnes mentionnées dans la listes des auteurs des articles). Attentions une personne peut écrire différents articles. Il doit recevoir un seul message.
 -3- les participants (ceux qui ont validé leur participation)
 -4- les inscrits sur le site mais n'ayant pas encore validé leur participation (les auteurs non inscrits ne sont pas dans cette liste).
 -5- les inscrits (toutes les personnes enregistrées sur le site, càd 3+4)

Il est possible d'envoyer directement un mail par une interface simple :
 - Sujet
 - Destinataire (sous forme de puce selectionnable)
 - Message

h2. Vue des participants

Affiche la vue des participants sous forme de liste filtrable.
Il doit être facile de voir l'ensemble des participants qui ont payé, ce qui n'ont pas payé...
Les colonnes affichées devraient être paramétrable : Nom, Prénom, mail, validé, liste article, extra page
(à voir en fonction de la difficulté toutes les options devraient pouvoir être affichées et triées).
Les colonnes affichées devraient être facilement triable par un bouton.

Il est donc facile d'avoir une visibilité sur les informations des participants, 

Il n'est pas utile de mettre un bouton « rechercher » puisque que l'on peut afficher les colonnes de son choix.

Le nom des participants est un lien vers le détail de leur inscription :
 - nom/prénom/mail...
 - état de validation
 - liste des articles avec les extra pages (et celles payée)
Un lien pour communiquer directement avec l'auteur

Un lien qui permet de forcer l'état de validation (par exemple un auteur est invité, il ne paye pas l'inscription. Si l'inscription coute de l'argent. Sa validation doit se faire par les organisateurs.)

h3. Vue des articles

Affiche l'ensemble des articles de l'événement (ID, titre, auteurs..., extra page, article dont au moins un auteur est inscrit, article dont au moins un auteur a validé sa participation).

Le titre permet d'accéder à la vue détaillée de l'article :
 - liste des auteurs ;
 - titre complet
 - mots clés
 - résumé
 - PDF uploadé
 - état d'inscription des auteurs
 - état de validation des auteurs
 
Il y a un lien qui permet de communiquer avec les auteurs de l'article (lien vers *communiquer* avec le champ destinataire renseigné).

h3. Configuration

- Permet d'ajouter des organisateurs (nom, prénom, identifiant, mail)
- de changer le texte d'accueil de l'événement
- de changer les dates 
- de gérer les options et catégories
- de mettre le site en production (oui/non) 
- de modifier la mailing list des organisateurs (ils sont en copies des échanges faits par le site)
- configuration du SMTP du site pour l'envoie des mails (pour changer ceux par défaut défini par l'admin). 
