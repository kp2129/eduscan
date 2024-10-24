<?php

namespace App\Filament\Resources\ClassResource\RelationManagers;

use App\Models\User;
use App\Models\ScannedQRCode;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;

class ClassUsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'name';

    public function table(Tables\Table $table): Tables\Table
    {
        $users = User::all();
        foreach ($users as $user) {
            $scannedToday = ScannedQRCode::where('user_id', $user->id)
                ->whereDate('scanned_at', Carbon::today())
                ->exists();

            if (!$scannedToday) {
                $user->update(['is_at_school' => 0]);
            }
        }

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('surname')
                    ->label('Surname')
                    ->searchable(),
                Tables\Columns\BooleanColumn::make('is_at_school')
                    ->label('Is at school')
                    ->getStateUsing(fn(User $record): bool => $record->is_at_school)
                    ->color(fn(User $record) => $record->is_at_school ? 'success' : 'danger'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->mutateFormDataUsing(function (array $data) {
                        $data['is_at_school'] = $data['is_at_school'] ? 1 : 0;
                        return $data;
                    })
                    ->action(function (User $record, array $data) {
                        $record->update($data);

                        if ($data['is_at_school']) {
                            $fakeToken = Str::random(32);

                            ScannedQRCode::create([
                                'user_id' => $record->id,
                                'token' => $fakeToken,
                                'scanned_at' => now(),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }

                        Notification::make()
                            ->title('User updated')
                            ->success()
                            ->body('The user\'s school status has been updated, and a fake token has been created.')
                            ->send();
                    }),
            ])
            ->bulkActions([])
            ->filters([])
            ->searchable();
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Checkbox::make('is_at_school')
                ->label('Is at school')
                ->default(false)
        ])
        ->model(User::class);
    }
}
