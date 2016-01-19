@extends('layouts.master')

@section('title', 'Create SKU')

@section('content')

<form class="form-horizontal" id="dialog-form" style="display: none;">
	{!! csrf_field() !!}
	<div id="feature_update" class="hide">
		<img src="/images/ajax-loader.gif" />
		<div>Updating variant list. Please wait...</div>
	</div>
	<input type="text" name="new_variant" style="margin:auto;"/>
	<div class="err"></div>
	<input type="hidden" name="feature_id"/>
	<input type="hidden" name="feature_type"/>
</form>


<form class="form-horizontal" id="product">
	{!! csrf_field() !!}
	<h2 class="center-align">Create SKU</h2>
	<div class="form-group hide">
		<label for="product_name" class="col-sm-4 control-label">Product Name</label>
		<div class="col-sm-6">
			<input type="text" class="form-control" id="product_name" name="product" placeholder="Product Name">
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-4 col-sm-offset-2">
			<input type="text" class="form-control" id="reference_sku" placeholder="Reference SKU">
		</div>

		<div class="col-sm-4">
			or &nbsp;&nbsp;&nbsp;
			<button class="btn btn-primary" id="create_new" type="button">
				Create New
			</button>
			<div class="btn-group">
				<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Recently Added Products <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" id="recent-products">
					@if(count($recent_products))
						@foreach($recent_products as $product)
							<li title="{{ $product['name'] }} ({{ $product['sku'] }})" class="recent-product">
								<a href="#" data-sku="{{ $product['sku'] }}" class="truncate" >
									{{ $product['name'] }}
								</a>
									@if($product['pushed_to_navision'] == 0)
										<span class="not-processed product-status">In Queue</span>
									@elseif($product['pushed_to_navision'] == 1)
										<span class="processing product-status">In Process</span>
									@else
										<span class="processed product-status">Processed</span>
									@endif
							</li>
						@endforeach
					@else
						<li title="" class="recent-product empty-list">
							No product found
						</li>
					@endif
				</ul>
			</div>
		</div>
	</div>
	<div class="loading-container hide">
		<img src="/images/loading-big.gif" />
		<br/>
		Loading product details...
	</div>
	<div class="form-group categories hide">
		<div for="category" class="col-sm-offset-2 col-sm-8 header">Product Group</div>
	</div>
	<div class="form-group categories hide">
		<div class="col-sm-4 col-sm-offset-2">
			<select id="categories" class="form-control" name="categories" disabled>
				<option>Loading...</option>
			</select>
		</div>
	</div>

	<div class="form-group hide">
		<div class="col-sm-offset-2 col-sm-8 header">Properties</div>
	</div>
	<div class="properties">
	
	</div>

	<div class="form-group hide">
		<div for="category" class="col-sm-offset-2 col-sm-8 header">Features</div>
	</div>
	<div class="features">
	
	</div>
	<div class="form-group">
		<div for="category" class="col-sm-offset-2 col-sm-8 right-align">
			<button type="button" class="add-feature-group btn btn-primary hide">Add More</button>
		</div>
	</div>
	<div class="col-sm-offset-2 col-sm-8 hide button-div center-align">
			<button type="submit" class="btn btn-success btn-lg">Save</button>
			<img src="/images/ajax-loader.gif" class="hide"/>
	</div>
</form>
@endsection
