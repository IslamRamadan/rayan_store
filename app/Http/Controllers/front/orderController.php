<?php

namespace App\Http\Controllers\front;

use App\Catering;
use App\CateringOrder;
use App\Country;
use App\Hall;
use App\HallOrder;
use App\Http\Controllers\Controller;
use App\Order;
use App\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\Console\Input\Input;

class orderController extends Controller
{
    public function index()
    {
//        $orders = OrderItem::distinct('product_id','')->pluck('product_id')->all();

//        $orders = Order::all();
//        dd($orders->order_item);

//        $comment = Order::all();
//
//        dd($comment->order_item) ;

//        foreach ($orders->order_item as $order){
//            dd($order->id);
//
//        }

//        $orders= Order::with('order_item')->where('id', 'like', '%1%')->first();
//
//        $postComment = array();
//
//        foreach($orders->order_item as $post){
//            $postComment = $post->order_item;
//        }
//        dd($postComment);
//
//        $comments = [];
//
//            $user = Order::where('country_id', 1)->with(['order_item.order' => function($query) use (&$comments) {
//            $comments = $query->get();
//        }])->first();
//foreach ($comments as $u){
//    echo("11") ;
//
//}
        $user_id = auth()->user()->id;
        $orders = Order::where('user_id', $user_id)->get();
//                dd($user);

//        $orders=[];
//        foreach ($user as $us){
//            array_push($orders,$us);
//
//        }


//        dd($orders);

        return view('front.myorder', compact('orders'));
    }

    public function hallOrder(Request $request, $id)
    {
        // dd($request->all());

        $validator = validator($request->all(), [
            'name' => 'required|max:250',
            'email' => 'nullable|email|max:250',
            'phone' => 'required|min:8|max:250',
            'street' => 'required|max:250',
            'block' => 'required|min:0|max:250',
            'floor' => 'required|min:0|max:250',
            'note' => 'nullable|max:2250',
            'start_date' => 'required|date|after:today',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'end_date' => 'required|date|after_or_equal:start_date',

        ]);
        //Islam
        if ($validator->fails()) {
            Alert::error($validator->errors()->first(), '');
            return back()->withInput();
        }
        $dates = [$request->start_date, $request->end_date];
        $checkDate = HallOrder::whereBetween('start_date', $dates)
            ->orWhereBetween('end_date', $dates)
            ->orWhere(function($query){
                $query->where('start_date', '<=', request('start_date'))
                    ->where('end_date', '>=', request('end_date'));
            })->first();
        if ($checkDate){
            Alert::error('فشل', "المدة من $checkDate->start_date الي $checkDate->end_date محجوزة من قبل.");
            return back()->withInput();
        }

        $inputs = $request->all();
        $inputs['hall_id'] = $id;
        $inputs['user_id'] = auth()->id();
        $inputs['day_price'] = Hall::findOrFail($id)->price;
        $inputs['days'] = (strtotime($request->end_date) - strtotime($request->start_date)) / (60 * 60 * 24) + 1;
        $inputs['total_price'] = $inputs['day_price'] * $inputs['days'];

        $order=HallOrder::create($inputs);
        $data = $this->makePayment1(\Illuminate\Support\Facades\Request::merge(['order_id' => $order->id]));

        //        dd($data);
        $json = json_decode($data->getContent(), true);

        $success =  $json['success'];

        if (!$success) {
            Alert::error($json['msg'], '');

            return back();
        }
        return redirect($json['link']);

    }
    public function checkDate(Request $request){
        $start_date=$request->start_date;
        $end_date=$request->end_date;
        if ($start_date=="-undefined-undefined"||$end_date=="-undefined-undefined") {
            return response()->json([
                'success' => false,
                'msg' => \Lang::get('site.correct_date')
            ]);
        }
        if ($start_date>$end_date) {
            return response()->json([
                'success' => false,
                'msg' => \Lang::get('site.wrong_date')
            ]);
        }
        $dates = [$start_date, $end_date];
        $checkDate = HallOrder::whereBetween('start_date', $dates)
            ->orWhereBetween('end_date', $dates)
            ->orWhere(function($query){
                $query->where('start_date', '<=', request('start_date'))
                    ->where('end_date', '>=', request('end_date'));
            })->first();
        if ($checkDate){
            return response()->json([
                'success' => false,
                'msg' =>  "المدة من $checkDate->start_date الي $checkDate->end_date محجوزة من قبل."
            ]);
        }
        return response()->json([
            'success' => true,
        ]);

    }

