<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2>New GPIO</h2>
				<h5>Connect your gpio to power socket.</h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />
		<?php echo form_open('configuration/verifyEditGpio'); ?>
		<input type="hidden" name="id_gpio" id="id_gpio" value="<?php echo $id_gpio;?>">
		<input type="hidden" name="id_powersocket" id="id_powersocket" value="<?php echo $id_powersocket;?>">
		<div class="row">
			<div class="col-md-3">
				<!-- Form Elements -->
				<div class="panel panel-default">
					<div class="panel-heading"> <i class="fa fa-plus-circle  "></i> <b>Connect gpio to power socket</b></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<?php echo validation_errors(); ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Gpio</label> <select class="form-control" name="gpio" id="gpio">
										<?php echo $option_gpio;?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Power socket</label> <select class="form-control" name="powersocket" id="powersocket">
										<?php echo $option_powersocket;?>							
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Devices connected to power socket</label>
									<input class="form-control" id="name_dev" name="name_dev" value="<?php echo $name_dev;?>"/>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Gpio Description</label>
									<textarea class="form-control" rows="3" name="desc" id="desc"><?php echo $desc;?></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-success"><i class="fa fa-plus-square"></i> Save</button>
							</div>
						</div>
					</div>
				</div>
				<!-- End Form Elements -->
			</div>
			</form>
		</div>
		<!-- /. ROW  -->
		<hr />
	</div>
	<!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->