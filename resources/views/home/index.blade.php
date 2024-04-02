@extends('layouts.app-master')

@section('content')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> 
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
							<th>No</th>  
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

				@guest
				<h1>Homepage</h1>
				<p class="lead">Your viewing the home page. Please login to view the restricted data.</p>
				@endguest
		
		
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
				{data: 'id', name: 'id'},
				{data: 'name', name: 'name'},
				{data: 'phone_number', name: 'phone_number'},
				{data: 'email', name: 'email'},
				{data: 'is_verify', name: 'is_verify'},
				{data: 'created_at', name: 'created_at', orderable: false, searchable: false},
			]
		});
		  
	  });
	</script>

@endsection

 