    public function cateringOrder(Request $request, $id)
    {
        // dd($request->all());
        $catering = Catering::findOrFail($id);
        $validator = validator($request->all(), [
            'name' => 'required|max:250',
            'email' => 'nullable|email|max:250',
            'phone' => 'required|max:250',
            'street' => 'required|max:250',
            'block' => 'required|max:250',
            'floor' => 'required|max:250',
            // 'address' => 'required|max:250',
            'persons_no' => 'required|int|min:' . $catering->persons_no.'|max:' . $catering->persons_max,
            'note' => 'nullable|max:2250',
            'request_female' => 'nullable|in:0,1',
            'ad_hours' => 'required|int|min:0',
            'ad_service' => 'required|int|min:0',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->errors()->first(), '');
            return back();
        }
        if ($request->email == null) {
            $request->merge(['email' => 'no@gmail.com']);
        }


        $inputs = $request->all();
        $inputs['catering_id'] = $id;
        $inputs['user_id'] = auth()->id();
        $inputs['price'] = $catering->price + (($request->persons_no - $catering->persons_no) * $catering->ad_person_price);
        $inputs['ad_hours_price'] = $catering->ad_hour_price * $request->ad_hours;
        $inputs['ad_service_price'] = $catering->ad_service_price * $request->ad_service;
        $inputs['total_price'] = $inputs['price'] + $inputs['ad_hours_price'] + $inputs['ad_service_price'];
        $order=CateringOrder::create($inputs);

        $data = $this->makePayment(\Illuminate\Support\Facades\Request::merge(['order_id' => $order->id]));

        //        dd($data);
        $json = json_decode($data->getContent(), true);

        $success =  $json['success'];

        if (!$success) {
            Alert::error($json['msg'], '');

            return back();
        }
        return redirect($json['link']);






        // Alert::success('نجح', ' تم الحجز بنجاح.');
        // return back();
    }

