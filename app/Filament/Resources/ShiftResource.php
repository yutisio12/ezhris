<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShiftResource\Pages;
use App\Models\ShiftTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ShiftResource extends Resource
{
    protected static ?string $model = ShiftTemplate::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Attendance';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(100),
            Forms\Components\TimePicker::make('check_in_time')->required(),
            Forms\Components\TimePicker::make('check_out_time')->required(),
            Forms\Components\TimePicker::make('break_start'),
            Forms\Components\TimePicker::make('break_end'),
            Forms\Components\TextInput::make('late_tolerance_minutes')->numeric()->default(0),
            Forms\Components\Toggle::make('is_flexible')->default(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('check_in_time'),
            Tables\Columns\TextColumn::make('check_out_time'),
            Tables\Columns\TextColumn::make('break_start'),
            Tables\Columns\TextColumn::make('break_end'),
            Tables\Columns\TextColumn::make('late_tolerance_minutes')->label('Tolerance (min)'),
            Tables\Columns\IconColumn::make('is_flexible')->boolean(),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShifts::route('/'),
            'create' => Pages\CreateShift::route('/create'),
            'edit' => Pages\EditShift::route('/{record}/edit'),
        ];
    }
}
