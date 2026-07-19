<?php

namespace App\Livewire\Pages\Admin;

use App\Models\FaqItem;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class FaqManager extends Component
{
    public bool $showForm = false;

    public ?int $editingId = null;

    public string $question = '';

    public string $answer = '';

    public string $sort_order = '0';

    protected function rules(): array
    {
        return [
            'question' => ['required', 'string', 'min:10'],
            'answer' => ['required', 'string', 'min:10'],
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
        $faq = FaqItem::findOrFail($id);

        $this->editingId = $faq->id;
        $this->question = $faq->question;
        $this->answer = $faq->answer;
        $this->sort_order = (string) $faq->sort_order;
        $this->showForm = true;
    }

    public function save(): void
    {
        $validated = $this->validate();

        $data = [
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'sort_order' => (int) $validated['sort_order'],
        ];

        if ($this->editingId) {
            FaqItem::findOrFail($this->editingId)->update($data);
            $this->dispatch('toast', type: 'success', message: 'FAQ berhasil diperbarui.');
        } else {
            FaqItem::create($data);
            $this->dispatch('toast', type: 'success', message: 'FAQ baru berhasil ditambahkan.');
        }

        $this->resetForm();
    }

    public function delete(int $id): void
    {
        FaqItem::findOrFail($id)->delete();
        $this->dispatch('toast', type: 'success', message: 'FAQ berhasil dihapus.');
    }

    public function cancel(): void
    {
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->showForm = false;
        $this->editingId = null;
        $this->reset(['question', 'answer']);
        $this->sort_order = '0';
    }

    public function render(): View
    {
        return view('livewire.pages.admin.faq-manager', [
            'faqs' => FaqItem::query()->orderBy('sort_order')->get(),
        ]);
    }
}
