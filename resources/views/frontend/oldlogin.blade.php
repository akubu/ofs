
<html>

<HEAD>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</HEAD>

<body>

<center>

    <br> <br> <br> <br> <br>

    <table>

        @if($error == 'yes')

                <tr>
                    <td colspan="2">
                        <div class="alert alert-danger">
                            <strong>Danger!</strong> Username Password combination not valid ..!!!!
                        </div>
                    </td>
                </tr>


        @endif

        <form method="post" action="{{ $baseURL }}/checkpoint" >

        <tr>
            <td colspan="2">
                 <center>   Employee Login</center>
            </td>
        </tr>
        <tr>
            <td>
                Username :
            </td>
            <td>
                <input id="username" type="text" name="username" size="30" placeholder="Enter your ID/Username" required="required" />
            </td>

        </tr>
        <tr>
            <td>
                Password :
            </td>
            <td>
                <input id="password" type="password" name="password" size="30" required="required" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
            <center>    <input type="submit" value="Login "  onclick="submit()" />  </center>

            </td>
        </tr>
            </table>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
</center>

</body>

<script type="application/javascript">

    function submit() {
        var userName = document.getElementById("username").value;
        var password = document.getElementById("password").value;

        if (userName == "")
        {
            alert("please enter username");
            return;
        }
        else if (password == "")
        {
            alert("please enter password ");
            return;
        }

       // window.location = "{{ $baseURL }}/checkpoint/" + userName + "/" + password;

    }
</script>




</html>