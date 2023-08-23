<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <style>
  
      html *
        {
         font-size: 0.8rem !important; 
         color: #000 !important;
         font-family: Arial !important;
      }
      
      body{
            background-image:url({{url('public/assets/watermark.png')}});
            height: 300px; /* You must set a specified height */
            background-position: center; /* Center the image */
            background-repeat: no-repeat, repeat;
            background-size: cover;
      }
        .container{
          width: 90%;
          margin:0 auto;
        }
        table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
        }
        </style>
      <style>
        #amount
        {
          margin-top:20px;
          margin-left:-20px;
        }
        #option1
        {
          margin-top:10px;
        }
        #option2
        {
          margin-top:10px;
        }
        .footer {
          position:absolute;
          right: 0;
          bottom: 0;
          left: 0;
          padding: 0rem;
          background-color: #ffffff;
          text-align: center;
        }
        .new2
        {
          border:1px dashed rgb(0, 0, 0);
        }
        .invoice
        {
          width:40%; 
          height:3.2rem; 
          text-align:right;
          line-height: 1.6;
        }
      #imgageLogo
      {
        width: 150px;
      }
      .imgageLogoDiv{
        margin:0 auto;
      }
      </style>
</head>

<body>
  <header></header>
<!-- <img id="imgageLogo" src="{{asset("public/assets/LOGO.png")}}"> -->
  <div class="container"> 
    <div class="imgageLogoDiv">
      <img id="imgageLogo" src="{{asset("public/assets/LOGO.png")}}">
    </div>
    <br>
@php
    $start = '';
    $end = '';
    if($currency == 'USD')
    {
      $start = '$';
      $end = '/-USD';
     }
    if($currency == 'INR')
    {
      $start = 'Rs.';
      $end = '/-INR';
     }
    if($currency == 'GBP')
    {
      $start = '£';
      $end = '/-GBP';
     }
    if($currency == 'CAD')
    {
      $start = '$';
      $end = '/-CAD';
     }
    if($currency == 'EURO')
    {
      $start = '€';
      $end = '/-EUR';
     }
    if($currency == 'AED')
    {
      $start = '$';
      $end = '/-AED';
     }
    if($currency == 'SAR')
    {
      $start = '';
      $end = '/-SAR';
     }
@endphp
    
    <table style="width:100%;">
      <tr>
        <td colspan="2" style="line-height: 1.5; padding:5px;">Bytelogic Technologies<br>
          Suit S-09, D-242, D-Block, Sector 63 noida, Uttar Pradesh 201301 IN</td>
        <td colspan="2" style="text-align:right; vertical-align: bottom;"><b>
        @php
            if($payment->invoice_type == 'gst')
            {
              echo 'Tax Invoice';
            }else{
              echo 'Payment Invoice';
            }
        @endphp  
        </b></td>
      </tr>
      <tr>
        <td colspan="2" style="padding:5px;">GSTIN - 09BCMPG2902G1ZR<br>
       </td>
        <td colspan="2" class="invoice">INVOICE# {{$payment->invoice_id}}<br>
          DATE: {{date("d-m-Y", strtotime($payment->invoice_date))}}</td>
      </tr>
      <tr>
        <td style="width:30px;">To</td>
        <td style="line-height:1.5;"> 
          {{$payment->name}}</br>
          @if($payment->address)
          {{$payment->address}}</br>
          @endif
          @if($payment->state)
          {{$payment->state}},
          @endif
          {{$payment->country}}</br>
          {{$payment->email}}</br>
          {{$payment->phone}}</br>
          @if($payment->gst_no)
            GSTIN: {{$payment->gst_no}}
          @endif
        </td>
          <td style="width:30px;">Job</td>
          <td style="padding:5px;">{{$payment->job_description}}</td>
      </tr>
     </table>

    <table style="width:100%; border-top:0; margin-top:10px;">
   <tr style="background-color: gainsboro;">
    <th style="line-height:1.5;">
      SR.</br>
      NO.
    </th>
    <th>DESCRIPTION</th>
    <th style="padding: 5px;">TOTAL CHARGES</th>
   </tr>

   @php $count = 0; @endphp

   @foreach ($services as $service)

   @php $count =$count + 1; @endphp
   <tr>
    <td style="padding:7px;">{{$count}}</td>
    <td style="line-height:2;">
        {{$service->service_name}}
    </td>
    <td style="line-height:2;">
      {{$start}}  {{$service->amount}} {{$end}}
    </tr>
    @endforeach


    @php $count =$count + 1; @endphp

   <tr>
    <td style="padding:7px;">{{$count}}</td>
    <td style="line-height:2;">
     Total 
    </td>
    <td style=" line-height:2;">
      {{ $start }} {{$payment->total_amount}}  {{$end}}
    </td>
  </tr>


  @php

  if($payment->invoice_type == 'gst'){
      if($payment->state == "Uttar Pradesh" && $payment->country == "India"){

        $html = 'CGST @9% on '.$payment->total_amount;
        $html1 =  'SGST @9% on '.$payment->total_amount;
        $html2 =  $start . ($payment->total_amount *9)/100 .$end ;
        $html3 =  $start . ($payment->total_amount *9)/100 .$end;
      }elseif($payment->state != "Uttar Pradesh" && $payment->country == "India"){
        $html = 'IGST @ 18% on ' . $payment->total_amount;
        $html2 = $start . ($payment->total_amount *18)/100 .$end;
        $html1 ='';
        $html3 = "";
      }else{
        $html = '';
        $html1 ='';
        $html3 = "";
        $html2 = '';
      }
  }else{
    $html = '';
    $html1 ='';
    $html2 = '';
    $html3 = '';
  } 
  @endphp

