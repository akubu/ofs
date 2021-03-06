<script type="application/javascript">
    $(document).ready(function () {

        $('.file_downloader').click(function () {

            var file_id = $(this).attr('href');

            window.open("dc/getDownload?file_id=" + file_id);


            return false;
        });

    });
</script>

<style>
    .bar {
        height: 18px;
        background: green;
    }
</style>
<div class="container">

    <div class="row">
        <center><h3>Documents for : {{ $dc_number }}</h3></center>
    </div>

    <table class="table table-striped">

        <tr>
            <th>
                S.no
            </th>
            <th>
                Document Type
            </th>
            <th>
                &nbsp;
            </th>
            <th>
                &nbsp;
            </th>
        </tr>


        @foreach( $response as $document)

            <tr>
                <td>
                    {{ $document['sno'] }}
                </td>
                <td>
                    {{ $document['type'] }}
                </td>

                <td>
                    <div class="input-group" style="max-width:300px">
                <span class="input-group-btn">
                    <span class="btn btn-primary btn-file btn-sm">
                        Browse… <input class="selector_file" id="fileupload{{ $document['type_number'] }}" type="file"
                                       name="files[]">
                    </span>
                </span>
                        <input type="text" class="form-control" id="fileupload{{ $document['type_number'] }}_name"
                               readonly=""
                               placeholder=" @if($document['file_name'] != '0') Replace Current File @else Upload File @endif">


                    </div>
                    <span><div class="progress-bar progress-bar-striped"></div></span>


                    <!--<input class="selector_file" id="fileupload{{ $document['type_number'] }}" type="file" name="files[]" >-->

                </td>
                <td>
                    @if($document['file_name'] != '0') <a class="file_downloader" href=" {{ $document['id'] }}">
                        <i class="fa fa-download"></i> Download File</a>  @else <i class="fa fa-times"></i> File Not
                    Uploaded
                    @endif
                </td>
            </tr>

        @endforeach

    </table>


    <!-- The global progress bar -->
    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-striped"></div>
    </div>
    <!-- The container for the uploaded files -->

    <br>


    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="js/jquery.ui.widget.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="js/jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="js/jquery.fileupload.js"></script>


    <script>
        /*jslint unparam: true */
        /*global window, $ */


        r = '';

        $(function () {

            'use strict';
            // Change this to the location of your server-side upload handler:
            var url = 'dc/documentUpload';

                    @foreach($response as $document)
                     var dcNumberSelect = $("#dcNumberSelect").val();
            $('#fileupload{{ $document['type_number'] }}').fileupload({
                url: url + "?dc={{ $dc_number }}&type=" +{{ $document['type_number'] }},
                dataType: 'json',

                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    if (progress == 100) {


                        $.get('dc/documentsForDC?dc_number=' + dcNumberSelect, function (data) {

                            if (data != 0) {

                                $('#upload_div').html(data);

                            } else {
                                $.growl.error({
                                    message: 'Please check the DC Number As eneterd. ',
                                    size: 'large',
                                    duration: 5000
                                });

                            }

                        });

                    }


                    if (progress == -1 || progress == 0) {
                        $.growl.error({
                            message: 'FileType Not Allowed. ',
                            size: 'large',
                            duration: 5000
                        });
                    }
                    $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                    );
                },

                done: function (e, data) {

                    r = data.result.path;
                    if (data.result == 0 || data.result == -1) {
                        $.growl.error({
                            message: 'FileType Not Allowed. ',
                            size: 'large',
                            duration: 5000
                        });
                        return false;
                    } else {
                        $.growl.notice({
                            message: 'File Uploaded. ',
                            size: 'large',
                            duration: 5000
                        });

                        $('#file_uploaded').html($('#file_uploaded').html() + '<tr><td><font color="green"> File Uploaded at : ' + r + '</font></td></tr>');

                    }

                },
            }).on('fileuploadadd', function (e, data) {

                $("#fileupload{{ $document['type_number'] }}_name").val(data.files[0].name);

            }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

            @endforeach


        });

    </script>

</div>