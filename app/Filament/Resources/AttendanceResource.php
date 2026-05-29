<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'Attendance';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('employee_id')->relationship('employee', 'full_name')->searchable()->required(),
            Forms\Components\DatePicker::make('attendance_date')->required(),
            Forms\Components\Select::make('shift_id')->relationship('shiftTemplate', 'name'),
            Forms\Components\DateTimePicker::make('check_in'),
            Forms\Components\DateTimePicker::make('check_out'),
            Forms\Components\TextInput::make('late_minutes')->numeric()->default(0),
            Forms\Components\TextInput::make('work_minutes')->numeric()->default(0),
            Forms\Components\TextInput::make('overtime_minutes')->numeric()->default(0),
            Forms\Components\Select::make('attendance_status')->options(['PRESENT' => 'PRESENT', 'ABSENT' => 'ABSENT', 'LEAVE' => 'LEAVE', 'SICK' => 'SICK', 'HOLIDAY' => 'HOLIDAY', 'WEEKEND' => 'WEEKEND', 'INCOMPLETE' => 'INCOMPLETE'])->required(),
            Forms\Components\Textarea::make('notes')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('employee.full_name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('attendance_date')->date()->sortable(),
            Tables\Columns\TextColumn::make('shiftTemplate.name'),
            Tables\Columns\TextColumn::make('check_in')->dateTime(),
            Tables\Columns\TextColumn::make('check_out')->dateTime(),
            Tables\Columns\TextColumn::make('late_minutes')->label('Late'),
            Tables\Columns\TextColumn::make('work_minutes')->label('Work'),
Tables\Columns\TextColumn::make('attendance_status')->badge()->color(fn($state) => match ($state) {
                'PRESENT' => 'success', 'ABSENT' => 'danger', 'Late' => 'warning', 'HALF_DAY' => 'warning', 'ON_LEAVE' => 'info', default => 'gray',
            }),
        ])->filters([
            Tables\Filters\Filter::make('attendance_date')->form([
                Forms\Components\DatePicker::make('from'),
                Forms\Components\DatePicker::make('until'),
            ])->query(function ($query, array $data) {
                return $query
                    ->when($data['from'], fn($q) => $q->whereDate('attendance_date', '>=', $data['from']))
                    ->when($data['until'], fn($q) => $q->whereDate('attendance_date', '<=', $data['until']));
            }),
            Tables\Filters\SelectFilter::make('attendance_status')->options(['PRESENT' => 'PRESENT', 'ABSENT' => 'ABSENT', 'LEAVE' => 'LEAVE', 'SICK' => 'SICK', 'HOLIDAY' => 'HOLIDAY', 'WEEKEND' => 'WEEKEND', 'INCOMPLETE' => 'INCOMPLETE']),
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
