<script type="application/javascript">

    $(document).ready(function () {

        $("#ask").click(function () {


            question = $('#question').val();


            if (question.length < 5) {
                $.growl.error({
                    message: 'Please ask a proper question',
                    size: 'large',
                    duration: 5000
                });
                return false;
            }
            $('#ask').addClass("hide");
            $('#ask').next().removeClass('hide');

            $.get("/help/question?question=" + question, function (data) {

                if (data == 1) {
                    $.growl.notice({
                        message: 'Question received, We will get back to you .',
                        size: 'large',
                        duration: 5000
                    });

                    $('#msg').html("We Will get back to you soon, with reply to your Question.<br>Q: <font color='blue'> " + question + "</font>");
                    $('#ask').removeClass("hide");
                    $('#ask').next().addClass('hide');
                } else {

                    $.growl.error({
                        message: 'Something went wrong, probably we are working on it',
                        size: 'large',
                        duration: 5000
                    });

                    $('#ask').removeClass("hide");
                    $('#ask').next().addClass('hide');

                }

            });

        });
    });

</script>
<center><h2>Have Questions ?</h2></center>
<hr>
<center>

    <table class="table table-striped">

        <tr>
            <th>
                <textarea id="question" rows="4" style="width: 100%; height: 110px;"/>
            </th>

        </tr>

    </table>
    <div class="row">
        <div class="col-md-5"></div>
        <div class="col-md-2">
            <button id="ask" class="btn btn-primary red">Ask this question</button>
            <div class="hide" style="text-align: center;"><img src="/images/ajax-loader.gif"/></div>
        </div>
        <div class="col-md-5"></div>
    </div>
    <p>

    <h3 id="msg"></h3></p>

</center>