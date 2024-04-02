@extends('layouts.app-master')

@section('content') 
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
              <h5 class="card-title">Manage Cities</h5>

			   @auth
       
				
				 <table class="table datatable">
					<thead>
					  <tr>
						<th>
						  <b>N</b>ame
						</th>
						<th>Ext.</th>
						<th>City</th>
						<th data-type="date" data-format="YYYY/DD/MM">Start Date</th>
						<th>Completion</th>
					  </tr>
					</thead>
					<tbody>
					  <tr>
						<td>Unity Pugh</td>
						<td>9958</td>
						<td>Curicó</td>
						<td>2005/02/11</td>
						<td>37%</td>
					  </tr>
					  <tr>
						<td>Theodore Duran</td>
						<td>8971</td>
						<td>Dhanbad</td>
						<td>1999/04/07</td>
						<td>97%</td>
					  </tr>					
					</tbody>
				</table>
				@endauth

            </div>
          </div>

        </div>

       
      </div>
    </section>


@endsection

 