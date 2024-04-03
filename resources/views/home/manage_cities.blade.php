@extends('layouts.app-master')

@section('content')

	  <meta name="csrf-token" content="{{ csrf_token() }}">
  
	<div class="pagetitle">
      <h1>Manage Cities</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Home</li>
          <li class="breadcrumb-item">Manage Cities</li>          
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Manage Cities
			  <a class="btn btn-info" href="javascript:void(0)" id="createNewProduct" style="float:right;"> Add City</a>
			  </h5>
			   @auth
				<table class="table table-bordered data-table">
					<thead>
						<tr>
							<th>#</th>
							<th>City Name</th>
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
	
	
	<div class="modal fade show" id="ajaxModelexa" tabindex="-1" aria-modal="true" role="dialog">
		<div class="modal-dialog">
		  <form id="productForm" name="productForm" class="form-horizontal">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="modelHeading"></h5>
			  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
                   <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="name" placeholder="Enter Name" value="" required>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-12">
                            <textarea id="description" name="description"  placeholder="Enter Description" class="form-control"></textarea>
                        </div>
                    </div>
      
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			  <button type="submit" class="btn btn-primary">Save </button>
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
        ajax: "{{ route('manage_cities') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'description', name: 'description'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    $('#createNewProduct').click(function () {
        $('#savedata').val("create-product");
        $('#id').val('');
        $('#productForm').trigger("reset");
        $('#modelHeading').html("Add City");
        $('#ajaxModelexa').modal('show');
    });
    
    $('body').on('click', '.editProduct', function () {
      var id = $(this).data('id');
      $.get("{{ url('edit_cities') }}" +'/' + id , function (data) {
          $('#modelHeading').html("Update City");
          $('#savedata').val("edit-user");
          $('#ajaxModelexa').modal('show');
          $('#id').val(data.id);
          $('#title').val(data.name);
          $('#description').val(data.description);
      })
   });
    
	$(document).ready(function () {

     $("#productForm").validate({
         ignore: ":hidden",
         rules: {
             name: {
                 required: true
                
             }
         },
         submitHandler: function (form) {
            $.ajax({
				  data: $('#productForm').serialize(),
				  url: "{{ route('save_cities') }}",
				  type: "POST",
				  dataType: 'json',
				  success: function (data) {
			 
					  $('#productForm').trigger("reset");
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
	 
    $('#savedatas').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#productForm').serialize(),
          url: "{{ route('save_cities') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#productForm').trigger("reset");
              $('#ajaxModelexa').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#savedata').html('Save Changes');
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
				url: "{{ url('destroy_cities') }}"+'/'+id,
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

 