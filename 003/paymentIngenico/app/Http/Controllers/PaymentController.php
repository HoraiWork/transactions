<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Transactions;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    private $apiUrl = 'https://ogone.test.v-psp.com/ncol/test/orderdirect.asp';
    private $pspid = 'horaiwork2';
    private $userid = 'user2';
    private $pswd = 'U{4%9v}?M6~m';

    public function index()
    {
        $transactions = Transactions::all();
        return view('pages.index' ,[
            'transactions' => $transactions
        ]);
    }
    /*
     * add a new note for the transaction
     */
    public function addNewNoteTransaction( )
    {

        $data['ORDERID'] = '345453435';
        $data['AMOUNT'] = $_GET['AMOUNT'] ?? 100;
        $data['CARDNO'] = '4111111111111111';
        $data['BRAND'] = 'VISA';
//        $data['PSPID'] = env('PSPID', 'horaiwork2');
//        $data['USERID'] = env('USERID', 'user2');
//        $data['PSWD'] = env('PSWD', 'U{4%9v}?M6~m');
        $data['CURRENCY'] = 'EUR';
        $data['LANGUAGE'] = 'en_US';
        $datatime = Carbon::now();
//        $data['OPERATION'] = 'RES';


        $array = [
            'billing_id' => $data['ORDERID'],
            'amount' => $data['AMOUNT'],
            'card_number' => $data['CARDNO'],
            'currency' => $data['CURRENCY'],
            'payment_methods' => $data['BRAND'],
            'payment_added' => $datatime,
            'payment_modified' => $datatime,
        ];
        DB::table('transactions')->insert(
            [$array]
        );

      //  return $add_transaction;
    }

    /*
     * add a new note for the transaction
     */

    public function addSelectedTransaction(Request $request)
    {
        $id = $request['order_id'];

        $array =  Transactions::where('id', '>', $id)->firstOrFail();

        $data['ORDERID'] = $array['billing_id'] ?? 11111;
        $data['AMOUNT'] = $array['amount'] ?? 1;
        $data['CARDNO'] = $array['card_number'] ?? "4111111111111111";
        $data['PSPID'] = $this->pspid;
        $data['USERID'] = $this->userid;
        $data['PSWD'] = $this->pswd;
        $data['PM'] = 'CreditCard';
        $data['ED'] = $array['ed'];
        $data['ECI'] = 7;
        $data['CVC'] = $array['cvc'];
        $data['BRAND'] = $array['BRAND'] ?? 'VISA';
        $data['CURRENCY'] = 'EUR';
        $data['LANGUAGE'] = 'en_US';
        $data['OPERATION'] = 'RES';

        $cURL = curl_init();

        $data['AMOUNT'] = $data['AMOUNT'] * 100;
        $query = str_replace("%3B", ";", http_build_query($data));
        $query = str_replace("&#47;", "/", $query);
        $parameters = $this->apiUrl.'?'.$query;

        curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($cURL, CURLOPT_URL, $parameters);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cURL, CURLOPT_HTTPGET, true);

        $result = curl_exec($cURL);
        curl_close($cURL);

        $xml = simplexml_load_string($result, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        $xml = $array['@attributes'];

        $request = json_encode($xml , true);
        return response()->json($request);
    }
}
