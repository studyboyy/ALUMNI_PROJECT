<?php

namespace App\Livewire\Pages\Admin;

use App\Models\ChatMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class ForumChat extends Component
{
    public string $body = '';

    public ?int $replyToId = null;

    /** @var array<int, array{id:int,body:string,created_at:?string,user:array{id:int,name:?string,role:?string,photo_url:?string,initials:?string},reply_to:?array{id:int,body:string,user:array{id:int,name:?string}}}> */
    public array $messages = [];

    public function mount(): void
    {
        $this->loadMessages();
    }

    public function loadMessages(): void
    {
        $items = ChatMessage::query()
            ->with([
                'user.alumniProfile',
                'replyTo.user',
            ])
            ->latest('id')
            ->limit(80)
            ->get()
            ->reverse()
            ->values();

        $this->messages = $items
            ->map(fn(ChatMessage $message) => [
                'id' => $message->id,
                'body' => $message->body,
                'created_at' => $message->created_at?->diffForHumans(),
                'user' => [
                    'id' => (int) $message->user_id,
                    'name' => $message->user?->name,
                    'role' => $message->user?->role,
                    'photo_url' => $message->user?->alumniProfile?->photo_url,
                    'initials' => $message->user?->initials(),
                ],
                'reply_to' => $message->replyTo
                    ? [
                        'id' => (int) $message->replyTo->id,
                        'body' => (string) $message->replyTo->body,
                        'user' => [
                            'id' => (int) $message->replyTo->user_id,
                            'name' => $message->replyTo->user?->name,
                        ],
                    ]
                    : null,
            ])
            ->all();
    }

    protected function rules(): array
    {
        return [
            'body' => ['required', 'string', 'max:1000'],
        ];
    }

    public function send(): void
    {
        $validated = $this->validate();

        ChatMessage::query()->create([
            'user_id' => (int) Auth::id(),
            'reply_to_id' => $this->replyToId,
            'body' => trim($validated['body']),
        ]);

        $this->body = '';
        $this->replyToId = null;
        $this->loadMessages();
        $this->dispatch('chat:scroll');
    }

    public function reply(int $messageId): void
    {
        $this->replyToId = $messageId;
        $this->dispatch('chat:focus');
    }

    public function cancelReply(): void
    {
        $this->replyToId = null;
    }

    public function render(): View
    {
        return view('livewire.pages.admin.forum-chat');
    }
}
