<html>
<head>
	<title></title>
	<style type="text/css">
		.package th{
			padding:5px;
		}
		.details th{
			padding:5px;
		}
		.package td{
			padding:5px;
		}
		.details td{
			padding:5px;
		}
	</style>
</head>
<body>
	<div>
		<h2 style="text-align:center;">Invoice</h2>
		<div>
			<h5 style="text-align:right;margin:0;">Invoice: #<?php echo $invoice_no; ?></h5>
			<?php 
				$date = new DateTime($booking[0]->booking_date);
				
			?>
			<h5 style="text-align:right;margin:0;">Date: <?php echo $date->format('Y-m-d'); ?></h5>
		</div>
		<div style="width:100%;">
			<div>
				<table style="width:100%;">
					<thead>
						<tr>
							<th style="border:1px solid gray;width:50%;">Company Details</th>
							<th style="border:1px solid gray;width:50%;">Customer Details</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="padding-left: 4%;">Street ,City</td>
							<td style="padding-left: 4%;"><b>Name:</b> <?php echo $booking[0]->cust_firstname." ".$booking[0]->cust_middlename." ".$booking[0]->cust_lastname; ?></td>
						</tr>
						<tr>
							<td style="padding-left: 4%;">Zip Code</td>
							<td style="padding-left: 4%;"><b>Add:</b> <?php echo $booking[0]->cust_address; ?></td>
						</tr>
						<tr>
							<td style="padding-left: 4%;">State, Country</td>
							<td style="padding-left: 4%;"><b>City:</b> <?php echo $booking[0]->cust_city ?></td>
						</tr>
						<tr>
							<td style="padding-left: 4%;">Phone: 1111</td>
							<td style="padding-left: 4%;"><b>PinCode:</b> <?php echo $booking[0]->cust_pin; ?></td>
						</tr>
						<tr>
							<td style="padding-left: 4%;"></td>
							<td style="padding-left: 4%;"><b>Phone:</b> <?php echo $booking[0]->cust_mob1; ?></td>
						</tr>
						<tr>
							<td style="padding-left: 4%;"></td>
							<td style="padding-left: 4%;"><b>PickUp Add:</b> <?php echo $booking[0]->pickup_location; ?></td>
						</tr>
						<tr>
							<td style="padding-left: 4%;"></td>
							<td style="padding-left: 4%;"><b>Drop Add:</b> <?php echo $booking[0]->drop_location; ?></td>
						</tr>


					</tbody>
				</table>
			</div>
		</div>

		<div style="width:100%; margin-top:20px;float:left">
			<table class="package" style="width:100%;" border="1" cellspacing="0" cellpadding="0">
				<thead>
					<tr style="background-color: #f9f9f9;">
						<th class="center">#</th>
						<th>Package Name</th>
						<th class="hidden-xs">Package Amt</th>
						<th class="hidden-480">Hours</th>
						<th class="hidden-480">Charge/Hr</th>
						<th>Km</th>
						<th>Charge/Km</th>
						<th>Travel Type</th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td class="center">1</td>
						<td>
							<?php echo $booking[0]->package_name ?>
						</td>
						<td class="hidden-xs">
							<?php echo $booking[0]->package_amt ?>
						</td>
						<td class="hidden-480"><?php echo $booking[0]->hours ?></td>
						<td><?php echo $booking[0]->charge_hour ?></td>
						<td><?php echo $booking[0]->distance; ?></td>
						<td><?php echo $booking[0]->charge_distance; ?></td>
						<td><?php echo $booking[0]->travel_type; ?></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div style="width:100%; margin-top:20px;float:left">
			<table class="details" style="width:100%;text-align:right;" border="1" cellspacing="0" cellpadding="0">
				<thead>
					<tr style="background-color: #f9f9f9;">
						<th>Details</th>
						<th>Km/Hr</th>
						<th>Extra Km/Hr(If Any)</th>
						<th>Amount</th>

					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="hidden-480">Package Amt</td>
						<td class="hidden-xs">
							 
						</td>
						<td class="hidden-xs">
							
						</td>
						<td class="hidden-xs">
							<?php echo $booking[0]->package_amt ?>
						</td>
					</tr>
					<tr>
						<td class="hidden-480"> Kms</td>
						<td class="hidden-xs">
							 <?php echo $booking[0]->distance ?>
						</td>
						<td class="hidden-xs">
							<?php echo $dutySlipData[0]->extra_kms ?>
						</td>
						 
						<td class="hidden-xs">
							<?php echo $dutySlipData[0]->extra_kms * $booking[0]->charge_distance ?>
						</td>
						 
					</tr>
					<tr>
						<td class="hidden-480"> Hours</td>
						<td class="hidden-xs">
							<?php echo $booking[0]->hours  ?>
						</td>
						<td class="hidden-xs">
							<?php echo $dutySlipData[0]->extra_hrs ?>
							
						</td>
						<td class="hidden-xs">
							<?php echo $dutySlipData[0]->extra_hrs * $booking[0]->charge_hour;?>
						</td>
						 
					</tr>
					<tr>
						<td class="hidden-480">Toll Fees</td>
						<td class="hidden-xs">
							 
						</td>
						<td class="hidden-xs">
							 
							
						</td>
						<td class="hidden-xs">
							<?php echo $dutySlipData[0]->toll_fess; ?>
						</td>
					</tr>
					<tr>
						<td class="hidden-480">Parking Fees</td>
						<td class="hidden-xs">
							 
						</td>
						<td class="hidden-xs">
							 
							
						</td>
						<td class="hidden-xs">
							<?php echo $dutySlipData[0]->parking_fees ?>
						</td>
					</tr>
					<tr>
						<td class="hidden-480"><b>Total Amount</b></td>
						<td class="hidden-xs">
							 
						</td>
						<td class="hidden-xs">
							 
							
						</td>
						<td class="hidden-xs">
							<b><?php echo $dutySlipData[0]->total_amt."/-" ?></b>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>