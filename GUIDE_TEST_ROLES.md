# 🔐 Guide de Test des Rôles - LenSymphony

## 📋 Résumé des Rôles

| Rôle | Permissions | Accès |
|------|-------------|-------|
| **visitor** | Lecture seule | Accueil, Liste partitions |
| **user** | Lecture + commentaires | + Voir les partitions en détail |
| **arranger** | user + CRUD partitions/arrangements | + Créer, modifier, supprimer ses partitions |
| **admin** | Toutes permissions | + Gérer tous les utilisateurs et contenus |

---

## 🧪 Comptes de Test

Après avoir exécuté `php artisan migrate:fresh --seed`, utilisez ces comptes :

### 👤 Visitor (Visiteur)
```
Email    : visitor@lensymphony.com
Password : password
Rôle     : visitor
```
**Peut faire :**
- ✅ Accéder à la page d'accueil
- ✅ Voir la liste des partitions
- ❌ Accéder aux détails d'une partition
- ❌ Créer une partition
- ❌ Modifier/Supprimer

---

### 👤 User (Utilisateur)
```
Email    : user@lensymphony.com
Password : password
Rôle     : user
```
**Peut faire :**
- ✅ Tout ce que visitor peut faire
- ✅ Accéder aux détails d'une partition
- ✅ Commenter les arrangements
- ✅ Liker/Disliker les arrangements
- ❌ Créer une partition
- ❌ Modifier/Supprimer

---

### 👤 Arranger (Arrangeur)
```
Email    : arranger@lensymphony.com
Password : password
Rôle     : arranger
```
**Peut faire :**
- ✅ Tout ce que user peut faire
- ✅ **Créer une partition**
- ✅ **Modifier ses propres partitions**
- ✅ **Supprimer ses propres partitions**
- ✅ **Créer des arrangements**
- ✅ **Modifier ses propres arrangements**
- ✅ **Supprimer ses propres arrangements**
- ❌ Modifier/Supprimer les partitions des autres
- ❌ Gérer les utilisateurs

---

### 👤 Admin (Administrateur)
```
Email    : admin@lensymphony.com
Password : password
Rôle     : admin
```
**Peut faire :**
- ✅ **Tout ce que arranger peut faire**
- ✅ **Modifier/Supprimer TOUTES les partitions**
- ✅ **Modifier/Supprimer TOUS les arrangements**
- ✅ **Gérer les utilisateurs (ajouter, modifier, supprimer)**
- ✅ **Modifier les rôles des utilisateurs**

---

## 🧪 Scénarios de Test

### Test 1 : Connexion et Accès
1. **Se connecter avec `visitor@lensymphony.com`**
   - ✅ Devrait voir la page d'accueil
   - ✅ Devrait voir la liste des partitions
   - ❌ Ne devrait PAS pouvoir accéder à `/partitions/1`

2. **Se connecter avec `user@lensymphony.com`**
   - ✅ Devrait voir la page d'accueil
   - ✅ Devrait voir la liste des partitions
   - ✅ Devrait pouvoir accéder à `/partitions/1`
   - ❌ Ne devrait PAS voir de bouton "Créer une partition"

3. **Se connecter avec `arranger@lensymphony.com`**
   - ✅ Devrait voir un bouton "Créer une partition"
   - ✅ Devrait pouvoir créer une partition
   - ✅ Devrait pouvoir modifier ses propres partitions
   - ❌ Ne devrait PAS pouvoir modifier les partitions des autres

4. **Se connecter avec `admin@lensymphony.com`**
   - ✅ Devrait pouvoir tout faire
   - ✅ Devrait voir un lien "Admin" dans la navbar
   - ✅ Devrait pouvoir modifier toutes les partitions
   - ✅ Devrait pouvoir gérer les utilisateurs

---

## 📝 Commandes de Test

### 1. Réinitialiser la base de données avec les comptes de test
```bash
php artisan migrate:fresh --seed
```

### 2. Vérifier les utilisateurs créés
```bash
php artisan tinker
```
```php
User::all()->pluck('email', 'role');
// Devrait afficher les 4 comptes de test
```

### 3. Vérifier le rôle d'un utilisateur spécifique
```bash
php artisan tinker
```
```php
$user = User::where('email', 'arranger@lensymphony.com')->first();
echo $user->role; // Devrait afficher "arranger"
```

### 4. Changer le rôle d'un utilisateur manuellement
```bash
php artisan tinker
```
```php
$user = User::where('email', 'visitor@lensymphony.com')->first();
$user->role = 'user';
$user->save();
```

---

## 🛡️ Implémentation des Middlewares (À faire)

Pour sécuriser les routes selon les rôles, créez des middlewares :

### 1. Middleware `CheckRole`
```bash
php artisan make:middleware CheckRole
```

