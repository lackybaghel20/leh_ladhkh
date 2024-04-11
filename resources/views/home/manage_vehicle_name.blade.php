@extends('layouts.app-master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">


<div class="pagetitle">
  <h1>Manage Vehicle Name</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item">Home</li>
	  <li class="breadcrumb-item">Manage Vehicle Name</li>          
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  <h5 class="card-title">Manage Vehicle Name
		  <a class="btn btn-info" href="javascript:void(0)" id="createNewProduct" style="float:right;"> Add Vehicle Name</a>
		  </h5>
		   @auth
			<table class="table table-bordered data-table">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Model</th>
						<th>Type</th>
						<th>Description</th>
						<th width="280px">Action</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>				
			@endauth
		</div>
	  </div>
	</div>
  </div>
</section>
	
	<div class="modal fade show" id="ajaxModelexa" tabindex="-1"  aria-modal="true" role="dialog">
		<div class="modal-dialog">
		 <form id="vehicleType" name="vehicleName" class="form-horizontal">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="modelHeading"></h5>
			  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
			   <input type="hidden" name="id" id="id">
				<div class="col-sm-12">
					<div class="form-group">
					<label for="vehicle_name" class="control-label">Vehicle Name</label>
						<input type="text" class="form-control vehicle_name" id="vehicle_name" name="vehicle_name" placeholder="Enter Vehicle Name" value="" required>
					</div>
				</div>

				<div class="col-sm-12">
					<div class="form-group">
					<label class="control-label">Vehicle Type</label>
						<select class="form-select vehicle_type" name="vehicle_type" aria-label="Default select example" required>
						  <option value="">Select Vehicle Type</option>
						  @foreach($manage_vehicle_types as $key=>$val)
							<option value="{{$val->id}}">{{$val->name}}</option>
						  @endforeach
						</select>
					</div>
				</div>
				
				<div class="col-sm-12">
					<div class="form-group">
					<label class="control-label">Vehicle Model</label>
						<select class="form-select vehicle_model" name="vehicle_model" aria-label="Default select example" required>
						<option value="">Select Vehicle Model</option>
						  @foreach($manage_vehicle_models as $key=>$val)
							<option value="{{$val->id}}">{{$val->name}}</option>
						  @endforeach
						  
						</select>
					</div>
				</div>

				<div class="col-sm-12">
					<div class="form-group">
					<label class="control-label">Description</label>
						<textarea id="description" name="description"  placeholder="Enter Description" class="form-control"></textarea>
					</div>
				</div>
      
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			  <button type="submit" class="btn btn-primary" id="savedata" value="create">Save</button>
			</div>
		  </div>
		</form>
		</div>
	  </div>
	  
	  

<script type="text/javascript">
  $(function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('manage_vehicle_name') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'vname', name: 'vname'},
            {data: 'vmodel', name: 'vmodel'},
            {data: 'vtype', name: 'vtype'},
            {data: 'description', name: 'description'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    $('#createNewProduct').click(function () {
        $('#savedata').val("create-product");
        $('#id').val('');
        $('#vehicleType').trigger("reset");
        $('#modelHeading').html("Add Vehicle Name");
        $('#ajaxModelexa').modal('show');
    });
    
    $('body').on('click', '.editProduct', function () {
      var id = $(this).data('id');
      $.get("{{ url('edit_vehicle_name') }}" +'/' + id , function (data) {
          $('#modelHeading').html("Update Vehicle Name");
          $('#savedata').val("edit-user");
          $('#ajaxModelexa').modal('show');
          $('#id').val(data.id);
          $('.vehicle_name').val(data.vname);
          $('.vehicle_type').val(data.vtype);
          $('.vehicle_model').val(data.vmodel);
          $('#description').val(data.description);
      })
   });
    
	$(document).ready(function () {

     $("#vehicleType").validate({
         ignore: ":hidden",
         rules: {
             name: {
                 required: true
                
             }
         },
         submitHandler: function (form) {
            $.ajax({
				  data: $('#vehicleType').serialize(),
				  url: "{{ route('save_vehicle_name') }}",
				  type: "POST",
				  dataType: 'json',
				  success: function (data) {
			 
					  $('#vehicleType').trigger("reset");
					  $('#ajaxModelexa').modal('hide');
					  table.draw();
				 
				  },
				  error: function (data) {
					  console.log('Error:', data);
					  $('#savedata').html('Save Changes');
				  }
			  });
             return false; // required to block normal submit since you used ajax
         }
     });

 });
	 
    $('body').on('click', '.deleteProduct', function () {
     
        var id = $(this).data("id");
       
	   Swal.fire({
		title: "Are you sure want to delete this item!",					  
		  showCancelButton: true,
		  cancelButtonText: "No",
		  confirmButtonText: "Yes",					  
		  icon: "warning"
		}).then((result) => {					  
		  if (result.isConfirmed) {
							
			 $.ajax({
				type: "DELETE",
				url: "{{ url('destroy_vehicle_name') }}"+'/'+id,
				success: function (data) {
					Swal.fire("Item deleted successfully", "", "success");
					table.draw();
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});				
		  } 
		});		
		
    });
     
  });
</script>

@endsection

 