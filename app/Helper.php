<?php
use App\Models\ChannelPartner;
use App\Models\CityList;
use App\Models\CountryList;
use App\Models\DebugLog;
use App\Models\ProductLog;
use App\Models\SalePerson;
use App\Models\StateList;
function successRes($msg = "Success", $statusCode = 200) {
	$return = array();
	$return['status'] = 1;
	$return['status_code'] = $statusCode;
	$return['msg'] = $msg;
	return $return;
}

function errorRes($msg = "Error", $statusCode = 400) {

	$return = array();
	$return['status'] = 0;
	$return['status_code'] = $statusCode;
	$return['msg'] = $msg;
	return $return;

}

function loadTextLimit($string, $limit) {
	$string = htmlspecialchars_decode($string);
	if (strlen($string) > $limit) {
		return substr($string, 0, $limit - 3) . "...";
	} else {
		return $string;
	}
}

function websiteTimeZone() {
	return "Asia/Kolkata";
}

function convertDateTime($GMTDateTime) {

	$TIMEZONE = websiteTimeZone();
	try {
		$dt = new DateTime('@' . strtotime($GMTDateTime));
		$dt->setTimeZone(new DateTimeZone($TIMEZONE));

		return $dt->format('Y/m/d h:i:s A');

	} catch (Exception $e) {

		return $GMTDateTime;

	}

}

function convertOrderDateTime($GMTDateTime) {

	$TIMEZONE = websiteTimeZone();
	try {
		$dt = new DateTime('@' . strtotime($GMTDateTime));
		$dt->setTimeZone(new DateTimeZone($TIMEZONE));

		return $dt->format('d M y');

	} catch (Exception $e) {

		return $GMTDateTime;

	}

}

function saveDebugLog($params) {

	$DebugLog = new DebugLog();
	$DebugLog->user_id = Auth::user()->id;
	$DebugLog->name = $params['name'];
	$DebugLog->description = $params['description'];
	$DebugLog->save();

}

function saveProductLog($params) {

	$DebugLog = new ProductLog();
	$DebugLog->product_inventory_id = $params['product_inventory_id'];
	$DebugLog->request_quantity = $params['request_quantity'];
	$DebugLog->quantity = $params['quantity'];
	$DebugLog->user_id = Auth::user()->id;
	$DebugLog->name = $params['name'];
	$DebugLog->description = $params['description'];
	$DebugLog->save();

}

function getCityName($cityId) {

	$CityListName = "";

	$CityList = CityList::select('name')->find($cityId);
	if ($CityList) {
		$CityListName = $CityList->name;
	}

	return $CityListName;

}

function getStateName($stateId) {

	$StateListName = "";

	$StateList = StateList::select('name')->find($stateId);
	if ($StateList) {
		$StateListName = $StateList->name;
	}

	return $StateListName;

}

function getCountryName($stateId) {

	$CountryListName = "";

	$CountryList = CountryList::select('name')->find($stateId);
	if ($CountryList) {
		$CountryListName = $CountryList->name;
	}

	return $CountryListName;

}

function priceLable($price) {
	return number_format($price, 2);
}

function getOrderLable($OrderStatus) {
	// code...
	$OrderStatus = (int) $OrderStatus;

	if ($OrderStatus == 0) {
		$OrderStatus = '<span class="badge badge-pill badge badge-soft-primary font-size-11"> PLACED</span>';

	} else if ($OrderStatus == 1) {

		$OrderStatus = '<span class="badge badge-pill badge badge-soft-info font-size-11"> PROCESSING</span>';

	} else if ($OrderStatus == 2) {

		$OrderStatus = '<span class="badge badge-pill badge badge-soft-success font-size-11"> PARTIALLY DISPATCHED</span>';

	} else if ($OrderStatus == 3) {

		$OrderStatus = '<span class="badge badge-pill badge badge-soft-dark font-size-11"> FULLY DISPATCHED</span>';

	}
	return $OrderStatus;
}

