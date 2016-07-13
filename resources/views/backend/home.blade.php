<table class="table table-striped" align="center">


    <tr>
        <th align="center">
            Total Undelivered DC :
        </th>
        <th align="center">
            {{ $response['dc_undelivered_count'] }}
        </th>

    </tr>


    <tr>
        <th align="center">
            Total Dispatch Pending Today :
        </th>
        <th align="center">
            {{ $response['dispatch_pending_today_count'] }}
        </th>

    </tr>


    <tr>
        <th align="center">
            Total Deliveries Pending Today:
        </th>
        <th align="center">
            {{ $response['delivery_pending_today_count'] }}
        </th>

    </tr>


    <tr>
        <th align="center">
            Dispatch Already Late :
        </th>
        <th align="center">
            {{ $response['late_dispatch_count'] }}
        </th>
    </tr>


    <tr>
        <th align="center">
            Deliveries Already Late :
        </th>
        <th align="center">
            {{ $response['late_delivery_count'] }}
        </th>

    </tr>

</table>