    public function makePayment(Request $request): \Illuminate\Http\JsonResponse
    {
        // dd('makePayment',$request->order_id);
        if (!$request->order_id) {
            response()->json(
                [
                    'success' => false,
                    'msg' => 'Data Not Match Any Order !'
                ]
            );
        }

        $order = CateringOrder::find($request->order_id);
        // dd('makePayment',$order->id);

        if (!$order) {
            response()->json(
                [
                    'success' => false,
                    'msg' => 'Order is not exist !'
                ]
            );
        }



        //        $user_id = $order->user_id;
        //
        //        $user = User::find($user_id);
        //
        //
        //        if(!$user){
        //            return  response()->json(
        //                [
        //                    'success' =>false,
        //
        //                    'msg' => 'User is not exists',
        //
        //                ]
        //            );
        //        }


        //TODO :: GET USER PHONE

        $country_code = $order->country->code;
        $phone = ($order->phone);
        $name = ($order->name) ?: '';
        $email = ($order->email) ?: '';

        //        TODO :: VALIDATION FOR BOOKING  IF  MONEY ALREADY PAID


        /* ------------------------ Configurations ---------------------------------- */
        //Test


        $apiURL = 'https://apitest.myfatoorah.com';
        $apiKey = 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL';
        //Live
        // $apiURL = 'https://api.myfatoorah.com';
        // $apiKey = 'bOP13e6rFDKxF8Q1GSGwrj327hMz4Pp7FEipItzvOVvmayOCblo1FDh2UV5uHGvgQatGWtPJGl68PQQJ4a3X3Xfp8VvSISvECda7uFZrJoo-JRBWbuGa4VLuKCTSaa1unjBoW8ywv1BL-dBPo3gMdjHovkbyDj8q2YRu_sH_IEMpKMeTUPkdeJI0l0DfDNTjqfj8iojDTZkfvOizJ4nGq2MOhBNHNsMdDcSX5yxfLv8ZJwqv_DVrZbfUxoVXX6kgHKMQcu7HBhqiO60K6Riujviasephrsa8k7qnylOZbLbEaSIXRuc7C_nRvvmUwqbw9HHG00gWAePF5KHsuuIquufKqfBZbIdbMWrM6bAzZkKSxCMIvM0adIJjzMWkI5SJc82ujVo76VRMpNvL-hx9cobZSN5AU1GklZXDCiTsITAo-AD60R3Q9M98YDYZVdihDc5lfGarVnEIMfqoz5qWI7m8te7Lj-V8oyFCpxZlTVa3SET7htHL9FvA_iQ1rivns7JnKwezb7l6jPi6uihYJmdQBbfqCJ27gkOanKQ7mBGPFscfyFX0e0dL5Cp7vhi3akde0GCtz9IBUkmXHU6bGVroP08agaxH92Y8Oxs_uTaAj87dNW4INKfwLur6Oepcy9egvLG0IYovcPhvXzw1fPEeXqDvL1vzmWNSycuMNdSyfBvz'; //Live token value to be placed here: https://myfatoorah.readme.io/docs/live-token


        /* ------------------------ Call SendPayment Endpoint ----------------------- */
        //Fill customer address array
        /* $customerAddress = array(
          'Block'               => 'Blk #', //optional
          'Street'              => 'Str', //optional
          'HouseBuildingNo'     => 'Bldng #', //optional
          'Address'             => 'Addr', //optional
          'AddressInstructions' => 'More Address Instructions', //optional
          ); */

        //Fill invoice item array
        /* $invoiceItems[] = [
          'ItemName'  => 'Item Name', //ISBAN, or SKU
          'Quantity'  => '2', //Item's quantity
          'UnitPrice' => '25', //Price per item
          ]; */

        // $order_item = OrderItem::where('order_id', $request->order_id)->get();
        // dd($delivery_cost);

        $invoiceItems = array();
        // foreach ($order_item as $item) {
            array_push($invoiceItems, [
                'ItemName'  => Catering::find($order->catering_id)->title_ar, //ISBAN, or SKU
                'Quantity'  => 1, //Item's quantity
                'UnitPrice' => number_format($order->total_price, 3, '.', ''), //Price per item
            ]);
        // }







        //Fill POST fields array
        $postFields = [
            //Fill required data
            'NotificationOption' => 'Lnk', //'SMS', 'EML', or 'ALL'
            'InvoiceValue' => $order->total_price,
            'CustomerName' => $name,
            //Fill optional data
            'DisplayCurrencyIso' => 'KWD',
            'MobileCountryCode'  => $country_code,
            'CustomerMobile'     => $phone,
            'CustomerEmail'      => $email ?? "no@gmail.com",
            'CallBackUrl'        => 'http://127.0.0.1:8000/payment_callback',
            'ErrorUrl'           =>  'http://127.0.0.1:8000/payment_error', //or 'https://example.com/error.php'
            //'Language'           => 'en', //or 'ar'
            //            'CustomerReference'  => $order->id,
            //            'CustomerCivilId'    => $order->national_id,
            //'UserDefinedField'   => 'This could be string, number, or array',
            //'ExpiryDate'         => '', //The Invoice expires after 3 days by default. Use 'Y-m-d\TH:i:s' format in the 'Asia/Kuwait' time zone.
            //'SourceInfo'         => 'Pure PHP', //For example: (Laravel/Yii API Ver2.0 integration)
            //            'CustomerAddress'    => $order->address1,
            //            'InvoiceItems'       => $order->order_items,
            'InvoiceItems'       => $invoiceItems,

        ];

        //Call endpoint
        $data = $this->sendPayment($apiURL, $apiKey, $postFields);

        //You can save payment data in database as per your needs
        $invoiceId = $data->InvoiceId;
        $paymentLink = $data->InvoiceURL;

        $order->invoice_id = $invoiceId;
        $order->invoice_link = $paymentLink;
        $order->save();


        return response()->json(
            [
                'success' => true,
                'link' => $paymentLink,
                'data' => $data,
                'order' => $order
            ]
        );
    }
    public function makePayment1(Request $request): \Illuminate\Http\JsonResponse
    {
        // dd('makePayment',$request->order_id);
        if (!$request->order_id) {
            response()->json(
                [
                    'success' => false,
                    'msg' => 'Data Not Match Any Order !'
                ]
            );
        }

        $order = HallOrder::find($request->order_id);
        // dd('makePayment',$order->id);

        if (!$order) {
            response()->json(
                [
                    'success' => false,
                    'msg' => 'Order is not exist !'
                ]
            );
        }



        //TODO :: GET USER PHONE

        $country_code = $order->country->code;
        $phone = ($order->phone);
        $name = ($order->name) ?: '';
        $email = ($order->email) ?: '';

        //        TODO :: VALIDATION FOR BOOKING  IF  MONEY ALREADY PAID


        /* ------------------------ Configurations ---------------------------------- */
        //Test


        $apiURL = 'https://apitest.myfatoorah.com';
        $apiKey = 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL';
        //Live
        // $apiURL = 'https://api.myfatoorah.com';
        // $apiKey = 'bOP13e6rFDKxF8Q1GSGwrj327hMz4Pp7FEipItzvOVvmayOCblo1FDh2UV5uHGvgQatGWtPJGl68PQQJ4a3X3Xfp8VvSISvECda7uFZrJoo-JRBWbuGa4VLuKCTSaa1unjBoW8ywv1BL-dBPo3gMdjHovkbyDj8q2YRu_sH_IEMpKMeTUPkdeJI0l0DfDNTjqfj8iojDTZkfvOizJ4nGq2MOhBNHNsMdDcSX5yxfLv8ZJwqv_DVrZbfUxoVXX6kgHKMQcu7HBhqiO60K6Riujviasephrsa8k7qnylOZbLbEaSIXRuc7C_nRvvmUwqbw9HHG00gWAePF5KHsuuIquufKqfBZbIdbMWrM6bAzZkKSxCMIvM0adIJjzMWkI5SJc82ujVo76VRMpNvL-hx9cobZSN5AU1GklZXDCiTsITAo-AD60R3Q9M98YDYZVdihDc5lfGarVnEIMfqoz5qWI7m8te7Lj-V8oyFCpxZlTVa3SET7htHL9FvA_iQ1rivns7JnKwezb7l6jPi6uihYJmdQBbfqCJ27gkOanKQ7mBGPFscfyFX0e0dL5Cp7vhi3akde0GCtz9IBUkmXHU6bGVroP08agaxH92Y8Oxs_uTaAj87dNW4INKfwLur6Oepcy9egvLG0IYovcPhvXzw1fPEeXqDvL1vzmWNSycuMNdSyfBvz'; //Live token value to be placed here: https://myfatoorah.readme.io/docs/live-token


        /* ------------------------ Call SendPayment Endpoint ----------------------- */
        //Fill customer address array
        /* $customerAddress = array(
          'Block'               => 'Blk #', //optional
          'Street'              => 'Str', //optional
          'HouseBuildingNo'     => 'Bldng #', //optional
          'Address'             => 'Addr', //optional
          'AddressInstructions' => 'More Address Instructions', //optional
          ); */

        //Fill invoice item array
        /* $invoiceItems[] = [
          'ItemName'  => 'Item Name', //ISBAN, or SKU
          'Quantity'  => '2', //Item's quantity
          'UnitPrice' => '25', //Price per item
          ]; */

        // $order_item = OrderItem::where('order_id', $request->order_id)->get();
        // dd($delivery_cost);

        $invoiceItems = array();
        $total_price=number_format($order->total_price, 3, '.', '');
        // foreach ($order_item as $item) {
            array_push($invoiceItems, [
                'ItemName'  => Hall::find($order->hall_id)->title_ar, //ISBAN, or SKU
                'Quantity'  => 1, //Item's quantity
                'UnitPrice' => $total_price, //Price per item
            ]);
        // }







        //Fill POST fields array
        $postFields = [
            //Fill required data
            'NotificationOption' => 'Lnk', //'SMS', 'EML', or 'ALL'
            'InvoiceValue' => $total_price,
            'CustomerName' => $name,
            //Fill optional data
            'DisplayCurrencyIso' => 'KWD',
            'MobileCountryCode'  => $country_code,
            'CustomerMobile'     => $phone,
            'CustomerEmail'      => $email ?? "no@gmail.com",
            'CallBackUrl'        => 'http://127.0.0.1:8000/payment_callback',
            'ErrorUrl'           =>  'http://127.0.0.1:8000/payment_error', //or 'https://example.com/error.php'
            //'Language'           => 'en', //or 'ar'
            //            'CustomerReference'  => $order->id,
            //            'CustomerCivilId'    => $order->national_id,
            //'UserDefinedField'   => 'This could be string, number, or array',
            //'ExpiryDate'         => '', //The Invoice expires after 3 days by default. Use 'Y-m-d\TH:i:s' format in the 'Asia/Kuwait' time zone.
            //'SourceInfo'         => 'Pure PHP', //For example: (Laravel/Yii API Ver2.0 integration)
            //            'CustomerAddress'    => $order->address1,
            //            'InvoiceItems'       => $order->order_items,
            'InvoiceItems'       => $invoiceItems,

        ];

        //Call endpoint
        $data = $this->sendPayment($apiURL, $apiKey, $postFields);

        //You can save payment data in database as per your needs
        $invoiceId = $data->InvoiceId;
        $paymentLink = $data->InvoiceURL;

        $order->invoice_id = $invoiceId;
        $order->invoice_link = $paymentLink;
        $order->save();


        return response()->json(
            [
                'success' => true,
                'link' => $paymentLink,
                'data' => $data,
                'order' => $order
            ]
        );
    }