function getInvoiceLable($invoiceStatus) {

	if ($invoiceStatus == 0) {
		$invoiceStatus = '<span class="badge badge-pill badge bg-primary font-size-11">INVOICE RAISED</span>';

	} else if ($invoiceStatus == 1) {

		$invoiceStatus = '<span class="badge badge-pill badge-soft-info font-size-11"> PACKED</span>';

	} else if ($invoiceStatus == 2) {

		$invoiceStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> DISPATCHED</span>';

	} else if ($invoiceStatus == 3) {

		$invoiceStatus = '<span class="badge badge-pill badge-soft-dark font-size-11"> RECIEVED</span>';

	}
	return $invoiceStatus;
	// code...
}

function getPaymentModeName($paymentMode) {

	if ($paymentMode == 0) {
		$paymentMode = "PDC";
	} else if ($paymentMode == 1) {
		$paymentMode = "ADVANCE";
	} else if ($paymentMode == 2) {
		$paymentMode = "CREDIT";
	}
	return $paymentMode;

}

function getProductGroupLable($ProductGroupStatus) {
	// code...
	$ProductGroupStatus = (int) $ProductGroupStatus;

	if ($ProductGroupStatus == 0) {
		$ProductGroupStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';

	} else if ($ProductGroupStatus == 1) {
		$ProductGroupStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';

	}
	return $ProductGroupStatus;
}

function getDataMasterStatusLable($dataMasterStatus) {
	// code...
	$dataMasterStatus = (int) $dataMasterStatus;

	if ($dataMasterStatus == 0) {
		$dataMasterStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';

	} else if ($dataMasterStatus == 1) {
		$dataMasterStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';

	} else if ($dataMasterStatus == 2) {
		$dataMasterStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Blocked</span>';

	}
	return $dataMasterStatus;
}

function getMainMasterStatusLable($mainMasterStatus) {
	$mainMasterStatus = (int) $mainMasterStatus;

	if ($mainMasterStatus == 0) {
		$mainMasterStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';

	} else if ($mainMasterStatus == 1) {
		$mainMasterStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';

	} else if ($mainMasterStatus == 2) {
		$mainMasterStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Blocked</span>';

	}
	return $mainMasterStatus;
}

function getSalesHierarchyStatusLable($salesHierarchyStatus) {

	$salesHierarchyStatus = (int) $salesHierarchyStatus;

	if ($salesHierarchyStatus == 0) {
		$salesHierarchyStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';

	} else if ($salesHierarchyStatus == 1) {
		$salesHierarchyStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';

	} else if ($salesHierarchyStatus == 2) {
		$salesHierarchyStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Blocked</span>';

	}
	return $salesHierarchyStatus;

}

function getCityStatusLable($cityStatus) {

	$cityStatus = (int) $cityStatus;

	if ($cityStatus == 0) {
		$cityStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';

	} else if ($cityStatus == 1) {
		$cityStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';

	} else if ($cityStatus == 2) {
		$cityStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Blocked</span>';

	}
	return $cityStatus;

}

function getUserStatusLable($userStatus) {

	$userStatus = (int) $userStatus;
	if ($userStatus == 0) {
		$userStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';

	} else if ($userStatus == 1) {
		$userStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';

	} else if ($userStatus == 2) {
		$userStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Blocked</span>';

	}
	return $userStatus;

}

function getCompanyStatusLable($companyStatus) {

	$companyStatus = (int) $companyStatus;
	if ($companyStatus == 0) {
		$companyStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';

	} else if ($companyStatus == 1) {
		$companyStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';

	} else if ($companyStatus == 2) {
		$companyStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Blocked</span>';

	}
	return $companyStatus;

}

/////

function getUserTypes() {
	$userTypes = array();
	$userTypes[0]['id'] = 0;
	$userTypes[0]['name'] = "Admin";
	$userTypes[0]['key'] = "t-user-admin";
//	$userTypes[0]['url'] = route('users.admin');

	$userTypes[1]['id'] = 1;
	$userTypes[1]['name'] = "Company Admin";
	$userTypes[1]['key'] = "t-user-company-admin";
//	$userTypes[1]['url'] = route('users.company.admin');

	$userTypes[2]['id'] = 2;
	$userTypes[2]['name'] = "Sales Depertment";
	$userTypes[2]['key'] = "t-user-sale-person";
//	$userTypes[2]['url'] = route('users.sale.person');

	$userTypes[3]['id'] = 3;
	$userTypes[3]['name'] = "Account User";
	$userTypes[3]['key'] = "t-user-account-user";
//	$userTypes[3]['url'] = route('users.account');

	$userTypes[4]['id'] = 4;
	$userTypes[4]['name'] = "Dispatcher User";
	$userTypes[4]['key'] = "t-user-dispatcher-user";
//	$userTypes[4]['url'] = route('users.dispatcher');

	$userTypes[5]['id'] = 5;
	$userTypes[5]['name'] = "Production User";
	$userTypes[5]['key'] = "t-user-production-user";
//	$userTypes[5]['url'] = route('users.production');

	return $userTypes;

}

