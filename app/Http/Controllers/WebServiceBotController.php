<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class WebServiceBotController extends Controller
{
    
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    /**
     * 
     */

    public function listenToReplies(Request $request)
    {
        $timestamp = date('Y-m-d H:i:s');
        $from = $request->input('From');
        $body = $request->input('Body');

        $listResponses = DB::table('responses')->get();
        $phone = DB::table('phones')->where('number', $from);
        if (!$phone->exists()) {
            DB::table('phones')->insert(
                array(
                    'number' => $from,
                    'status' => '0',
                    'history' => '0',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                )
            );
        }
        
        $phone = DB::table('phones')->where('number', $from)->first();
        if ($phone->status == 1){ //if active
            $cleanBody = preg_replace("/[^a-zA-Z]+/", "", $body);
            $upBody = strtoupper($cleanBody);

            if ($phone->history == 1){ //if answered
                if ($upBody == "SELESAI") { //if body is selesai
                    DB::table('phones')->where('number', $from)->update(['status' => 0, 'history' => 0, 'updated_at' => $timestamp,]);

                    $this->sendThanks($from);
                } else if ($upBody == "MENU") { //if body is menu
                    DB::table('phones')->where('number', $from)->update(['history' => 0, 'updated_at' => $timestamp,]);
                    
                    $this->sendHello($from);
                    $this->sendMenu($from, $listResponses);
                } else { // if body is other
                    $response = DB::table('responses')->where('code', $upBody);
                    if ($response->exists()) { //if body exists in db
                        $response = $response->first();
                        DB::table('phones')->where('number', $from)->update(['history' => 1, 'updated_at' => $timestamp,]);

                        $this->sendAnswer($from, $response);
                    } else { //if body is not exist in db
                        DB::table('phones')->where('number', $from)->update(['updated_at' => $timestamp,]);

                        $this->sendMenu($from, $listResponses);
                        
                    }
                }
            } else { //if had not answered
                $response = DB::table('responses')->where('code', $upBody);
                if ($response->exists()) { //if body exists in db
                    $response = $response->first();
                    DB::table('phones')->where('number', $from)->update(['history' => 1, 'updated_at' => $timestamp,]);

                    $this->sendAnswer($from, $response);
                } else { //if body is not exists in db
                    $this->sendMenu($from, $listResponses);
                    
                }
            }
        } else { //if inactive
            DB::table('phones')->where('number', $from)->update(['status' => '1', 'updated_at' => $timestamp,]);

            $this->sendHello($from);
            $this->sendMenu($from, $listResponses);

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
    public function sendMenu($from, $listResponses){
        $message = "Apa saja sih yang ingin kamu ketahui?\n";
        foreach ($listResponses as $row) {
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
     * Sends a WhatsApp message  to phones using
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