    public function sendPayment($apiURL, $apiKey, $postFields)
    {
        // dd('sendPayment');

        $json = $this->callAPI("$apiURL/v2/SendPayment", $apiKey, $postFields);
        return $json->Data;
    }

    public  function handleError($response)
    {
        // dd('handleError');
        $json = json_decode($response);
        if (isset($json->IsSuccess) && $json->IsSuccess == true) {
            return null;
        }

        //Check for the errors
        if (isset($json->ValidationErrors) || isset($json->FieldsErrors)) {
            $errorsObj = isset($json->ValidationErrors) ? $json->ValidationErrors : $json->FieldsErrors;
            $blogDatas = array_column($errorsObj, 'Error', 'Name');

            $error = implode(', ', array_map(function ($k, $v) {
                return "$k: $v";
            }, array_keys($blogDatas), array_values($blogDatas)));
        } else if (isset($json->Data->ErrorMessage)) {
            $error = $json->Data->ErrorMessage;
        }

        if (empty($error)) {
            $error = (isset($json->Message)) ? $json->Message : (!empty($response) ? $response : 'API key or API URL is not correct');
        }

        return $error;
    }

    public   function callAPI($endpointURL, $apiKey, $postFields = [], $requestType = 'POST')
    {
        // dd('callAPI');
        $curl = curl_init($endpointURL);
        curl_setopt_array($curl, array(
            CURLOPT_CUSTOMREQUEST => $requestType,
            CURLOPT_POSTFIELDS => json_encode($postFields),
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $apiKey", 'Content-Type: application/json'),
            CURLOPT_RETURNTRANSFER => true,
        ));

        $response = curl_exec($curl);
        $curlErr = curl_error($curl);

        curl_close($curl);

        if ($curlErr) {
            //Curl is not working in your server
            die("Curl Error: $curlErr");
        }

        $error = $this->handleError($response);
        if ($error) {
            die("Error: $error");
        }

        return json_decode($response);
    }

