<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class CreateNotification extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.create-notification';

    public ?array $data = [];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('message')
                    ->label(__('Message'))
                    ->required()
                    ->maxLength(160)
                    ->helperText('After you send the notification, go to filament-v4 branch and send the message again to see the difference'),
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
