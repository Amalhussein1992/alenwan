<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CartoonResource\Pages;
use App\Models\Cartoon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CartoonResource extends Resource
{
    protected static ?string $model = Cartoon::class;
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.content');
    }

    public static function getNavigationLabel(): string
    {
        return 'الكارتون';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('المعلومات الأساسية')->schema([
                Forms\Components\TextInput::make('title')->label('العنوان')->required(),
                Forms\Components\TextInput::make('title_ar')->label('العنوان بالعربية'),
                Forms\Components\Textarea::make('description')->label('الوصف')->rows(3),
                Forms\Components\FileUpload::make('poster')->label('الصورة')->image()->directory('cartoons'),
                Forms\Components\TextInput::make('video_url')->label('رابط الفيديو')->url(),
            ])->columns(2),
            
            Forms\Components\Section::make('التفاصيل')->schema([
                Forms\Components\Select::make('category_id')->label('التصنيف')
                    ->relationship('category', 'name')->searchable()->preload(),
                Forms\Components\Select::make('age_rating')->label('تصنيف عمري')
                    ->options(['G' => 'G - للجميع', 'PG' => 'PG - بإشراف', 'PG-13' => 'PG-13']),
                Forms\Components\TextInput::make('duration')->label('المدة (دقيقة)')->numeric(),
                Forms\Components\TextInput::make('year')->label('السنة')->numeric(),
                Forms\Components\TextInput::make('rating')->label('التقييم')->numeric()->minValue(0)->maxValue(10)->step(0.1),
            ])->columns(3),
            
            Forms\Components\Section::make('معلومات الحلقات')->schema([
                Forms\Components\Toggle::make('is_series')->label('مسلسل')->reactive(),
                Forms\Components\TextInput::make('season_number')->label('رقم الموسم')->numeric()
                    ->visible(fn ($get) => $get('is_series')),
                Forms\Components\TextInput::make('episode_number')->label('رقم الحلقة')->numeric()
                    ->visible(fn ($get) => $get('is_series')),
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
            Tables\Columns\TextColumn::make('category.name')->label('الفئة')->badge()->color('info')->sortable()->toggleable(),
            Tables\Columns\TextColumn::make('age_rating')->label('التصنيف العمري')->badge()
                ->color(fn ($state) => match($state) {
                    'G' => 'success',
                    'PG' => 'warning',
                    'PG-13' => 'danger',
                    default => 'gray',
                })->toggleable(),
            Tables\Columns\IconColumn::make('is_series')->label('مسلسل')->boolean()->sortable(),
            Tables\Columns\TextColumn::make('season_number')->label('الموسم')->sortable()->toggleable()
                ->formatStateUsing(fn ($state) => $state ? 'S' . $state : '-'),
            Tables\Columns\TextColumn::make('episode_number')->label('الحلقة')->sortable()->toggleable()
                ->formatStateUsing(fn ($state) => $state ? 'E' . $state : '-'),
            Tables\Columns\TextColumn::make('year')->label('السنة')->sortable()->badge()->color('gray')->toggleable(),
            Tables\Columns\TextColumn::make('rating')->label('التقييم')->sortable()->toggleable()
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
                ->label('الفئة')
                ->relationship('category', 'name')
                ->multiple()
                ->preload(),
            Tables\Filters\SelectFilter::make('age_rating')
                ->label('التصنيف العمري')
                ->options([
                    'G' => 'G - للجميع',
                    'PG' => 'PG - بإشراف',
                    'PG-13' => 'PG-13',
                ])
                ->multiple(),
            Tables\Filters\TernaryFilter::make('is_series')
                ->label('النوع')
                ->placeholder('الكل')
                ->trueLabel('مسلسل فقط')
                ->falseLabel('أفلام فقط'),
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
            'index' => Pages\ListCartoons::route('/'),
            'create' => Pages\CreateCartoon::route('/create'),
            'edit' => Pages\EditCartoon::route('/{record}/edit'),
        ];
    }
}
