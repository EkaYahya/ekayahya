<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use Illuminate\Validation\Rule;

class ScanQRController extends Controller
{
    public function show()
    {
        $guests = Guest::all();
        return view('scan-qr', compact('guests'));
    }

    public function updateAttendance($slug)
    {
        try {
            $guest = Guest::where('slug', $slug)->firstOrFail();
            
            if ($guest->attended) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tamu sudah melakukan scan sebelumnya.'
                ], 400);
            }
            
            $guest->update(['attended' => true]);
            
            return response()->json([
                'success' => true,
                'guest' => $guest->only(['name', 'will_attend', 'number_of_guests'])
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tamu tidak ditemukan'
            ], 404);
        }
    }
    
    public function updateGuestCount(Request $request, $slug)
    {
        try {
            $validated = $request->validate([
                'number_of_guests' => ['required', 'integer', 'min:1']
            ]);
            
            $guest = Guest::where('slug', $slug)->firstOrFail();
            $guest->update($validated);
            
            return response()->json([
                'success' => true,
                'guest' => $guest->only(['name', 'will_attend', 'number_of_guests'])
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tamu tidak ditemukan atau input tidak valid'
            ], 404);
        }
    }
}