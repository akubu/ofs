@extends('layouts.master')

@section('title', 'Create SKU')

@section('content')
	<div class="container">
		<div class="col-sm-12">
			<button class="btn btn-primary pull-right"  data-toggle="modal" data-target="#myModal">Add User</button>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add User</h4>
					</div>
					<div class="modal-body">
						<form role="form">
							{!! csrf_field() !!}
							<div class="form-group">
								<label for="email">VTiger User ID</label>
								<input type="text" class="form-control" name="user[vtiger_user_id]">
								<div class="checkbox">
									<label>
										<input type="hidden" name="is_cluster_head" value="0">
										<input type="checkbox" name="is_cluster_head" value="1">
										Is this user a cluer head?
									</label>
								</div>
							</div>
							<div class="form-group">
								<label for="email">Permissions</label>
								@foreach($permissions as $permission)
									<div class="checkbox checkbox-primary">
										<label>
											<input type="hidden" name="permission[{{ $permission->id }}]" value="0">
											<input type="checkbox" name="permission[{{ $permission->id }}]" value="1">
											{{ $permission->permission }}
										</label>
									</div>
								@endforeach
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success save-user">Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
(function() {
	$('#myModal').modal()
})();
</script>
@endsection
