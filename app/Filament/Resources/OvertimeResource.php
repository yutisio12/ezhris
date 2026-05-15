<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OvertimeResource\Pages;
use App\Models\OvertimeRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OvertimeResource extends Resource
{
    protected static ?string $model = OvertimeRequest::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'Attendance';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('employee_id')->relationship('employee', 'full_name')->searchable()->required(),
            Forms\Components\DatePicker::make('overtime_date')->required(),
            Forms\Components\DateTimePicker::make('start_time')->required(),
            Forms\Components\DateTimePicker::make('end_time')->required(),
            Forms\Components\TextInput::make('total_minutes')->numeric()->default(0),
            Forms\Components\Textarea::make('reason')->columnSpanFull(),
            Forms\Components\Select::make('status')->options(['PENDING' => 'PENDING', 'APPROVED' => 'APPROVED', 'REJECTED' => 'REJECTED', 'CANCELLED' => 'CANCELLED'])->default('PENDING'),
            Forms\Components\Select::make('approved_by')->relationship('approver', 'full_name')->searchable(),
            Forms\Components\DateTimePicker::make('approved_at'),
            Forms\Components\Textarea::make('rejection_reason'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('employee.full_name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('overtime_date')->date()->sortable(),
            Tables\Columns\TextColumn::make('start_time')->dateTime(),
            Tables\Columns\TextColumn::make('end_time')->dateTime(),
            Tables\Columns\TextColumn::make('total_minutes')->label('Minutes'),
            Tables\Columns\TextColumn::make('status')->badge()->color(fn(string $status) => match ($status) {
                'APPROVED' => 'success', 'PENDING' => 'warning', 'REJECTED' => 'danger', 'CANCELLED' => 'gray', default => 'gray',
            }),
            Tables\Columns\TextColumn::make('requested_at')->dateTime()->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status')->options(['PENDING' => 'PENDING', 'APPROVED' => 'APPROVED', 'REJECTED' => 'REJECTED', 'CANCELLED' => 'CANCELLED']),
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
            'index' => Pages\ListOvertimes::route('/'),
            'create' => Pages\CreateOvertime::route('/create'),
            'edit' => Pages\EditOvertime::route('/{record}/edit'),
        ];
    }
}
