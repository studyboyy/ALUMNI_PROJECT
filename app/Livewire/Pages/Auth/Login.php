<?php

namespace App\Livewire\Pages\Auth;

use App\Models\AlumniProfile;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class Login extends Component
{
    public string $email = '';

    public string $password = '';

    protected function rules(): array
    {
        return [
            'email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    public function authenticate(): void
    {
        $credentials = $this->validate();

        $identifier = trim((string) $credentials['email']);
        $resolvedEmail = $identifier;

        if (! filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $profile = AlumniProfile::query()
                ->where('nim', $identifier)
                ->first();

            if (! $profile) {
                $this->addError('email', 'NIM atau email tidak ditemukan.');

                return;
            }

            if (! $profile->user_id) {
                $this->addError('email', 'NIM belum memiliki akun. Silakan daftar terlebih dahulu.');

                return;
            }

            $resolvedEmail = (string) $profile->user?->email;

            if ($resolvedEmail === '') {
                $this->addError('email', 'Akun untuk NIM ini belum siap. Silakan hubungi admin.');

                return;
            }
        }

        if (! Auth::attempt(['email' => $resolvedEmail, 'password' => $credentials['password']])) {
            $this->addError('email', 'Email atau password tidak valid.');

            return;
        }

        session()->regenerate();

        $user = Auth::user();

        if ($user?->isAdmin()) {
            $this->redirect(route('admin.dashboard'), navigate: true);

            return;
        }

        $this->redirect(route('alumni.dashboard'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.pages.auth.login');
    }
}
