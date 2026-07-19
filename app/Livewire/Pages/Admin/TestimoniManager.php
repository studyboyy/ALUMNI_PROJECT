<?php

namespace App\Livewire\Pages\Admin;

use App\Models\Testimonial;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class TestimoniManager extends Component
{
    use WithFileUploads;

    public bool $showForm = false;

    public ?int $editingId = null;

    public string $name = '';

    public string $role = '';

    public string $company = '';

    public string $quote = '';

    public string $photo_url = '';

    public $photo_file = null;

    public string $batch_year = '';

    public string $sort_order = '0';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'role' => ['required', 'string'],
            'company' => ['nullable', 'string'],
            'quote' => ['required', 'string', 'min:10'],
            'photo_url' => ['nullable', 'string'],
            'photo_file' => ['nullable', 'image', 'max:3072'],
            'batch_year' => ['nullable', 'integer', 'min:1990', 'max:2100'],
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
        $t = Testimonial::findOrFail($id);

        $this->editingId = $t->id;
        $this->name = $t->name;
        $this->role = $t->role;
        $this->company = $t->company ?? '';
        $this->quote = $t->quote;
        $this->photo_url = $t->photo_url ?? '';
        $this->batch_year = (string) ($t->batch_year ?? '');
        $this->sort_order = (string) $t->sort_order;
        $this->showForm = true;
    }

    public function save(): void
    {
        $validated = $this->validate();

        if ($this->photo_file) {
            $path = $this->photo_file->storePublicly('testimoni-photos', 'public');
            $this->photo_url = asset('storage/'.$path);
        }

        $data = [
            'name' => $validated['name'],
            'role' => $validated['role'],
            'company' => $validated['company'] ?: null,
            'quote' => $validated['quote'],
            'photo_url' => $this->photo_url ?: null,
            'batch_year' => $validated['batch_year'] ?: null,
            'sort_order' => (int) $validated['sort_order'],
        ];

        if ($this->editingId) {
            Testimonial::findOrFail($this->editingId)->update($data);
            $this->dispatch('toast', type: 'success', message: 'Testimoni berhasil diperbarui.');
        } else {
            Testimonial::create($data);
            $this->dispatch('toast', type: 'success', message: 'Testimoni baru berhasil ditambahkan.');
        }

        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Testimonial::findOrFail($id)->delete();
        $this->dispatch('toast', type: 'success', message: 'Testimoni berhasil dihapus.');
    }

    public function cancel(): void
    {
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->showForm = false;
        $this->editingId = null;
        $this->photo_file = null;
        $this->reset(['name', 'role', 'company', 'quote', 'photo_url', 'batch_year']);
        $this->sort_order = '0';
    }

    public function render(): View
    {
        return view('livewire.pages.admin.testimoni-manager', [
            'testimonials' => Testimonial::query()->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }
}