    public function getPaymentStatus($payment_id): \Illuminate\Http\JsonResponse
    {


        /* ------------------------ Configurations ---------------------------------- */

        //Test
        $apiURL = 'https://apitest.myfatoorah.com';
        $apiKey = 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL';

        //Live
        // $apiURL = 'https://api.myfatoorah.com';
        // $apiKey = 'bOP13e6rFDKxF8Q1GSGwrj327hMz4Pp7FEipItzvOVvmayOCblo1FDh2UV5uHGvgQatGWtPJGl68PQQJ4a3X3Xfp8VvSISvECda7uFZrJoo-JRBWbuGa4VLuKCTSaa1unjBoW8ywv1BL-dBPo3gMdjHovkbyDj8q2YRu_sH_IEMpKMeTUPkdeJI0l0DfDNTjqfj8iojDTZkfvOizJ4nGq2MOhBNHNsMdDcSX5yxfLv8ZJwqv_DVrZbfUxoVXX6kgHKMQcu7HBhqiO60K6Riujviasephrsa8k7qnylOZbLbEaSIXRuc7C_nRvvmUwqbw9HHG00gWAePF5KHsuuIquufKqfBZbIdbMWrM6bAzZkKSxCMIvM0adIJjzMWkI5SJc82ujVo76VRMpNvL-hx9cobZSN5AU1GklZXDCiTsITAo-AD60R3Q9M98YDYZVdihDc5lfGarVnEIMfqoz5qWI7m8te7Lj-V8oyFCpxZlTVa3SET7htHL9FvA_iQ1rivns7JnKwezb7l6jPi6uihYJmdQBbfqCJ27gkOanKQ7mBGPFscfyFX0e0dL5Cp7vhi3akde0GCtz9IBUkmXHU6bGVroP08agaxH92Y8Oxs_uTaAj87dNW4INKfwLur6Oepcy9egvLG0IYovcPhvXzw1fPEeXqDvL1vzmWNSycuMNdSyfBvz'; //Live token value to be placed here: https://myfatoorah.readme.io/docs/live-token


        /* ------------------------ Call getPaymentStatus Endpoint ------------------ */
        //Inquiry using paymentId
        $keyId = $payment_id;
        $KeyType = 'paymentId';

        //Inquiry using invoiceId
        //        $keyId   = $invoice_id;
        //        $KeyType = 'invoiceId';

        //Fill POST fields array
        $postFields = [
            'Key' => $keyId,
            'KeyType' => $KeyType
        ];
        //Call endpoint
        $json = $this->callAPI("$apiURL/v2/getPaymentStatus", $apiKey, $postFields);

        //Display the payment result to your customer
        return response()->json($json->Data);
    }


