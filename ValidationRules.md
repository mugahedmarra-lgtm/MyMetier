# User Module Validation Rules

As requested, here are the prepared validation rules. These rules can be used in your FormRequests (e.g. `LoginRequest`, `RegisterRequest`) or Livewire components.

**Phone Validation**
```php
'phone' => ['required', 'string', 'unique:users,phone'],
// Or when updating a user:
'phone' => ['required', 'string', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
```

**Password Validation**
```php
'password' => ['required', 'string', 'min:6'],
// Or using Laravel's Password rule object for stronger defaults:
// 'password' => ['required', \Illuminate\Validation\Rules\Password::min(6)],
```

*(Note: No controllers were created as per your instructions. Authentication adjustments were made in the Fortify configuration, User model, and Livewire Profile component.)*
