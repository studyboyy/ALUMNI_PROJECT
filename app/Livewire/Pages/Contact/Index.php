<?php

namespace App\Livewire\Pages\Contact;

use App\Models\ContactMessage;
use App\Models\FaqItem;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public string $name = '';

    public string $email = '';

    public string $subject = '';

    public string $message = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'string', 'min:5'],
            'message' => ['required', 'string', 'min:20'],
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        ContactMessage::query()->create($validated);

        $this->reset('name', 'email', 'subject', 'message');
        $this->dispatch('toast', type: 'success', message: 'Pesan berhasil dikirim. Tim alumni akan menindaklanjuti segera.');
    }

    public function render(): View
    {
        return view('livewire.pages.contact.index', [
            'faqs' => FaqItem::query()->orderBy('sort_order')->get(),
            'contactChannels' => [
                ['label' => 'Email Humas', 'value' => 'humas@alumni-fti.test'],
                ['label' => 'WhatsApp Admin', 'value' => '+62 811-2222-3333'],
                ['label' => 'Sekretariat', 'value' => 'Gedung FTI Lt. 2, Kampus Utama'],
            ],
        ]);
    }
}
