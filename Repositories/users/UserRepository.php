<?php

namespace App\Domains\Users\Repositories;

use App\Domains\Users\Models\User;

class UserRepository
{
    public function all() { return User::all(); }
    public function find($id) { return User::find($id); }
    public function create(array $data) { return User::create($data); }
    public function update(User $user, array $data): bool { return $user->update($data); }
    public function delete(User $user): bool { return $user->delete(); }
}