    public function callBackUrl(Request $request)
    {
        dd('CallBack');

        $payment_id = $request->paymentId;


        $invoice_data =  $this->getPaymentStatus($payment_id);
        //        return $invoice_data;
        $invoice_id = $invoice_data->original->InvoiceId;
        $invoice_status = $invoice_data->original->InvoiceStatus;

        //ORDER

        $order = CateringOrder::where('invoice_id', $invoice_id)->first();
        dd('CallBack',$order);
        if (!$order) {
            //                    dd($request->all());

            Alert::error('Order is not Exist1 !');
            return redirect()->route('/');
        }

        $order->status = 1;
        $order->save();

        if (!Auth::check()) {   // Check is user logged in
            $visitor=Visitor::where('phone',$order->phone)->first();
        // dd($visitor);

        if($visitor){
        // dd($visitor);

            $visitor->num_order+=1;
            $visitor->sum_order+= $order->total_price;
            $visitor->save();
        }
        else{
            Visitor::create([
               'name'=>$order->name,
               'email'=>$order->email,
               'phone'=> $order->phone,
               'region'=> $order->city->name_ar,
               'num_order'=>1,
               'sum_order'=> $order->total_price
            ]);
        }
        }

        $country=Country::find($order->country_id);

        $country->num_order+=1;
        $country->save();





        Alert::success('Payment Completed Successfully !', '');


        return redirect()->route('/')->with(['order' => $order]);
        //ORDER 1


        //ALERT


        //HOME

    }

    public function errorUrl(Request $request)
    {
        dd('error',$request->all());
        $payment_id = $request->paymentId;



        $invoice_data =  $this->getPaymentStatus($payment_id);
        //        return $invoice_data;
        $invoice_id = $invoice_data->original->InvoiceId;
        $invoice_status = $invoice_data->original->InvoiceStatus;

        $order = CateringOrder::where('invoice_id', $invoice_id)->first();
        // dd($order);
        if (!$order) {
            $order = HallOrder::where('invoice_id', $invoice_id)->first();

        }

        Alert::error('Payment Not Completed !', '');

        return redirect()->route('/')->with(['order' => $order]);;
    }

    public function payNow($order_id)
    {
        dd('paynow',$order_id);

        $order = CateringOrder::find($order_id);

        if (!$order) {
            Alert::error('Order is not Exist2', '');

            return back();
        }

        if ($order->invoice_link && ($order->invoice_link != null)) {
            if ($order->status != 0) {
                Alert::error('Payment Can not be completed, Maybe you already paid for this', '');

                return back();
            }
            return redirect($order->invoice_link);
        }

        $data = $this->makePayment(\Illuminate\Support\Facades\Request::merge(['order_id' => $order->id]));

        $json = json_decode($data->getContent(), true);

        $success =  $json['success'];

        if (!$success) {
            Alert::error($json['msg'], '');

            return back();
        }

        return redirect($json['link']);
    }


}
