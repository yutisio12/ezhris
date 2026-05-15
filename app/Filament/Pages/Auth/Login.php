<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Support\Facades\Hash;

class Login extends BaseLogin
{
    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('username')
                ->label('Username')
                ->required()
                ->autocomplete()
                ->autofocus(),
            TextInput::make('password')
                ->label('Password')
                ->password()
                ->required(),
            $this->getRememberFormComponent(),
        ]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['username'],
            'password' => $data['password'],
        ];
    }

    protected function attemptLogin(): bool
    {
        $credentials = $this->getCredentialsFromFormData($this->form->getState());

        $user = User::where('username', $credentials['username'])
            ->where('is_active', true)
            ->first();

        if (!$user) {
            return false;
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return false;
        }

        auth()->login($user, $this->form->getState('remember', false));

        return true;
    }
}
