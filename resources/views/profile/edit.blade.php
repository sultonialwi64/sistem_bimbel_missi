@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'Profile')
@section('page-subtitle', 'Kelola informasi akun dan foto profil Anda.')

@section('content')
<div class="max-w-5xl space-y-6">
    <div class="rounded-2xl border border-slate-700/50 bg-white p-5 shadow-xl sm:p-8">
        <div class="max-w-2xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="rounded-2xl border border-slate-700/50 bg-white p-5 shadow-xl sm:p-8">
        <div class="max-w-2xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="rounded-2xl border border-red-200/70 bg-white p-5 shadow-xl sm:p-8">
        <div class="max-w-2xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
