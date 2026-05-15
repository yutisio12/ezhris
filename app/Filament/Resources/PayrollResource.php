<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PayrollResource\Pages;
use App\Models\Payroll;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PayrollResource extends Resource
{
    protected static ?string $model = Payroll::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Payroll';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('payroll_period_id')->relationship('payrollPeriod', 'period_name')->searchable()->required(),
            Forms\Components\Select::make('employee_id')->relationship('employee', 'full_name')->searchable()->required(),
            Forms\Components\TextInput::make('basic_salary')->numeric()->prefix('IDR'),
            Forms\Components\TextInput::make('attendance_deduction')->numeric()->prefix('IDR'),
            Forms\Components\TextInput::make('leave_deduction')->numeric()->prefix('IDR'),
            Forms\Components\TextInput::make('overtime_amount')->numeric()->prefix('IDR'),
            Forms\Components\TextInput::make('allowance_amount')->numeric()->prefix('IDR'),
            Forms\Components\TextInput::make('bonus_amount')->numeric()->prefix('IDR'),
            Forms\Components\TextInput::make('tax_amount')->numeric()->prefix('IDR'),
            Forms\Components\TextInput::make('bpjs_amount')->numeric()->prefix('IDR'),
            Forms\Components\TextInput::make('gross_salary')->numeric()->prefix('IDR'),
            Forms\Components\TextInput::make('net_salary')->numeric()->prefix('IDR'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('employee.full_name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('payrollPeriod.period_name')->sortable(),
            Tables\Columns\TextColumn::make('basic_salary')->money('IDR'),
            Tables\Columns\TextColumn::make('gross_salary')->money('IDR'),
            Tables\Columns\TextColumn::make('net_salary')->money('IDR'),
            Tables\Columns\TextColumn::make('generated_at')->dateTime()->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('payroll_period_id')->relationship('payrollPeriod', 'period_name'),
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
            'index' => Pages\ListPayrolls::route('/'),
            'create' => Pages\CreatePayroll::route('/create'),
            'edit' => Pages\EditPayroll::route('/{record}/edit'),
        ];
    }
}