@if ($html != '' && $html2 !='')
  @php $count =$count + 1; @endphp
  <tr>
    <td style="padding:7px;">{{$count}}</td>
    <td style="line-height: 2">{{$html}} <br> {{$html1}}</td>
    <td style="line-height: 2;">{{$html2}}  <br> {{$html3}}</td>
  </tr>
@endif


@php $count =$count + 1; @endphp
  <tr>
    <td style="padding:7px;">{{$count}}</td>
    <td><b>Grand Total</b></td>
    <td style="padding:10px;"><b>
    @php 
    $cgstIgst = $payment->total_amount + ($payment->total_amount *9)/100 + ($payment->total_amount *9)/100;
    $gst = $payment->total_amount + ($payment->total_amount *18)/100;
    @endphp

    @if ($payment->invoice_type == 'gst')
      @if ($payment->state == "Uttar Pradesh" && $payment->country == "India")
        {{$start}}{{round($cgstIgst)}} {{$end}}
        @php $total = $cgstIgst; @endphp
      @elseif($payment->state != "Uttar Pradesh" && $payment->country == "India")
      {{$start}}{{round($gst)}}  {{$end}}
      @php $total = $gst; @endphp
      @else
      @php $total = $payment->total_amount; @endphp
      {{$start}}{{round($total)}} {{$end}}
      @endif
      @else 
        @php $total = $payment->total_amount; @endphp
        {{$start}}{{round($total)}} {{$end}}
     @endif 
      
   </b></td>
  </tr>
    </table>

   
<div id="amount">
    <a href=""><b>Amount in Words:</b></a> <b><span id="grandTotal">
      @php
      $number = round($total);
      $no = floor($number);
      $point = round($number - $no, 2) * 100;
      $hundred = null;
      $digits_1 = strlen($no);
      $i = 0;
      $str = array();
      $words = array('0' => '', '1' => 'One', '2' => 'Two',
        '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
        '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
        '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
        '13' => 'Thirteen', '14' => 'Fourteen',
        '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
        '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
        '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
        '60' => 'Sixty', '70' => 'Seventy',
        '80' => 'Eighty', '90' => 'Ninety');
      $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
      while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number] .
                " " . $digits[$counter] . $plural . " " . $hundred
                :
                $words[floor($number / 10) * 10]
                . " " . $words[$number % 10] . " "
                . $digits[$counter] . $plural . " " . $hundred;
        } else $str[] = null;
      }
      $str = array_reverse($str);
      $result = implode('', $str);
      $points = ($point) ?
        "." . $words[$point / 10] . " " . 
              $words[$point = $point % 10] : '';

        $currency_value = '';
               if($currency == 'USD')
               {
                $currency_value = 'US Dollars';
                }
               if($currency == 'INR')
               {
                $currency_value = 'Indian Rupees';
                }
               if($currency == 'GBP')
               {
                $currency_value = 'Great Britain Pound';
                }
               if($currency == 'CAD')
               {
                $currency_value = 'Canadian Dollars';
                }
               if($currency == 'EURO')
               {
                $currency_value = 'Euro';
                }
               if($currency == 'AED')
               {
                $currency_value = 'United Arab Emirates Dirham';
                }
               if($currency == 'SAR')
               {
                $currency_value = 'Saudi Riyal';
                }

      echo $result .  $currency_value ;
 
      @endphp  
    </span></b>
    <p> Wiring Instructions:<i> PLEASE FOLLOW THE PAYMENT INSTRUCTIONS EXACTLY AS MENTIONED.</i></br>
      Credit the amount to
    </p>
    <div><b><u><i>OPTION 1: Account TRANSFER</i></u></b></div>
    <div id="option1">
      Account Name: BYTELOGIC TECHNOLOGIES </br>
      Account Number: 4078002100207719 </br>
      Bank: Punjab National Bank </br> 
      Branch: RDC Rajnagar, Ghaziabad </br>
      IFSC: PUNB0407800 </br>
      SWIFT CODE: PUNBINBBISP </br>
    </div>
    <div id="option2"><b><u><i>Option2: UPI</i></u></b></div>
    <div style="margin-top:10px;">
      bytelogicindia-1@okaxis</br>
    </div>

    <div style="margin-top:10px;"><b><u><i>Option2: Paypal</i></u></b></div>
    <div style="margin-top:10px;">
      info@bytelogicindia.com</br>
    </div>
    
    <div style="margin-top:10px;">
    <b><u>Thanking You </u></b></br>
     Vineet Gupta </br>
     Phone: +91-9971727334 </br>
     Email: vineet@bytelogicindia.com </br>
    </div>
</div>
</div>

<footer>
  <div class="footer">
    <hr class="new2">
    <p> Bytelogic Technologies (www.bytelogicindia.com) / Email: bytelogicindia@gmail.com | info@bytelogicindia.com
    </p>
    <p>Ph.: +91-9971727334 | Suit S09 – D-242, D-Block, Sector–63, Noida, 201301</p>
  </div>
</footer>


 
</body>


</html>
