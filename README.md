# Tableau des Tâches par Membre

| Sprint | Membre       | Tâches                  | Statut   |
|--------|--------------|-------------------------|----------|
| 1      | Regniez Léo  | \#12, \#13, \#14, \#15  | Terminée |
| 1      | Strobbe Théo | \#9, \#10, \#11         | Terminée |
| 1      | Bras Tristan | \#8, \#7, \#3           | Terminée |
| 1      | Plouvain     | \#6, \#5, \#4, \#2, \#1 | Terminée |


---

## Justification de l'Utilisation de l'IA

### Contexte
Le projet LenSymphony-Web est un projet SAE S3.A.01 nécessitant une stack technique complexe (Laravel, Vue.js, MusicXML, synthèse audio). L'IA à été utilisée pour accélérer certaines phases de développement cependant:
- 
- Chaque code généré est **revu et validé** avant intégration
- Les décisions techniques importantes sont **prises collectivement**




# Dictionnaire de Données - LenSymphony-Web

### User (Utilisateur)
| Attribut | Type | Description | Contraintes |
|----------|------|-------------|-------------|
| id | Integer | Identifiant unique | PK, Auto-increment |
| name | String | Nom de l'utilisateur | Required, Max: 255 |
| email | String | Adresse email | Required, Unique |
| password | String | Mot de passe hashé | Required, Min: 8 |
| role | Enum | Rôle de l'utilisateur | visitor, user, arranger, admin |
| created_at | Timestamp | Date de création | Auto |
| updated_at | Timestamp | Date de modification | Auto |

### Partition
| Attribut | Type | Description | Contraintes |
|----------|------|-------------|-------------|
| id | Integer | Identifiant unique | PK, Auto-increment |
| title | String | Titre de la partition | Required, Max: 255 |
| composer | String | Compositeur | Nullable, Max: 255 |
| musicxml_file_path | String | Chemin du fichier MusicXML | Required |
| user_id | Integer | Créateur de la partition | FK → User.id |
| created_at | Timestamp | Date d'import | Auto |
| updated_at | Timestamp | Date de modification | Auto |

### Arrangement
| Attribut | Type | Description | Contraintes |
|----------|------|-------------|-------------|
| id | Integer | Identifiant unique | PK, Auto-increment |
| partition_id | Integer | Partition associée | FK → Partition.id |
| creator_id | Integer | Créateur de l'arrangement | FK → User.id |
| name | String | Nom de l'arrangement | Required, Max: 255 |
| instruments_config | JSON | Configuration des instruments | Required |
| audio_file_path | String | Chemin du fichier audio généré | Nullable |
| status | Enum | Statut de la synthèse | pending, processing, completed, failed |
| created_at | Timestamp | Date de création | Auto |
| updated_at | Timestamp | Date de modification | Auto |

### Comment (Commentaire)
| Attribut | Type | Description | Contraintes |
|----------|------|-------------|-------------|
| id | Integer | Identifiant unique | PK, Auto-increment |
| arrangement_id | Integer | Arrangement commenté | FK → Arrangement.id |
| user_id | Integer | Auteur du commentaire | FK → User.id |
| content | Text | Contenu du commentaire | Required |
| created_at | Timestamp | Date de création | Auto |
| updated_at | Timestamp | Date de modification | Auto |

### Appreciation (Classe associative User-Arrangement)
| Attribut | Type | Description | Contraintes |
|----------|------|-------------|-------------|
| id | Integer | Identifiant unique | PK, Auto-increment |
| user_id | Integer | Utilisateur | FK → User.id |
| arrangement_id | Integer | Arrangement apprécié | FK → Arrangement.id |
| is_like | Boolean | Like (true) ou Dislike (false) | Required |
| created_at | Timestamp | Date de création | Auto |
| updated_at | Timestamp | Date de modification | Auto |

**Note :** Contrainte unique sur (user_id, arrangement_id) - un utilisateur ne peut apprécier qu'une seule fois le même arrangement.

### Instrument
| Attribut | Type | Description | Contraintes |
|----------|------|-------------|-------------|
| id | Integer | Identifiant unique | PK, Auto-increment |
| name | String | Nom de l'instrument | Required, Max: 255 |
| category | String | Catégorie (cordes, vents, etc.) | Nullable, Max: 255 |
| soundfont_file_path | String | Chemin du fichier soundfont | Required |
| created_at | Timestamp | Date de création | Auto |
| updated_at | Timestamp | Date de modification | Auto |

### ArrangementInstrument (Classe associative Arrangement-Instrument)
| Attribut | Type | Description | Contraintes |
|----------|------|-------------|-------------|
| arrangement_id | Integer | Arrangement | PK, FK → Arrangement.id |
| instrument_id | Integer | Instrument | PK, FK → Instrument.id |
| track_number | Integer | Numéro de piste | Required |
| created_at | Timestamp | Date de création | Auto |
| updated_at | Timestamp | Date de modification | Auto |

**Note :** Clé primaire composite sur (arrangement_id, instrument_id).

---

## MCD (Modèle Conceptuel de Données)

