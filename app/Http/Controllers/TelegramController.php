<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Bus;
use Illuminate\Support\Facades\Http;

class TelegramController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $update = $request->all();
        $chat_id = $update["message"]["chat"]["id"];
        $text = $update["message"]["text"];

        if ($text == "/start") {
            $response_text = "Salom! Avtobus joylashuvini bilish uchun /location [bus_number] yozing.";
        } elseif (strpos($text, "/location") === 0) {
            $bus_number = trim(str_replace("/location", "", $text));

            $bus = Bus::where('bus_number', $bus_number)->first();
            if ($bus) {
                $this->sendLocation($chat_id, $bus->latitude, $bus->longitude);
                return response()->json(['status' => 'sent']);
            } else {
                $response_text = "Bunday avtobus topilmadi.";
            }
        } else {
            $response_text = "Buyruq noto‘g‘ri. /location [bus_number] yozing.";
        }

        $this->sendMessage($chat_id, $response_text);
        return response()->json(['status' => 'ok']);
    }

    private function sendMessage($chat_id, $text)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        Http::get("https://api.telegram.org/bot$token/sendMessage", [
            'chat_id' => $chat_id,
            'text' => $text,
        ]);
    }

    private function sendLocation($chat_id, $latitude, $longitude)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        Http::get("https://api.telegram.org/bot$token/sendLocation", [
            'chat_id' => $chat_id,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);
    }
}
