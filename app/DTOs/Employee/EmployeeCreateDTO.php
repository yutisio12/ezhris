<?php

namespace App\DTOs\Employee;

use App\Models\Employee;

class EmployeeCreateDTO
{
    public function __construct(
        public readonly string $full_name,
        public readonly string $email,
        public readonly string $phone,
        public readonly ?string $gender,
        public readonly ?string $birth_place,
        public readonly ?string $birth_date,
        public readonly ?string $marital_status,
        public readonly ?string $religion,
        public readonly ?string $address,
        public readonly string $hire_date,
        public readonly int $department_id,
        public readonly int $position_id,
        public readonly ?int $manager_id,
        public readonly float $basic_salary,
        public readonly ?string $bank_name,
        public readonly ?string $bank_account_number,
        public readonly ?string $bank_account_name,
        public readonly ?string $npwp,
        public readonly ?string $bpjs_number,
        public readonly ?string $employee_code = null,
        public readonly string $employment_status = 'ACTIVE',
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            full_name: $data['full_name'],
            email: $data['email'],
            phone: $data['phone'] ?? '',
            gender: $data['gender'] ?? null,
            birth_place: $data['birth_place'] ?? null,
            birth_date: $data['birth_date'] ?? null,
            marital_status: $data['marital_status'] ?? null,
            religion: $data['religion'] ?? null,
            address: $data['address'] ?? null,
            hire_date: $data['hire_date'],
            department_id: $data['department_id'],
            position_id: $data['position_id'],
            manager_id: $data['manager_id'] ?? null,
            basic_salary: $data['basic_salary'] ?? 0,
            bank_name: $data['bank_name'] ?? null,
            bank_account_number: $data['bank_account_number'] ?? null,
            bank_account_name: $data['bank_account_name'] ?? null,
            npwp: $data['npwp'] ?? null,
            bpjs_number: $data['bpjs_number'] ?? null,
            employee_code: $data['employee_code'] ?? null,
            employment_status: $data['employment_status'] ?? 'ACTIVE',
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'employee_code' => $this->employee_code,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'birth_place' => $this->birth_place,
            'birth_date' => $this->birth_date,
            'marital_status' => $this->marital_status,
            'religion' => $this->religion,
            'address' => $this->address,
            'hire_date' => $this->hire_date,
            'department_id' => $this->department_id,
            'position_id' => $this->position_id,
            'manager_id' => $this->manager_id,
            'basic_salary' => $this->basic_salary,
            'bank_name' => $this->bank_name,
            'bank_account_number' => $this->bank_account_number,
            'bank_account_name' => $this->bank_account_name,
            'npwp' => $this->npwp,
            'bpjs_number' => $this->bpjs_number,
            'employment_status' => $this->employment_status,
        ], fn($value) => $value !== null);
    }
}
