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
| user_id | Integer | Créateur de l'arrangement | FK → User.id |
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

### Like (Appréciation)
| Attribut | Type | Description | Contraintes |
|----------|------|-------------|-------------|
| id | Integer | Identifiant unique | PK, Auto-increment |
| arrangement_id | Integer | Arrangement apprécié | FK → Arrangement.id |
| user_id | Integer | Utilisateur | FK → User.id |
| is_like | Boolean | Like (true) ou Dislike (false) | Required |
| created_at | Timestamp | Date de création | Auto |
| updated_at | Timestamp | Date de modification | Auto |

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

class Utilise {
  - track_number: Integer
}

class Appreciation {
  - is_like: Boolean
  - created_at: Timestamp
}

User "1" -- "0..*" Partition
User "**" -- "0..*" Arrangement
User "1" -- "0..*" Comment
User "1" -- "0..*" Appreciation

Partition "1" -- "0..*" Arrangement

Arrangement "1" -- "0..*" Comment
Arrangement "0..*" -- "0..*" Utilise
Utilise "0..*" -- "1" Instrument

Arrangement "0..*" -- "0..*" Appreciation
```

---

## MLD (Modèle Logique de Données)

```plantuml
@startuml
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
  <b>id</b>: INTEGER
  --
  <i>arrangement_id</i>: INTEGER
  <i>instrument_id</i>: INTEGER
  track_number: INTEGER
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
  <i>arrangement_id</i>: INTEGER
  <i>user_id</i>: INTEGER
  is_like: BOOLEAN
  created_at: TIMESTAMP
}

entity "user_arrangements" as user_arrangements {
  <b>id</b>: INTEGER
  --
  <i>user_id</i>: INTEGER
  <i>arrangement_id</i>: INTEGER
  created_at: TIMESTAMP
}

users ||--o{ partitions : "user_id"
users ||--o{ user_arrangements : "user_id"
users ||--o{ comments : "user_id"
users ||--o{ appreciations : "user_id"

partitions ||--o{ arrangements : "partition_id"

arrangements ||--o{ arrangement_instruments : "arrangement_id"
arrangements ||--o{ comments : "arrangement_id"
arrangements ||--o{ appreciations : "arrangement_id"
arrangements ||--o{ user_arrangements : "arrangement_id"

instruments ||--o{ arrangement_instruments : "instrument_id"

@enduml
```
