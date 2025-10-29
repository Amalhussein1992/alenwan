<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SportResource\Pages;
use App\Models\Sport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SportResource extends Resource
{
    protected static ?string $model = Sport::class;
    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.content');
    }

    public static function getNavigationLabel(): string
    {
        return 'الرياضة';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('المعلومات الأساسية')->schema([
                Forms\Components\TextInput::make('title')->label('العنوان')->required(),
                Forms\Components\TextInput::make('title_ar')->label('العنوان بالعربية'),
                Forms\Components\Textarea::make('description')->label('الوصف')->rows(3),
                Forms\Components\FileUpload::make('poster')->label('الصورة')->image()->directory('sports'),
            ])->columns(2),
            
            Forms\Components\Section::make('تفاصيل المباراة')->schema([
                Forms\Components\Select::make('sport_type')->label('نوع الرياضة')
                    ->options(['football' => 'كرة قدم', 'basketball' => 'كرة سلة', 'tennis' => 'تنس']),
                Forms\Components\TextInput::make('league')->label('الدوري'),
                Forms\Components\TextInput::make('teams')->label('الفرق'),
                Forms\Components\DateTimePicker::make('match_date')->label('موعد المباراة'),
                Forms\Components\TextInput::make('venue')->label('المكان'),
            ])->columns(2),
            
            Forms\Components\Section::make('الإعدادات')->schema([
                Forms\Components\Toggle::make('is_live')->label('مباشر')->default(false),
                Forms\Components\Toggle::make('is_premium')->label('مميز')->default(false),
                Forms\Components\Toggle::make('is_published')->label('منشور')->default(true),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('poster')->label('الصورة')->size(60),
            Tables\Columns\TextColumn::make('title')->label('العنوان')->searchable()->sortable()->limit(30),
            Tables\Columns\TextColumn::make('sport_type')->label('النوع')->badge()->searchable()->sortable(),
            Tables\Columns\TextColumn::make('league')->label('الدوري')->searchable()->toggleable(),
            Tables\Columns\TextColumn::make('teams')->label('الفرق')->searchable()->toggleable()->limit(25),
            Tables\Columns\IconColumn::make('is_live')->label('مباشر')->boolean()->sortable(),
            Tables\Columns\TextColumn::make('match_date')->label('الموعد')->dateTime('d/m/Y H:i')->sortable(),
            Tables\Columns\IconColumn::make('is_premium')->label('مميز')->boolean()->toggleable(),
            Tables\Columns\IconColumn::make('is_published')->label('منشور')->boolean(),
            Tables\Columns\TextColumn::make('views_count')->label('المشاهدات')->sortable()->toggleable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('sport_type')
                ->label('نوع الرياضة')
                ->options([
                    'football' => 'كرة قدم',
                    'basketball' => 'كرة سلة',
                    'tennis' => 'تنس',
                ])
                ->multiple(),
            Tables\Filters\TernaryFilter::make('is_live')
                ->label('البث المباشر')
                ->placeholder('الكل')
                ->trueLabel('مباشر فقط')
                ->falseLabel('غير مباشر'),
            Tables\Filters\TernaryFilter::make('is_premium')
                ->label('المحتوى المميز')
                ->placeholder('الكل')
                ->trueLabel('مميز فقط')
                ->falseLabel('عادي فقط'),
            Tables\Filters\TernaryFilter::make('is_published')
                ->label('حالة النشر')
                ->placeholder('الكل')
                ->trueLabel('منشور')
                ->falseLabel('مسودة'),
            Tables\Filters\Filter::make('match_date')
                ->form([
                    Forms\Components\DatePicker::make('from')->label('من تاريخ'),
                    Forms\Components\DatePicker::make('until')->label('إلى تاريخ'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when($data['from'], fn ($query, $date) => $query->whereDate('match_date', '>=', $date))
                        ->when($data['until'], fn ($query, $date) => $query->whereDate('match_date', '<=', $date));
                }),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ])
        ->defaultSort('match_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSports::route('/'),
            'create' => Pages\CreateSport::route('/create'),
            'edit' => Pages\EditSport::route('/{record}/edit'),
        ];
    }
}
