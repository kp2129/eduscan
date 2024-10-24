<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QRCode;
use App\Models\ScannedQRCode;
use App\Models\User;
use Carbon\Carbon;

class QRCodeController extends Controller
{
    public function generateQRCode(Request $request)
    {
        $user = $request->user();

        $scannedToday = ScannedQRCode::where('user_id', $user->id)
            ->whereDate('scanned_at', Carbon::today())
            ->exists();

        if ($scannedToday) {
            return response()->json(['message' => 'User has already scanned the QR code today'], 400);
        }

        $existingQRCode = QRCode::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->first();

        if ($existingQRCode) {
            if (!$existingQRCode->scanned && $existingQRCode->expires_at->isPast()) {
                $existingQRCode->delete(); 
                $qrCode = QRCode::generateForUser($user);
                return response($qrCode->token);
            }

            if (!$existingQRCode->scanned) {
                return response($existingQRCode->token);
            }
        }

        $qrCode = QRCode::generateForUser($user);

        return response($qrCode->token);
    }

    public function validateQRCode(Request $request)
    {
        try {
            $token = $request->input('token');
            $user = $request->user();

            $qrCode = QRCode::where('token', $token)->first();

            if (!$qrCode || !$qrCode->isValid() || $qrCode->scanned) {
                return response()->json(['success' => false, 'message' => 'Invalid or expired QR code'], 400);
            }

            QRCode::where('token', $token)->update(['scanned' => 1]);

            ScannedQRCode::create([
                'user_id' => $qrCode->user_id,
                'token' => $qrCode->token,
                'scanned_at' => now(), 
            ]);

            $user = User::find($qrCode->user_id);
            $user->updateIsAtSchoolIfNotScannedToday();

            return response()->json(['success' => true, 'qr_code' => $qrCode], 200);
        } catch (\Exception $e) {
            \Log::error("QR Code validation failed: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Internal server error'], 500);
        }
    }
}
