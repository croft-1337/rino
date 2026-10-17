<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use App\Support\Defaults\DefaultContent;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Throwable;

class EditPage extends EditRecord
{
    protected static string $resource =
        PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make(
                'resetDefault'
            )
                ->label(
                    'Reset to Default'
                )
                ->icon(
                    'heroicon-o-arrow-path'
                )
                ->color(
                    'gray'
                )
                ->visible(
                    fn (): bool =>
                        filled(
                            $this->record
                                ->default_key
                        )
                        &&
                        DefaultContent::exists(
                            $this->record
                                ->default_key
                        )
                )
                ->requiresConfirmation()
                ->modalHeading(
                    'Reset page to default?'
                )
                ->modalDescription(
                    'This will replace the page content with the original Rino default. Your slug, navigation placement, active status, and sort order will be preserved.'
                )
                ->modalSubmitActionLabel(
                    'Reset Page'
                )
                ->action(
                    function (): void {
                        try {
                            DefaultContent::reset(
                                $this->record
                            );

                            $this->record
                                ->refresh();

                            $this->fillForm();

                            Notification::make()
                                ->title(
                                    'Page reset to default'
                                )
                                ->success()
                                ->send();
                        } catch (
                            Throwable $exception
                        ) {
                            Notification::make()
                                ->title(
                                    'Unable to reset page'
                                )
                                ->body(
                                    $exception
                                        ->getMessage()
                                )
                                ->danger()
                                ->send();
                        }
                    }
                ),

            DeleteAction::make(),
        ];
    }
}