<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DC-Power2SME</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrapDC.min.css" rel="stylesheet">
    <link href="../css/mainDC.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font: 12pt "Tahoma";
        }
        *{
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 0 20mm 20mm 20mm;
            margin: 10mm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .subpage {
            /*padding: 1cm;
          border: 5px red solid;
          height: 257mm;
          outline: 2cm #FFEAEA solid;*/
        }

        @page {
            size: A4;
            margin: 0;
        }
        @media print {
            html, body {
                width: 210mm;
                height: 297mm;
            }
            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }
    </style>
</head>

<body>

<div class="book">
    <div class="page">
        <div class="subpage">

            <div class="main_container">


                <div class="row">
                    <div class="col-md-12">
                        <header class="siteHeader">

                            <div class="row">
                                <table>
                                    <tr>
                                        <td width="40%">
                                            <div class="col-md-12 logoDiv">
                                                <a href="#"><img src="../img/logo_nDC.png" alt="Power2Sme"></a>
                                                <span style="font-size:12px; padding:0 0 0 16px;">www.power2sme.com</span>
                                            </div>
                                        </td>

                                        <td width="60%">
                                            <div class="col-md-12">
                                                <p class="head text-right">Delivery Challan</p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </header>
                    </div>



                    <div class="clearfix"></div>

                </div>


                <div class="row">



                    <div class="main_content clearfix">



                        <div class="col-md-12">

                            <div class="heading">

                                <div class="row">

                                    <table>
                                        <tr>
                                            <td width="50%">

                                                <div class="col-md-12" style=" padding: 64px 0 0px 20px;">
                    <span class="text small"><span style="font-weight:700;">NOTE:</span><br>
Please receive the undermentioned goods order and sound condition and return the DUPLICATE COPY duly signed with your rubber stamp.</span>
                                                </div>
                                            </td>

                                            <td width="50%">
                                                <div class="col-md-8 col-md-offset-4  ">

                                                    <div class="dc_details">

                                                        <p>
                                                            <span>Order Date :</span> {{ $so->order_date }}<br>
                                                            <span>Order # </span> {{ $so->so_number }} <br>
                                                            <span>Challan Number :</span> {{ $dc->dc_number }}<br>
                                                            <span>Challan Date :</span> {{ $dc->created_at->format('Y-m-d') }} <br>
                                                            <span>PO Number :</span> 231456<br>
                                                            <span>PO Date :</span> 03 March 2016<br>

                                                        </p>

                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                    </table>

                                </div>

                            </div>

                            <div class="row">

                                <table>
                                    <tr>
                                        <td width="50%">

                                            <div class="col-md-12 address_panel">
                                                <div class="address_head"><strong>Invoice Address:</strong></div>

                                                <div class="address_box" style=" border: 1px solid #ddd !important;">

                                                    <p class="box_head">BEBB INDIA PVT. LTD.</p>
                                                    <p>{{ $bebb_location->address }}</p>

                                                    <p>
                                                        <span>TIN :</span> {{ $bebb_location->tin }}<br>
                                                        <span>CST :</span> {{ $bebb_location->cst }}<br>
                                                        <span>CIN No.:</span> {{ $bebb_location->cin }}
                                                    </p>

                                                    <p><span>Regd. Office :</span> {{ $bebb_location->address }}</p>


                                                </div>

                                            </div>

                                        </td>

                                        <td width="50%">
                                            <div class="col-md-12 address_panel">
                                                <div class="address_head"><strong>Shipping Address:</strong></div>

                                                <div class="address_box" style=" border: 1px solid #ddd !important;">

                                                    <p class="box_head">{{ $customer->name }}</p>
                                                    <p>{{ $customer->address }}</p>

                                                    <p>
                                                        <span>TIN :</span> {{ $customer->tin }}<br>
                                                        <span>CST :</span> {{ $customer->cst }}<br>

                                                    </p>

                                                    <p><br><br><br><br></p>


                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                </table>


                            </div>

                            <div class="invoice">

                                <table class="table invoice_table">
                                    <thead>

                                    <tr>
                                        <th width="60%">Description of Goods</th>
                                        <th>Total Qty.</th>
                                        <th>Unit Price</th>
                                        <th class="text-right">Sub Total</th>
                                    </tr>

                                    </thead>

                                    <tbody>


                                    @foreach($dc_details as $dc_detail)
                                    <tr>
                                        <td>
                                        <strong>1.</strong> {{ $dc_detail->sku }}</td>
                                        <td> {{ $dc_detail->sku_quantity }}</td>
                                        <td><span class="fa fa-rupee"></span> 89</td>
                                        <td class="text-right"><span class="fa fa-rupee">345</span>
                                        </td>
                                    </tr>

                                    @endforeach

                                    <tr>
                                        <td><strong>1.</strong> sdfdsfgs</td>
                                        <td>1000 MT</td>
                                        <td><span class="fa fa-rupee"></span> 89MT</td>
                                        <td class="text-right"><span class="fa fa-rupee"></span> 89,000</td>
                                    </tr>



                                    {{--<tr>--}}
                                        {{--<td colspan="4" class="text-right">--}}
                                            {{--<strong>VAT 5%:  </strong> <span class="fa fa-rupee"></span>1,59,000--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                    <tr>
                                        <td colspan="4" class="text-right">
                                            <strong>NET AMOUNT:  </strong>  <span class="fa fa-rupee"></span>1,59,000
                                        </td>
                                    </tr>



                                    <tr class="thick_border">
                                        <td colspan="4">&nbsp;

                                        </td>
                                    </tr>

                                    <tr>
                                        <td  colspan="4">
                                            <table>
                                                <tr>
                                                    <td width="50%">
                                                        <div class="row">
                                                            <div class="col-md-12">

                                                                <div class="address_box">

                                                                    <p class="box_head">Lorry /Vehicle No. : {{ $dc->truck_number }} </p>
                                                                    <p>
                                                                        <span>Note :</span><br>
                                                                        Every care is taken in packing/Delivery/goods but we do not hold ourselves responsible for loss or damage after the goods have delivered and received by you or your representative as stated above.
                                                                    </p>



                                                                </div>

                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td width="50%">
                                                        Received the above mentioned materials in good order and condition.

                                                        <br><br><br><br>
                                                        <p>________________________________________</p>
                                                        <strong> Receivers Signature with Rubber Stamp.</strong>
                                                    </td>

                                                </tr>

                                            </table>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>



                            </div>

                            <div class="row" align="center">
                                <div class="col-md-12">

                                    <div class="address_box">

                                        <p class="box_head">THANK YOU FOR YOUR BUSSINESS !!</p>
                                        <p>
                                            If you have any enquiries regading this delivery challan, Please contact us at deliveries@power2sme.com
                                        </p>

                                        <p><span>This is a Computer Generated Challan and does not require Signature.</span>
                                        </p>



                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>


            </div>

        </div>
    </div>
</div>

@if($print == '1')

<script type="text/javascript">
    <!--

    window.print();

    //-->
</script>

@endif

</body>
</html>
