<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveResource\Pages;
use App\Models\LeaveRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeaveResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Leave';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('employee_id')->relationship('employee', 'full_name')->searchable()->required(),
            Forms\Components\Select::make('leave_type_id')->relationship('leaveType', 'name')->searchable()->required(),
            Forms\Components\DatePicker::make('start_date')->required(),
            Forms\Components\DatePicker::make('end_date')->required(),
            Forms\Components\TextInput::make('total_days')->numeric()->required(),
            Forms\Components\Textarea::make('reason')->columnSpanFull(),
            Forms\Components\TextInput::make('attachment_url')->url(),
            Forms\Components\Select::make('status')->options(['PENDING' => 'PENDING', 'APPROVED' => 'APPROVED', 'REJECTED' => 'REJECTED', 'CANCELLED' => 'CANCELLED'])->default('PENDING'),
            Forms\Components\DateTimePicker::make('requested_at'),
            Forms\Components\Select::make('approved_by')->relationship('approver', 'full_name')->searchable(),
            Forms\Components\DateTimePicker::make('approved_at'),
            Forms\Components\Textarea::make('rejection_reason'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('employee.full_name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('leaveType.name')->sortable(),
            Tables\Columns\TextColumn::make('start_date')->date()->sortable(),
            Tables\Columns\TextColumn::make('end_date')->date()->sortable(),
            Tables\Columns\TextColumn::make('total_days'),
            Tables\Columns\TextColumn::make('status')->badge()->color(fn($state) => match ($state) {
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
            'index' => Pages\ListLeaves::route('/'),
            'create' => Pages\CreateLeave::route('/create'),
            'edit' => Pages\EditLeave::route('/{record}/edit'),
        ];
    }
}
