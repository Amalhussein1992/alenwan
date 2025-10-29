<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserDeviceResource\Pages;
use App\Filament\Resources\UserDeviceResource\RelationManagers;
use App\Models\UserDevice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserDeviceResource extends Resource
{
    protected static ?string $model = UserDevice::class;

    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';

    protected static ?string $navigationLabel = 'User Devices';

    protected static ?string $modelLabel = 'Device';

    protected static ?string $pluralModelLabel = 'User Devices';

    protected static ?string $navigationGroup = 'إدارة المستخدمين';

    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Device Information')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required()
                            ->preload(),

                        Forms\Components\TextInput::make('device_name')
                            ->label('Device Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., iPhone 13 Pro'),

                        Forms\Components\Select::make('device_type')
                            ->label('Device Type')
                            ->options([
                                'mobile' => 'Mobile 📱',
                                'tablet' => 'Tablet 📱',
                                'tv' => 'TV 📺',
                                'web' => 'Web Browser 💻',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('device_id')
                            ->label('Device ID')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Unique identifier for this device'),
                    ])->columns(2),

                Forms\Components\Section::make('System Information')
                    ->schema([
                        Forms\Components\TextInput::make('os')
                            ->label('Operating System')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., iOS, Android, Windows'),

                        Forms\Components\TextInput::make('os_version')
                            ->label('OS Version')
                            ->maxLength(255)
                            ->placeholder('e.g., 16.0'),

                        Forms\Components\TextInput::make('app_version')
                            ->label('App Version')
                            ->maxLength(255)
                            ->placeholder('e.g., 1.0.0'),

                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP Address')
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Deactivate to prevent device from accessing the app'),

                        Forms\Components\TextInput::make('fcm_token')
                            ->label('FCM Token (Push Notifications)')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('device_name')
                    ->label('Device')
                    ->searchable()
                    ->sortable()
                    ->description(fn (UserDevice $record): string => $record->device_id),

                Tables\Columns\BadgeColumn::make('device_type')
                    ->label('Type')
                    ->colors([
                        'primary' => 'mobile',
                        'success' => 'tablet',
                        'warning' => 'tv',
                        'danger' => 'web',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'mobile' => '📱 Mobile',
                        'tablet' => '📱 Tablet',
                        'tv' => '📺 TV',
                        'web' => '💻 Web',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('os')
                    ->label('OS')
                    ->searchable()
                    ->description(fn (UserDevice $record): ?string => $record->os_version),

                Tables\Columns\TextColumn::make('app_version')
                    ->label('App Version')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('last_active_at')
                    ->label('Last Active')
                    ->dateTime()
                    ->sortable()
                    ->since(),

                Tables\Columns\TextColumn::make('last_login_at')
                    ->label('Last Login')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('last_active_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('device_type')
                    ->label('Device Type')
                    ->options([
                        'mobile' => 'Mobile',
                        'tablet' => 'Tablet',
                        'tv' => 'TV',
                        'web' => 'Web',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('All devices')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),

                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\Action::make('activate')
                    ->label('Activate')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (UserDevice $record) => $record->activate())
                    ->visible(fn (UserDevice $record) => !$record->is_active),

                Tables\Actions\Action::make('deactivate')
                    ->label('Deactivate')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Deactivate Device?')
                    ->modalDescription('This will prevent the device from accessing the app.')
                    ->action(fn (UserDevice $record) => $record->deactivate())
                    ->visible(fn (UserDevice $record) => $record->is_active),

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Delete Device?')
                    ->modalDescription('This will permanently remove this device. The user can register it again.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->activate()),

                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->deactivate()),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserDevices::route('/'),
            'create' => Pages\CreateUserDevice::route('/create'),
            'edit' => Pages\EditUserDevice::route('/{record}/edit'),
        ];
    }
}