function getInquiryStatus() {
	//Inquiry status type
	$inquiryStatus = array();

	$inquiryStatus[0]['id'] = 0;
	$inquiryStatus[0]['name'] = "Inquiry";
	$inquiryStatus[0]['key'] = "t-inquiry";

	$inquiryStatus[1]['id'] = 1;
	$inquiryStatus[1]['name'] = "Potential Inquiry";
	$inquiryStatus[1]['key'] = "t-potential-inquiry";

	$inquiryStatus[2]['id'] = 2;
	$inquiryStatus[2]['name'] = "Demo Done";
	$inquiryStatus[2]['key'] = "t-demo-done";

	$inquiryStatus[3]['id'] = 3;
	$inquiryStatus[3]['name'] = "Site Visit";
	$inquiryStatus[3]['key'] = "t-site-visit";

	$inquiryStatus[4]['id'] = 4;
	$inquiryStatus[4]['name'] = "Quotation";
	$inquiryStatus[4]['key'] = "t-quotation";

	$inquiryStatus[5]['id'] = 5;
	$inquiryStatus[5]['name'] = "Negotiation";
	$inquiryStatus[5]['key'] = "t-negotiation";

	$inquiryStatus[6]['id'] = 6;
	$inquiryStatus[6]['name'] = "Order Confrimed";
	$inquiryStatus[6]['key'] = "t-order-confrimed";

	$inquiryStatus[7]['id'] = 7;
	$inquiryStatus[7]['name'] = "Closing";
	$inquiryStatus[7]['key'] = "t-closing";

	$inquiryStatus[8]['id'] = 8;
	$inquiryStatus[8]['name'] = "Material Sent";
	$inquiryStatus[8]['key'] = "t-material-sent";

	$inquiryStatus[9]['id'] = 9;
	$inquiryStatus[9]['name'] = "Rejected";
	$inquiryStatus[9]['key'] = "t-rejected";

	$inquiryStatus[10]['id'] = 10;
	$inquiryStatus[10]['name'] = "Non Potential";
	$inquiryStatus[10]['key'] = "t-non-potential";

	$inquiryStatus[11]['id'] = 11;
	$inquiryStatus[11]['name'] = "Reports";
	$inquiryStatus[11]['key'] = "t-reports";

	return $inquiryStatus;
}

function getChannelPartners() {
	$userTypes = array();
	$userTypes[101]['id'] = 101;
	$userTypes[101]['name'] = "ASM(Autorise Stockist Merchantize)";
	$userTypes[101]['short_name'] = "ASM";
	$userTypes[101]['key'] = "t-channel-partner-stockist";
//	$userTypes[101]['url'] = route('channel.partners.stockist');
//	$userTypes[101]['url_view'] = route('channel.partners.stockist.view');

	$userTypes[102]['id'] = 102;
	$userTypes[102]['name'] = "ADM(Authorize Distributor Merchantize)";
	$userTypes[102]['short_name'] = "ADM";
	$userTypes[102]['key'] = "t-channel-partner-adm";
//	$userTypes[102]['url'] = route('channel.partners.adm');
//	$userTypes[102]['url_view'] = route('channel.partners.adm.view');

	$userTypes[103]['id'] = 103;
	$userTypes[103]['name'] = "APM(Authorize Project Merchantize)";
	$userTypes[103]['short_name'] = "APM";
	$userTypes[103]['key'] = "t-channel-partner-apm";
//	$userTypes[103]['url'] = route('channel.partners.apm');
//	$userTypes[103]['url_view'] = route('channel.partners.apm.view');

	$userTypes[104]['id'] = 104;
	$userTypes[104]['name'] = "AD(Authorised Dealer)";
	$userTypes[104]['short_name'] = "AD";
	$userTypes[104]['key'] = "t-channel-partner-ad";
//	$userTypes[104]['url'] = route('channel.partners.ad');
//	$userTypes[104]['url_view'] = route('channel.partners.ad.view');

	return $userTypes;

}

