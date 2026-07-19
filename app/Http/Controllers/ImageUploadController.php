<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    /**
     * Handle TinyMCE image uploads
     */
    public function uploadForEditor(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'file' => ['required', 'image', 'max:5120'], // Max 5MB
            ]);

            $file = $request->file('file');

            // Generate unique filename with timestamp
            $timestamp = now()->format('YmdHis');
            $filename = $timestamp.'_'.Str::random(8).'.'.$file->getClientOriginalExtension();

            // Store in public disk
            $path = $file->storeAs('news-images', $filename, 'public');

            // Return URL that TinyMCE expects
            return response()->json([
                'location' => asset('storage/'.$path),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => [
                    'message' => 'Upload gagal: '.$e->getMessage(),
                ],
            ], 422);
        }
    }
}
