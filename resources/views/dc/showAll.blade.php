<table class="table table-striped">
    <tbody>
    <tr>
        <th>
            Dc Number
        </th>
        <th>
            Customer Name
        </th>
        <th>
            Expected Shipment Date
        </th>
        <th>
            Expected Delivery Date
        </th>
        <th>
            Update
        </th>
        <th>
            Track
        </th>
    </tr>

    @foreach( $responses as $response)

        <tr>
            <th>
                {{ $response['dc']->dc_number }}
            </th>
            <th>
                {{ $response['so']->ship_to_name }}
            </th>
            <th>
                {{ $response['dc']->expected_shipment_dt }}
            </th>
            <th>
                {{ $response['dc']->expected_delivery_dt }}
            </th>
            <th>
                Update
            </th>
            <th>
                Track
            </th>
        </tr>

    @endforeach
    </tbody>
</table>

