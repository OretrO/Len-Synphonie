# Admin management feature removed

The experimental admin management feature (users/comments dashboard, `/admin/manage`) has been removed for simplicity.

Removed parts:
- Routes under the `admin` prefix in `routes/web.php`.
- Controllers: `Admin\\AdminDashboardController`, `Admin\\UserManagementController`, `Admin\\CommentManagementController` are no longer referenced.
- Views under `resources/views/admin/*` are no longer used.
- Gate `manage-users` and `UserPolicy` have been detached from `AuthServiceProvider`.

The rest of the application (home, partitions, profile, arrangements) continues to work as before.

