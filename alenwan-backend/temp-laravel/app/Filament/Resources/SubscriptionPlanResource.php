<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionPlanResource\Pages;
use App\Filament\Resources\SubscriptionPlanResource\RelationManagers;
use App\Models\SubscriptionPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscriptionPlanResource extends Resource
{
    protected static ?string $model = SubscriptionPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'إدارة المستخدمين';

    public static function getNavigationLabel(): string
    {
        return __('filament.resources.subscription-plans.navigation_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('filament.fields.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label(__('filament.fields.description'))
                    ->rows(3),
                Forms\Components\TextInput::make('price')
                    ->label(__('filament.fields.price'))
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('currency')
                    ->label('العملة')
                    ->default('USD')
                    ->required(),
                Forms\Components\TextInput::make('duration_days')
                    ->label('المدة بالأيام')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('duration_months')
                    ->label('المدة بالأشهر')
                    ->numeric()
                    ->default(1),
                Forms\Components\Textarea::make('features')
                    ->label(__('filament.fields.features'))
                    ->rows(3),
                Forms\Components\Toggle::make('is_popular')
                    ->label('شائع')
                    ->default(false),
                Forms\Components\Toggle::make('is_active')
                    ->label(__('filament.fields.is_active'))
                    ->default(true),
                Forms\Components\TextInput::make('order')
                    ->label(__('filament.fields.order'))
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.fields.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label(__('filament.fields.price'))
                    ->money('USD'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('filament.fields.is_active'))
                    ->boolean(),
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
            'index' => Pages\ListSubscriptionPlans::route('/'),
            'create' => Pages\CreateSubscriptionPlan::route('/create'),
            'edit' => Pages\EditSubscriptionPlan::route('/{record}/edit'),
        ];
    }
}
