<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\InquiryQuestion;
use App\Models\InquiryQuestionAnswer;
use App\Models\InquiryQuestionOption;
use App\Models\User;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CRMInquiryController extends Controller {

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $tabCanAccessBy = array(0, 1);
            if (!in_array(Auth::user()->type, $tabCanAccessBy)) {
                return redirect()->route('dashboard');
            }
            return $next($request);
        });
    }

    public function index() {
        $data = array();
        $data['title'] = "Inquiry";
        return view('inquiry/index', compact('data'));
    }

    public function saveInquiry(Request $request) {
        $inquiry_address_line2 = isset($request->inquiry_address_line2) ? $request->inquiry_address_line2 : '';

        $validator = Validator::make($request->all(), [
                    'inquiry_id' => ['required'],
                    'inquiry_first_name' => ['required'],
                    'inquiry_last_name' => ['required'],
                    'inquiry_phone_number' => ['required'],
                    'inquiry_address_line1' => ['required'],
                    'inquiry_country_id' => ['required'],
                    'inquiry_state_id' => ['required'],
                    'inquiry_city_id' => ['required'],
                    'inquiry_pincode' => ['required'],
                    'inquiry_source_type' => ['required'],
                    'inquiry_source' => ['required']
        ]);

        if ($validator->fails()) {
            $response = array();
            $response['status'] = 0;
            $response['msg'] = "The request could not be understood by the server due to malformed syntax";
            $response['statuscode'] = 400;
            $response['data'] = $validator->errors();

            return response()->json($response)->header('Content-Type', 'application/json');
        } else {
            if ($request->inquiry_id != 0) {
                $Inquiry = Inquiry::find($request->inquiry_id);
            } else {
                $Inquiry = new Inquiry();
            }

            $Inquiry->first_name = $request->inquiry_first_name;
            $Inquiry->last_name = $request->inquiry_last_name;
            $Inquiry->phone_number = $request->inquiry_phone_number;
            $Inquiry->address_line1 = $request->inquiry_address_line1;
            $Inquiry->address_line2 = $inquiry_address_line2;
            $Inquiry->country_id = $request->inquiry_country_id;
            $Inquiry->state_id = $request->inquiry_state_id;
            $Inquiry->city_id = $request->inquiry_city_id;
            $Inquiry->pincode = $request->inquiry_pincode;
            $Inquiry->source_type = $request->inquiry_source_type;
            $Inquiry->source_user_id = $request->inquiry_source;
            $Inquiry->user_id = Auth::id();
            $Inquiry->assigned_to = Auth::id();
            $Inquiry->save();

            if ($Inquiry) {
                if ($request->inquiry_id != 0) {
                    $response = successRes("Successfully saved Inquiry");

                    $debugLog = array();
                    $debugLog['name'] = "inquiry-edit";
                    $debugLog['description'] = "inquiry #" . $Inquiry->id . "(" . $Inquiry->first_name . ' ' . $Inquiry->last_name . ") has been updated ";
                    saveDebugLog($debugLog);
                } else {
                    $response = successRes("Successfully added inquiry");

                    $debugLog = array();
                    $debugLog['name'] = "inquiry-add";
                    $debugLog['description'] = "inquiry #" . $Inquiry->id . "(" . $Inquiry->first_name . ' ' . $Inquiry->last_name . ") has been added ";
                    saveDebugLog($debugLog);
                }
            }
            return response()->json($response)->header('Content-Type', 'application/json');
        }
    }

    public function question() {
        $data = array();
        $data['title'] = "Inquiry Question";
        return view('inquiry/question', compact('data'));
    }

    public function saveQuestion(Request $request) {       

        $rules = array();

        $rules['inquiery_questions_id'] = 'required';
        $rules['inquiery_questions_status'] = 'required';
        $rules['inquiery_questions_type'] = 'required';
        $rules['inquiery_questions_question'] = 'required';
        $rules['inquiery_questions_is_static'] = 'required';
        $rules['inquiery_questions_is_required'] = 'required';
        $rules['inquiery_questions_question'] = 'required';

        if ($request->inquiery_questions_type == 1) {
//            $rules['inner_group.*.question_option'] = 'required';
            $rules['question_option.*'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            $response = array();
            $response['status'] = 0;
            $response['msg'] = "The request could not be understood by the server due to malformed syntax";
            $response['statuscode'] = 400;
            $response['data'] = $validator->errors();

            return response()->json($response)->header('Content-Type', 'application/json');
        } else {

            if ($request->inquiery_questions_id != 0) {
                $InquiryQuestion = InquiryQuestion::find($request->inquiery_questions_id);
            } else {
                $InquiryQuestion = new InquiryQuestion();
            }

            $InquiryQuestion->status = $request->inquiery_questions_status;
            $InquiryQuestion->type = $request->inquiery_questions_type;
            $InquiryQuestion->question = $request->inquiery_questions_question;
            $InquiryQuestion->is_static = $request->inquiery_questions_is_static;
            $InquiryQuestion->is_required = $request->inquiery_questions_is_required;
            $InquiryQuestion->save();

            if ($InquiryQuestion) {
                if ($request->inquiery_questions_id != 0) {
//                    echo "<pre>";
//                    print_r($request->question_option);
//                    print_r($request->question_option_id);
//                    echo "</pre>";
//                    die;

                    $response = successRes("Successfully saved Inquiry");

                    
                    #logic for add,edit and delete options
                    $InquiryQuestionOption = InquiryQuestionOption::where('inquiry_question_id', $request->inquiery_questions_id)->get();
                    if(count($InquiryQuestionOption)){
                        foreach ($InquiryQuestionOption as $InquiryQuestionOptionKey => $InquiryQuestionOptionValue) {
//                            echo "<pre>";
//                            print_r($InquiryQuestionOptionValue->id);
//                            echo "</pre>";
//                            die;
                            //check id is exist or not
                            if(in_array($InquiryQuestionOptionValue->id, $request->question_option_id)){
//                                echo "<pre>";
//                                print_r($request->question_option_id);
//                                print_r(array_search($InquiryQuestionOptionValue->id,$request->question_option_id));
//                                echo "</pre>";
//                                die;
                                $key = array_search($InquiryQuestionOptionValue->id,$request->question_option_id);
                               
//                            if(array_search($InquiryQuestionOptionValue->id,$request->question_option_id,true)){
//                                echo "<pre>";
//                                print_r('update');
//                                print_r($request->question_option[$InquiryQuestionOptionValue->id]);
//                                echo "</pre>";
                                #update
                                $InquiryQuestionOption = InquiryQuestionOption::where('id', $InquiryQuestionOptionValue->id)->update(['option' => $request->question_option[$key]]);
                            }else{
                                #delete
                                $InquiryQuestionOption = InquiryQuestionOption::where('id', $InquiryQuestionOptionValue->id)->delete();
                            }
                        }
                    }
                    //add new option
                    if(isset($request->question_option_id) && count($request->question_option_id) > 0){
                        #create a option array
                        $question_option = array();
                        foreach ($request->question_option_id as $questionOptionIdKey => $questionOptionIdValue) {
                            if($questionOptionIdValue == ''){
                                //add new option
                                $question_option[$questionOptionIdKey]['inquiry_question_id'] = $InquiryQuestion->id;
                                $question_option[$questionOptionIdKey]['option'] = $request->question_option[$questionOptionIdKey];
                                $question_option[$questionOptionIdKey]['created_at'] = date("Y-m-d H:i:s", strtotime('now'));
                                $question_option[$questionOptionIdKey]['updated_at'] = date("Y-m-d H:i:s", strtotime('now'));
                            }
                        }
                        $InquiryQuestionOption = new InquiryQuestionOption();
                        $InquiryQuestionOption->insert($question_option);
                    }

                    $debugLog = array();
                    $debugLog['name'] = "inquiry-question-edit";
                    $debugLog['description'] = "inquiry #" . $InquiryQuestion->id . "(" . $InquiryQuestion->question . ") has been updated ";
                    saveDebugLog($debugLog);
                } else {

                    if ($request->inquiery_questions_type == 1) {
                        //create a option array
                        $questionOption = array();
                        foreach ($request->question_option as $key => $val) {
                            $questionOption[$key]['inquiry_question_id'] = $InquiryQuestion->id;
                            $questionOption[$key]['option'] = $val;
                            $questionOption[$key]['created_at'] = date("Y-m-d H:i:s", strtotime('now'));
                            $questionOption[$key]['updated_at'] = date("Y-m-d H:i:s", strtotime('now'));
                        }
                        $InquiryQuestionOption = new InquiryQuestionOption();
                        $InquiryQuestionOption->insert($questionOption);
                    }
                    $response = successRes("Successfully added Inquiry Question");

                    $debugLog = array();
                    $debugLog['name'] = "inquiry-question-add";
                    $debugLog['description'] = "inquiry #" . $InquiryQuestion->id . "(" . $InquiryQuestion->question . ") has been added ";
                    saveDebugLog($debugLog);
                }
            }

            return response()->json($response)->header('Content-Type', 'application/json');
        }
    }

    function ajax(Request $request) {
        //DB::enableQueryLog();

        $searchColumns = array(
            0 => 'inquiry_questions.id',
            1 => 'inquiry_questions.question',
        );

        $columns = array(
            0 => 'inquiry_questions.id',
            1 => 'inquiry_questions.status',
            2 => 'inquiry_questions.type',
            3 => 'inquiry_questions.question',
            4 => 'inquiry_questions.is_static',
            5 => 'inquiry_questions.is_required',
        );

        $recordsTotal = InquiryQuestion::count();
        $recordsFiltered = $recordsTotal; // when there is no search parameter then total number rows = total number filtered rows.

        $query = InquiryQuestion::query();
        $query->select($columns);
        if ($request->status_id != "") {
            $query->where('inquiry_questions.status', $request->status_id);
        }
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

        $inquiryStatus = getInquiryStatus();
        foreach ($data as $key => $value) {

            $data[$key]['id'] = "<p>" . $data[$key]['id'] . '</p>';
            $data[$key]['status'] = "<p>" . $inquiryStatus[$data[$key]['status']]['name'] . '</p>';

            if ($data[$key]['type'] == 0) {
                $data[$key]['type'] = "<p>Text</p>";
            } elseif ($data[$key]['type'] == 1) {
                $data[$key]['type'] = "<p>Option</p>";
            } elseif ($data[$key]['type'] == 2) {
                $data[$key]['type'] = "<p>File</p>";
            } elseif ($data[$key]['type'] == 3) {
                $data[$key]['type'] = "<p>checkbox</p>";
            }

            $data[$key]['question'] = "<p>" . $data[$key]['question'] . '</p>';
            $is_static = $data[$key]['is_static'];
            if ($data[$key]['is_static'] == 1) {
                $data[$key]['is_static'] = "<p>Dyanmic</p>";
            } else {
                $data[$key]['is_static'] = "<p>Static</p>";
            }

            $data[$key]['is_required'] = "<p>" . (($data[$key]['is_required'] == 1) ? 'Yes' : 'No') . '</p>';

            $uiAction = '<ul class="list-inline font-size-20 contact-links mb-0">';

            $uiAction .= '<li class="list-inline-item px-2">';
            $uiAction .= '<a onclick="editView(\'' . $value['id'] . '\')" href="javascript: void(0);" title="Edit"><i class="bx bx-edit-alt"></i></a>';
            $uiAction .= '</li>';

            $uiAction .= '<li class="list-inline-item px-2">';
            $uiAction .= '<a onclick="deleteWarning(\'' . $value['id'] . '\')" href="javascript: void(0);" title="Delete" class="' . (($is_static == 0) ? 'isDisabled' : '') . '" ><i class="bx bx-trash-alt"></i></a>';
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

    function inquiryAjax(Request $request) {
//        DB::enableQueryLog();
        $searchColumns = array(
            0 => 'inquiry.id',
            1 => 'inquiry.first_name',
            2 => 'inquiry.last_name',
            3 => 'inquiry.phone_number',
            4 => 'city_list.name',
            5 => 'users.first_name',
            6 => 'users.last_name',
        );

        $selectColumns = array(
            0 => 'inquiry.id',
            1 => 'inquiry.first_name',
            2 => 'inquiry.last_name',
            3 => 'inquiry.phone_number',
            4 => 'inquiry.address_line1',
            5 => 'inquiry.address_line2',
            5 => 'inquiry.country_id',
            6 => 'inquiry.state_id',
            7 => 'inquiry.city_id',
            8 => 'inquiry.status',
            9 => 'inquiry.pincode',
            10 => 'inquiry.source_type',
            11 => 'inquiry.source_user_id',
            12 => 'users.id as user_id',
            13 => 'users.first_name as user_first_name',
            14 => 'users.last_name as user_last_name',
            15 => 'city_list.name as city_list_name'
        );

        $sortColumns = array(
            0 => 'inquiry.id',
            1 => 'inquiry.first_name',
            2 => 'inquiry.last_name',
            3 => 'inquiry.phone_number',
            4 => 'city_list.name',
            5 => 'users.first_name',
            6 => 'users.last_name',
        );

        $userTypes = getUserTypes();
        $channelPartners = getChannelPartners();
        $sourceType = array_merge($userTypes, $channelPartners);

        $recordsTotal = Inquiry::count();
        $recordsFiltered = $recordsTotal; // when there is no search parameter then total number rows = total number filtered rows.

        $query = DB::table('inquiry');
        $query->select($selectColumns);
        $query->Join('users', 'users.id', '=', 'inquiry.source_user_id');
        $query->Join('city_list', 'city_list.id', '=', 'inquiry.city_id');
        $query->limit($request->length);
        $query->offset($request->start);
        $query->orderBy($sortColumns[$request['order'][0]['column']], $request['order'][0]['dir']);

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
//         echo "<pre>";
//         print_r(DB::getQueryLog());
//         die;

        $data = json_decode(json_encode($data), true);

        if ($isFilterApply == 1) {
            $recordsFiltered = count($data);
        }
        $inquiryStatus = getInquiryStatus();

        foreach ($data as $key => $value) {

            $found_key = array_search($data[$key]['source_type'], array_column($sourceType, 'id'));
            $data[$key]['inquiry_id'] = $data[$key]['id'];
            $data[$key]['id'] = '<div class="avatar-xs"><span class="avatar-title rounded-circle">' . $data[$key]['id'] . '</span></div>';

            $data[$key]['first_name'] = '<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">' . $value['first_name'] . " " . $value['last_name'] . '</a></h5>
                <div class="row">
                    <div class="d-inline-flex">
                        <div class="me-1"><i class="bx bx-map bx-sm"></i></div>
                        <div class="text-wrap me-1"><p class="text-muted mb-0">' . $data[$key]['address_line1'] . '</p></div>
                    </div>
                </div>
                <div class="row">
                    <div class="d-inline-flex">
                        <div class="align-self-center me-1"><p class="text-muted mb-0">Source </p></div>
                        <div class="align-self-center me-1"><i class="bx bxs-group bx-sm"></i></div>
                        <div class="text-wrap me-1">
                            <p class="text-muted mb-0">' . $data[$key]['user_first_name'] . ' ' . $data[$key]['user_last_name'] . '<br>' . $sourceType[$found_key]['name'] . '</p>
                        </div>
                    </div>
                </div>';

            $data[$key]['phone_number'] = '<h5 class="font-size-14 mb-1">' . $data[$key]['phone_number'] . '</h5><div class="row">
                </div>';

            $data[$key]['city_id'] = "<p>" . $data[$key]['city_list_name'] . '</p>';
            $data[$key]['created_by'] = "<p class='text-muted mb-0'>" . $data[$key]['user_first_name'] . ' ' . $data[$key]['user_last_name'] . "</p>";
            $data[$key]['assign_to'] = "<p class='text-muted mb-0'>" . $data[$key]['user_first_name'] . ' ' . $data[$key]['user_last_name'] . "</p>";

            $next_status = (int) $data[$key]['status'] + 1;
            $data[$key]['status'] = '<button type="button" class="btn btn-primary waves-effect waves-light btn-sm" onclick="changeStatus(' . $next_status . ',' . $data[$key]['inquiry_id'] . ')">';
            $data[$key]['status'] .= $inquiryStatus[$next_status]['name'];
            $data[$key]['status'] .= '</button>';
        }

        $jsonData = array(
            "draw" => intval($request['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($recordsTotal), // total number of records
            "recordsFiltered" => intval($recordsFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data, // total data array
        );
        return $jsonData;
    }

    public function detail(Request $request) {
        $InquiryQuestion = InquiryQuestion::select('*')->find($request->id);
        if ($InquiryQuestion) {
            if ($InquiryQuestion->type == 1) {
                $InquiryQuestion['inquiry_question_option'] = InquiryQuestionOption::select('*')->where('inquiry_question_id', $InquiryQuestion->id)->get();
            }
            $response = successRes("Successfully get Inquiry Question");
            $response['data'] = $InquiryQuestion;
        } else {
            $response = errorRes("Invalid id");
        }
        return response()->json($response)->header('Content-Type', 'application/json');
    }

    public function inquiryDetail(Request $request) {
        $Inquiry = Inquiry::select('*')->find($request->id);
        if ($Inquiry) {
            $response = successRes("Successfully get Inquiry");
            $response['data'] = $Inquiry;
        } else {
            $response = errorRes("Invalid id");
        }
        return response()->json($response)->header('Content-Type', 'application/json');
    }

    public function inquiryQuestions(Request $request) {
        $InquiryQuestionResponse = array();
        $InquiryQuestions = InquiryQuestion::where('status', $request->status)->get();

        if ($InquiryQuestions) {
            foreach ($InquiryQuestions as $InquiryQuestionKey => $InquiryQuestionValue) {
                $InquiryQuestionResponse[$InquiryQuestionKey]['question'] = $InquiryQuestionValue;
                $InquiryQuestionResponse[$InquiryQuestionKey]['question_option'] = InquiryQuestionOption::where('inquiry_question_id', $InquiryQuestionValue->id)->get();
            }

            $response = successRes("Successfully get Inquiry Questions");
            $response['data'] = $InquiryQuestionResponse;
        } else {
            $response = errorRes("Invalid id");
        }
        return response()->json($response)->header('Content-Type', 'application/json');
    }

    public function delete(Request $request) {
        $InquiryQuestion = InquiryQuestion::find($request->id);
        if ($InquiryQuestion) {
            $debugLog = array();
            $debugLog['name'] = "inquiry-question-delete";
            $debugLog['description'] = "inquiry question #" . $InquiryQuestion->id . "(" . $InquiryQuestion->question . ") has been deleted";

            saveDebugLog($debugLog);

            $InquiryQuestionOption = InquiryQuestionOption::where('inquiry_question_id', $InquiryQuestion->id)->get();
            if (count($InquiryQuestionOption) > 0) {
                $InquiryQuestionOption = InquiryQuestionOption::where('inquiry_question_id', $InquiryQuestion->id)->delete();
            }
            $InquiryQuestion->delete();
        }
        $response = successRes("Successfully delete Inquiry Question");
        return response()->json($response)->header('Content-Type', 'application/json');
    }

    public function searchUser(Request $request) {
        $User = $UserResponse = array();
        $q = $request->q;
        $User = User::select('users.id', 'users.first_name', 'users.last_name', DB::raw("CONCAT(users.first_name,' ',users.last_name) AS full_name"));

        $User->where('users.type', $request->source_type);
        $User->where(function ($query) use ($q) {
            $query->where('users.first_name', 'like', '%' . $q . '%');
            $query->orWhere('users.last_name', 'like', '%' . $q . '%');
        });
        $User->limit(5);
        $User = $User->get();

        if (count($User) > 0) {
            foreach ($User as $User_key => $User_value) {
                $UserResponse[$User_key]['id'] = $User_value['id'];
                $UserResponse[$User_key]['text'] = $User_value['full_name'];
            }
        }
        $response = array();
        $response['results'] = $UserResponse;
        $response['pagination']['more'] = false;
        return response()->json($response)->header('Content-Type', 'application/json');
    }

    public function saveInquiryAnswer(Request $request) {
        
        #make qustion answer validation rules
        $rules = array();
        $questionIds = array_keys($request->question_type);
        $InquiryQuestions = InquiryQuestion::whereIn('id', $questionIds)->get();        
        if (count($InquiryQuestions) > 0) {
            foreach ($InquiryQuestions as $InquiryQuestionsKey => $InquiryQuestionsValue) {
                if ($InquiryQuestionsValue->is_required == 1 && $InquiryQuestionsValue->type == 2) {
                    $rules['question.' . $InquiryQuestionsValue->id] = 'required|mimes:png,jpg,jpeg,csv,txt,xlx,xls,pdf';
                } elseif ($InquiryQuestionsValue->is_required == 1) {
                    $rules['question.' . $InquiryQuestionsValue->id] = 'required';
                }
            }
        }              
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $response = array();
            $response['status'] = 0;
            $response['msg'] = "The request could not be understood by the server due to malformed syntax";
            $response['statuscode'] = 400;
            $response['data'] = $validator->errors();

            return response()->json($response)->header('Content-Type', 'application/json');
        } else {

            //create a answer array
            $inquiry_question_answer = array();
            foreach ($request->question_type as $question_id => $question_type) {
                $inquiry_question_answer[$question_id]['inquiry_question_id'] = $question_id;
                $inquiry_question_answer[$question_id]['inquiry_id'] = $request->inquiry_id;
                $inquiry_question_answer[$question_id]['user_id'] = Auth::id();
                
                if ($question_type == 2) {
                    $question_attachment_file_name = '';
                    if ($request->hasFile('question.' . $question_id)) {

                        $question_attachment = $request->file('question.' . $question_id);
                        $extension = $question_attachment->getClientOriginalExtension();

                        $question_attachment_file_name = time() . mt_rand(10000, 99999) . '.' . $extension;

                        $destinationPath = public_path('/s/question_attachment');
                        $question_attachment->move($destinationPath, $question_attachment_file_name);

                        if (!File::exists('s/question_attachment/' . $question_attachment_file_name)) {
                            $question_attachment_file_name = "";
                        } else {
                            $question_attachment_file_name = 's/question_attachment/' . $question_attachment_file_name;
                        }
                    }
                    $inquiry_question_answer[$question_id]['answer'] = $question_attachment_file_name;
                } elseif ($question_type == 3) {
                    $answerIsCheked = (isset($request->question[$question_id]) && $request->question[$question_id] == 'on') ? 1 : 0;
                    $inquiry_question_answer[$question_id]['answer'] = $answerIsCheked;
                } else {
                    $inquiry_question_answer[$question_id]['answer'] = $request->question[$question_id];
                }

                $inquiry_question_answer[$question_id]['created_at'] = date("Y-m-d H:i:s", strtotime('now'));
                $inquiry_question_answer[$question_id]['updated_at'] = date("Y-m-d H:i:s", strtotime('now'));
            }

            $InquiryQuestionAnswer = new InquiryQuestionAnswer();
            $InquiryQuestionAnswer->insert($inquiry_question_answer);
            if ($InquiryQuestionAnswer) {

                if ($request->inquiry_id != 0) {
                    $Inquiry = Inquiry::find($request->inquiry_id);
                    $Inquiry->status = $request->inquiry_status;
                    $Inquiry->save();
                    $response = successRes("Successfully Inquiry Status changed");

                    $debugLog = array();
                    $debugLog['name'] = "inquiry-edit";
                    $debugLog['description'] = "inquiry #" . $Inquiry->id . "(" . $Inquiry->status . ") has been updated ";
                    saveDebugLog($debugLog);
                }
            }
        }
        return response()->json($response)->header('Content-Type', 'application/json');
    }

}
