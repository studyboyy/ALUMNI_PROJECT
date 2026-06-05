<?php

namespace App\Livewire\Pages\Admin;

use App\Models\OrganizationMember;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class OrganizationManager extends Component
{
    use WithFileUploads;

    public bool $showForm = false;
    public ?int $editingId = null;

    public string $name = '';
    public string $role = '';
    public string $division = '';
    public string $period = '';
    public string $focus_area = '';
    public string $photo_url = '';
    public $photo_file = null;
    public string $sort_order = '0';

    protected function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'min:3'],
            'role'       => ['required', 'string'],
            'division'   => ['required', 'string'],
            'period'     => ['required', 'string'],
            'focus_area' => ['nullable', 'string', 'max:255'],
            'photo_url'  => ['nullable', 'string'],
            'photo_file' => ['nullable', 'image', 'max:3072'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ];
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $member = OrganizationMember::findOrFail($id);

        $this->editingId   = $member->id;
        $this->name        = $member->name;
        $this->role        = $member->role;
        $this->division    = $member->division;
        $this->period      = $member->period;
        $this->focus_area  = $member->focus_area ?? '';
        $this->photo_url   = $member->photo_url ?? '';
        $this->sort_order  = (string) $member->sort_order;
        $this->showForm    = true;
    }

    public function save(): void
    {
        $validated = $this->validate();

        if ($this->photo_file) {
            $path = $this->photo_file->storePublicly('org-photos', 'public');
            $this->photo_url = asset('storage/' . $path);
        }

        $data = [
            'name'       => $validated['name'],
            'role'       => $validated['role'],
            'division'   => $validated['division'],
            'period'     => $validated['period'],
            'focus_area' => $validated['focus_area'] ?: null,
            'photo_url'  => $this->photo_url ?: null,
            'sort_order' => (int) $validated['sort_order'],
        ];

        if ($this->editingId) {
            OrganizationMember::findOrFail($this->editingId)->update($data);
            $this->dispatch('toast', type: 'success', message: 'Data pengurus berhasil diperbarui.');
        } else {
            OrganizationMember::create($data);
            $this->dispatch('toast', type: 'success', message: 'Pengurus baru berhasil ditambahkan.');
        }

        $this->resetForm();
    }

    public function delete(int $id): void
    {
        OrganizationMember::findOrFail($id)->delete();
        $this->dispatch('toast', type: 'success', message: 'Pengurus berhasil dihapus.');
    }

    public function cancel(): void
    {
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->showForm   = false;
        $this->editingId  = null;
        $this->photo_file = null;
        $this->reset(['name', 'role', 'division', 'period', 'focus_area', 'photo_url']);
        $this->sort_order = '0';
    }

    public function render(): View
    {
        return view('livewire.pages.admin.organization-manager', [
            'members' => OrganizationMember::query()->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }
}
