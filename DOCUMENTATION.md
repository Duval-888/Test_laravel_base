# Plateforme de Discussion en Ligne avec Laravel

Une plateforme complète de discussion en ligne construite avec Laravel 10, permettant aux utilisateurs de créer des sujets, de répondre, de voter pour les meilleurs messages, et de gérer les badges et notifications.

## Fonctionnalités

### 1. **Catégories de Sujets**
- Création et gestion des catégories
- Chaque catégorie contient plusieurs sujets
- Affichage des statistiques (nombre de sujets, etc.)

### 2. **Sujets et Messages**
- Créer de nouveaux sujets dans une catégorie
- Répondre aux sujets et aux messages (réponses en chaîne)
- Éditer ses propres messages
- Verrouillage des sujets
- Épingler les sujets importants
- Compteur de vues pour chaque sujet

### 3. **Système de Vote**
- Voter "like" ou "dislike" sur les messages
- Les votes augmentent/diminuent le compteur de votes
- Chaque utilisateur ne peut voter qu'une fois par message
- Annuler ou modifier son vote

### 4. **Système de Badges**
- Les utilisateurs gagnent des badges au fur et à mesure de leur participation
- **Premier Message**: Badge au premier message publié
- **Création Productive**: 10 posts publiés
- **Membre Utile**: Messages reçoivent des votes positifs
- **Contributeur Actif**: 50 posts
- **Expert du Forum**: 100 posts
- **Modérateur**: Assigné par les administrateurs

### 5. **Modération des Contenus**
- Suppression de messages inappropriés
- Suspension de sujets
- Historique des actions de modération
- Restauration des messages supprimés

### 6. **Notifications**
- Notification quand quelqu'un répond à votre message
- Notification quand votre message reçoit des votes positifs
- Compteur de notifications non lues
- Marquer les notifications comme lues
- Suppression des notifications

## Installation

### Prérequis
- PHP 8.1+
- Composer
- Laravel 10
- MySQL ou autre base de données supportée

### Étapes d'installation

1. **Cloner le projet**
```bash
git clone <repository-url>
cd "forum en ligne"
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurer la base de données**
Éditer le fichier `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=forum_db
DB_USERNAME=root
DB_PASSWORD=
```

5. **Exécuter les migrations**
```bash
php artisan migrate
```

6. **Remplir la base de données (optionnel)**
```bash
php artisan db:seed
```

7. **Démarrer le serveur**
```bash
php artisan serve
```

La plateforme sera accessible à `http://localhost:8000`

## Structure de l'application

### Modèles
- **User**: Les utilisateurs de la plateforme
- **Category**: Les catégories de sujets
- **Topic**: Les sujets de discussion
- **Post**: Les messages/réponses
- **Vote**: Les votes sur les messages
- **Badge**: Les badges de récompense
- **UserBadge**: Liaison entre utilisateurs et badges
- **Notification**: Les notifications utilisateur
- **ModerationLog**: Historique des actions de modération

### Routes API

#### Catégories (Publiques)
```
GET /api/categories                    - Lister toutes les catégories
GET /api/categories/{category}         - Voir une catégorie
POST /api/categories                   - Créer une catégorie (Admin)
PUT /api/categories/{category}         - Modifier une catégorie (Admin)
DELETE /api/categories/{category}      - Supprimer une catégorie (Admin)
```

#### Sujets
```
GET /api/topics                        - Lister tous les sujets
GET /api/topics?category_id=1          - Sujets par catégorie
GET /api/topics/{topic}                - Voir un sujet
POST /api/topics                       - Créer un sujet (Auth)
PUT /api/topics/{topic}                - Modifier un sujet (Auth/Admin)
DELETE /api/topics/{topic}             - Supprimer un sujet (Auth/Admin)
```

#### Messages (Posts)
```
GET /api/posts                         - Lister tous les messages
GET /api/posts?topic_id=1              - Messages d'un sujet
GET /api/posts/{post}                  - Voir un message
POST /api/posts                        - Créer un message (Auth)
PUT /api/posts/{post}                  - Modifier un message (Auth/Admin)
DELETE /api/posts/{post}               - Supprimer un message (Auth/Admin)
```

#### Votes
```
GET /api/votes/post/{post}             - Voir les votes d'un message
POST /api/posts/{post}/vote            - Voter sur un message (Auth)
```

#### Modération
```
POST /api/moderation/posts/{post}/delete     - Supprimer un post (Admin)
POST /api/moderation/posts/{post}/restore    - Restaurer un post (Admin)
POST /api/moderation/topics/{topic}/suspend  - Suspendre un sujet (Admin)
GET /api/moderation/logs               - Voir l'historique (Admin)
```

