<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public function sendMessage($phone, $message)
    {
        try {
            // Format nomor telepon
            $phone = $this->formatPhoneNumber($phone);
            
            // Log untuk monitoring
            Log::info('WhatsApp Message Sent', [
                'phone' => $phone,
                'message' => $message
            ]);
            
            // Kirim WA real via Fonnte
            if (env('FONNTE_TOKEN')) {
                $response = Http::withHeaders([
                    'Authorization' => env('FONNTE_TOKEN')
                ])->post('https://api.fonnte.com/send', [
                    'target' => $phone,
                    'message' => $message,
                    'countryCode' => '62'
                ]);
                
                if ($response->successful()) {
                    Log::info('Fonnte API Success', $response->json());
                    return true;
                } else {
                    Log::error('Fonnte API Failed', $response->json());
                    return false;
                }
            }
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('WhatsApp send error: ' . $e->getMessage());
            return false;
        }
    }

    private function formatPhoneNumber($phone)
    {
        // Hapus karakter non-digit
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Jika dimulai dengan 0, ganti dengan 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }
        
        return $phone;
    }
}