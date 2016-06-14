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
            <td>
                {{ $dc->dc_number }}
            </td>
            <td>
                <a href='/dc/printDC?dc_number={{ $dc->dc_number }}&print=2' target="_blank">
                    <button  class="btn btn-primary" style="width: auto; " >View DC</button>
                </a>
            </td>
            <td>

                <input type="text" class="form-control" placeholder="Enter Email-Id" id="email_id_{{ $dc->identifier }}" /><center><button class="btn btn-primary" id="button_{{ $dc->identifier }}" style="width: auto; " onclick='sendMail( "{{ $dc->dc_number }}" )'>Email DC</button></center>
                <div class="hide" id="button_back_{{ $dc->identifier }}" style="text-align: center;"><img src="../images/ajax-loader.gif" /></div>
            </td>
            <td>
                <a href="/dc/downloadDC?dc_number={{ $dc->dc_number }}" ><button class="btn btn-primary" style="width: auto; ">Download DC</button></a>
            </td>
            <td>
                <a href="" ><button class="btn btn-primary" style="width: auto; ">Cancel DC</button></a>
            </td>
            <td>
                <a href='/dc/printDC?dc_number={{ $dc->dc_number }}&print=1' target="_blank"><button class="btn btn-primary" style="width: auto; ">Print DC</button></a>
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

        $('#button_' + identifier).addClass("hide");
        $('#button_back_' + identifier).removeClass('hide');




        if(validateEmail(email_id)){

            $.post('/dc/sendMail', { dc_number: dc_number , email_id  : email_id }, function(data, status){

                if( status == "success")
                {
                    $.growl.notice({
                        message: ' E-Mail sent. ',
                        size: 'large',
                        duration: 5000
                    });

                    $('#button_' + identifier).removeClass("hide");
                    $('#button_back_' + identifier).addClass('hide');


                }else{

                    $.growl.error({
                        message: ' Mail cannot be sent, please contact support. ',
                        size: 'large',
                        duration: 5000
                    });

                    $('#button_' + identifier).removeClass("hide");
                    $('#button_back_' + identifier).addClass('hide');

                }

            });

        }else{

            $.growl.error({
                message: ' Pease check email_id ',
                size: 'large',
                duration: 5000
            });


            $('#button_' + identifier).removeClass("hide");
            $('#button_back_' + identifier).addClass('hide');


        }



    }

</script>