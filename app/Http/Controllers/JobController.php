<?php

namespace App\Http\Controllers;


use App\Models\Job;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function index()
    {
        return json_encode(Job::all());
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'title' => ['required', 'string', 'min:3'],
            'company' => ['required', 'string', 'min:3'],
            'description' => ['required', 'string'],
            'salary' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            Job::create($validator->attributes());
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage()
            ], 500);
        }

        return response()->json(['success' => true]);
    }
}
