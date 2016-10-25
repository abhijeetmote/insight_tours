<html>
<head>
	<title></title>
</head>
<body>
	<?php
		$km = $dutySlipData[0]->extra_kms * $booking[0]->charge_distance;
		$hr = $dutySlipData[0]->extra_hrs * $booking[0]->charge_hour;
		$extra_charges = $km + $hr;
	?>
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
				<td style="width:25%;padding:5px 0 5px 10px;"><span><b>DS No.:</b> <?php echo $dutySlipData[0]->duty_sleep_id; ?></span></td>
				<td style="text-align:center;"><span><b>Duty Slip</b></span></td>
				<td style="width:25%;"><span><b>Booking Ref No:</b> <?php echo $booking[0]->booking_id; ?></span></td>
			</tr>
		</table>

		<table style="width:100%;font-size:15px;padding-bottom:2px;" cellspacing="0">
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;padding:5px 0 0 10px;"><span><b>Bill To : </b><?php echo $booking[0]->cust_firstname; ?></span></td>
				<td style="width:50%;padding:5px 0 0 10px;"><span><b>Invoice No : </b><?php echo $invoice_no; ?></span></td>
			</tr>
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;padding:0 0 0 10px;"><span><b>Add : </b><?php echo $booking[0]->cust_address; ?></span></td>
				<td style="width:50%;padding:0 0 0 10px;"><span><b>Invoice Date : </b><?php echo $invoice_date; ?></span></td>
			</tr>
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;padding:0 0 0 10px;"><span><b>Report To : </b><?php echo $passenger[0]->passenger_name; ?></span></td>
				<td style="width:50%;padding:0 0 0 10px;"><span><b>Report Date : </b><?php echo $dutySlipData[0]->start_date; ?></span></td>
			</tr>
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;padding:0 0 0 10px;"><span><b>Pick Up Add : </b><?php echo $passenger[0]->pickup_address; ?></span></td>
				<td style="width:50%;padding:0 0 0 10px;"><span><b>Booked By : </b><?php echo $booking[0]->cust_firstname; ?></span></td>
			</tr>
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;padding:0 0 0 10px;"><span><b>Mobile No : </b><?php echo $passenger[0]->passenger_number; ?></span></td>
				<td style="width:50%;padding:0 0 0 10px;"><span><b>Destination : </b><?php echo $passenger[0]->drop_address; ?></span></td>
			</tr>
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;padding:0 0 5px 10px;"><span><b></b> </span></td>
				<td style="width:50%;padding:0 0 5px 10px;"><span><b>Vehicle Type : </b><?php echo $dutySlipData[0]->vehicle_name; ?></span></td>
			</tr>
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;padding:0 0 5px 10px;"><span><b></b> </span></td>
				<td style="width:50%;padding:0 0 5px 10px;"><span><b>Vehicle No : </b><?php echo $dutySlipData[0]->vehicle_no; ?></span></td>
			</tr>
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;padding:0 0 5px 10px;"><span><b></b> </span></td>
				<td style="width:50%;padding:0 0 5px 10px;"><span><b>Chauffeurs : </b><?php echo $dutySlipData[0]->driver_fname; ?></span></td>
			</tr>

		</table>

		<table style="width:100%;border-top:0.1px solid #000;border-bottom:0.1px solid #000;font-size:15px;" cellspacing="0">
			<tr>
				<td style="text-align:center;padding:10px 0;"><span><b>Description</b></span></td>
			</tr>
		</table>
		
		<table style="width:100%;font-size:15px;" cellspacing="0">
			<tr>
				<th style="width:18%;border-right:0.1px solid black;"><span><b>Particulars</b></span></th>
				<th style="width:18%;border-right:0.1px solid black;"><span><b>Starting</b></span></th>
				<th style="width:18%;border-right:0.1px solid black;"><span><b>Closing</b></span></th>
				<th style="width:18%;border-right:0.1px solid black;"><span><b>Total</b></span></th>
				<th style="width:18%;border-right:0.1px solid black;"><span><b>Extra</b></span></th>
			</tr>
			<tr>
				<td style="text-align:center;border-top:0.1px solid black;width:18%;border-right:0.1px solid black;"><span>Kms</span></td>
				<td style="border-top:0.1px solid black;width:18%;border-right:0.1px solid black;text-align:center;"><?php echo $dutySlipData[0]->start_km; ?></td>
				<td style="border-top:0.1px solid black;width:18%;border-right:0.1px solid black;text-align:center;"><?php echo $dutySlipData[0]->end_km; ?></td>
				<td style="border-top:0.1px solid black;width:18%;border-right:0.1px solid black;text-align:center;"><?php echo $dutySlipData[0]->total_kms; ?></td>
				<td style="border-top:0.1px solid black;width:18%;border-right:0.1px solid black;text-align:center;"><?php echo $dutySlipData[0]->extra_kms; ?></td>
			</tr>
			<tr>
				<td style="border-bottom:0.1px solid black;text-align:center;border-top:0.1px solid black;width:18%;border-right:0.1px solid black;"><span>Timing</span></td>
				<td style="text-align:center;border-top:0.1px solid black;border-bottom:0.1px solid black;width:18%;border-right:0.1px solid black;"></td>
				<td style="text-align:center;border-top:0.1px solid black;border-bottom:0.1px solid black;width:18%;border-right:0.1px solid black;"></td>
				<td style="text-align:center;border-top:0.1px solid black;border-bottom:0.1px solid black;width:18%;border-right:0.1px solid black;"><?php echo $dutySlipData[0]->total_hrs; ?></td>
				<td style="text-align:center;border-top:0.1px solid black;border-bottom:0.1px solid black;width:18%;border-right:0.1px solid black;"><?php echo $dutySlipData[0]->extra_hrs; ?></td>
			</tr>
		</table>
		
		
		<table style="width:100%;font-size:14px;" cellspacing="0">
			<tr>
				<td style="width:80%;text-align:right;padding:0px 0 2px 10px;"><span><b>Package Amt : </b></span></td>
				<td style="width:20%;padding:0px 10px 2px 0px;text-align:right;"><span><?php echo number_format($booking[0]->package_amt,2); ?></span></td>
			</tr>
			<tr>
				<td style="width:80%;text-align:right;padding:0px 0 2px 10px;"><span><b>Extra Charges : </b></span></td>
				<td style="width:20%;padding:0px 10px 2px 0px;text-align:right;"><span><?php echo number_format($extra_charges,2); ?></span></td>
			</tr>
			<tr>
				<td style="width:80%;text-align:right;padding:0px 0 2px 10px;"><span><b>Gross Amt : </b></span></td>
				<td style="width:20%;padding:0px 10px 2px 0px;text-align:right;"><span><?php echo number_format($gross_amt,2); ?></span></td>
			</tr>
			<tr>
				<td style="width:80%;text-align:right;padding:0px 0 2px 10px;"><span><b>Service Tax 14.5 % : </b></span></td>
				<td style="width:20%;padding:0px 10px 2px 0px;text-align:right;"><span><?php echo number_format($service_tax_amt,2); ?></span></td>
			</tr>
			<tr>
				<td style="width:80%;text-align:right;padding:0px 0 2px 10px;"><span><b>Education Cess 2 % : </b></span></td>
				<td style="width:20%;padding:0px 10px 2px 0px;text-align:right;"><span><?php echo number_format($education_cess_amt, 2); ?></span></td>
			</tr>
			<tr>
				<td style="width:80%;text-align:right;padding:0px 0 2px 10px;"><span><b>Sec. & Higher Edu. Cess 1 % : </b></span></td>
				<td style="width:20%;padding:0px 10px 2px 0px;text-align:right;"><span><?php echo number_format($sec_education_cess_amt, 2); ?></span></td>
			</tr>
			<tr>
				<td style="width:80%;text-align:right;padding:0px 0 2px 10px;"><span><b>Toll & Parking Charges : </b></span></td>
				<td style="width:20%;padding:0px 10px 2px 0px;text-align:right;"><span><?php echo number_format($dutySlipData[0]->toll_fess + $dutySlipData[0]->parking_fees, 2); ?></span></td>
			</tr>
			<tr>
				<td style="width:80%;text-align:right;padding:0px 0 2px 10px;"><span><b>Advance Amount : </b></span></td>
				<td style="width:20%;padding:0px 10px 2px 0px;text-align:right;"><span><?php echo "-".number_format($adv_amount, 2); ?></span></td>
			</tr>

		</table>

		<table style="width:100%;border-top:0.1px solid #000;border-bottom:0.1px solid #000;font-size:18px;" cellspacing="0">
			<tr>
				<td style="width:80%;text-align:right;padding:0px 0 0px 10px;"><span><b>Total Amount: </b></span></td>
				<td style="width:20%;padding:0px 10px 0px 0px;text-align:right;"><span><b><?php echo number_format($final_amount, 2); ?></b></span></td>
			</tr>
		</table>

		<table style="width:100%;border-top:0.1px solid #000;font-size:14px;" cellspacing="0">
			<tr>
				<td style="width:100%;padding:0px 0 10px 10px;font-size:16px;"><span><b><u>Amt. in words : </u></b></span></td>
			</tr>

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
				<td style="width:80%;padding:0 0 5px 10px;"><span><b>Created By :</b></span></td>
				<td style="width:20%;padding:0 0 5px 0;"><span><b>Signature</b></span></td>
			</tr>
		</table>
	</div>
</body>
</html>
