var baseUrl = $('#baseUrl').val();
var array = [
	{name: "vehiclecategory", value: baseUrl + "vehicle/categorySubmit"},
	{name: "vehicle", value: baseUrl + "vehicle/vehicleSubmit"},
	{name: "vehicleList", value: baseUrl + "vehicle/vehicleDelete"},
	{name: "vehicle_update", value: baseUrl + "vehicle/vehicleUpdate"},
	{name: "vehicleList", value: baseUrl + "vehicle/vehicleDelete"},
	{name: "vehicle-detail-view", value: baseUrl + "vehicle/vehicleDetails"},
	{name: "drivermaster", value: baseUrl + "driver/driverMasterSubmit"},
	{name: "driverList", value: baseUrl + "driver/driverDelete"},
	{name: "driver_update", value: baseUrl + "driver/driverUpdate"},
	{name: "vendormaster", value: baseUrl + "vendor/addvendor"},
	{name: "vendorList", value: baseUrl + "vendor/vendorDelete"},
	{name: "vendor_update", value: baseUrl + "vendor/vendorUpdate"},
	{name: "useradd", value: baseUrl + "user/adduser"},
	{name: "user_update", value: baseUrl + "user/Userupdate"},
	{name: "userList", value: baseUrl + "user/userDelete"},
	{name: "bookingmaster", value: baseUrl + "booking/addbooking"},
	{name: "booking_update", value: baseUrl + "booking/Bookingupdate"},
	{name: "bookingList", value: baseUrl + "booking/bookingDelete"},
	{name: "passenger-detail-view", value: baseUrl + "booking/passengerList"},
	{name: "customermaster", value: baseUrl + "customer/addcustomer"},
	{name: "customerUpdate", value: baseUrl + "customer/customerUpdate"},
	{name: "dutySlip", value: baseUrl + "booking/addDutySlip"},
	{name: "updateDutySlip", value: baseUrl + "booking/updateDuty"},
	{name: "passenger-detail-delete", value: baseUrl + "booking/passengerDelete"},
	{name: "login", value: baseUrl + "login/loginAction"},
	{name: "driverattn", value: baseUrl + "driver/driverAttnSubmit"},
	{name: "holiday", value: baseUrl + "company/addHoliday"},
	{name: "holidayList", value: baseUrl + "company/holidayDelete"},
	{name: "attendanceReport", value: baseUrl + "driver/attnReport"}
	
];

