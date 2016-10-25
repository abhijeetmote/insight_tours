<html>
<head>
	<title></title>
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
				<td style="text-align:center;"><span><b>Invoice</b></span></td>
			</tr>
		</table>

		<table style="width:100%;font-size:15px;padding-bottom:2px;" cellspacing="0">
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;padding:5px 0 0 10px;"><span><b>Bill To : </b><?php echo $cust_compname ?></span></td>
				<td style="width:50%;padding:5px 0 0 10px;"><span><b>Invoice No : </b><?php echo strtoupper($invoice_no) ?></span></td>
			</tr>
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;padding:0 0 0 10px;"><span><b>Add : </b><?php echo $cust_address ?></span></td>
				<td style="width:50%;padding:0 0 0 10px;"><span><b>Invoice Date : </b><?php echo $invoice_date ?></span></td>
			</tr>
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;padding:0 0 0 10px;"><span><b>Contact No : </b><?php echo $cust_telno ?></span></td>
				<td style="width:50%;padding:0 0 0 10px;"><span><b>Term : </b>Monthly Billing</span></td>
			</tr>
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;"><span><b></b> </span></td>
				<td style="width:50%;padding:0 0 0 10px;"><span><b>Period :</b></span></td>
			</tr>
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;"><span><b></b> </span></td>
				<td style="width:50%;padding:0 0 0 10px;"><span><b>Payment Due Date : </b></span></td>
			</tr>
			<tr>
				<td style="width:50%;border-right:0.1px solid #000;padding:0 0 5px 10px;"><span><b></b> </span></td>
				<td style="width:50%;padding:0 0 5px 10px;"><span><b>Contact Person : </b><?php echo $contact_per_name ?></span></td>
			</tr>
		</table>

		<table style="width:100%;border-top:0.1px solid #000;border-bottom:0.1px solid #000;font-size:15px;" cellspacing="0">
			<tr>
				<td style="text-align:center;padding:10px 0;"><span><b>Invoice Summery</b></span></td>
			</tr>
		</table>
		
		<table style="width:100%;font-size:15px;" cellspacing="0">
			<tr>
				<th style="border-top:0.1px solid black;width:10%;border-right:0.1px solid black;"><span><b>Sr No.</b></span></th>
				<th style="border-top:0.1px solid black;width:18%;border-right:0.1px solid black;"><span><b>Package Name</b></span></th>
				<th style="border-top:0.1px solid black;width:18%;border-right:0.1px solid black;"><span><b>Travel Type</b></span></th>
				<th style="border-top:0.1px solid black;width:18%;border-right:0.1px solid black;"><span><b>Total Tour</b></span></th>
				<th style="border-top:0.1px solid black;width:18%;border-right:0.1px solid black;"><span><b>Total Amt</b></span></th>
			</tr>

			<tr>
				<td style="border-bottom:0.1px solid black;text-align:center;border-top:0.1px solid black;width:10%;border-right:0.1px solid black;">1</td>
				<td style="border-top:0.1px solid black;border-bottom:0.1px solid black;width:18%;border-right:0.1px solid black;"></td>
				<td style="border-top:0.1px solid black;border-bottom:0.1px solid black;width:18%;border-right:0.1px solid black;"></td>
				<td style="border-top:0.1px solid black;border-bottom:0.1px solid black;width:18%;border-right:0.1px solid black;"></td>
				<td style="border-top:0.1px solid black;border-bottom:0.1px solid black;width:18%;border-right:0.1px solid black;"></td>
			</tr>
		</table>
		
		<table style="width:100%;font-size:14px;" cellspacing="0">
			<tr>
				<td style="width:80%;text-align:right;padding:0px 0 2px 10px;"><span><b>Gross Amt : </b></span></td>
				<td style="width:20%;padding:0px 10px 2px 0px;text-align:right;"><span><?php echo number_format($gross_amt - $toll_parking, 2); ?></span></td>
			</tr>
			<tr>
				<td style="width:80%;text-align:right;padding:0px 0 2px 10px;"><span><b>Service Tax 14.5 % : </b></span></td>
				<td style="width:20%;padding:0px 10px 2px 0px;text-align:right;"><span><?php echo number_format($service_tax_amt, 2) ?></span></td>
			</tr>
			<tr>
				<td style="width:80%;text-align:right;padding:0px 0 2px 10px;"><span><b>Education Cess 2 % : </b></span></td>
				<td style="width:20%;padding:0px 10px 2px 0px;text-align:right;"><span><?php echo number_format($education_cess_amt, 2) ?></span></td>
			</tr>
			<tr>
				<td style="width:80%;text-align:right;padding:0px 0 2px 10px;"><span><b>Sec. & Higher Edu. Cess 1 % : </b></span></td>
				<td style="width:20%;padding:0px 10px 2px 0px;text-align:right;"><span><?php echo number_format($sec_education_cess_amt, 2) ?></span></td>
			</tr>
			<tr>
				<td style="width:80%;text-align:right;padding:0px 0 2px 10px;"><span><b>Total Toll & Parking Charges : </b></span></td>
				<td style="width:20%;padding:0px 10px 2px 0px;text-align:right;"><span><?php echo number_format($toll_parking, 2); ?></span></td>
			</tr>
			<tr>
				<td style="width:80%;text-align:right;padding:0px 0 2px 10px;"><span><b>Advance Amount : </b></span></td>
				<td style="width:20%;padding:0px 10px 2px 0px;text-align:right;"><span><?php echo "-".number_format($adv_amount, 2); ?></span></td>
			</tr>

		</table>

		<table style="width:100%;border-top:0.1px solid #000;border-bottom:0.1px solid #000;font-size:18px;" cellspacing="0">
			<tr>
				<td style="width:80%;text-align:right;padding:0px 0 0px 10px;"><span><b>Total Amount: </b></span></td>
				<td style="width:20%;padding:0px 10px 0px 0px;text-align:right;"><span><b><?php echo number_format($final_amount,2) ?></b></span></td>
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