<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MessageHelper
{
    public static function sendMessage($message, $number)
    {
        try {
            // Normalisasi nomor WA
            if (str_starts_with($number, '62')) {
                $processedNumber = $number;
            } elseif (str_starts_with($number, '0')) {
                $processedNumber = '62' . substr($number, 1);
            } elseif (str_starts_with($number, '+62')) {
                $processedNumber = substr($number, 1); // hapus "+"
            } else {
                $processedNumber = '62' . $number;
            }

            // Kirim HTTP POST
            $response = Http::timeout(10)->post(env("URL_WHATSAPP"), [
                "number" => $processedNumber,
                "message" => $message,
            ]);

            if (!$response->successful()) {
                Log::error("Gagal mengirim pesan ke {$processedNumber}. Response: " . $response->body());
                return false;
            }
            return true;
        } catch (\Exception $e) {
            Log::error("Error saat mengirim pesan ke {$number}: " . $e->getMessage());
            return false;
        }
    }
}