```plantuml
skinparam classAttributeIconSize 0
hide empty members

class User {
  - name: String
  - email: String {unique}
  - password: String
  - role: Enum
  - created_at: Timestamp
  - updated_at: Timestamp
}

class Partition {
  - title: String
  - composer: String
  - musicxml_file_path: String
  - created_at: Timestamp
  - updated_at: Timestamp
}

class Arrangement {
  - name: String
  - instruments_config: JSON
  - audio_file_path: String
  - status: Enum
  - created_at: Timestamp
  - updated_at: Timestamp
}

class Instrument {
  - name: String
  - category: String
  - soundfont_file_path: String
  - created_at: Timestamp
  - updated_at: Timestamp
}

class Comment {
  - content: Text
  - created_at: Timestamp
  - updated_at: Timestamp
}

class Utilise <<association>> {
  - track_number: Integer
}

class Appreciation <<association>> {
  - is_like: Boolean
  - created_at: Timestamp
}

User "1" -- "0..*" Partition : compose
User "**" -- "0..*" Arrangement : crée
(User, Arrangement) .. Appreciation
User "1" -- "0..*" Comment : écrit
Partition "1" -- "0..*" Arrangement : génère
Arrangement "1" -- "0..*" Comment : possède
Arrangement "0..*" -- "0..*" Instrument
(Arrangement, Instrument) .. Utilise
```

---

## MLD (Modèle Logique de Données)

```plantuml
hide methods
hide stereotypes

entity "users" as users {
  <b>id</b>: INTEGER
  --
  name: VARCHAR(255)
  email: VARCHAR(255) UNIQUE
  password: VARCHAR(255)
  role: ENUM('visitor','user','arranger','admin')
  created_at: TIMESTAMP
  updated_at: TIMESTAMP
}

entity "partitions" as partitions {
  <b>id</b>: INTEGER
  --
  title: VARCHAR(255)
  composer: VARCHAR(255) NULL
  musicxml_file_path: VARCHAR(255)
  <i>user_id</i>: INTEGER
  created_at: TIMESTAMP
  updated_at: TIMESTAMP
}

entity "arrangements" as arrangements {
  <b>id</b>: INTEGER
  --
  <i>partition_id</i>: INTEGER
  <i>creator_id</i>: INTEGER
  name: VARCHAR(255)
  instruments_config: JSON
  audio_file_path: VARCHAR(255) NULL
  status: ENUM('pending','processing','completed','failed')
  created_at: TIMESTAMP
  updated_at: TIMESTAMP
}

entity "instruments" as instruments {
  <b>id</b>: INTEGER
  --
  name: VARCHAR(255)
  category: VARCHAR(255)
  soundfont_file_path: VARCHAR(255)
  created_at: TIMESTAMP
  updated_at: TIMESTAMP
}

entity "arrangement_instruments" as arrangement_instruments {
  <b>arrangement_id, instrument_id</b>: PK
  --
  <i>arrangement_id</i>: INTEGER
  <i>instrument_id</i>: INTEGER
  track_number: INTEGER
  created_at: TIMESTAMP
  updated_at: TIMESTAMP
}

entity "comments" as comments {
  <b>id</b>: INTEGER
  --
  <i>arrangement_id</i>: INTEGER
  <i>user_id</i>: INTEGER
  content: TEXT
  created_at: TIMESTAMP
  updated_at: TIMESTAMP
}

entity "appreciations" as appreciations {
  <b>id</b>: INTEGER
  --
  <i>user_id</i>: INTEGER
  <i>arrangement_id</i>: INTEGER
  is_like: BOOLEAN
  created_at: TIMESTAMP
  updated_at: TIMESTAMP
  UNIQUE(user_id, arrangement_id)
}

' Relations directes (traits pleins)
users ||--o{ partitions : "user_id"
users ||--o{ arrangements : "creator_id"
users ||--o{ comments : "user_id"
partitions ||--o{ arrangements : "partition_id"
arrangements ||--o{ comments : "arrangement_id"

' Relations via classes associatives (traits pointillés)
users ||..o{ appreciations : "user_id"
arrangements ||..o{ appreciations : "arrangement_id"

arrangements ||..o{ arrangement_instruments : "arrangement_id"
instruments ||..o{ arrangement_instruments : "instrument_id"
```

### Structure détaillée des tables

#### **users** (table principale)
- Contient les informations des utilisateurs
- Champs : id, name, email, password, role, timestamps

#### **partitions** (table principale)
- Stocke les partitions musicales originales
- Clé étrangère : user_id → users(id)

#### **arrangements** (table principale)
- Représente les arrangements créés à partir des partitions
- Clé étrangère : partition_id → partitions(id)
- Clé étrangère : creator_id → users(id) [relation directe créateur]

#### **instruments** (table principale)
- Catalogue des instruments disponibles

#### **comments** (table principale)
- Commentaires sur les arrangements
- Clé étrangère : user_id → users(id)
- Clé étrangère : arrangement_id → arrangements(id)

#### **arrangement_instruments** (table associative)
- Lie les arrangements aux instruments utilisés
- Clé primaire composite : (arrangement_id, instrument_id)
- Attribut additionnel : track_number

#### **appreciations** (table associative - classe association)
- Lie les utilisateurs aux arrangements qu'ils apprécient
- Clé étrangère : user_id → users(id)
- Clé étrangère : arrangement_id → arrangements(id)
- Attribut additionnel : is_like (true = like, false = dislike)
- Contrainte unique sur (user_id, arrangement_id)

