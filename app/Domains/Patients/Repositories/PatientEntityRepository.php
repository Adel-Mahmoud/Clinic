<?php

namespace App\Domains\Patients\Repositories;

use App\Domains\Patients\Models\PatientEntity;
use App\Domains\Users\Models\UserEntity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientEntityRepository
{
    public function all()
    {
        return PatientEntity::all();
    }

    public function find($id)
    {
        return PatientEntity::find($id);
    }

    public function findOrFailWithUser($id)
    {
        return PatientEntity::with('user')->findOrFail($id);
    }

    public function create(array $data)
    {
        return PatientEntity::create($data);
    }

    public function createWithUser(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = UserEntity::create([
                'name' => $data['user_name'],
                'email' => $data['user_email'],
                'password' => Hash::make($data['user_password']),
            ]);

            return PatientEntity::create([
                'user_id' => $user->id,
                'phone' => $data['phone'] ?? null,
                'gender' => $data['gender'] ?? null,
                'birth_date' => $data['birth_date'] ?? null,
                'address' => $data['address'] ?? null,
                'national_id' => $data['national_id'] ?? null,
                'created_by' => auth('admin')->id(),
            ]);
        });
    }

    public function update($id, array $data)
    {
        $model = PatientEntity::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function updateWithUser($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $patient = PatientEntity::with('user')->findOrFail($id);
            $user = $patient->user;

            if ($user) {
                $user->name = $data['user_name'];
                $user->email = $data['user_email'];
                if (!empty($data['user_password'])) {
                    $user->password = Hash::make($data['user_password']);
                }
                $user->save();
            }

            $patient->update([
                'phone' => $data['phone'] ?? null,
                'gender' => $data['gender'] ?? null,
                'birth_date' => $data['birth_date'] ?? null,
                'address' => $data['address'] ?? null,
                'national_id' => $data['national_id'] ?? null,
            ]);

            return $patient;
        });
    }

    public function delete($id)
    {
        return PatientEntity::destroy($id);
    }
}