<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentaryResource\Pages;
use App\Models\Documentary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DocumentaryResource extends Resource
{
    protected static ?string $model = Documentary::class;
    protected static ?string $navigationIcon = 'heroicon-o-film';

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.content');
    }

    public static function getNavigationLabel(): string
    {
        return 'الوثائقيات';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('المعلومات الأساسية')->schema([
                Forms\Components\TextInput::make('title')->label('العنوان')->required(),
                Forms\Components\TextInput::make('title_ar')->label('العنوان بالعربية'),
                Forms\Components\Textarea::make('description')->label('الوصف')->rows(3),
                Forms\Components\FileUpload::make('poster')->label('الصورة')->image()->directory('documentaries'),
                Forms\Components\TextInput::make('video_url')->label('رابط الفيديو')->url(),
            ])->columns(2),
            
            Forms\Components\Section::make('التفاصيل')->schema([
                Forms\Components\Select::make('category_id')->label('التصنيف')
                    ->relationship('category', 'name')->searchable()->preload(),
                Forms\Components\TextInput::make('director')->label('المخرج'),
                Forms\Components\TextInput::make('producer')->label('المنتج'),
                Forms\Components\TextInput::make('duration')->label('المدة (دقيقة)')->numeric(),
                Forms\Components\TextInput::make('year')->label('السنة')->numeric(),
                Forms\Components\TextInput::make('rating')->label('التقييم')->numeric()->minValue(0)->maxValue(10)->step(0.1),
            ])->columns(3),
            
            Forms\Components\Section::make('الإعدادات')->schema([
                Forms\Components\Toggle::make('is_premium')->label('مميز')->default(false),
                Forms\Components\Toggle::make('is_published')->label('منشور')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('poster')->label('الصورة')->size(60),
            Tables\Columns\TextColumn::make('title')->label('العنوان')->searchable()->sortable()->limit(30),
            Tables\Columns\TextColumn::make('category.name')->label('التصنيف')->badge()->color('info')->sortable()->toggleable(),
            Tables\Columns\TextColumn::make('director')->label('المخرج')->searchable()->toggleable()->limit(20),
            Tables\Columns\TextColumn::make('year')->label('السنة')->sortable()->badge()->color('gray'),
            Tables\Columns\TextColumn::make('duration')->label('المدة')->suffix(' د')->sortable()->toggleable(),
            Tables\Columns\TextColumn::make('rating')->label('التقييم')->sortable()
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 1) . '/10' : '-')
                ->badge()
                ->color(fn ($state) => match(true) {
                    $state >= 8 => 'success',
                    $state >= 6 => 'warning',
                    default => 'danger',
                }),
            Tables\Columns\IconColumn::make('is_premium')->label('مميز')->boolean()->toggleable(),
            Tables\Columns\IconColumn::make('is_published')->label('منشور')->boolean(),
            Tables\Columns\TextColumn::make('views_count')->label('المشاهدات')->sortable()->toggleable()
                ->formatStateUsing(fn ($state) => number_format($state)),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('category_id')
                ->label('التصنيف')
                ->relationship('category', 'name')
                ->multiple()
                ->preload(),
            Tables\Filters\Filter::make('year')
                ->form([
                    Forms\Components\TextInput::make('from')->label('من سنة')->numeric(),
                    Forms\Components\TextInput::make('until')->label('إلى سنة')->numeric(),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when($data['from'], fn ($query, $year) => $query->where('year', '>=', $year))
                        ->when($data['until'], fn ($query, $year) => $query->where('year', '<=', $year));
                }),
            Tables\Filters\Filter::make('rating')
                ->form([
                    Forms\Components\Select::make('rating')
                        ->label('التقييم')
                        ->options([
                            '8+' => '8+ ممتاز',
                            '6+' => '6+ جيد',
                            '0+' => 'الكل',
                        ]),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query->when($data['rating'], function ($query, $rating) {
                        return match($rating) {
                            '8+' => $query->where('rating', '>=', 8),
                            '6+' => $query->where('rating', '>=', 6),
                            default => $query,
                        };
                    });
                }),
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
        ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocumentaries::route('/'),
            'create' => Pages\CreateDocumentary::route('/create'),
            'edit' => Pages\EditDocumentary::route('/{record}/edit'),
        ];
    }
}
