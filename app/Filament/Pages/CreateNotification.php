<?php

namespace App\Filament\Pages;

use Filament\Schemas\Schema;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class CreateNotification extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'filament.pages.create-notification';

    public ?array $data = [];

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('message')
                    ->label(__('Message'))
                    ->required()
                    ->maxLength(160),
            ])
            ->statePath('data');
    }

    public function send(): void
    {
        $data = $this->form->getState();
        $recipient = auth('web')->user();

        $notification = Notification::make()
            ->success()
            ->title(__('filament-actions::edit.single.notifications.saved.title'))
            ->body($data['message'])
            ->send();

        $notification->actions([
            Action::make('view')
                ->button()
                ->markAsRead(),
        ])
            ->sendToDatabase($recipient);
    }
}