function getUserTypeName($userType) {

	$userType = (int) $userType;
	$userTypeLable = "";
	if (isset(getUserTypes()[$userType]['name'])) {
		$userTypeLable = getUserTypes()[$userType]['name'];
	} else if (isset(getChannelPartners()[$userType]['short_name'])) {
		$userTypeLable = getChannelPartners()[$userType]['short_name'];
	}
	return $userTypeLable;

}
function getChannelPartnersForAccount() {

	$ChannelPartner = ChannelPartner::where('user_id', Auth::user()->parent_id)->first();
	$viewAccountOFChannelPartner = array();
	$viewAccountOFChannelPartner[] = getChannelPartners()[$ChannelPartner->type];
	return $viewAccountOFChannelPartner;

}

function isChannelPartner($userType) {

	$isChannelPartner = 0;
	if (isset(getChannelPartners()[$userType]['short_name'])) {
		$isChannelPartner = getChannelPartners()[$userType]['id'];
	}
	return $isChannelPartner;

}

function userHasAcccess($userType) {

	$accessTypes = getUsersAccess(Auth::user()->type);

	$accessTypesList = array();
	foreach ($accessTypes as $key => $value) {
		$accessTypesList[] = $value['id'];
	}

	if (in_array($userType, $accessTypesList)) {

		return true;

	} else {

		return false;

	}
}

function getUsersAccess($userType) {

	$accessArray = array();

	$AllUserTypes = getUserTypes();

	if ($userType == 0) {

		$accessIds = array(0, 1, 2, 3, 4, 5);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}

	} else if ($userType == 1) {

		$accessIds = array(1, 2, 3, 4, 5);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}

	} else if ($userType == 2) {

		$accessIds = array();

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}

	} else if ($userType == 3) {

		$accessIds = array();

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}

	} else if ($userType == 4) {

		$accessIds = array();

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}

	} else if ($userType == 5) {

		$accessIds = array();

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}

	} else if ($userType == 101) {

		$accessIds = array(3, 4);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}

	} else if ($userType == 102) {

		$accessIds = array(3, 4);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}

	} else if ($userType == 103) {

		$accessIds = array(3, 4);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}

	} else if ($userType == 104) {

		$accessIds = array();

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}

	}
	return $accessArray;

}

function createThumbs($sourceFilePath, $destinationFilePath, $maxWidth) {

	/////////// CREATE THUMB

	$quality = 100;
	$imgsize = getimagesize($sourceFilePath);
	$width = $imgsize[0];
	$height = $imgsize[1];
	$mime = $imgsize['mime'];

	switch ($mime) {
	case 'image/gif':
		$imageCreate = "imagecreatefromgif";
		$image = "imagegif";
		break;

	case 'image/png':
		$imageCreate = "imagecreatefrompng";
		$image = "imagepng";
		$quality = 7;
		break;

	case 'image/jpeg':
		$imageCreate = "imagecreatefromjpeg";
		$image = "imagejpeg";
		$quality = 80;
		break;
	default:
		return false;
		break;
	}

	$scalRatio = ($maxWidth / $width);
	$maxHeight = round($scalRatio * $height);
	$dstImg = imagecreatetruecolor($maxWidth, $maxHeight);
	///////////////
	imagealphablending($dstImg, false);
	imagesavealpha($dstImg, true);
	///IF IMAGE IS TRANSPERANT THEN THUMBNAI RESIZABLE IMAGE WILL TRANSPERANT ,,IF NOT USE THIS FUNCTION GET IMAGE BACKGROUD WHITE
	$transparent = imagecolorallocatealpha($dstImg, 255, 255, 255, 127);
	imagefilledrectangle($dstImg, 0, 0, $maxWidth, $maxHeight, $transparent);
	/////////////
	$srcImg = $imageCreate($sourceFilePath);
	imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $maxWidth, $maxHeight, $width, $height);

	$image($dstImg, $destinationFilePath, $quality);
	if ($dstImg) {
		imagedestroy($dstImg);
	}

	if ($srcImg) {
		imagedestroy($srcImg);
	}

}

