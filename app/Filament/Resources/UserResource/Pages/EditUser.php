<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\AuditLog;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(function ($record) {
                    AuditLog::registrar('excluiu', $record, $record->toArray());
                }),
        ];
    }

    protected function afterSave(): void
    {
        AuditLog::registrar(
            'editou',
            $this->record,
            $this->record->getOriginal(),
            $this->record->toArray()
        );
    }
}
