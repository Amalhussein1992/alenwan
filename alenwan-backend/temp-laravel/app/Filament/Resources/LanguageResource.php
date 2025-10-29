<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LanguageResource\Pages;
use App\Filament\Resources\LanguageResource\RelationManagers;
use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;

    protected static ?string $navigationIcon = 'heroicon-o-language';

    protected static ?string $navigationLabel = 'Languages';

    protected static ?string $modelLabel = 'Language';

    protected static ?string $pluralModelLabel = 'Languages';

    protected static ?string $navigationGroup = 'الإعدادات';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Language Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Language Name (English)')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Arabic, English, French')
                            ->helperText('Enter the language name in English'),

                        Forms\Components\TextInput::make('native_name')
                            ->label('Native Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., العربية, English, Français')
                            ->helperText('Enter the language name in its native form'),

                        Forms\Components\TextInput::make('code')
                            ->label('Language Code (ISO 639-1)')
                            ->required()
                            ->maxLength(5)
                            ->placeholder('e.g., ar, en, fr')
                            ->helperText('2-letter ISO language code')
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('flag')
                            ->label('Flag Emoji or Icon')
                            ->maxLength(255)
                            ->placeholder('🇸🇦, 🇺🇸, 🇫🇷')
                            ->helperText('Emoji flag or path to flag icon'),

                        Forms\Components\Select::make('direction')
                            ->label('Text Direction')
                            ->required()
                            ->options([
                                'ltr' => 'Left to Right (LTR)',
                                'rtl' => 'Right to Left (RTL)',
                            ])
                            ->default('ltr')
                            ->helperText('Select RTL for Arabic, Hebrew, etc.'),
                    ])->columns(2),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_default')
                            ->label('Default Language')
                            ->helperText('Set as the default language for the app'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Enable/disable this language'),

                        Forms\Components\TextInput::make('order')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Order for language selection list'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('native_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('flag')
                    ->searchable(),
                Tables\Columns\TextColumn::make('direction')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_default')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
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
            'index' => Pages\ListLanguages::route('/'),
            'create' => Pages\CreateLanguage::route('/create'),
            'edit' => Pages\EditLanguage::route('/{record}/edit'),
        ];
    }
}
