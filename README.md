# 🧬 Game of Life

Une implémentation interactive du [Jeu de la Vie de Conway](https://fr.wikipedia.org/wiki/Jeu_de_la_vie), construite avec **Laravel**, **Vue 3** et **Inertia.js**.

---

## ✨ Fonctionnalités

- **Grille interactive** — Dessinez des cellules vivantes à la souris (clic et glisser)
- **Simulation** — Démarrez, arrêtez et réinitialisez la simulation à tout moment
- **Paramètres personnalisables** :
  - Taille de la grille (10 × 10 à 50 × 50)
  - Vitesse de mise à jour (100 ms à 1 000 ms)
  - Couleur des cellules avec un sélecteur de couleur
  - Règles de survie et de naissance configurables (min survie, max survie, seuil de naissance)
- **Mélange de couleurs** — Les nouvelles cellules héritent d'une couleur fusionnée de leurs voisines vivantes
- **Compteur de cycles** — Suivez le nombre de générations écoulées
- **Authentification** — Inscription, connexion, réinitialisation de mot de passe
- **Sauvegardes** — Enregistrez et rechargez vos configurations depuis le tableau de bord (nécessite un compte)
- **Mode sombre / clair** — Thème adaptatif

---

## 🛠️ Stack technique

| Couche      | Technologie                                  |
|-------------|----------------------------------------------|
| Backend     | PHP 8.2+, Laravel 12, SQLite                 |
| Frontend    | Vue 3, TypeScript, Vite                      |
| Bridge      | Inertia.js                                   |
| UI          | Tailwind CSS, shadcn/ui (Radix Vue / Reka UI)|
| Tests       | Pest                                         |

---

## 🚀 Installation

### Option A — Docker (recommandé)

> **Prérequis :** [Docker](https://docs.docker.com/get-docker/) ≥ 24 avec le plugin Compose V2.

```bash
# 1. Cloner le dépôt
git clone https://github.com/zdossantos/life-game.git
cd life-game

# 2. Démarrer l'environnement de développement
docker compose up
```

Au premier démarrage, Docker :
- installe les dépendances PHP et JavaScript
- crée le fichier `.env` et génère la clé d'application
- crée la base SQLite et exécute les migrations

L'application est ensuite disponible sur :
- **[http://localhost:8000](http://localhost:8000)** — Laravel
- **[http://localhost:5173](http://localhost:5173)** — Vite HMR (utilisé automatiquement)

#### Commandes Docker utiles

| Commande | Description |
|---|---|
| `docker compose up` | Démarre les services (Ctrl+C pour arrêter) |
| `docker compose up -d` | Démarre en arrière-plan |
| `docker compose down` | Arrête et supprime les conteneurs |
| `docker compose exec app sh` | Ouvre un shell dans le conteneur PHP |
| `docker compose exec app php artisan migrate` | Exécute les migrations |
| `docker compose exec app php artisan test` | Lance les tests |
| `docker compose logs -f` | Affiche les logs en continu |

---

### Option B — Installation locale

**Prérequis :** PHP ≥ 8.2, Composer, Node.js ≥ 18, pnpm

```bash
# 1. Cloner le dépôt
git clone https://github.com/zdossantos/life-game.git
cd life-game

# 2. Installer les dépendances PHP
composer install

# 3. Copier et configurer le fichier d'environnement
cp .env.example .env
php artisan key:generate

# 4. Créer la base de données et lancer les migrations
touch database/database.sqlite
php artisan migrate

# 5. Installer les dépendances JavaScript
pnpm install   # ou : npm install

# 6. Lancer le serveur de développement
composer run dev
```

L'application sera disponible sur [http://localhost:8000](http://localhost:8000).

---

## 🖥️ Déploiement sur VPS

```bash
# 1. Cloner le dépôt sur le serveur
git clone https://github.com/zdossantos/life-game.git
cd life-game

# 2. Créer le fichier .env de production
cp .env.example .env
# Éditer .env : APP_ENV=production, APP_DEBUG=false, APP_URL=https://votre-domaine.com
# Générer APP_KEY :
docker compose -f docker-compose.prod.yml run --rm app php artisan key:generate --show
# Copier la clé obtenue dans .env : APP_KEY=base64:...

# 3. Construire et démarrer
docker compose -f docker-compose.prod.yml up -d --build
```

L'application écoute sur le port **80**. Placez Nginx, Caddy ou Traefik en reverse proxy devant elle pour gérer HTTPS.

#### Mise à jour

```bash
git pull
docker compose -f docker-compose.prod.yml up -d --build
```

Les données (base SQLite, fichiers uploadés) sont persistées dans des volumes Docker nommés et ne sont pas affectées par les mises à jour.

---

## 📜 Commandes utiles

| Commande                  | Description                                           |
|---------------------------|-------------------------------------------------------|
| `composer run dev`        | Lance le serveur PHP, la queue, les logs et Vite      |
| `npm run build`           | Compile les assets pour la production                 |
| `npm run lint`            | Analyse et corrige le code JS/TS avec ESLint          |
| `npm run format`          | Formate le code avec Prettier                         |
| `php artisan test`        | Lance la suite de tests Pest                          |
| `./vendor/bin/pint`       | Formate le code PHP avec Laravel Pint                 |

---

## 🎮 Utilisation

1. **Dessiner** — Cliquez ou glissez sur la grille pour activer/désactiver des cellules (simulation arrêtée uniquement)
2. **Démarrer** — Cliquez sur *Démarrer* pour lancer la simulation
3. **Arrêter** — Cliquez sur *Arrêter* pour mettre la simulation en pause
4. **Réinitialiser** — Efface la grille et remet le compteur de cycles à zéro
5. **Sauvegarder** — Connectez-vous pour sauvegarder l'état actuel ; retrouvez vos sauvegardes dans le tableau de bord

---

## 📁 Structure du projet

```
├── app/
│   ├── Http/Controllers/   # Contrôleurs (Auth, Save, Settings)
│   └── Models/             # Modèles Eloquent (User, Save)
├── resources/js/
│   ├── components/         # Composants Vue (GameGrid, GameControls, UI)
│   ├── pages/              # Pages Inertia (Home, Dashboard, Auth, Settings)
│   ├── layouts/            # Layouts de l'application
│   └── types/              # Types TypeScript (Cell, Grid, GameSettings…)
├── routes/
│   ├── web.php             # Routes principales
│   ├── auth.php            # Routes d'authentification
│   └── settings.php        # Routes des paramètres
└── database/               # Migrations et factories
```

---

## 📄 Licence

Ce projet est distribué sous licence [MIT](https://opensource.org/licenses/MIT).
