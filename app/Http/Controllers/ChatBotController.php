<?php

namespace App\Http\Controllers;

use DB;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class ChatBotController extends Controller
{
    /**
     * 
     */

    public function listenToReplies(Request $request)
    {
        $from = $request->input('From');
        $body = $request->input('Body');

        $listResponse = DB::table('response')->get();
        $user = DB::table('user')->where('number', $from);
        if (!$user->exists()) {
            DB::table('user')->insert(array('number' => $from,'status' => '0','history' => '0',));

        }
        
        $user = DB::table('user')->where('number', $from)->first();
        if ($user->status == 1){ //if active
            $cleanBody = preg_replace("/[^a-zA-Z]+/", "", $body);
            $upBody = strtoupper($cleanBody);

            if ($user->history == 1){ //if answered
                if ($upBody == "SELESAI") { //if body is selesai
                    DB::table('user')->where('number', $from)->update(['status' => 0, 'history' => 0]);

                    $this->sendThanks($from);
                } else if ($upBody == "MENU") { //if body is menu
                    DB::table('user')->where('number', $from)->update(['history' => 0]);
                    
                    $this->sendHello($from);
                    $this->sendMenu($from, $listResponse);
                } else { // if body is other
                    $response = DB::table('response')->where('code', $upBody);
                    if ($response->exists()) { //if body exists in db
                        $response = $response->first();
                        DB::table('user')->where('number', $from)->update(['history' => 1]);

                        $this->sendAnswer($from, $response);
                    } else { //if body is not exist in db
                        $this->sendMenu($from, $listResponse);
                        
                    }
                }
            } else { //if had not answered
                $response = DB::table('response')->where('code', $upBody);
                if ($response->exists()) { //if body exists in db
                    $response = $response->first();
                    DB::table('user')->where('number', $from)->update(['history' => 1]);

                    $this->sendAnswer($from, $response);
                } else { //if body is not exists in db
                    $this->sendMenu($from, $listResponse);
                    
                }
            }
        } else { //if inactive
            DB::table('user')->where('number', $from)->update(['status' => '1',]);

            $this->sendHello($from);
            $this->sendMenu($from, $listResponse);

        }

        return;
    }

    /**
     * Generate Massage
     */
    
    public function sendAnswer($from, $response){
        $message = $response->answer;
        $message .= "\n\nKetik *MENU* untuk melihat daftar pertanyaan, atau ketik *SELESAI* untuk mengakhiri perbincangan.";
        $this->sendWhatsAppMessage($message, $from);
    }
    public function sendHello($from){
        $message = "Halo! Selamat datang di Pusat Informasi *NATUSI*.";
        $this->sendWhatsAppMessage($message, $from);
    }
    public function sendMenu($from, $listResponse){
        $message = "Apa saja sih yang ingin kamu ketahui?\n";
        foreach ($listResponse as $row) {
            $message .= "*$row->code*. $row->question\n";
        }
        $message .= "\n\nKetik kode abjad yang diinginkan jawabannya, kemudian kirim ke kami. Maka, kami akan menjawab pertanyaan kamu.";
        $this->sendWhatsAppMessage($message, $from);
    }
    public function sendThanks($from){
        $message = "Terima kasih sudah mampir ke pusat informasi *NATUSI*.";
        $this->sendWhatsAppMessage($message, $from);
    }

    /**
     * Sends a WhatsApp message  to user using
     * @param string $message Body of sms
     * @param string $recipient Number of recipient
     */
    public function sendWhatsAppMessage(string $message, string $recipient)
    {
        $twilio_whatsapp_number = getenv('TWILIO_WHATSAPP_NUMBER');
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");

        $client = new Client($account_sid, $auth_token);
        return $client->messages->create($recipient, array('from' => "whatsapp:$twilio_whatsapp_number", 'body' => $message));
    }
}