#### Badges
```
GET /api/badges                        - Lister tous les badges
GET /api/users/{user}/badges           - Badges d'un utilisateur
POST /api/users/{user}/badges          - Assigner un badge (Admin)
DELETE /api/users/{user}/badges/{badge} - Retirer un badge (Admin)
```

#### Notifications
```
GET /api/notifications                 - Lister les notifications (Auth)
GET /api/notifications/unread-count    - Nombre de notifications non lues (Auth)
PUT /api/notifications/{notification}/read   - Marquer comme lue (Auth)
PUT /api/notifications/mark-all-read   - Marquer toutes comme lues (Auth)
DELETE /api/notifications/{notification}     - Supprimer une notification (Auth)
DELETE /api/notifications              - Supprimer toutes (Auth)
```

## Exemple d'utilisation

### 1. Créer une catégorie
```bash
curl -X POST http://localhost:8000/api/categories \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "PHP & Laravel",
    "description": "Discussions sur PHP et Laravel",
    "slug": "php-laravel"
  }'
```

### 2. Créer un sujet
```bash
curl -X POST http://localhost:8000/api/topics \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "category_id": 1,
    "title": "Comment utiliser les relations Eloquent?",
    "content": "Je voudrais comprendre les relations Many-to-Many...",
    "slug": "eloquent-relations"
  }'
```

### 3. Répondre à un sujet
```bash
curl -X POST http://localhost:8000/api/posts \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "topic_id": 1,
    "content": "Les relations Many-to-Many se définissent avec belongsToMany()..."
  }'
```

### 4. Voter sur un message
```bash
curl -X POST http://localhost:8000/api/posts/1/vote \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"type": "like"}'
```

### 5. Récupérer les notifications
```bash
curl -X GET http://localhost:8000/api/notifications \
  -H "Authorization: Bearer {token}"
```

## Services

### VotingService
Service pour gérer les votes sur les messages:
- `vote()`: Voter sur un message
- `getVoteStats()`: Obtenir les statistiques de votes
- `getUserVote()`: Vérifier le vote de l'utilisateur

### BadgeService
Service pour gérer les badges:
- `awardBadge()`: Attribuer un badge
- `hasBadge()`: Vérifier si l'utilisateur a un badge
- `checkAndAwardBadges()`: Vérifier et attribuer automatiquement les badges
- `removeBadge()`: Retirer un badge

### NotificationService
Service pour gérer les notifications:
- `notifyReply()`: Notifier une réponse
- `notifyLike()`: Notifier un vote positif
- `getUnreadCount()`: Nombre de notifications non lues
- `markAsRead()`: Marquer comme lue
- `markAllAsRead()`: Marquer toutes comme lues

## Policies (Autorisation)

- **TopicPolicy**: Contrôle l'accès aux sujets
- **PostPolicy**: Contrôle l'accès aux messages
- **BadgePolicy**: Contrôle l'accès aux badges (admin seulement pour la création)
- **NotificationPolicy**: Contrôle l'accès aux notifications personnelles

## Configuration

### Activer les authentifications
Utilisez Laravel Sanctum pour les tokens API:
```bash
php artisan install:api
```

### Ajouter le rôle administrateur
Les utilisateurs avec `is_admin = true` peuvent:
- Créer/modifier/supprimer des catégories
- Modérer les contenus
- Créer/attribuer des badges
- Voir les logs de modération

## Développement

### Lancer les tests
```bash
php artisan test
```

### Générer les données de test
```bash
php artisan db:seed
```

### Supprimer et recréer la base de données
```bash
php artisan migrate:fresh --seed
```

## Considérations de sécurité

✅ Validation des requêtes  
✅ Autorisation des actions (Policies)  
✅ Protection CSRF (déjà intégrée)  
✅ Hachage des mots de passe  
✅ Authentification JWT/Sanctum  
✅ Rate limiting recommandé

## Améliorations futures

- [ ] Système de recherche avancée
- [ ] Filtriage par tags
- [ ] Système de suiveur/follower
- [ ] Notifications en temps réel (WebSockets)
- [ ] Système de rapports d'abus
- [ ] Histoire de l'édition des messages
- [ ] Archivage automatique des sujets anciens
- [ ] Intégration d'email pour les notifications
- [ ] Interface Web/Frontend

## Licence

Ce projet est sous licence MIT.

## Support

Pour toute question ou problème, veuillez créer une issue sur le repository.
