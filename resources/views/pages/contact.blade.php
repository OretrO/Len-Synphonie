@extends('layouts.app')

@section('title', 'Contact')

@section('content')
    <div class="page-container">
        <div class="card">
            <h1 class="card-title">Contact</h1>

            <p class="card-text">
                For any question about the LenSymphony-Web project, you can contact
                the teaching staff or the team members through the usual channels
                (ENT, GitLab, etc.).
            </p>

            <form method="post" action="#" class="contact-form">
                @csrf
                <div class="form-field">
                    <label class="form-label">Email address</label>
                    <input type="email" class="form-input" placeholder="your.email@example.com" disabled>
                </div>

                <div class="form-field">
                    <label class="form-label">Message</label>
                    <textarea class="form-input form-textarea" rows="4" placeholder="Demo form (not functional in sprint 1)." disabled></textarea>
                </div>

                <p class="form-hint">
                    This form is only for demonstration purposes in sprint 1.
                </p>
            </form>
        </div>
    </div>
@endsection

