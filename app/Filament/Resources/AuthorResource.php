<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuthorResource\Pages;
use App\Models\Author;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Str; 

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = null;
    protected static ?int $navigationSort = 2; // Urutan sidebar

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
        ->schema([
            TextInput::make('name')
                ->required()
                ->live() // Memantau perubahan langsung
                ->afterStateUpdated(fn ($state, callable $set) => 
                    $set('slug', Str::slug($state))),

            TextInput::make('occupation')->label('Occupation'),
            FileUpload::make('avatar')->image(),
            TextInput::make('slug')
                ->required()
                ->unique()
                ->disabled(), // Buat slug tidak bisa diinput manual
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->circular()
                    ->disk('public') // Sesuai konfigurasi storage
                    ->url(fn ($record) => asset('storage/' . $record->avatar)), // Tambahkan asset storage
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('occupation'),
                TextColumn::make('slug')->copyable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuthors::route('/'),
            'create' => Pages\CreateAuthor::route('/create'),
            'edit' => Pages\EditAuthor::route('/{record}/edit'),
        ];
    }
}
