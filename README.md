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

```plantuml
skinparam classAttributeIconSize 0

class User {
- id: Integer {PK}
- name: String
- email: String {unique}
- password: String
- role: Enum
- created_at: Timestamp
- updated_at: Timestamp
  }

class Partition {
- id: Integer {PK}
- title: String
- composer: String
- musicxml_file_path: String
- user_id: Integer {FK}
- created_at: Timestamp
- updated_at: Timestamp
  }

class Arrangement {
- id: Integer {PK}
- partition_id: Integer {FK}
- user_id: Integer {FK}
- name: String
- instruments_config: JSON
- audio_file_path: String
- status: Enum
- created_at: Timestamp
- updated_at: Timestamp
  }

class Comment {
- id: Integer {PK}
- arrangement_id: Integer {FK}
- user_id: Integer {FK}
- content: Text
- created_at: Timestamp
- updated_at: Timestamp
  }

class Like {
- id: Integer {PK}
- arrangement_id: Integer {FK}
- user_id: Integer {FK}
- is_like: Boolean
- created_at: Timestamp
- updated_at: Timestamp
  }

User "1" -- "0..*" Partition : crée >
User "1" -- "0..*" Arrangement : crée >
User "1" -- "0..*" Comment : rédige >
User "1" -- "0..*" Like : émet >

Partition "1" -- "0..*" Arrangement : génère >

Arrangement "1" -- "0..*" Comment : reçoit >
Arrangement "1" -- "0..*" Like : reçoit >

note right of User::role
visitor, user,
arranger, admin
end note

note right of Arrangement::status
pending, processing,
completed, failed
end note
```

---

## MLD (Modèle Logique de Données)

```plantuml
@startuml
!define Table(name,desc) class name as "desc" << (T,#FFAAAA) >>
!define primary_key(x) <b>x</b>
!define foreign_key(x) <i>x</i>
!define column(x) x

hide methods
hide stereotypes

entity "users" as users {
  primary_key(id): INTEGER
  --
  column(name): VARCHAR(255)
  column(email): VARCHAR(255) UNIQUE
  column(password): VARCHAR(255)
  column(role): ENUM('visitor','user','arranger','admin')
  column(created_at): TIMESTAMP
  column(updated_at): TIMESTAMP
}

entity "partitions" as partitions {
  primary_key(id): INTEGER
  --
  column(title): VARCHAR(255)
  column(composer): VARCHAR(255) NULL
  column(musicxml_file_path): VARCHAR(255)
  foreign_key(user_id): INTEGER
  column(created_at): TIMESTAMP
  column(updated_at): TIMESTAMP
}

entity "arrangements" as arrangements {
  primary_key(id): INTEGER
  --
  foreign_key(partition_id): INTEGER
  foreign_key(user_id): INTEGER
  column(name): VARCHAR(255)
  column(instruments_config): JSON
  column(audio_file_path): VARCHAR(255) NULL
  column(status): ENUM('pending','processing','completed','failed')
  column(created_at): TIMESTAMP
  column(updated_at): TIMESTAMP
}

entity "comments" as comments {
  primary_key(id): INTEGER
  --
  foreign_key(arrangement_id): INTEGER
  foreign_key(user_id): INTEGER
  column(content): TEXT
  column(created_at): TIMESTAMP
  column(updated_at): TIMESTAMP
}

entity "likes" as likes {
  primary_key(id): INTEGER
  --
  foreign_key(arrangement_id): INTEGER
  foreign_key(user_id): INTEGER
  column(is_like): BOOLEAN
  column(created_at): TIMESTAMP
  column(updated_at): TIMESTAMP
}

users ||--o{ partitions : "user_id"
users ||--o{ arrangements : "user_id"
users ||--o{ comments : "user_id"
users ||--o{ likes : "user_id"

partitions ||--o{ arrangements : "partition_id"

arrangements ||--o{ comments : "arrangement_id"
arrangements ||--o{ likes : "arrangement_id"

@enduml
```
