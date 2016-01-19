<script type="application/javascript">

$(document).ready(function(){

    $("#ask").click(function () {


    var question = $('#question').val();

    if(question.length < 5){
        $.growl.error({
            message: 'Please ask a proper question',
            size: 'large',
            duration: 5000
        });
        return false;
    }
        $.get("/help/question?question="+question, function (data) {

            if(data == 0){
                $.growl.notice({
                    message: 'We will get back to you !',
                    size: 'large',
                    duration: 5000
                });
            $('#msg').html("We Willl get back to you soon, with reply to your Question.<br>Q: <font color='blue' " + question +"</font");

            }else {

                $.growl.error({
                    message: 'Something went wrong, probably we are working on it',
                    size: 'large',
                    duration: 5000
                });
            }

        });

    });
});

</script>

<center>

    <table class="table table-bordered">
        <tr>
            <th>
                <center>Question</center>
            </th>
        </tr>
        <tr>
            <th>
            <textarea id="question" rows="4" style="width: 100%; height: 110px;"/>
            </th>

        </tr>
        <tr>
            <th>
                <button id="ask" class="btn btn-primary red">Ask this question</button>
            </th>
        </tr>
    </table>

    <br>
    <hr>
    <p  > <h3 id="msg"></h3></p>

</center>