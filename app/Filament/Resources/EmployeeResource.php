<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Human Resource';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Personal Information')->schema([
                Forms\Components\TextInput::make('employee_code')->required()->maxLength(30)->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('full_name')->required()->maxLength(150),
                Forms\Components\TextInput::make('email')->email()->maxLength(150)->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('phone')->tel()->maxLength(30),
                Forms\Components\Select::make('gender')->options(['Male' => 'Male', 'Female' => 'Female']),
                Forms\Components\TextInput::make('birth_place')->maxLength(100),
                Forms\Components\DatePicker::make('birth_date'),
                Forms\Components\Select::make('marital_status')->options(['Single' => 'Single', 'Married' => 'Married', 'Divorced' => 'Divorced']),
                Forms\Components\TextInput::make('religion')->maxLength(30),
                Forms\Components\Textarea::make('address')->columnSpanFull(),
            ])->columns(2),
            Forms\Components\Section::make('Employment Information')->schema([
                Forms\Components\DatePicker::make('hire_date')->required(),
                Forms\Components\DatePicker::make('resign_date'),
                Forms\Components\Select::make('employment_status')->options(['ACTIVE' => 'ACTIVE', 'INACTIVE' => 'INACTIVE', 'RESIGNED' => 'RESIGNED', 'TERMINATED' => 'TERMINATED'])->default('ACTIVE')->required(),
                Forms\Components\Select::make('department_id')->relationship('department', 'name')->searchable()->preload(),
                Forms\Components\Select::make('position_id')->relationship('position', 'name')->searchable()->preload(),
                Forms\Components\Select::make('manager_id')->relationship('manager', 'full_name')->searchable()->preload(),
            ])->columns(2),
            Forms\Components\Section::make('Salary & Banking')->schema([
                Forms\Components\TextInput::make('basic_salary')->numeric()->prefix('IDR')->step(0.01),
                Forms\Components\TextInput::make('bank_name')->maxLength(100),
                Forms\Components\TextInput::make('bank_account_number')->maxLength(100),
                Forms\Components\TextInput::make('bank_account_name')->maxLength(150),
                Forms\Components\TextInput::make('npwp')->maxLength(50),
                Forms\Components\TextInput::make('bpjs_number')->maxLength(50),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('employee_code')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('full_name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('email')->searchable(),
            Tables\Columns\TextColumn::make('department.name')->sortable(),
            Tables\Columns\TextColumn::make('position.name')->sortable(),
            Tables\Columns\TextColumn::make('employment_status')->badge()->color(fn(string $status) => match ($status) {
                'ACTIVE' => 'success', 'INACTIVE' => 'warning', 'RESIGNED' => 'danger', 'TERMINATED' => 'danger', default => 'gray',
            }),
            Tables\Columns\TextColumn::make('hire_date')->date()->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('employment_status')->options(['ACTIVE' => 'ACTIVE', 'INACTIVE' => 'INACTIVE', 'RESIGNED' => 'RESIGNED', 'TERMINATED' => 'TERMINATED']),
            Tables\Filters\SelectFilter::make('department_id')->relationship('department', 'name'),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