function getChildSalePersonsIds($userId) {

	$SalePersons = SalePerson::select('user_id')->where('reporting_manager', $userId)->get();

	$SalePersonsIds = array();
	$SalePersonsIds[] = $userId;

	foreach ($SalePersons as $key => $value) {
		$SalePersonsIds[] = $value['user_id'];
		$getChildSalePersonsIds = getChildSalePersonsIds($value['user_id']);
		$SalePersonsIds = array_merge($SalePersonsIds, $getChildSalePersonsIds);

	}
	$SalePersonsIds = array_unique($SalePersonsIds);
	$SalePersonsIds = array_values($SalePersonsIds);
	return $SalePersonsIds;

}

function GSTPercentage() {
	return 18;
}

function calculationProcessOfOrder($orderItems, $GSTPercentage, $shippingCost) {

	$order = array();
	$order['total_qty'] = 0;
	$order['total_weight'] = 0;
	$order['total_mrp'] = 0;
	$order['total_discount'] = 0;
	$order['total_mrp_minus_disocunt'] = 0;
	$order['gst_percentage'] = floatval($GSTPercentage);
	$order['gst_tax'] = 0;
	$order['shipping_cost'] = floatval($shippingCost);
	$order['delievery_charge'] = 0;
	$order['total_payable'] = 0;

	foreach ($orderItems as $key => $value) {

		$orderItems[$key]['id'] = $value['id'];
		if (isset($value['info'])) {
			$orderItems[$key]['info'] = $value['info'];
		}

		//
		$productPrice = floatval($value['mrp']);
		$orderItems[$key]['mrp'] = $productPrice;
		//

		//
		$orderItemQTY = intval($value['qty']);
		$orderItems[$key]['qty'] = $orderItemQTY;
		$order['total_qty'] = $order['total_qty'] + $orderItemQTY;
		//

		//
		$OrderItemsMRP = ($orderItemQTY * $productPrice);
		$orderItems[$key]['total_mrp'] = $OrderItemsMRP;
		$order['total_mrp'] = $order['total_mrp'] + $OrderItemsMRP;
		//

		//
		$discountPercentage = floatval($value['discount_percentage']);
		$orderItems[$key]['discount_percentage'] = $discountPercentage;

		$totalDiscount = 0;
		if ($discountPercentage > 0) {
			$totalDiscount = round(($discountPercentage / 100) * $OrderItemsMRP, 2);
		}

		$discount = 0;

		if ($discountPercentage > 0) {
			$discount = round(($discountPercentage / 100) * $productPrice, 2);
		}

		//
		$orderItems[$key]['discount'] = $discount;
		$orderItems[$key]['total_discount'] = $totalDiscount;
		$order['total_discount'] = round($order['total_discount'] + $totalDiscount, 2);
		//

		//
		$mrpMinusDiscount = round($OrderItemsMRP - $totalDiscount, 2);
		$orderItems[$key]['mrp_minus_disocunt'] = $mrpMinusDiscount;
		$order['total_mrp_minus_disocunt'] = $order['total_mrp_minus_disocunt'] + $mrpMinusDiscount;

		//
		$productWeight = floatval($value['weight']);
		$orderItemTotalWeight = $productWeight * $orderItemQTY;
		$orderItems[$key]['weight'] = $productWeight;
		$orderItems[$key]['total_weight'] = $orderItemTotalWeight;
		$order['total_weight'] = $order['total_weight'] + $orderItemTotalWeight;

	}

	$order['total_mrp_minus_disocunt'] = round($order['total_mrp_minus_disocunt'], 2);

	if ($order['gst_percentage'] != 0) {
		$order['gst_tax'] = round(($order['gst_percentage'] / 100) * $order['total_mrp_minus_disocunt'], 2);
	}

	$order['weightInKG'] = $order['total_weight'] / 1000;
	$order['delievery_charge'] = (round($order['weightInKG'] * $order['shipping_cost'], 2));

	$order['total_payable'] = round($order['total_mrp_minus_disocunt'] + $order['gst_tax'] + $order['delievery_charge'], 2);
	$order['items'] = $orderItems;

	return $order;

}
