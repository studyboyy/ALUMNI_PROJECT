<?php

namespace App\Livewire\Pages\Auth;

use App\Models\AlumniProfile;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class Register extends Component
{
    public string $email = '';

    public string $password = '';

    public string $passwordConfirmation = '';

    public string $nimQuery = '';

    /** @var array<int, array{id:int,nim:?string,name:string,program:string,batch_year:int,campus_name:?string,is_registered:bool}> */
    public array $nimResults = [];

    public ?int $alumniProfileId = null;

    public function updatedNimQuery(): void
    {
        $this->resetErrorBag('alumniProfileId');
        $query = trim($this->nimQuery);

        if ($this->alumniProfileId) {
            $selectedNim = AlumniProfile::query()
                ->whereKey($this->alumniProfileId)
                ->value('nim');

            if (is_string($selectedNim) && $selectedNim === $query) {
                $this->nimResults = [];
                return;
            }
        }

        $this->alumniProfileId = null;

        if ($query === '') {
            $this->nimResults = [];
            return;
        }

        $results = AlumniProfile::query()
            ->select(['id', 'nim', 'name', 'program', 'batch_year', 'campus_name', 'user_id'])
            ->whereNotNull('nim', 'and')
            ->where('nim', 'like', "%{$query}%")
            ->orderByRaw('case when user_id is null then 0 else 1 end')
            ->orderBy('nim', 'asc')
            ->limit(8)
            ->get();

        $this->nimResults = $results
            ->map(fn(AlumniProfile $profile) => [
                'id' => $profile->id,
                'nim' => $profile->nim,
                'name' => $profile->name,
                'program' => $profile->program,
                'batch_year' => (int) $profile->batch_year,
                'campus_name' => $profile->campus_name,
                'is_registered' => $profile->user_id !== null,
            ])
            ->all();

        $exact = $results->firstWhere('nim', $query);
        if ($exact) {
            $this->selectAlumni((int) $exact->id);
        }
    }

    public function selectAlumni(int $id): void
    {
        $profile = AlumniProfile::query()
            ->select(['id', 'nim', 'name', 'program', 'batch_year', 'campus_name', 'user_id'])
            ->whereKey($id)
            ->first();

        if (! $profile) {
            return;
        }

        if ($profile->user_id !== null) {
            $this->addError('alumniProfileId', 'NIM sudah terdaftar di website. Silakan login.');

            return;
        }

        $this->alumniProfileId = $profile->id;
        $this->nimQuery = $profile->nim ?? '';
        $this->nimResults = [];
    }

    public function getSelectedAlumniProperty(): ?AlumniProfile
    {
        if (! $this->alumniProfileId) {
            return null;
        }

        return AlumniProfile::query()->find($this->alumniProfileId);
    }

    protected function rules(): array
    {
        return [
            'alumniProfileId' => [
                'required',
                'integer',
                Rule::exists('alumni_profiles', 'id')->whereNull('user_id'),
            ],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8'],
            'passwordConfirmation' => ['required', 'same:password'],
        ];
    }

    public function register(): void
    {
        $validated = $this->validate();

        DB::transaction(function () use ($validated) {
            $alumniProfile = AlumniProfile::query()
                ->whereKey($validated['alumniProfileId'])
                ->whereNull('user_id')
                ->lockForUpdate()
                ->firstOrFail();

            $user = User::query()->create([
                'name' => $alumniProfile->name,
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'alumni',
            ]);

            $alumniProfile->update([
                'user_id' => $user->id,
                'email' => $validated['email'],
            ]);

            Auth::login($user);
        });

        session()->regenerate();

        $this->redirect(route('alumni.dashboard'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.pages.auth.register');
    }
}
