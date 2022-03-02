@extends('layouts.main')
@section('title', $data['title'])
@section('content')

                <div class="page-content">
                    <div class="container-fluid">                       
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Inquiry</h4>
                                    <div class="page-title-right">
                                        <button id="addBtnInquiry" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalInquiry" role="button"><i class="bx bx-plus font-size-16 align-middle me-2"></i>Inquiry</button>                                        

                                        <!-- start model popup-->
                                        <div class="modal fade" id="modalInquiry" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalInquiryLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalInquiryLabel">Inquiry</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form  id="formInquiry" action="{{route('inquiry.save')}}" method="POST"  class="needs-validation" novalidate>
                                                        <div class="modal-body">
                                                            @csrf
                                                            <input type="hidden" name="inquiry_id" id="inquiry_id">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="inquiry_first_name" class="form-label">First name</label>
                                                                        <input type="text" class="form-control" id="inquiry_first_name" name="inquiry_first_name"
                                                                               placeholder="First name" value="" required >
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="inquiry_last_name" class="form-label">Last name</label>
                                                                        <input type="text" class="form-control" id="inquiry_last_name" name="inquiry_last_name"
                                                                               placeholder="Last name" value="" required>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">                                                                
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="inquiry_phone_number" class="form-label">Phone number</label>
                                                                        <div class="input-group">
                                                                            <input type="number" class="form-control" id="inquiry_phone_number" name="inquiry_phone_number"
                                                                                   placeholder="Phone number" value="" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label for="inquiry_country_id" class="form-label">Country</label>
                                                                        <select class="form-select" id="inquiry_country_id" name="inquiry_country_id" required >
                                                                            <option selected value="1">India</option>

                                                                        </select>
                                                                        <div class="invalid-feedback">
                                                                            Please select country.
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="mb-3 ajax-select mt-3 mt-lg-0">
                                                                        <label class="form-label">State </label>
                                                                        <select class="form-control select2-ajax select2-state" id="inquiry_state_id" name="inquiry_state_id" required >
                                                                        </select>
                                                                        <div class="invalid-feedback">
                                                                            Please select state.
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="mb-3 ajax-select mt-3 mt-lg-0">
                                                                        <label class="form-label">City </label>
                                                                        <select class="form-control select2-ajax select2-state" id="inquiry_city_id" name="inquiry_city_id" required >
                                                                        </select>
                                                                        <div class="invalid-feedback">
                                                                            Please select city.
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="inquiry_pincode" class="form-label">Pincode</label>
                                                                        <input type="text" class="form-control" id="inquiry_pincode" name="inquiry_pincode"
                                                                               placeholder="Pincode" value="" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="inquiry_address_line1" class="form-label">Address line 1</label>
                                                                        <input type="text" class="form-control" id="inquiry_address_line1" name="inquiry_address_line1"
                                                                               placeholder="Address line 1" value="" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="inquiry_address_line2" class="form-label">Address line 2</label>
                                                                        <input type="text" class="form-control" id="inquiry_address_line2" name="inquiry_address_line2"
                                                                               placeholder="Address line 2" value="" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="inquiry_source_type" class="form-label">Source Type</label>
                                                                        @php
                                                                            $userTypes=getUserTypes();
                                                                            $channelPartners = getChannelPartners();
                                                                            $sourceType = array_merge($userTypes,$channelPartners);
                                                                        @endphp
                                                                        <select class="form-control select2-ajax" id="inquiry_source_type" name="inquiry_source_type" required >
                                                                        @if(count($sourceType)>0)
                                                                            @foreach($sourceType as $key=>$value)
                                                                                <option value="{{$value['id']}}">{{$value['name']}}</option>
                                                                            @endforeach
                                                                        @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="inquiry_source" class="form-label">Source</label>
                                                                        <select class="form-control select2-ajax" id="inquiry_source" name="inquiry_source" required >
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>                                                            
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end model popup-->
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        @include('../inquiry/tab')
                                        <br>
                                        <table id="datatable" class="table table-striped dt-responsive  nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Phone Number</th>
                                                <th>City</th>
                                                <th>Assigned to</th>
                                                <th>Created by</th>
                                                <th>Status</th>
                                              
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>  <!-- end col -->
                        </div><!--̧̧end row--> 
                        
                        <!-- start inquiry status change model-->
                        <div class="modal fade" id="modalStatusChange" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalStatusChangeLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" > Question </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <form  id="formInquiryStatusChange" action="{{route('inquiry.answer.save')}}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data" >
                                        @csrf
                                        <div class="modal-body" id="inquiry_quastion_body">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <button id="submit" type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End inquiry status change model-->

                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

    @csrf
