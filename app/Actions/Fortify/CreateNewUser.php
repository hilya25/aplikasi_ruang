<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $validator = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'invite_code' => ['nullable', 'string'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $usertype = 'user';
        $inviteCode = null;

        if (!empty($input['invite_code'])) {
            $inviteCode = \App\Models\InviteCode::where('code', $input['invite_code'])
                ->where('is_used', false)
                ->first();

            if (!$inviteCode) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'invite_code' => ['Kode invite tidak valid atau sudah digunakan.'],
                ]);
            }

            $usertype = 'admin';
        }

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'usertype' => $usertype,
        ]);

        if ($inviteCode) {
            $inviteCode->update([
                'is_used' => true,
                'used_by_user_id' => $user->id,
            ]);
        }

        return $user;
    }
}
