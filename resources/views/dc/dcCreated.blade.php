<br>
<br>
<br>
<center>



    <table class="table table-striped">


        @if (count($dcs) > 0)


        <tr>
        <th>
            DC Number
        </th>
        <th>
            View DC
        </th>
            <th>
                Email DC
            </th>
        <th>
            Download DC
        </th>
        <th>
            Cancel DC
        </th>
        <th>
            Print DC
        </th>
        </tr>

        @foreach($dcs as $dc)

        <tr>
            <td title="

            @foreach($dc->details as $dc_detail)
            {{ $dc_detail->sku_description }} &nbsp; &nbsp; {{ $dc_detail->sku_quantity }} {{ $dc_detail->sku_units }}
            @endforeach

            ">
                {{ $dc->dc_number }}
            </td>
            <td >
                <a href='/dc/printDC?dc_number={{ $dc->dc_number }}&print=2' target="_blank">
                    <i class="fa fa-eye" aria-hidden="true"><span style="font-family: open sans,Helvetica Neue,Helvetica,Arial,sans-serif !important; font-weight:700;" > View DC </span></i>
                </a>
            </td>
            <td width="290px">

                <div >
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="email id " id="email_id_{{ $dc->identifier }}">
      <span class="input-group-btn">
        <button  id="email_id_button_{{ $dc->identifier }}" class="btn btn-primary btn-sm" type="button" onclick='sendMail( "{{ $dc->dc_number }}")'>Email DC</button>
          <div class="hide" id="email_id_button_back_{{ $dc->identifier }}" style="text-align: center;"><img src="../images/ajax-loader.gif" /></div>
      </span>
                    </div>
                </div>


                {{--<input type="text" class="form-control" placeholder="Enter Email-Id" id="email_id_{{ $dc->identifier }}" /><center><button class="btn btn-primary" id="button_{{ $dc->identifier }}" style="width: auto; " onclick='sendMail( "{{ $dc->dc_number }}" )'>Email DC</button></center>--}}
                {{--<div class="hide" id="button_back_{{ $dc->identifier }}" style="text-align: center;"><img src="../images/ajax-loader.gif" /></div>--}}
            </td>
            <td>
                <a href="/dc/downloadDC?dc_number={{ $dc->dc_number }}" ><i class="fa fa-download" ></i> <span style="font-weight: 700"> Download DC </span> </a>
            </td>
            <td>
                <a onclick='cancelDC( "{{ $dc->dc_number }}")'  id="cancel_dc_button_{{ $dc->identifier }}"><i class="fa fa-times" aria-hidden="true"></i> <span style="font-weight: 700"> Cancel DC</span> </a>
                <div class="hide" id="cancel_dc_button_back_{{ $dc->identifier }}" style="text-align: center;"><img src="../images/ajax-loader.gif" /></div>
            </td>
            <td>
                <a href='/dc/printDC?dc_number={{ $dc->dc_number }}&print=1' target="_blank"><i class="fa fa-print" aria-hidden="true"><span style="font-family: open sans,Helvetica Neue,Helvetica,Arial,sans-serif !important; font-weight:700;" > Print DC</span> </i></a>
            </td>
        </tr>
        @endforeach
    </table>

    @else
        <center>
            <h3>
                No DC Registered for SO.
            </h3>
        </center>

    @endif

</center>

<script type="application/javascript">

    function validateEmail(email_address) {

        var atpos = email_address.indexOf("@");
        var dotpos = email_address.lastIndexOf(".");
        if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email_address.length) {

            return false;
        }
        else
        {
            return true;
        }
    }


    function sendMail( dc_number ){



        var identifier =  dc_number.replace(new RegExp('/', 'g'), '_');

        var email_id = $("#email_id_" + identifier).val();

        $('#email_id_button_' + identifier).addClass("hide");
        $('#email_id_button_back_' + identifier).removeClass('hide');




        if(validateEmail(email_id)){

            $.post('/dc/sendMail', { dc_number: dc_number , email_id  : email_id }, function(data, status){

                if( status == "success")
                {
                    $.growl.notice({
                        message: ' E-Mail sent. ',
                        size: 'large',
                        duration: 5000
                    });

                    $('#email_id_button_' + identifier).removeClass("hide");
                    $('#email_id_button_back_' + identifier).addClass('hide');

                    $("#email_id_" + identifier).val("");


                }else{

                    $.growl.error({
                        message: ' Mail cannot be sent, please contact support. ',
                        size: 'large',
                        duration: 5000
                    });

                    $('#email_id_button_' + identifier).removeClass("hide");
                    $('#email_id_button_back_' + identifier).addClass('hide');

                }

            });

        }else{

            $.growl.error({
                message: ' Pease check email id ',
                size: 'large',
                duration: 5000
            });


            $('#email_id_button_' + identifier).removeClass("hide");
            $('#email_id_button_back_' + identifier).addClass('hide');


        }

    }

    function cancelDC(dc_number) {


        var identifier = dc_number.replace(new RegExp('/', 'g'), '_');


        $('#cancel_dc_button_' + identifier).addClass("hide");
        $('#cancel_dc_button_back_' + identifier).removeClass('hide');


        var r = confirm("Do you want to Cancel " + dc_number);
        if (r == true) {


            $.post('/dc/cancelDC', {dc_number: dc_number}, function (data, status) {

                if (status == "success") {

                    var so_number = $('#so_number').val();

                    $.post("/so/show", {so_number: so_number}, function (data, status) {

                        $('#so_details').html(data);
                    });


                } else {

                    $.growl.error({
                        message: ' DC Cannot be deleted. ',
                        size: 'large',
                        duration: 5000
                    });

                    $('#cancel_dc_button_' + identifier).removeClass("hide");
                    $('#cancel_dc_button_back_' + identifier).addClass('hide');

                }

            });


        } else {

            $('#cancel_dc_button_' + identifier).removeClass("hide");
            $('#cancel_dc_button_back_' + identifier).addClass('hide');

        }
    }


</script>