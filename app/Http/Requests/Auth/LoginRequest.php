<?php

namespace App\Http\Requests\Auth;

use Illuminate\Support\Str;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    protected $inputType;

    
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'email' => ['required_without:username', 'string', 'email', 'exists:users,email'],
            'username' => ['required_without:email', 'string', 'alpha_dash:ascii', 'exists:users,username'],
            'password' => ['required', 'string'],
        ];
    }

    
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only($this->inputType, 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                $this->inputType  => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('username')).'|'.$this->ip());
    }

    protected function prepareForValidation()
    {
        $this->inputType = filter_var($this->input('input_type'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $this->merge([
            $this->inputType => $this->input('input_type')
        ]);
    }
}
