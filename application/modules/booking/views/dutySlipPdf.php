<html>
<head>
	<title></title>

<style>
.custom{
	padding-left:10px;
}
</style>	
</head>
<body>
	<div style="border:0.1px solid #000;font-weight:100">
		<h3 style="text-align:center;">Tours</h3>
		<table style="width:100%;">
			<tr>
				<td style="width:50%;padding:0 0 0 10px;"><span style="font-size:15px;"><b>Head Office:</b> Sec.01,PL-E324,Indrayani Nagar,Pritam Prakash Prestige,Flat No.B/1,Bhosari,Pune – 26.</span></td>

				<td style="width:50%;"><span style="font-size:15px;"><b>Head Office:</b> Sec.01,PL-E324,Indrayani Nagar,Pritam Prakash Prestige,Flat No.B/1,Bhosari,Pune – 26.</span></td>
			</tr>
			<tr>
				<td style="width:50%;padding:0 0 0 10px;"><span style="font-size:15px;"><b>Mob:</b> 9029124578</span></td>
			</tr>
			<tr>
				<td style="width:50%;padding:0 0 10px 10px;"><span style="font-size:15px;"><b>Email:</b> sample@gmail.com</span></td>
			</tr>
		</table>

		<table style="width:100%;border-top:0.1px solid #000;border-bottom:0.1px solid #000;font-size:15px;" cellspacing="0">
			<tr>
				<td style="width:25%;padding:5px 0 5px 10px;"><span><b>DS No.:</b> <span class="custom"><?php echo isset($dutyslipdetails[0]->duty_slip_id) ? "DS_".$dutyslipdetails[0]->duty_slip_id : "NA";?></span></span></td>
				<td style="text-align:center;"><span><b>Duty Slip</b></span></td>
				<td style="width:25%;"><span><b>Booking Ref No:</b> <span class="custom"><?php echo isset($dutyslipdetails[0]->booking_id) ? "BK_".$dutyslipdetails[0]->booking_id : "NA";?></span></span></td>
			</tr>
		</table>

		<table style="width:100%;font-size:15px;padding-bottom:2px;" cellspacing="0">
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;padding:0px 0 0 10px;"><span><b>Report To:</b> <span class="custom"><?php if($dutyslipdetails[0]->cust_type_id == 1) echo  $dutyslipdetails[0]->contact_per_name;else $dutyslipdetails[0]->cust_firstname; echo $dutyslipdetails[0]->cust_firstname . "  ".$dutyslipdetails[0]->cust_lastname;?></span></span></td>
				<td style="width:50%;padding:0px 0 0 10px;"><span><b>Report Date:</b><span class="custom"><?php echo isset($dutyslipdetails[0]->booking_date) ? $dutyslipdetails[0]->booking_date : "NA";?></span></span></td>
			</tr>
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;padding:0 0 0 10px;"><span><b>Pick Up Add:</b> <span class="custom"><?php echo isset($dutyslipdetails[0]->pickup_location) ? $dutyslipdetails[0]->pickup_location : "NA";?></span></span></td>
				<td style="width:50%;padding:0 0 0 10px;"><span><b>Booked By:</b><span class="custom"><?php echo isset($dutyslipdetails[0]->user_first_name) ? $dutyslipdetails[0]->user_first_name . "   " . $dutyslipdetails[0]->user_last_name : "NA";?></span></span></td>
			</tr>
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;padding:0 0 0 10px;"><span><b>Mobile No:</b>  <span class="custom"><?php echo isset($dutyslipdetails[0]->cust_mob1) ? $dutyslipdetails[0]->cust_mob1 : "NA";?></span></span></td>
				<td style="width:50%;padding:0 0 0 10px;"><span><b>Destination:</b><span class="custom"><?php echo isset($dutyslipdetails[0]->drop_location) ? $dutyslipdetails[0]->drop_location : "NA";?></span></span></td>
			</tr>
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;"><span><b></b> </span></td>
				<td style="width:50%;padding:0 0 0 10px;"><span><b>Vehicle Type:</b><span class="custom"><?php echo isset($dutyslipdetails[0]->vehicle_type) ? $dutyslipdetails[0]->vehicle_type : "NA";?></span></span></td>
			</tr>
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;"><span><b></b> </span></td>
				<td style="width:50%;padding:0 0 0 10px;"><span><b>Vehicle No:</b><span class="custom"><?php echo isset($dutyslipdetails[0]->vehicle_no) ? $dutyslipdetails[0]->vehicle_no : "NA";?></span></span></td>
			</tr>
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;padding:0 0 5px 10px;"><span><b>Note:</b> <span class="custom"><?php echo isset($dutyslipdetails[0]->comments) ? $dutyslipdetails[0]->comments : "NA";?></span></span></td>
				<td style="width:50%;padding:0 0 5px 10px;"><span><b>Chauffeurs:</b><span class="custom"><?php echo isset($dutyslipdetails[0]->drop_location) ? $dutyslipdetails[0]->driver_fname. "  " . $dutyslipdetails[0]->driver_lname : "NA";?></span></span></td>
			</tr>

		</table>

		<table style="width:100%;border-top:0.1px solid #000;border-bottom:0.1px solid #000;font-size:15px;" cellspacing="0">
			<tr>
				<td style="text-align:center;padding:10px 0;"><span><b>From Garage To Garage</b></span></td>
			</tr>
		</table>
		
		<table style="width:100%;font-size:15px;" cellspacing="0">
			<tr>
				<th style="width:18%;border-right:0.1px solid black;"><span><b>Particulars</b></span></th>
				<th style="width:18%;border-right:0.1px solid black;"><span><b>Starting</b></span></th>
				<th style="width:18%;border-right:0.1px solid black;"><span><b>Closing</b></span></th>
				<th style="width:18%;border-right:0.1px solid black;"><span><b>Total</b></span></th>
				<th style="width:18%;border-right:0.1px solid black;"><span><b>Extra</b></span></th>
				<th style="width:18%;"><span><b>Extra Charges</b></span></th>
			</tr>
			<tr>
				<td style="text-align:center;border-top:0.1px solid black;width:18%;border-right:0.1px solid black;"><span>Kms</span></td>
				<td style="border-top:0.1px solid black;width:18%;border-right:0.1px solid black;"><span class="custom"><?php echo isset($dutyslipdetails[0]->start_km) ? $dutyslipdetails[0]->start_km : "NA";?></span></td>
				<td style="border-top:0.1px solid black;width:18%;border-right:0.1px solid black;"><span class="custom"><?php echo isset($dutyslipdetails[0]->end_km) ? $dutyslipdetails[0]->end_km : "NA";?></span></td>
				<td style="border-top:0.1px solid black;width:18%;border-right:0.1px solid black;"><span class="custom"><?php echo isset($dutyslipdetails[0]->total_kms) ? $dutyslipdetails[0]->total_kms : "NA";?></span></td>
				<td style="border-top:0.1px solid black;width:18%;border-right:0.1px solid black;"><span class="custom"><?php echo isset($dutyslipdetails[0]->extra_kms) ? $dutyslipdetails[0]->extra_kms : "NA";?></span></td>
				<td style="border-top:0.1px solid black;width:18%;"></td>
			</tr>
			<tr>
				<td style="border-bottom:0.1px solid black;text-align:center;border-top:0.1px solid black;width:18%;border-right:0.1px solid black;"><span>Timing</span></td>
				<td style="border-top:0.1px solid black;border-bottom:0.1px solid black;width:18%;border-right:0.1px solid black;"><span class="custom"><?php echo isset($dutyslipdetails[0]->start_time) ? $dutyslipdetails[0]->start_time : "NA";?></span></td>
				<td style="border-top:0.1px solid black;border-bottom:0.1px solid black;width:18%;border-right:0.1px solid black;"><span class="custom"><?php echo isset($dutyslipdetails[0]->end_time) ? $dutyslipdetails[0]->end_time : "NA";?></span></td>
				<td style="border-top:0.1px solid black;border-bottom:0.1px solid black;width:18%;border-right:0.1px solid black;"><span class="custom"><?php echo isset($dutyslipdetails[0]->total_hrs) ? $dutyslipdetails[0]->total_hrs : "NA";?></span></td>
				<td style="border-top:0.1px solid black;border-bottom:0.1px solid black;width:18%;border-right:0.1px solid black;"><span class="custom"><?php echo isset($dutyslipdetails[0]->extra_hrs) ? $dutyslipdetails[0]->extra_hrs : "NA";?></span></td>
				<td style="border-top:0.1px solid black;border-bottom:0.1px solid black;width:18%;"></td>
			</tr>
		</table>
		
		<table>
			<tr>
				<td style="width:100%;padding:10px 0 10px 10px;"><span><b>Toll & Parking Charges :</b><span class="custom"><?php echo $dutyslipdetails[0]->toll_fess + $dutyslipdetails[0]->parking_fees;?></span></span></td>
			</tr>
		</table>

		<table style="width:100%;border-top:0.1px solid #000;border-bottom:0.1px solid #000;font-size:15px;" cellspacing="0">
			<tr>
				<td style="text-align:center;padding:10px 0;"><span><b>We Confirm use of the car & agree to pay the compensation charges </b></span></td>
			</tr>
		</table>

		<table style="width:100%;font-size:14px;" cellspacing="0">
			<tr>
				<td style="width:45%;padding:5px 0 5px 10px;"><span>Car Released At :</span></td>
				<td style="width:5%;border-right:0.1px solid black;"><span>Hrs.</span></td>
				<td style="width:20%;border-right:0.1px solid black;"><span>Kms.</span></td>
				<td style="width:30%;"><span>Place:</span></td>
			</tr>
		</table>

		<table style="width:100%;border-top:0.1px solid #000;border-bottom:0.1px solid #000;font-size:15px;" cellspacing="0">
			<tr>
				<td style="text-align:center;padding:10px 0;"><span><b>Client  Instructions for Next day </b></span></td>
			</tr>
		</table>

		<table style="width:100%;font-size:14px;" cellspacing="0">
			<tr>
				<td style="width:35%;padding:0 0 0 10px;"><span>Date :</span></td>
				<td style="width:20%;"><span>Time:</span></td>
				<td style="width:30%;"><span>Place.</span></td>
			</tr>
		</table>

		<table style="width:100%;font-size:14px;" cellspacing="0">
			<tr>
				<td style="width:100%;text-align:right;padding:20px 0 20px 10px;"><span><b>User's Signature</b></span></td>
			</tr>
		</table>

		<table style="width:100%;border-top:0.1px solid #000;border-bottom:0.1px solid #000;font-size:14px;" cellspacing="0">
			<tr>
				<td style="width:100%;padding:20px 0 0 10px;"><span><b>Terms & Conditions : </b></span></td>
			</tr>
			<tr>
				<td style="width:100%;padding:0 0 0 10px;"><span>1. Please mention if any cash paid to driver.</span></td>
			</tr>
			<tr>
				<td style="width:100%;padding:0 0 0 10px;"><span>2. Kms & Hrs will be counted from Garage to Garage.</span></td>
			</tr>
			<tr>
				<td style="width:100%;padding:0 0 0 10px;"><span>3. Request to check your belongings before releasing the car.</span></td>
			</tr>
			<tr>
				<td style="width:100%;padding:0 0 0 10px;"><span>4. Good left in the car at Client’s Risk.</span></td>
			</tr>
			<tr>
				<td style="width:100%;padding:0 0 10px 10px;"><span>5. I/We have checked the car before leaving.</span></td>
			</tr>

		</table>

		<table style="width:100%;font-size:14px;" cellspacing="0">
			<tr>
				<td style="width:100%;padding:0 0 10px 10px;"><span><b>For Office Use Only : </b></span></td>
			</tr>
			<tr>
				<td style="width:50%;padding:0 0 5px 10px;"><span><b>Created By :</b></span></td>
				<td style="width:100%;padding:0 0 5px 0;"><span><b>Date & Time :</b></span></td>
			</tr>
		</table>
	</div>
</body>
</html>