@endsection('content')
@section('custom-scripts')
<script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
<script src="{{ asset('assets/js/pages/jquery.form.js') }}"></script>
<script type="text/javascript">

var ajaxURL='{{route('inquiry.ajax')}}';
var ajaxURLSearchState='{{route('users.search.state')}}';
var ajaxURLSearchCity='{{route('users.search.city')}}';
var ajaxURLSearchUser = '{{route('users.search')}}';
var ajaxURLInquiryDetail = '{{route('inquiry.detail')}}';
var ajaxURLInquiryQuestions = '{{route('inquiry.questions')}}';

var csrfToken=$("[name=_token").val();

//open when add new inquiry
$("#addBtnInquiry").click(function() {
    resetInputForm();
    $("#modalInquiryLabel").html("Add Inquiry");
    $("#inquiry_id").val(0);
    $(".loadingcls").hide();
    $("#formInquiry .row").show();
    $("#modalInquiry .modal-footer").show();
});

//reset all the element in form when open popup
function resetInputForm(){
     $('#formInquiry').trigger("reset"); 
     $("#inquiry_country_id").select2("val", "1");
     $("#inquiry_source_type").select2("val", "0");
     $("#inquiry_source").empty().trigger('change');
     $("#inquiry_state_id").empty().trigger('change');
     $("#inquiry_city_id").empty().trigger('change');
     $("#formInquiry").removeClass('was-validated');                     
}

//select2-apply
$("#inquiry_country_id").select2({
    minimumResultsForSearch: Infinity,
    dropdownParent: $("#modalInquiry .modal-body")
});

$(".inquiry_status").select2({
    minimumResultsForSearch: Infinity,
    dropdownParent: $("#datatable")
});

$('#inquiry_country_id').on('change', function() {
     $("#inquiry_state_id").empty().trigger('change');
     $("#inquiry_city_id").empty().trigger('change');
});

$("#inquiry_state_id").select2({
    ajax: {
        url: ajaxURLSearchState,
        dataType: 'json',
        delay: 0,
        data: function (params) {
          return {
            "country_id":  function() { return $("#inquiry_country_id").val()},
            q: params.term, // search term
            page: params.page
          };
        },
        processResults: function (data, params) {
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            params.page = params.page || 1;
            return {
                results: data.results,
                pagination: {
                    more: (params.page * 30) < data.total_count
                }
            };
        },
        cache: false
    },
    placeholder: 'Search for a state',
    minimumInputLength: 1,
    dropdownParent: $("#modalInquiry .modal-body")
});

$('#inquiry_state_id').on('change', function() {
    $("#inquiry_city_id").empty().trigger('change');
});

$("#inquiry_city_id").select2({
  ajax: {
    url: ajaxURLSearchCity,
    dataType: 'json',
    delay: 0,
    data: function (params) {
      return {
        "country_id":  function() { return $("#inquiry_country_id").val()},
        "state_id":  function() { return $("#inquiry_state_id").val()},
        q: params.term, // search term
        page: params.page
      };
    },
    processResults: function (data, params) {
      // parse the results into the format expected by Select2
      // since we are using custom formatting functions we do not need to
      // alter the remote JSON data, except to indicate that infinite
      // scrolling can be used
      params.page = params.page || 1;

      return {
        results: data.results,
        pagination: {
          more: (params.page * 30) < data.total_count
        }
      };
    },
    cache: false
  },
  placeholder: 'Search for a city',
  minimumInputLength: 1,
  dropdownParent: $("#modalInquiry .modal-body")
});

$("#inquiry_source_type").select2({
    minimumResultsForSearch: Infinity,
    dropdownParent: $("#modalInquiry .modal-body")
});

$('#inquiry_source_type').on('change', function() {
     $("#inquiry_source").empty().trigger('change');
});

