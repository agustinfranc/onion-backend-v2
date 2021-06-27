<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getByEmail(string $email): User
    {
        $user = User::whereEmail($email)->first();

        return $user;
    }

    public function getOne(User $user): User
    {
        $commerceRepository = new CommerceRepository;

        $user->commerces = $commerceRepository->getAll([], $user);

        $user->token = $this->_createToken($user);

        return $user;
    }

    private function _createToken(User $user): string
    {
        return $user->createToken($validatedData['device_name'] ?? 'token-name')->plainTextToken;
    }
}
