<?php

namespace App\Livewire\Pages\Auth;

use App\Models\AlumniProfile;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $passwordConfirmation = '';

    public string $program = '';

    public string $campusName = '';

    public string $batchYear = '';

    public string $graduationYear = '';

    public string $phone = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8'],
            'passwordConfirmation' => ['required', 'same:password'],
            'program' => ['required', 'string', 'max:120'],
            'campusName' => ['required', 'string', 'max:180'],
            'batchYear' => ['required', 'integer', 'min:1990', 'max:2100'],
            'graduationYear' => ['nullable', 'integer', 'min:1990', 'max:2100'],
            'phone' => ['nullable', 'string', 'max:40'],
        ];
    }

    public function register(): void
    {
        $validated = $this->validate();

        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'alumni',
        ]);

        AlumniProfile::query()->create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::lower(Str::random(5)),
            'email' => $validated['email'],
            'phone' => $validated['phone'] !== '' ? $validated['phone'] : null,
            'program' => $validated['program'],
            'campus_name' => $validated['campusName'],
            'batch_year' => (int) $validated['batchYear'],
            'graduation_year' => $validated['graduationYear'] !== '' ? (int) $validated['graduationYear'] : null,
            'employment_status' => 'Bekerja',
        ]);

        Auth::login($user);
        session()->regenerate();

        $this->redirect(route('alumni.dashboard'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.pages.auth.register');
    }
}
