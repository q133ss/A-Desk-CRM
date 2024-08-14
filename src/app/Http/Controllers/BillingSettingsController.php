<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillingSettingsController\UpdateRequest;
use App\Models\BillingSetting;
use App\Models\Entity;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BillingSettingsController extends Controller
{
    public function index()
    {
        return Entity::where('user_id', Auth()->id())
            ->with([
                'billing' => function($query)
                {
                    $query->with('stamp', 'signature', 'logo');
                }
            ])
            ->get();
    }

    public function update(UpdateRequest $request, $entity_id)
    {
        $entity = Entity::where('user_id', Auth()->id())->findOrFail($entity_id);

        $data = $request->validated();

        unset($data['stamp']);
        unset($data['signature']);
        unset($data['logo']);

        if($entity->billing == null)
        {
            $data['entity_id'] = $entity_id;
            $billing = BillingSetting::create($data);
        }else{
            $update = $entity->billing->update($data);
            $billing = $entity->billing;
        }

        if ($request->hasFile('stamp')) {
            $oldFile = File::where('fileable_id', $billing->id)
                ->where('fileable_type', 'App\Models\BillingSetting')
                ->where('category', 'stamp');

            if ($oldFile->exists()) {
                Storage::disk('public')->delete(str_replace(env('APP_URL').'/storage/', '', $oldFile->pluck('src')->first()));
                $oldFile->delete();
            }

            File::create([
                'fileable_id' => $billing->id,
                'fileable_type' => 'App\Models\BillingSetting',
                'category' => 'stamp',
                'src' => env('APP_URL') . '/storage/' . $request->file('stamp')->store('stamp', 'public')
            ]);
        }

        if ($request->hasFile('signature')) {
            $oldFile = File::where('fileable_id', $billing->id)
                ->where('fileable_type', 'App\Models\BillingSetting')
                ->where('category', 'signature');

            if ($oldFile->exists()) {
                Storage::disk('public')->delete(str_replace(env('APP_URL').'/storage/', '', $oldFile->pluck('src')->first()));
                $oldFile->delete();
            }

            File::create([
                'fileable_id' => $billing->id,
                'fileable_type' => 'App\Models\BillingSetting',
                'category' => 'signature',
                'src' => env('APP_URL') . '/storage/' . $request->file('signature')->store('signature', 'public')
            ]);
        }

        if ($request->hasFile('logo')) {
            $oldFile = File::where('fileable_id', $billing->id)
                ->where('fileable_type', 'App\Models\BillingSetting')
                ->where('category', 'logo');

            if ($oldFile->exists()) {
                Storage::disk('public')->delete(str_replace(env('APP_URL').'/storage/', '', $oldFile->pluck('src')->first()));
                $oldFile->delete();
            }

            File::create([
                'fileable_id' => $billing->id,
                'fileable_type' => 'App\Models\BillingSetting',
                'category' => 'logo',
                'src' => env('APP_URL') . '/storage/' . $request->file('logo')->store('logo', 'public')
            ]);
        }

        return $billing->load('stamp','signature','logo');
    }
}