$("#inquiry_source").select2({
    ajax: {
        url: ajaxURLSearchUser,
        dataType: 'json',
        delay: 0,
        data: function (params) {
          return {
            "source_type":  function() { return $("#inquiry_source_type").val()},
            q: params.term, // search term
            page: params.page
          };
        },
        processResults: function (data, params) {
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            params.page = params.page || 1;
            return {
                results: data.results,
                pagination: {
                    more: (params.page * 30) < data.total_count
                }
            };
        },
        cache: false
    },
    placeholder: 'Search for a user',
    minimumInputLength: 1,
    dropdownParent: $("#modalInquiry .modal-body")
});

$(document).ready(function() {
    var options = {
        beforeSubmit: showRequest, // pre-submit callback
        success: showResponse // post-submit callback

        // other available options:
        //url:       url         // override for form's 'action' attribute
        //type:      type        // 'get' or 'post', override for form's 'method' attribute
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
        //clearForm: true        // clear all form fields after successful submit
        //resetForm: true        // reset the form after successful submit

        // $.ajax options can be used here too, for example:
        //timeout:   3000
    };

    // bind form using 'ajaxForm'
    $('#formInquiry').ajaxForm(options);
    $('#formInquiryStatusChange').ajaxForm(options);
});

function showRequest(formData, jqForm, options) {

    // formData is an array; here we use $.param to convert it to a string to display it
    // but the form plugin does this for you automatically when it submits the data
    var queryString = $.param(formData);

    // jqForm is a jQuery object encapsulating the form element.  To access the
    // DOM element for the form do this:
    // var formElement = jqForm[0];

    // alert('About to submit: \n\n' + queryString);

    // here we could return false to prevent the form from being submitted;
    // returning anything other than false will allow the form submit to continue
    return true;
}

// post-submit callback
function showResponse(responseText, statusText, xhr, $form) {

    if (responseText['status'] == 1) {
        toastr["success"](responseText['msg']);
        reloadTable();
        resetInputForm();
        $("#modalInquiry").modal('hide');
        $("#modalStatusChange").modal('hide');

    } else if (responseText['status'] == 0) {
        toastr["error"](responseText['msg']);
    }

    // for normal html responses, the first argument to the success callback
    // is the XMLHttpRequest object's responseText property

    // if the ajaxForm method was passed an Options Object with the dataType
    // property set to 'xml' then the first argument to the success callback
    // is the XMLHttpRequest object's responseXML property

    // if the ajaxForm method was passed an Options Object with the dataType
    // property set to 'json' then the first argument to the success callback
    // is the json data object returned by the server

    // alert('status: ' + statusText + '\n\nresponseText: \n' + responseText +
    //     '\n\nThe output div should have already been updated with the responseText.');
}

var table=$('#datatable').DataTable({
//  "aoColumnDefs": [{ "bSortable": false, "aTargets": [5] }],
    "order":[[ 0, 'desc' ]],
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": ajaxURL,
      "type": "POST",
       "data": {
          "_token": csrfToken,
          }
    },
    "aoColumns" : [
      {"mData" : "id"},
      {"mData" : "first_name"},
      {"mData" : "phone_number"},
      {"mData" : "city_id"},
      {"mData" : "created_by"},
      {"mData" : "assign_to"},
      {"mData" : "status"}
    ], 
});

function reloadTable() {
    table.ajax.reload();
}

