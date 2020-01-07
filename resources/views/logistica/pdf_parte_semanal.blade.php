<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>


<div class="col-md-12" >
	<div class="header">
		<div class="col-md-12"style=" display: block;"  >
			<div class="col-md-3 "  style="float:left; position: relative;" >
				<img src="images/pdf_images/logosp.png">
			</div>
			<br>
			<div class="col-md-3 " style="float:center; text-align: center;">
				
				<p> <h4>DIRECCIÓN GENERAL ADMINISTRACIÓN</h4>
					<h4>DIRECCIÓN LOGÍSTICA</h4>
					<h4>DEPARTAMENTO AUTOMOTORES</h4>
				</p>
			</div>
		</div>
	</div>

	<div class="container divbody" style="text-align: center;" >
		<hr>
		<div class="col-md-12" >

			<div class="col-md-12 table-responsive " >
				<table   class=" table table-striped table-hover table-condensed table-bordered">
				    <thead>
				      <tr>
				        <th>Fecha</th>
				        <th>Responsable</th>
				        <th>vehiculo</th>
				        <th>Tarea Realizada</th>
				      </tr>
				    </thead>
				    <tbody>
				    	@foreach($parteSemanal as $item)
					    	<tr>
					    		<td>{{ date('d-m-Y H:i', strtotime($item->created_at)) }}</td>
					    		<td >{{ $item->nombre }} </td>
					    		<td >{{ $item->numero_de_identificacion }} | {{ $item->dominio }}</td>
					    		<td >{{ $item->observaciones_parte }}</td>
					    	</tr>
				    	@endforeach
				    </tbody>
				</table>
			</div>
		</div>
		<br>
		<hr>
		<div class="col-md-12" >
			<div class="col-md-3" style="float:left;">
				<br>
				<strong>ENCARGADO DE ÁREA</strong>
				<br>
				.................................................
				<br>
				<strong>Aclaración:</strong>
				<br>
				.................................................
				<br>
				<strong>Jerarquia:</strong>
				<br>
				.................................................
			</div>
			<div class="col-md-3" style="float:right;">
				<br>
				<strong>RECIBE CONFORME</strong>
				<br>
				.................................................
				<br>
				<strong>Aclaración:</strong>
				<br>
				.................................................
				<br>
				<strong>Jerarquia:</strong>
				<br>
				.................................................
			</div>
		</div>

	</div>

</div>


<style type="text/css">

	table{
		width: 100% !important; 
	}
	th {
		font-size: 12px;     
		font-weight: normal;     
		padding: 4px; 
		background: #B4B3A9;
	    color: #000000; 
	}

	td {    
		padding: 3px;     
		background: #E3E3E3; 
		width: 100%;
		border-bottom: 0.2px solid #fff;
	    color: #000000;   
	    border-top: 1px solid transparent; 
	}
	td.automatico{
		width:auto ;
	}
	p.pdf_historial {
    border: 1px;
    display: inline-block;
    width: auto;
    margin: 0 20px;
    text-align: justify;

  
}
	div.divbody{
		display: block; 
		margin-top: 120px;
	}
	h1.encabezado_pdf_historial{
		/*padding-top:0px;*/
		font-family: Vegur, 'PT Sans', Verdana, sans-serif;
	}

</style>

</body>
</html>