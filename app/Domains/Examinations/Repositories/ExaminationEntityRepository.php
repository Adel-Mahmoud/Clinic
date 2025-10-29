<?php

namespace App\Domains\Examinations\Repositories;

use Illuminate\Support\Facades\DB;
use App\Domains\Drugs\Models\DrugEntity;
use App\Domains\Visits\Models\VisitEntity;
use App\Domains\Examinations\Models\ExaminationEntity;
use App\Domains\Examinations\Models\PrescriptionDrugs;
use App\Domains\Examinations\Models\ExaminationAttachment;

class ExaminationEntityRepository
{
    public function getNextVisitInQueue()
    {
        return VisitEntity::where('status', 'pending')
            ->with('patient')
            ->orderBy('visit_date', 'asc')
            ->orderBy('visit_time', 'asc')
            ->orderBy('id', 'asc')
            ->first();
    }

    public function getDrugs()
    {
        return DrugEntity::all();
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request) {

            $visit = VisitEntity::findOrFail($request->visit_id);

            $examination = ExaminationEntity::create([
                'visit_id' => $visit->id,
                'patient_id' => $visit->patient_id,
                'symptoms' => $request->symptoms,
                'diagnosis' => $request->diagnosis,
                'notes' => $request->notes,
                'tests_type' => $request->testType,
                'tests_details' => $request->tests_details,
                'created_by' => auth('admin')->id(),
            ]);

            if ($request->drugs) {
                foreach ($request->drugs as $drug) {
                    PrescriptionDrugs::create([
                        'examination_id' => $examination->id,
                        'drug_name' => $drug['name'],
                        'dose' => $drug['dose'] ?? null,
                        'duration' => $drug['duration'] ?? null,
                        'form' => $drug['form'] ?? null,
                        'instructions' => $drug['instructions'] ?? null,
                        'created_by' => auth('admin')->id(),
                    ]);
                }
            }

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('examination_attachments', 'public');
                    ExaminationAttachment::create([
                        'examination_id' => $examination->id,
                        'file_path' => $path,
                        'file_type' => $file->getClientMimeType(),
                        'created_by' => auth('admin')->id()
                    ]);
                }
            }

            $visit->update(['status' => 'completed']);

            return $examination;
        });
    }
}
