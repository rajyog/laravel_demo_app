<?php
namespace App\Http\Controllers;
use App\Models\CityList;
use App\Models\Company;
use App\Models\SalePerson;
use App\Models\SalesHierarchy;
use App\Models\StateList;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

//use Session;

class UsersController extends Controller {

	public function reportingManager(Request $request) {

		if ($request->user_company_id != "" && $request->sale_person_type != "") {

			$SalesHierarchy = array();
			$SalesHierarchy = SalesHierarchy::select('id', 'parent_id');
			$SalesHierarchy->where('status', 1);
			$SalesHierarchy->where('id', $request->sale_person_type);
			$SalesHierarchy = $SalesHierarchy->get();

			$SalesHierarchyId = array();
			/// Repeat Code start
			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}

			}

			if (count($parentIds) > 0) {

				$SalesHierarchy = array();
				$SalesHierarchy = SalesHierarchy::select('id', 'parent_id');
				$SalesHierarchy->where('status', 1);
				$SalesHierarchy->whereIn('id', $parentIds);
				$SalesHierarchy = $SalesHierarchy->get();

			}
			/// Repeat Code end
			/// Repeat Code start
			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}

			}

			if (count($parentIds) > 0) {

				$SalesHierarchy = array();
				$SalesHierarchy = SalesHierarchy::select('id', 'parent_id');
				$SalesHierarchy->where('status', 1);
				$SalesHierarchy->whereIn('id', $parentIds);
				$SalesHierarchy = $SalesHierarchy->get();

			}
			/// Repeat Code end
			/// Repeat Code start
			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}

			}

			if (count($parentIds) > 0) {

				$SalesHierarchy = array();
				$SalesHierarchy = SalesHierarchy::select('id', 'parent_id');
				$SalesHierarchy->where('status', 1);
				$SalesHierarchy->whereIn('id', $parentIds);
				$SalesHierarchy = $SalesHierarchy->get();

			}
			/// Repeat Code end
			/// Repeat Code start
			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}

			}

			if (count($parentIds) > 0) {

				$SalesHierarchy = array();
				$SalesHierarchy = SalesHierarchy::select('id', 'parent_id');
				$SalesHierarchy->where('status', 1);
				$SalesHierarchy->whereIn('id', $parentIds);
				$SalesHierarchy = $SalesHierarchy->get();

			}
			/// Repeat Code end
			/// Repeat Code start
			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}

			}

			if (count($parentIds) > 0) {

				$SalesHierarchy = array();
				$SalesHierarchy = SalesHierarchy::select('id', 'parent_id');
				$SalesHierarchy->where('status', 1);
				$SalesHierarchy->whereIn('id', $parentIds);
				$SalesHierarchy = $SalesHierarchy->get();

			}
			/// Repeat Code end

			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}

			}

			$SalesHierarchyId = array_unique($SalesHierarchyId);
			$SalesHierarchyId = array_values($SalesHierarchyId);

			$q = $request->q;

			$query = DB::table('sale_person');
			$query->leftJoin('users', 'sale_person.user_id', '=', 'users.id');
			$query->select('users.id as id', DB::raw('CONCAT(first_name," ", last_name) AS text'));
			$query->whereIn('sale_person.type', $SalesHierarchyId);
			$query->where('users.type', 2);
			$query->where('users.company_id', $request->user_company_id);
			$query->where('users.reference_id', '!=', 0);
			$query->where('users.id', '!=', $request->user_id);

			$query->where(function ($query) use ($q) {
				$query->where('users.first_name', 'like', '%' . $q . '%');
				$query->orWhere('users.last_name', 'like', '%' . $q . '%');
			});

			$query->limit(5);
			$data = $query->get();

			$response = array();
			$response['results'] = $data;

		} else {
			$response = array();
			$response['results'] = array();

		}

		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');

	}

	function searchStateCities(Request $request) {

		$CityList = array();
		$CityList = CityList::select('id', 'name as text');
		//$CityList->where('country_id', $request->country_id);
		$CityList->whereIn('state_id', explode(",", $request->sale_person_state));
		$CityList->where('name', 'like', "%" . $request->q . "%");
		$CityList->where('status', 1);
		$CityList->limit(5);
		$CityList = $CityList->get();

		$response = array();
		$response['results'] = $CityList;
		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');

	}

	public function stateCities(Request $request) {

		$CityList = array();
		$CityList = CityList::select('id', 'name as text');
		$CityList->whereIn('state_id', explode(",", $request->state_ids));
		$CityList->orderByRaw('FIELD (state_id, ' . $request->state_ids . ') ASC');
		$CityList->where('status', 1);
		$CityList = $CityList->get();
		$response = array();
		$response['data'] = $CityList;
		return response()->json($response)->header('Content-Type', 'application/json');

	}

	public function searchSalePersonType(Request $request) {

		$SalesHierarchy = array();
		$SalesHierarchy = SalesHierarchy::select('id', 'name as text');
		$SalesHierarchy->where('status', 1);
		$SalesHierarchy->where('name', 'like', "%" . $request->q . "%");
		$SalesHierarchy->limit(5);
		$SalesHierarchy = $SalesHierarchy->get();

		$response = array();
		$response['results'] = $SalesHierarchy;
		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');

	}

	public function searchState(Request $request) {

		$StateList = array();
		$StateList = StateList::select('id', 'name as text');
		$StateList->where('country_id', $request->country_id);

		$StateList->where('name', 'like', "%" . $request->q . "%");

		$StateList->limit(5);
		$StateList = $StateList->get();

		$response = array();
		$response['results'] = $StateList;
		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');

	}

	public function searchCity(Request $request) {

		$CityList = array();
		$CityList = CityList::select('id', 'name as text');
		$CityList->where('country_id', $request->country_id);
		$CityList->where('state_id', $request->state_id);
		$CityList->where('name', 'like', "%" . $request->q . "%");
		$CityList->where('status', 1);
		$CityList->limit(5);
		$CityList = $CityList->get();

		$response = array();
		$response['results'] = $CityList;
		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');

	}

	public function searchCompany(Request $request) {

		$Company = array();
		$Company = Company::select('id', 'name as text');
		$Company->where('name', 'like', "%" . $request->q . "%");
		$Company->where('status', 1);
		$Company->limit(5);
		$Company = $Company->get();
		$response = array();
		$response['results'] = $Company;
		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');

	}

	public function save(Request $request) {

		if (userHasAcccess($request->user_type)) {

			if ($request->user_type == 0) {

				$user_address_line2 = isset($request->user_address_line2) ? $request->user_address_line2 : '';

// START ADMIN
				$validator = Validator::make($request->all(), [
					'user_id' => ['required'],
					'user_first_name' => ['required'],
					'user_last_name' => ['required'],
					'user_email' => ['required'],
					'user_phone_number' => ['required'],
					'user_ctc' => ['required'],
					'user_address_line1' => ['required'],
					'user_pincode' => ['required'],
					'user_country_id' => ['required'],
					'user_state_id' => ['required'],
					'user_city_id' => ['required'],

				]);

				if ($validator->fails()) {

					$response = array();
					$response['status'] = 0;
					$response['msg'] = "The request could not be understood by the server due to malformed syntax";
					$response['statuscode'] = 400;
					$response['data'] = $validator->errors();

					return redirect()->back()->with("error", "Something went wrong with validation");

				} else {

					$phone_number = $request->user_phone_number;

					$alreadyEmail = User::query();
					$alreadyEmail->where('email', $request->user_email);

					if ($request->user_id != 0) {
						$alreadyEmail->where('id', '!=', $request->user_id);
					}
					$alreadyEmail = $alreadyEmail->first();

					$alreadyPhoneNumber = User::query();
					$alreadyPhoneNumber->where('phone_number', $request->user_phone_number);

					if ($request->user_id != 0) {
						$alreadyPhoneNumber->where('id', '!=', $request->user_id);
					}
					$alreadyPhoneNumber = $alreadyPhoneNumber->first();

					if ($alreadyEmail) {

						$response = errorRes("Email already exists, Try with another email");

					} else if ($alreadyPhoneNumber) {
						$response = errorRes("Phone number already exists, Try with another phone number");

					} else {

						if ($request->user_id == 0) {
							$User = new User();
							$User->password = Hash::make("111111");
							$User->last_active_date_time = date('Y-m-d H:i:s');
							$User->last_login_date_time = date('Y-m-d H:i:s');
							$User->avatar = "default.png";
						} else {
							$User = User::find($request->user_id);
						}
						$User->first_name = $request->user_first_name;
						$User->last_name = $request->user_last_name;
						$User->email = $request->user_email;
						$User->dialing_code = "+91";
						$User->phone_number = $request->user_phone_number;
						$User->ctc = $request->user_ctc;
						$User->address_line1 = $request->user_address_line1;
						$User->address_line2 = $user_address_line2;
						$User->pincode = $request->user_pincode;
						$User->country_id = $request->user_country_id;
						$User->state_id = $request->user_state_id;
						$User->city_id = $request->user_city_id;
						$User->company_id = 0;

						$User->type = 0;
						$User->status = $request->user_status;
						$User->reference_type = 0;
						$User->reference_id = 0;
						$User->save();

						if ($request->user_id != 0) {

							$response = successRes("Successfully saved user");

							$debugLog = array();
							$debugLog['name'] = "user-edit";
							$debugLog['description'] = "user #" . $User->id . "(" . $User->first_name . " " . $User->last_name . ") has been updated ";
							saveDebugLog($debugLog);

						} else {
							$response = successRes("Successfully added user");

							$debugLog = array();
							$debugLog['name'] = "user-add";
							$debugLog['description'] = "user #" . $User->id . "(" . $User->first_name . " " . $User->last_name . ") has been added ";
							saveDebugLog($debugLog);

						}

					}

					return response()->json($response)->header('Content-Type', 'application/json');

				}
// END ADMIN
			} else if ($request->user_type == 1) {

				$user_address_line2 = isset($request->user_address_line2) ? $request->user_address_line2 : '';

// START ADMIN
				$validator = Validator::make($request->all(), [
					'user_id' => ['required'],
					'user_first_name' => ['required'],
					'user_last_name' => ['required'],
					'user_email' => ['required'],
					'user_phone_number' => ['required'],
					'user_ctc' => ['required'],
					'user_address_line1' => ['required'],
					'user_pincode' => ['required'],
					'user_country_id' => ['required'],
					'user_state_id' => ['required'],
					'user_city_id' => ['required'],
					'user_company_id' => ['required'],

				]);

				if ($validator->fails()) {

					$response = array();
					$response['status'] = 0;
					$response['msg'] = "The request could not be understood by the server due to malformed syntax";
					$response['statuscode'] = 400;
					$response['data'] = $validator->errors();

					return redirect()->back()->with("error", "Something went wrong with validation");

				} else {

					$phone_number = $request->user_phone_number;

					$alreadyEmail = User::query();
					$alreadyEmail->where('email', $request->user_email);

					if ($request->user_id != 0) {
						$alreadyEmail->where('id', '!=', $request->user_id);
					}
					$alreadyEmail = $alreadyEmail->first();

					$alreadyPhoneNumber = User::query();
					$alreadyPhoneNumber->where('phone_number', $request->user_phone_number);

					if ($request->user_id != 0) {
						$alreadyPhoneNumber->where('id', '!=', $request->user_id);
					}
					$alreadyPhoneNumber = $alreadyPhoneNumber->first();

					if ($alreadyEmail) {

						$response = errorRes("Email already exists, Try with another email");

					} else if ($alreadyPhoneNumber) {
						$response = errorRes("Phone number already exists, Try with another phone number");

					} else {

						if ($request->user_id == 0) {
							$User = new User();
							$User->password = Hash::make("111111");
							$User->last_active_date_time = date('Y-m-d H:i:s');
							$User->last_login_date_time = date('Y-m-d H:i:s');
							$User->avatar = "default.png";
						} else {
							$User = User::find($request->user_id);
						}
						$User->first_name = $request->user_first_name;
						$User->last_name = $request->user_last_name;
						$User->email = $request->user_email;
						$User->dialing_code = "+91";
						$User->phone_number = $request->user_phone_number;
						$User->ctc = $request->user_ctc;
						$User->address_line1 = $request->user_address_line1;
						$User->address_line2 = $user_address_line2;
						$User->pincode = $request->user_pincode;
						$User->country_id = $request->user_country_id;
						$User->state_id = $request->user_state_id;
						$User->city_id = $request->user_city_id;
						$User->company_id = $request->user_company_id;

						$User->type = 1;
						$User->status = $request->user_status;
						$User->reference_type = 0;
						$User->reference_id = 0;
						$User->save();

						if ($request->user_id != 0) {

							$response = successRes("Successfully saved user");

							$debugLog = array();
							$debugLog['name'] = "user-edit";
							$debugLog['description'] = "user #" . $User->id . "(" . $User->first_name . " " . $User->last_name . ") has been updated ";
							saveDebugLog($debugLog);

						} else {
							$response = successRes("Successfully added user");

							$debugLog = array();
							$debugLog['name'] = "user-add";
							$debugLog['description'] = "user #" . $User->id . "(" . $User->first_name . " " . $User->last_name . ") has been added ";
							saveDebugLog($debugLog);

						}

					}

					return response()->json($response)->header('Content-Type', 'application/json');

				}

			} else if ($request->user_type == 2) {

				$user_address_line2 = isset($request->user_address_line2) ? $request->user_address_line2 : '';
				$sale_person_reporting_manager = isset($request->sale_person_reporting_manager) ? $request->sale_person_reporting_manager : 0;

// START ADMIN
				$validator = Validator::make($request->all(), [
					'user_id' => ['required'],
					'user_first_name' => ['required'],
					'user_last_name' => ['required'],
					'user_email' => ['required'],
					'user_phone_number' => ['required'],
					'user_ctc' => ['required'],
					'user_address_line1' => ['required'],
					'user_pincode' => ['required'],
					'user_country_id' => ['required'],
					'user_state_id' => ['required'],
					'user_city_id' => ['required'],
					'user_company_id' => ['required'],
					'sale_person_type' => ['required'],
					'sale_person_state' => ['required'],
					'sale_person_city' => ['required'],

				]);

				if ($validator->fails()) {

					$response = array();
					$response['status'] = 0;
					$response['msg'] = "The request could not be understood by the server due to malformed syntax";
					$response['statuscode'] = 400;
					$response['data'] = $validator->errors();

					return redirect()->back()->with("error", "Something went wrong with validation");

				} else {

					// print_r($request->sale_person_state);
					// die;

					//$phone_number = $request->user_phone_number;

					$alreadyEmail = User::query();
					$alreadyEmail->where('email', $request->user_email);

					if ($request->user_id != 0) {
						$alreadyEmail->where('id', '!=', $request->user_id);
					}
					$alreadyEmail = $alreadyEmail->first();

					$alreadyPhoneNumber = User::query();
					$alreadyPhoneNumber->where('phone_number', $request->user_phone_number);

					if ($request->user_id != 0) {
						$alreadyPhoneNumber->where('id', '!=', $request->user_id);
					}
					$alreadyPhoneNumber = $alreadyPhoneNumber->first();

					if ($alreadyEmail) {

						$response = errorRes("Email already exists, Try with another email");

					} else if ($alreadyPhoneNumber) {
						$response = errorRes("Phone number already exists, Try with another phone number");

					} else {

						if ($request->user_id == 0) {
							$User = new User();
							$User->password = Hash::make("111111");
							$User->last_active_date_time = date('Y-m-d H:i:s');
							$User->last_login_date_time = date('Y-m-d H:i:s');
							$User->avatar = "default.png";
							$SalePerson = new SalePerson();

						} else {
							$User = User::find($request->user_id);
							$SalePerson = SalePerson::find($User->reference_id);
							if (!$SalePerson) {

								$SalePerson = new SalePerson();

							}

						}
						$User->first_name = $request->user_first_name;
						$User->last_name = $request->user_last_name;
						$User->email = $request->user_email;
						$User->dialing_code = "+91";
						$User->phone_number = $request->user_phone_number;
						$User->ctc = $request->user_ctc;
						$User->address_line1 = $request->user_address_line1;
						$User->address_line2 = $user_address_line2;
						$User->pincode = $request->user_pincode;
						$User->country_id = $request->user_country_id;
						$User->state_id = $request->user_state_id;
						$User->city_id = $request->user_city_id;
						$User->company_id = $request->user_company_id;

						$User->type = 2;
						$User->status = $request->user_status;
						$User->reference_type = 0;
						$User->reference_id = 0;
						$User->save();

						// print_r(implode(",", $request->sale_person_state));
						// die;

						$SalePerson->user_id = $User->id;
						$SalePerson->type = $request->sale_person_type;
						$SalePerson->reporting_manager = $sale_person_reporting_manager;
						$SalePerson->states = implode(",", $request->sale_person_state);
						$SalePerson->cities = implode(",", $request->sale_person_city);
						$SalePerson->save();

						$User->reference_type = "sale_person";
						$User->reference_id = $SalePerson->id;
						$User->save();

						if ($request->user_id != 0) {

							$response = successRes("Successfully saved user");

							$debugLog = array();
							$debugLog['name'] = "user-edit";
							$debugLog['description'] = "user #" . $User->id . "(" . $User->first_name . " " . $User->last_name . ") has been updated ";
							saveDebugLog($debugLog);

						} else {
							$response = successRes("Successfully added user");

							$debugLog = array();
							$debugLog['name'] = "user-add";
							$debugLog['description'] = "user #" . $User->id . "(" . $User->first_name . " " . $User->last_name . ") has been added ";
							saveDebugLog($debugLog);

						}

					}

					return response()->json($response)->header('Content-Type', 'application/json');

				}

			} else if ($request->user_type == 3) {

				$user_address_line2 = isset($request->user_address_line2) ? $request->user_address_line2 : '';

				$parent_id = 0;
				$user_company_id = 0;

				if (isChannelPartner(Auth::user()->type) != 0) {
					$parent_id = Auth::user()->id;
				} else {
					$user_company_id = $request->user_company_id;
				}

// START ADMIN
				$validator = Validator::make($request->all(), [
					'user_id' => ['required'],
					'user_first_name' => ['required'],
					'user_last_name' => ['required'],
					'user_email' => ['required'],
					'user_phone_number' => ['required'],
					'user_ctc' => ['required'],
					'user_address_line1' => ['required'],
					'user_pincode' => ['required'],
					'user_country_id' => ['required'],
					'user_state_id' => ['required'],
					'user_city_id' => ['required'],

				]);

				if ($validator->fails()) {

					$response = array();
					$response['status'] = 0;
					$response['msg'] = "The request could not be understood by the server due to malformed syntax";
					$response['statuscode'] = 400;
					$response['data'] = $validator->errors();

					return redirect()->back()->with("error", "Something went wrong with validation");

				} else {

					$phone_number = $request->user_phone_number;

					$alreadyEmail = User::query();
					$alreadyEmail->where('email', $request->user_email);

					if ($request->user_id != 0) {
						$alreadyEmail->where('id', '!=', $request->user_id);
					}
					$alreadyEmail = $alreadyEmail->first();

					$alreadyPhoneNumber = User::query();
					$alreadyPhoneNumber->where('phone_number', $request->user_phone_number);

					if ($request->user_id != 0) {
						$alreadyPhoneNumber->where('id', '!=', $request->user_id);
					}
					$alreadyPhoneNumber = $alreadyPhoneNumber->first();

					if ($alreadyEmail) {

						$response = errorRes("Email already exists, Try with another email");

					} else if ($alreadyPhoneNumber) {
						$response = errorRes("Phone number already exists, Try with another phone number");

					} else {

						if ($request->user_id == 0) {
							$User = new User();
							$User->parent_id = $parent_id;
							$User->password = Hash::make("111111");
							$User->last_active_date_time = date('Y-m-d H:i:s');
							$User->last_login_date_time = date('Y-m-d H:i:s');
							$User->avatar = "default.png";
						} else {
							$User = User::find($request->user_id);
						}
						$User->first_name = $request->user_first_name;
						$User->last_name = $request->user_last_name;
						$User->email = $request->user_email;
						$User->dialing_code = "+91";
						$User->phone_number = $request->user_phone_number;
						$User->ctc = $request->user_ctc;
						$User->address_line1 = $request->user_address_line1;
						$User->address_line2 = $user_address_line2;
						$User->pincode = $request->user_pincode;
						$User->country_id = $request->user_country_id;
						$User->state_id = $request->user_state_id;
						$User->city_id = $request->user_city_id;
						$User->company_id = $user_company_id;

						$User->type = 3;
						$User->status = $request->user_status;
						$User->reference_type = 0;
						$User->reference_id = 0;
						$User->save();

						if ($request->user_id != 0) {

							$response = successRes("Successfully saved user");

							$debugLog = array();
							$debugLog['name'] = "user-edit";
							$debugLog['description'] = "user #" . $User->id . "(" . $User->first_name . " " . $User->last_name . ") has been updated ";
							saveDebugLog($debugLog);

						} else {
							$response = successRes("Successfully added user");

							$debugLog = array();
							$debugLog['name'] = "user-add";
							$debugLog['description'] = "user #" . $User->id . "(" . $User->first_name . " " . $User->last_name . ") has been added ";
							saveDebugLog($debugLog);

						}

					}

					return response()->json($response)->header('Content-Type', 'application/json');

				}

			} else if ($request->user_type == 4) {

				$user_address_line2 = isset($request->user_address_line2) ? $request->user_address_line2 : '';

				$parent_id = 0;
				$user_company_id = 0;

				if (isChannelPartner(Auth::user()->type) != 0) {
					$parent_id = Auth::user()->id;
				} else {
					$user_company_id = $request->user_company_id;
				}

// START ADMIN
				$validator = Validator::make($request->all(), [
					'user_id' => ['required'],
					'user_first_name' => ['required'],
					'user_last_name' => ['required'],
					'user_email' => ['required'],
					'user_phone_number' => ['required'],
					'user_ctc' => ['required'],
					'user_address_line1' => ['required'],
					'user_pincode' => ['required'],
					'user_country_id' => ['required'],
					'user_state_id' => ['required'],
					'user_city_id' => ['required'],

				]);

				if ($validator->fails()) {

					$response = array();
					$response['status'] = 0;
					$response['msg'] = "The request could not be understood by the server due to malformed syntax";
					$response['statuscode'] = 400;
					$response['data'] = $validator->errors();

					return redirect()->back()->with("error", "Something went wrong with validation");

				} else {

					$phone_number = $request->user_phone_number;

					$alreadyEmail = User::query();
					$alreadyEmail->where('email', $request->user_email);

					if ($request->user_id != 0) {
						$alreadyEmail->where('id', '!=', $request->user_id);
					}
					$alreadyEmail = $alreadyEmail->first();

					$alreadyPhoneNumber = User::query();
					$alreadyPhoneNumber->where('phone_number', $request->user_phone_number);

					if ($request->user_id != 0) {
						$alreadyPhoneNumber->where('id', '!=', $request->user_id);
					}
					$alreadyPhoneNumber = $alreadyPhoneNumber->first();

					if ($alreadyEmail) {

						$response = errorRes("Email already exists, Try with another email");

					} else if ($alreadyPhoneNumber) {
						$response = errorRes("Phone number already exists, Try with another phone number");

					} else {

						if ($request->user_id == 0) {
							$User = new User();
							$User->parent_id = $parent_id;
							$User->password = Hash::make("111111");
							$User->last_active_date_time = date('Y-m-d H:i:s');
							$User->last_login_date_time = date('Y-m-d H:i:s');
							$User->avatar = "default.png";
						} else {
							$User = User::find($request->user_id);
						}
						$User->first_name = $request->user_first_name;
						$User->last_name = $request->user_last_name;
						$User->email = $request->user_email;
						$User->dialing_code = "+91";
						$User->phone_number = $request->user_phone_number;
						$User->ctc = $request->user_ctc;
						$User->address_line1 = $request->user_address_line1;
						$User->address_line2 = $user_address_line2;
						$User->pincode = $request->user_pincode;
						$User->country_id = $request->user_country_id;
						$User->state_id = $request->user_state_id;
						$User->city_id = $request->user_city_id;
						$User->company_id = $user_company_id;

						$User->type = 4;
						$User->status = $request->user_status;
						$User->reference_type = 0;
						$User->reference_id = 0;
						$User->save();

						if ($request->user_id != 0) {

							$response = successRes("Successfully saved user");

							$debugLog = array();
							$debugLog['name'] = "user-edit";
							$debugLog['description'] = "user #" . $User->id . "(" . $User->first_name . " " . $User->last_name . ") has been updated ";
							saveDebugLog($debugLog);

						} else {
							$response = successRes("Successfully added user");

							$debugLog = array();
							$debugLog['name'] = "user-add";
							$debugLog['description'] = "user #" . $User->id . "(" . $User->first_name . " " . $User->last_name . ") has been added ";
							saveDebugLog($debugLog);

						}

					}

					return response()->json($response)->header('Content-Type', 'application/json');

				}

			} else if ($request->user_type == 5) {

				$user_address_line2 = isset($request->user_address_line2) ? $request->user_address_line2 : '';

// START ADMIN
				$validator = Validator::make($request->all(), [
					'user_id' => ['required'],
					'user_first_name' => ['required'],
					'user_last_name' => ['required'],
					'user_email' => ['required'],
					'user_phone_number' => ['required'],
					'user_ctc' => ['required'],
					'user_address_line1' => ['required'],
					'user_pincode' => ['required'],
					'user_country_id' => ['required'],
					'user_state_id' => ['required'],
					'user_city_id' => ['required'],
					'user_company_id' => ['required'],

				]);

				if ($validator->fails()) {

					$response = array();
					$response['status'] = 0;
					$response['msg'] = "The request could not be understood by the server due to malformed syntax";
					$response['statuscode'] = 400;
					$response['data'] = $validator->errors();

					return redirect()->back()->with("error", "Something went wrong with validation");

				} else {

					$phone_number = $request->user_phone_number;

					$alreadyEmail = User::query();
					$alreadyEmail->where('email', $request->user_email);

					if ($request->user_id != 0) {
						$alreadyEmail->where('id', '!=', $request->user_id);
					}
					$alreadyEmail = $alreadyEmail->first();

					$alreadyPhoneNumber = User::query();
					$alreadyPhoneNumber->where('phone_number', $request->user_phone_number);

					if ($request->user_id != 0) {
						$alreadyPhoneNumber->where('id', '!=', $request->user_id);
					}
					$alreadyPhoneNumber = $alreadyPhoneNumber->first();

					if ($alreadyEmail) {

						$response = errorRes("Email already exists, Try with another email");

					} else if ($alreadyPhoneNumber) {
						$response = errorRes("Phone number already exists, Try with another phone number");

					} else {

						if ($request->user_id == 0) {
							$User = new User();
							$User->password = Hash::make("111111");
							$User->last_active_date_time = date('Y-m-d H:i:s');
							$User->last_login_date_time = date('Y-m-d H:i:s');
							$User->avatar = "default.png";
						} else {
							$User = User::find($request->user_id);
						}
						$User->first_name = $request->user_first_name;
						$User->last_name = $request->user_last_name;
						$User->email = $request->user_email;
						$User->dialing_code = "+91";
						$User->phone_number = $request->user_phone_number;
						$User->ctc = $request->user_ctc;
						$User->address_line1 = $request->user_address_line1;
						$User->address_line2 = $user_address_line2;
						$User->pincode = $request->user_pincode;
						$User->country_id = $request->user_country_id;
						$User->state_id = $request->user_state_id;
						$User->city_id = $request->user_city_id;
						$User->company_id = $request->user_company_id;

						$User->type = 5;
						$User->status = $request->user_status;
						$User->reference_type = 0;
						$User->reference_id = 0;
						$User->save();

						if ($request->user_id != 0) {

							$response = successRes("Successfully saved user");

							$debugLog = array();
							$debugLog['name'] = "user-edit";
							$debugLog['description'] = "user #" . $User->id . "(" . $User->first_name . " " . $User->last_name . ") has been updated ";
							saveDebugLog($debugLog);

						} else {
							$response = successRes("Successfully added user");

							$debugLog = array();
							$debugLog['name'] = "user-add";
							$debugLog['description'] = "user #" . $User->id . "(" . $User->first_name . " " . $User->last_name . ") has been added ";
							saveDebugLog($debugLog);

						}

					}

					return response()->json($response)->header('Content-Type', 'application/json');

				}

			} else {
				$response = errorRes("Invalid user access", 402);
			}

		} else {

			$response = errorRes("Invalid user access", 402);

		}

		return response()->json($response)->header('Content-Type', 'application/json');

	}

	public function detail(Request $request) {

		$User = User::with(array('country' => function ($query) {
			$query->select('id', 'name');
		}, 'state' => function ($query) {
			$query->select('id', 'name');
		}, 'city' => function ($query) {
			$query->select('id', 'name');
		}, 'company' => function ($query) {
			$query->select('id', 'name');
		}))->find($request->id);
		if ($User) {

			if (userHasAcccess($User->type)) {

				if ($User->type == 2) {
					$User['sale_person'] = SalePerson::select('type', 'reporting_manager', 'states', 'cities')->with(array('type' => function ($query) {
						$query->select('id', 'name');
					}, 'reporting_manager' => function ($query) {
						$query->select('id', DB::raw('CONCAT(first_name," ", last_name) AS name'));
					}))->find($User->reference_id);
					if ($User['sale_person']) {

						$User['sale_person']['states'] = StateList::select('id', 'name as text')->whereIn('id', explode(",", $User['sale_person']->states))->get();

						$User['sale_person']['cities'] = CityList::select('id', 'name as text')->whereIn('id', explode(",", $User['sale_person']->cities))->get();

					}

				}

				$response = successRes("Successfully get user");
				$response['data'] = $User;
			} else {
				$response = errorRes("Invalid user access", 402);
			}

		} else {
			$response = errorRes("Invalid id");
		}
		return response()->json($response)->header('Content-Type', 'application/json');

	}

}