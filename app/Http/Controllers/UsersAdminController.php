<?php
namespace App\Http\Controllers;
use App\Models\CountryList;
use DB;
use Illuminate\Http\Request;

class UsersAdminController extends Controller {

	public function __construct() {

		$this->middleware(function ($request, $next) {

			if (!userHasAcccess(0)) {
				return redirect()->route('dashboard');
			}
			return $next($request);

		});

	}

	public function index() {
		$data = array();
		$data['title'] = "Admin - Users";
		$data['country_list'] = CountryList::get();
		return view('users/admin', compact('data'));
	}

	public function ajax(Request $request) {

		$searchColumns = array(

			0 => 'users.id',
			1 => 'users.first_name',
			2 => 'users.last_name',
			3 => 'users.email',
			4 => 'users.phone_number',
		);

		$columns = array(
			0 => 'users.id',
			1 => 'users.first_name',
			2 => 'users.email',
			3 => 'users.last_active_date_time',
			4 => 'users.last_login_date_time',
			5 => 'users.status',
			5 => 'users.last_name',
			6 => 'users.type',
			7 => 'users.created_at',
			8 => 'users.status',
			9 => 'users.phone_number',

		);

		$recordsTotal = DB::table('users')->where('type', 0)->count();
		$recordsFiltered = $recordsTotal; // when there is no search parameter then total number rows = total number filtered rows.
		$query = DB::table('users');
		$query->select($columns);
		$query->where('type', 0);
		$query->limit($request->length);
		$query->offset($request->start);
		$query->orderBy($columns[$request['order'][0]['column']], $request['order'][0]['dir']);
		$isFilterApply = 0;

		if (isset($request['search']['value'])) {
			$isFilterApply = 1;
			$search_value = $request['search']['value'];
			$query->where(function ($query) use ($search_value, $searchColumns) {

				for ($i = 0; $i < count($searchColumns); $i++) {

					if ($i == 0) {
						$query->where($searchColumns[$i], 'like', "%" . $search_value . "%");

					} else {

						$query->orWhere($searchColumns[$i], 'like', "%" . $search_value . "%");

					}

				}

			});

		}

		$data = $query->get();
		// echo "<pre>";
		// print_r(DB::getQueryLog());
		// die;

		$data = json_decode(json_encode($data), true);

		if ($isFilterApply == 1) {
			$recordsFiltered = count($data);
		}

		foreach ($data as $key => $value) {

			$data[$key]['id'] = '<div class="avatar-xs"><span class="avatar-title rounded-circle">' . $data[$key]['id'] . '</span></div>';

			$data[$key]['name'] = '<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">' . $value['first_name'] . " " . $value['last_name'] . '</a></h5>
             <p class="text-muted mb-0">' . getUserTypeName($value['type']) . '</p>';

			if ($data[$key]['created_at'] == $data[$key]['last_active_date_time']) {

				$data[$key]['last_active_date_time'] = "-";
				$data[$key]['last_login_date_time'] = "-";

			} else {

				$data[$key]['last_active_date_time'] = convertDateTime($value['last_active_date_time']);
				$data[$key]['last_login_date_time'] = convertDateTime($value['last_login_date_time']);

			}

			$data[$key]['status'] = getUserStatusLable($value['status']);
			$data[$key]['email'] = '<p class="text-muted mb-0">' . $value['email'] . '</p>
             <p class="text-muted mb-0">' . $value['phone_number'] . '</p>';

			$uiAction = '<ul class="list-inline font-size-20 contact-links mb-0">';

			$uiAction .= '<li class="list-inline-item px-2">';
			$uiAction .= '<a onclick="editView(\'' . $value['id'] . '\')" href="javascript: void(0);" title="Edit"><i class="bx bx-edit-alt"></i></a>';
			$uiAction .= '</li>';

			$uiAction .= '</ul>';
			$data[$key]['action'] = $uiAction;

		}

		$jsonData = array(
			"draw" => intval($request['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
			"recordsTotal" => intval($recordsTotal), // total number of records
			"recordsFiltered" => intval($recordsFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data" => $data, // total data array

		);
		return $jsonData;

	}

}