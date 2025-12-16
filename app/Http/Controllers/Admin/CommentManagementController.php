<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;

class CommentManagementController extends Controller
{
    public function index()
    {
        Gate::authorize('manage-users');

        $comments = Comment::with(['user', 'partition', 'arrangement'])
            ->latest()
            ->paginate(30);

        return view('admin.comments.index', compact('comments'));
    }

    public function destroy(Comment $comment)
    {
        Gate::authorize('manage-users');

        $comment->delete();

        return redirect()->route('admin.comments.index')->with('success', 'Comment deleted successfully.');
    }
}

