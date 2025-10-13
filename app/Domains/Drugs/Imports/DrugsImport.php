<?php

namespace App\Domains\Drugs\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Domains\Drugs\Models\DrugEntity;

class DrugsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DrugEntity([
            'name' => $row['name'],
            'generic_name' => $row['generic_name'] ?? null,
            'form' => $row['form'] ?? null,
            'strength' => $row['strength'] ?? null,
            'manufacturer' => $row['manufacturer'] ?? null,
            'barcode' => $row['barcode'] ?? null,
            'default_dosage' => $row['default_dosage'] ?? null,
            'default_instructions' => $row['default_instructions'] ?? null,
            'is_active' => $row['is_active'] ?? 1,
            'created_by' => auth('admin')->id(),
        ]);
    }
}
