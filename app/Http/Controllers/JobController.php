<?php

namespace App\Http\Controllers;


use App\Models\Job;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function index()
    {
        return json_encode(Job::all());
    }

    public function delete()
    {
        $validator = Validator::make(request()->all(), [
           'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'fail' => true,
                'errors' => $validator->errors()
            ], 422);
        }

        try{
            $job = Job::findOrFail($validator->safe()->only(['id'])['id']);
            $job->delete();
            return response()->json([
                'success' => true,
                'message' => 'Job deleted successfully!',
            ]);
        }catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Job not found',
                'message' => $e->getMessage()
            ], 404);
        }catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }

    }

    public function edit($id)
    {
        try{
            $job = Job::findOrFail($id);
            return response()->json([
                'success' => true,
                'job' => $job,
            ]);
        }catch (Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function update()
    {
        $validator = Validator::make(request()->all(), [
            'id' => 'required',
            'title' => 'required|string|min:3',
            'company' => ['required', 'string', 'min:3'],
            'description' => ['required', 'string'],
            'salary' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'fail' => true,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $result = Job::findOrFail($validator->safe()->only('id')['id']);
            $result->update($validator->safe()->except('id'));
            return response()->json([
                'success' => true,
                'message' => 'Job updated successfully',
                'job' => $result
            ]);
        }catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Job not found',
                'message' => $e->getMessage()
            ], 404);
        } catch(Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required|string|min:3',
            'company' => ['required', 'string', 'min:3'],
            'description' => ['required', 'string'],
            'salary' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'fail' => true,
                'errors' => $validator->errors()
            ], 422);
        }
        try {
            $job = Job::create($validator->validated());
            return response()->json([
                'success' => true,
                'message' => 'Job created successfully',
                'job' => $job
                ]);
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
