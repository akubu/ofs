@extends('layouts.master')

@section('title', 'Products')

@section('content')
	<table class="product-list">
		<tr>
			<td>Product ID</td>
			<td>Product Name</td>
			<td>SKU</td>
			<td>Navision Status</td>
		</tr>
		@if(count($products))
			@foreach($products as $product) 
				<tr>
					<td>{{ $product['cscart_product_id'] }}</td>
					<td>{{ $product['name'] }}</td>
					<td>{{ $product['sku'] }}</td>
						
					<td>
						@if($product['pushed_to_navision'] == 0)
							In Queue
						@elseif($product['pushed_to_navision'] == 1)
							Processing
						@else
							Processed
						@endif
					</td>
				</tr>
			@endforeach
		@else
			<tr>
				<td colspan="4">No Product found.</td>
			</tr>
		@endif
	</table>
@endsection
