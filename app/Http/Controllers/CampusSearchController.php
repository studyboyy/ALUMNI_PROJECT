<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CampusSearchController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $query = trim((string) $request->query('q', ''));

        if (mb_strlen($query) < 2) {
            return response()->json([
                'data' => [],
            ]);
        }

        $campuses = Cache::remember('campuses.indonesia.hipolabs.v1', now()->addDay(), function () {
            $response = Http::timeout(20)->get('http://universities.hipolabs.com/search', [
                'country' => 'Indonesia',
            ]);

            if (! $response->ok()) {
                return [];
            }

            return collect($response->json())
                ->pluck('name')
                ->filter(fn($name) => is_string($name) && trim($name) !== '')
                ->map(fn($name) => trim($name))
                ->unique()
                ->sort()
                ->values()
                ->all();
        });

        $needle = mb_strtolower($query);

        $filtered = collect($campuses)
            ->filter(fn($name) => str_contains(mb_strtolower($name), $needle))
            ->take(20)
            ->values()
            ->all();

        return response()->json([
            'data' => $filtered,
        ]);
    }
}
