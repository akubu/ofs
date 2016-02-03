
<div  contenteditable="false">

    <table class="table borderless">
        <tr>
            <th>
                Device type
            </th>
            <th>
                <input type="text" class="form-control" value="{{ $device['device_type'] }}" id="type" placeholder="Enter Device type" readonly>
            </th>
            <th>
                Device model
            </th>
            <th>
                <input type="text" class="form-control" value="{{ $device['device_model'] }}" id="model" placeholder="Enter Device Model" readonly>
            </th>
        </tr>
        <tr>
            <th>
                IMEI Number :
            </th>
            <th>
                <input type="text" class="form-control" id="imei_number" value="{{ $device['imei_number'] }}" placeholder="Enter IMEI number" readonly>
            </th>
            <th>
                SIM Number
            </th>
            <th>
                <input type="text" class="form-control" id="sim_number" value="{{ $device['sim_number'] }}" placeholder="Enter SIM number" readonly>
            </th>
        </tr>

        <tr>
            <th>
                GSM Number
            </th>
            <th>
                <input type="text" class="form-control" id="gsm_number" value="{{ $device['gsm_number'] }}" placeholder="Enter GSM number" readonly>
            </th>

            <th>
                SCM ID
            </th>
            <th><input type="text" class="form-control" id="scm_id"  value="{{ $device['scm_id'] }}" placeholder="Enter SCM id" readonly></th>
        </tr>

        <tr>
            <th>
                Runner Id
            </th>
            <th>
                <input type="text" class="form-control" id="runner_id" value="{{ $device['runner_id'] }}" value="0" placeholder="Enter runner id" readonly="readonly">
            </th>

        </tr>


    </table>

</div>