```php
// app/Http/Middleware/CheckRole.php
public function handle($request, Closure $next, ...$roles)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (!in_array(auth()->user()->role, $roles)) {
        abort(403, 'Accès refusé.');
    }

    return $next($request);
}
```

### 2. Enregistrement dans `app/Http/Kernel.php`
```php
protected $middlewareAliases = [
    // ...
    'role' => \App\Http\Middleware\CheckRole::class,
];
```

### 3. Utilisation dans les routes
```php
// routes/web.php

// Routes pour tous les visiteurs
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/partitions', [PartitionController::class, 'index'])->name('partitions.index');

// Routes pour utilisateurs connectés (user, arranger, admin)
Route::middleware(['auth', 'role:user,arranger,admin'])->group(function () {
    Route::get('/partitions/{partition}', [PartitionController::class, 'show'])->name('partitions.show');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
});

// Routes pour arrangers et admins
Route::middleware(['auth', 'role:arranger,admin'])->group(function () {
    Route::get('/partitions/create', [PartitionController::class, 'create'])->name('partitions.create');
    Route::post('/partitions', [PartitionController::class, 'store'])->name('partitions.store');
});

// Routes pour admins uniquement
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::patch('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
});
```

---

## 🔍 Vérification des Permissions dans les Vues Blade

### Cacher des éléments selon le rôle

```blade
{{-- Afficher le bouton "Créer" seulement pour arranger et admin --}}
@auth
    @if(in_array(auth()->user()->role, ['arranger', 'admin']))
        <a href="{{ route('partitions.create') }}" class="btn btn-primary">
            Créer une partition
        </a>
    @endif
@endauth

{{-- Afficher le lien Admin seulement pour les admins --}}
@auth
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.users') }}">Administration</a>
    @endif
@endauth

{{-- Boutons Modifier/Supprimer seulement si propriétaire ou admin --}}
@auth
    @if(auth()->user()->id === $partition->user_id || auth()->user()->role === 'admin')
        <a href="{{ route('partitions.edit', $partition) }}">Modifier</a>
        <form action="{{ route('partitions.destroy', $partition) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Supprimer</button>
        </form>
    @endif
@endauth
```

---

## 🎯 Checklist de Test

### Test Visitor
- [ ] Se connecter avec `visitor@lensymphony.com`
- [ ] Accéder à la page d'accueil ✅
- [ ] Voir la liste des partitions ✅
- [ ] Essayer d'accéder à `/partitions/1` → Devrait être refusé ❌
- [ ] Vérifier qu'il n'y a pas de bouton "Créer" ✅

### Test User
- [ ] Se connecter avec `user@lensymphony.com`
- [ ] Accéder aux détails d'une partition ✅
- [ ] Ajouter un commentaire ✅
- [ ] Liker/Disliker un arrangement ✅
- [ ] Essayer d'accéder à `/partitions/create` → Devrait être refusé ❌
- [ ] Vérifier qu'il n'y a pas de bouton "Créer partition" ✅

### Test Arranger
- [ ] Se connecter avec `arranger@lensymphony.com`
- [ ] Créer une partition ✅
- [ ] Modifier sa propre partition ✅
- [ ] Créer un arrangement ✅
- [ ] Essayer de modifier la partition d'un autre → Devrait être refusé ❌
- [ ] Essayer d'accéder à `/admin` → Devrait être refusé ❌

### Test Admin
- [ ] Se connecter avec `admin@lensymphony.com`
- [ ] Accéder à l'interface admin ✅
- [ ] Modifier n'importe quelle partition ✅
- [ ] Supprimer n'importe quelle partition ✅
- [ ] Gérer les utilisateurs ✅
- [ ] Changer le rôle d'un utilisateur ✅

---

## 🔧 Commandes Utiles

### Voir tous les utilisateurs avec leurs rôles
```bash
php artisan tinker
```
```php
User::all(['id', 'name', 'email', 'role'])->toArray();
```

### Créer un nouvel admin manuellement
```bash
php artisan tinker
```
```php
User::create([
    'name' => 'Nouveau Admin',
    'email' => 'newadmin@lensymphony.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
]);
```

### Promouvoir un utilisateur en admin
```bash
php artisan tinker
```
```php
$user = User::find(5); // ID de l'utilisateur
$user->role = 'admin';
$user->save();
```

---

## 🚀 Prochaines Étapes

1. ✅ Créer les middlewares de vérification de rôle
2. ✅ Protéger les routes selon les permissions
3. ✅ Ajouter les vérifications dans les contrôleurs
4. ✅ Masquer/Afficher les éléments UI selon les rôles
5. ✅ Tester tous les scénarios

---

**Note** : Les mots de passe par défaut sont tous `password` pour faciliter les tests.
En production, utilisez des mots de passe forts !

