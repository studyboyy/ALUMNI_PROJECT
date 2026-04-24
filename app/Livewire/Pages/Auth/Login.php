<?php

namespace App\Livewire\Pages\Auth;

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
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    public function authenticate(): void
    {
        $credentials = $this->validate();

        if (! Auth::attempt($credentials)) {
            $this->addError('email', 'Email atau password tidak valid.');

            return;
        }

        session()->regenerate();

        $user = Auth::user();

        if ($user?->isAdmin()) {
            $this->redirect(route('admin.jobs'), navigate: true);

            return;
        }

        $this->redirect(route('alumni.dashboard'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.pages.auth.login');
    }
}
