<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user()->loadMissing('tutor'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        unset($validated['avatar']);

        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if ($request->hasFile('avatar')) {
            $this->deleteStoredAvatar($request->user()->avatar);
            $request->user()->avatar = $this->storeCompressedAvatar($request);
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    private function storeCompressedAvatar(ProfileUpdateRequest $request): string
    {
        $file = $request->file('avatar');
        $imageContents = file_get_contents($file->getRealPath());
        $source = imagecreatefromstring($imageContents);

        if (! $source) {
            $path = $file->store('avatars', 'public');
            return Storage::url($path);
        }

        $width = imagesx($source);
        $height = imagesy($source);
        $cropSize = min($width, $height);
        $sourceX = (int) (($width - $cropSize) / 2);
        $sourceY = (int) (($height - $cropSize) / 2);
        $targetSize = 720;
        $target = imagecreatetruecolor($targetSize, $targetSize);

        imagecopyresampled(
            $target,
            $source,
            0,
            0,
            $sourceX,
            $sourceY,
            $targetSize,
            $targetSize,
            $cropSize,
            $cropSize
        );

        ob_start();
        imagejpeg($target, null, 78);
        $compressed = ob_get_clean();

        imagedestroy($source);
        imagedestroy($target);

        $path = 'avatars/avatar-' . $request->user()->id . '-' . time() . '.jpg';
        Storage::disk('public')->makeDirectory('avatars');

        if (! Storage::disk('public')->put($path, $compressed)) {
            $fallbackPath = $file->store('avatars', 'public');
            return Storage::url($fallbackPath);
        }

        return Storage::url($path);
    }

    private function deleteStoredAvatar(?string $avatarUrl): void
    {
        if (! $avatarUrl || ! str_starts_with($avatarUrl, '/storage/')) {
            return;
        }

        $path = str_replace('/storage/', '', $avatarUrl);

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
