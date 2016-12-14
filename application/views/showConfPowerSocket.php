<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2>Configuration</h2>
				<h5>Manage gpio and power socket connections settings.</h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />
		<div class="row">
			<div class="col-md-12">
				<!--   Kitchen Sink -->
				<div class="panel panel-default">
					<div class="panel-heading"><i class="fa fa-bars "></i> 
						<b>GPIO to POWER SOCKET</b>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>GPIO BCM</th>
										<th>POWER SOCKET</th>
										<th>Status</th>
										<th>Devices connected to power socket</th>
										<th>Gpio description</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
                                      <?php echo $tr;?>                          
                                </tbody>
							</table>
							<form action="/configuration/showNewPowerSocket/">
								<button class="btn btn-success">
									<i class="fa fa-plus-square"></i> Add new
								</button>
							</form>
						</div>
					</div>
				</div>
				<!-- End  Kitchen Sink -->


				<!-- /. ROW  -->
				<hr />
			</div>
			<!-- /. PAGE INNER  -->
		</div>
		<!-- /. PAGE WRAPPER  -->