function editView(id) {
    editModeLoading = 1;
    resetInputForm();

    $("#modalInquiry").modal('show');
    $("#modalInquiryLabel").html("Edit Inquiry #" + id);
    $("#formInquiry .row").hide();
    $(".loadingcls").show();
    $("#modalInquiry .modal-footer").hide();

    $.ajax({
    type: 'GET',
            url: ajaxURLInquiryDetail + "?id=" + id,
            success: function(resultData) {                
                if (resultData['status'] == 1) {
                    $("#inquiery_questions_id").val(resultData['data']['id']);
                    $("#inquiry_first_name").val(resultData['data']['first_name']);
                    $("#inquiry_last_name").val(resultData['data']['last_name']);
                    $("#inquiry_phone_number").val(resultData['data']['phone_number']);
                    
//                    $("#inquiry_last_name").select2("val", "" + resultData['data']['status'] + "");
//                    $("#inquiry_phone_number").select2("val", "" + resultData['data']['type'] + "");
//                    $("#inquiery_questions_is_static").select2("val", "" + resultData['data']['is_static'] + "");
//                    $("#inquiery_questions_is_required").select2("val", "" + resultData['data']['is_required'] + "");


                    $("#inquiry_pincode").val(resultData['data']['phone_number']);
                    $("#inquiry_address_line1").val(resultData['data']['address_line1']);
                    $("#inquiry_address_line2").val(resultData['data']['address_line2']);
                    
                    $(".loadingcls").hide();
                    $("#formInquiry .row").show();
                    $("#modalInquiry .modal-footer").show();
                    editModeLoading = 0;                                         
                } else {
                    toastr["error"](resultData['msg']);
                }
            }
    });
}


function deleteWarning(url){
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: !0,
            confirmButtonColor: "#34c38f",
            cancelButtonColor: "#f46a6a",
            confirmButtonText: "Yes, delete it!"
        }).then(function(t) {
            if(t.value ===true){
                 window.location = url;
            }
            //t.value && Swal.fire("Deleted!", "Your file has been deleted.", "success")
        })
}


function changeStatus(type,id) {

        $('#formInquiryStatusChange').trigger("reset");
        $("#formInquiryStatusChange").removeClass('was-validated');
    
	$.ajax({
		type: 'GET',
		url: ajaxURLInquiryQuestions + "?status=" + type,
		success: function(resultData) {                    
			if (resultData['status'] == 1) {
				$("#modalStatusChange").modal('show');
                                
                                var html = '';
                                $("#inquiry_quastion_body").html(html);                                
                                html += '<input type="hidden" name="inquiry_id" id="inquiry_id" value='+id+'>';
                                html += '<input type="hidden" name="inquiry_status" id="inquiry_id" value='+type+'>';
                                $.each(resultData['data'], function( key, value ) {
                                    
                                    var isRequired = (value['question']['is_required'] == 1) ? "required":" ";
                                    
                                    html += '<div class="row">';
                                    html += '<div class="col-md-12">';
                                    html += '<div class="card mb-1">';
                                    html += '<div class="card-body mt-0 px-0 py-2">';
                                    
                                    html += '<div>';
                                    html += '<input type="hidden" name="question_type['+value['question']['id']+']" value='+value['question']['type']+'>';
                                    if(value['question']['type'] != 3){
                                        html += '<p class="text-muted mb-2">';                                        
                                        html += value['question']['question'];
                                        html += '</p>';
                                    }
                                    if(value['question']['type'] == 0){
                                        html += '<input type="text" name="question['+value['question']['id']+']" class="form-control" placeholder="Enter you answer" '+isRequired+'/>';
                                    }else if (value['question']['type'] == 1) {
                                        html += '<select class="form-select" name="question['+value['question']['id']+']" '+isRequired+'>';
                                        $.each(value['question_option'], function( question_option_key, question_option_value ) {                                            
                                            html += '<option value="'+question_option_value['option']+'">'+question_option_value['option']+'</option>';
//                                            html += '<option value="'+question_option_value['id']+'">'+question_option_value['option']+'</option>';
                                        });
                                        html += '</select>';                                                   
                                    }else if (value['question']['type'] == 2) {
                                        html += '<input type="file" name="question['+value['question']['id']+']" class="form-control" '+isRequired+'/>';
                                    }else if (value['question']['type'] == 3) {
                                        html += '<p class="text-muted mb-2">';                                        
                                        html += value['question']['question'];
                                        html += '&nbsp;&nbsp;';
                                        html += '<input class="form-check-input" type="checkbox" name="question['+value['question']['id']+']" '+isRequired+'>';
                                        html += '</p>';
                                    }
                                    html += '</div>';
                                    
                                    html += '</div>';                                    
                                    html += '</div>';                                    
                                    html += '</div>';                                    
                                    html += '</div>';                                    
                                });

				$("#inquiry_quastion_body").html(html);//				
			} else {
				toastr["error"](resultData['msg']);
			}
		}
	});
}
</script>
@endsection