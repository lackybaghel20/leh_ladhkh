@extends('layouts.app-master')

@section('content')
 
	<div class="pagetitle">
      <h1>Manage Users</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Home</li>
          <li class="breadcrumb-item">Manage Users</li>          
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Manage Users</h5>

			   @auth
       
				<table class="table table-bordered data-table">
					<thead>
						<tr>
							<th>#</th>  
							<th>Name</th>
							<th>Phone Number</th>
							<th>Email</th>
							<th>Status</th>
							<th width="200px">Entered Date</th>
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
	

	<script type="text/javascript">
	
	  $(function () {
		 
		var table = $('.data-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('home.index') }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'name', name: 'name'},
				{data: 'phone_number', name: 'phone_number'},
				{data: 'email', name: 'email'},
				{data: 'is_verify', name: 'is_verify'},
				{data: 'created_at', name: 'created_at', orderable: false, searchable: false},
			]
		});
		  
		   $(document).on("change",'.toggle-class',function() {
				var status = $(this).prop('checked') == true ? 1 : 0; 
				var user_id = $(this).data('id'); 
			 
				 if(status == 1){
					 var label = 'verify';
					 var slable = 'verified';
				 }else{
					 var label = 'unverify';
					 var slable = 'unverified';
				 }
				 Swal.fire({
					  title: "Do you want to "+label+" user?",					  
					  showCancelButton: true,
					  cancelButtonText: "No",
					  confirmButtonText: "Yes",					  
					  icon: "warning"
					}).then((result) => {					  
					  if (result.isConfirmed) {
						  $.ajax({
							type: "GET",
							dataType: "json",
							url: '/changeStatus',
							data: {'status': status, 'user_id': user_id},
							success: function(data){
							  Swal.fire("User "+slable+" successfully", "", "success");
							}
						});						
					  } else{
						  if(status == 1){
								 $(this).prop('checked',false);
							 }else{
								 $(this).prop('checked',true);
							 }
						  
					  }
					});				
			})			
	  });
	  
	  
	</script>

@endsection

 