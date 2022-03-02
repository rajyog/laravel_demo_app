@extends('layouts.main')
@section('title', $data['title'])
@section('content')

<div class="page-content">
    <div class="container-fluid">
        @php
        $inquiryStatus=getInquiryStatus();
        @endphp
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Inquiry Question</h4>
                    <div class="page-title-right">
                        <button id="addBtnInquiryQuestion" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalInquiry" role="button"><i class="bx bx-plus font-size-16 align-middle me-2"></i>Inquiry Question</button>
                        <div class="modal fade" id="modalInquiry" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalInquiryLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalInquiryLabel">Inquiry Question</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form  id="formInquiryQuestion" action="{{route('inquiry.question.save')}}" method="POST"  class="needs-validation repeater" novalidate>
                                        <div class="modal-body">
                                            @csrf
                                            <div class="col-md-12 text-center loadingcls">
                                                <button type="button" class="btn btn-light waves-effect">
                                                    <i class="bx bx-hourglass bx-spin font-size-16 align-middle me-2"></i> Loading
                                                </button>
                                            </div>
                                            <input type="hidden" name="inquiery_questions_id" id="inquiery_questions_id">                                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">                                                        
                                                        <label for="inquiery_questions_status" class="form-label">Inquiry Status</label>
                                                        <select class="form-select select2-apply" id="inquiery_questions_status" name="inquiery_questions_status">
                                                            @foreach($inquiryStatus as $key=>$value)
                                                            @if($value['id'] != 0)                                                         
                                                            <option value="{{$value['id']}}">{{$value['name']}}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">                                                                
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="inquiery_questions_type" class="form-label">Question Type</label>
                                                        <select class="form-select select2-apply" id="inquiery_questions_type" name="inquiery_questions_type" > 
                                                            <option value="0">Text</option>
                                                            <option value="1">Option</option>
                                                            <option value="2">File</option>
                                                            <option value="3">checkbox</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="sec_inquiery_questions_question">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="inquiery_questions" class="form-label">Question</label>
                                                        <textarea id="inquiery_questions_question" name="inquiery_questions_question" class="form-control" rows="3"></textarea>                                                                        
                                                    </div>
                                                </div>
                                            </div>
<!--                                            <div class="row" id="sec_inquiery_questions_options">                                                                
                                                <div class="col-md-12">
                                                    <div class="inner-repeater mb-3">
                                                        <div data-repeater-list="inner_group" class="inner mb-3">
                                                            <label>Question Option:</label>
                                                            <div data-repeater-item class="inner mb-3 row">
                                                                <div class="col-md-10 col-8">
                                                                    <input type="text" name="question_option" id="question_option" class="inner form-control"/>
                                                                </div>
                                                                <div class="col-md-2 col-4">
                                                                    <div class="d-grid">
                                                                        <input data-repeater-delete type="button" class="btn btn-primary inner" value="Delete"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input data-repeater-create type="button" class="btn btn-success inner" value="Add New Option"/>
                                                    </div>
                                                </div>
                                            </div>-->

                                            <div class="row" id="sec_inquiery_questions_options">                                                                
                                                <div class="col-md-12">                                                    
                                                    <label>Question Option:</label>
                                                    <div class="inner-default">
                                                        <div class="element mb-3 row" id='option_1'>
                                                            <div class="col-md-10 col-8">
                                                                <input type="text" name="question_option[1]" id="question_option_1"  class="form-control"/>
                                                                <input type="hidden" name="question_option_id[1]" id="question_option_id_1"  class="form-control"/>
                                                            </div>
                                                            <div class="col-md-2 col-4">
                                                                <div class="d-grid">
                                                                    <input type="button" class="btn btn-primary remove" id="remove_1" value="Delete"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="inner-dynamic">
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="button" class="btn btn-success" id="addMoreOption" value="Add New Option"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="inquiery_questions_is_static" class="form-label">Answer Type</label>
                                                        <select class="form-select select2-apply" id="inquiery_questions_is_static" name="inquiery_questions_is_static">
                                                            <option value="1">Dynamic</option>
                                                            <option value="0">Static</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="inquiery_questions_is_required" class="form-label">Answer Required</label>
                                                        <select class="form-control select2-apply" id="inquiery_questions_is_required" name="inquiery_questions_is_required">
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
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
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- start filter section-->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" id="status_id">
                                            <option value="">ALL</option>
                                            @foreach($inquiryStatus as $key=>$value)
                                            @if($value['id'] != 0)                                                         
                                            <option value="{{$value['id']}}">{{$value['name']}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end filter section-->

        <!-- start datatable section -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable" class="table table-striped dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Question</th>                                    
                                    <th>Is Static</th>
                                    <th>Required</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end datatable section -->

    </div>
    <!-- container-fluid -->
</div>
<!-- End Page-content -->

@csrf
@endsection('content')
@section('custom-scripts')
<style>
    .isDisabled {
        color: currentColor;
        opacity: 0.5;
        text-decoration: none;
        pointer-events: none;
    }
</style>
<script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
<script src="{{ asset('assets/js/pages/jquery.form.js') }}"></script>
<!-- form repeater js -->

<script type="text/javascript">

var ajaxURL = '{{route('inquiry.question.ajax')}}';
var ajaxURLInquiryQuestionDetail = '{{route('inquiry.question.detail')}}';
var ajaxInquiryQuestionDeleteURL = '{{route('inquiry.question.delete')}}';
var csrfToken = $("[name=_token").val();

$("#addBtnInquiryQuestion").click(function () {
resetInputForm();
$('.inner-dynamic').html('');
$("#modalInquiryLabel").html("Add Inquiry Question");
$(".loadingcls").hide();
$("#inquiery_questions_id").val(0);
});

function resetInputForm() {
$('#formInquiryQuestion').trigger("reset");
$("#inquiery_questions_status").select2("val", "1");
$("#inquiery_questions_type").select2("val", "0");
$("#inquiery_questions_is_static").select2("val", "1");
$("#inquiery_questions_is_required").select2("val", "1");
$("#formInquiryQuestion").removeClass('was-validated');
}

//select2-apply
$("#inquiery_questions_status").select2({
minimumResultsForSearch: Infinity,
        dropdownParent: $("#modalInquiry .modal-body")
});
$("#inquiery_questions_type").select2({
minimumResultsForSearch: Infinity,
        dropdownParent: $("#modalInquiry .modal-body")
});
$("#inquiery_questions_is_static").select2({
minimumResultsForSearch: Infinity,
        dropdownParent: $("#modalInquiry .modal-body")
});
$("#inquiery_questions_is_required").select2({
minimumResultsForSearch: Infinity,
        dropdownParent: $("#modalInquiry .modal-body")
});

$("#sec_inquiery_questions_options").hide();
$('#inquiery_questions_type').on('change', function () {
if ($(this).val() == 1) {
$("#sec_inquiery_questions_options").show();
} else {
$("#sec_inquiery_questions_options").hide();
}
});

$(document).ready(function () {
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
$('#formInquiryQuestion').ajaxForm(options);
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

var table = $('#datatable').DataTable({
"aoColumnDefs": [{"bSortable": false, "aTargets": [6]}],
        "order": [[0, 'desc']],
        "processing": true,
        "serverSide": true,
        "ajax": {
        "url": ajaxURL,
                "type": "POST",
                "data": {
                "_token": csrfToken,
                        "status_id":  function() { return $("#status_id").val() },
                }
        },
        "aoColumns": [
        {"mData": "id"},
        {"mData": "status"},
        {"mData": "type"},
        {"mData": "question"},
        {"mData": "is_static"},
        {"mData": "is_required"},
        {"mData": "action"}
        ]
});
function reloadTable() {
table.ajax.reload();
}

function applyFilter() {
reloadTable();
}

$('#status_id').on('change', function() {
applyFilter();
});
function editView(id) {
editModeLoading = 1;
resetInputForm();
$("#modalInquiry").modal('show');
$("#modalInquiryLabel").html("Edit Inquiry Question #" + id);
$("#formInquiryQuestion .row").hide();
$(".loadingcls").show();
$("#modalInquiry .modal-footer").hide();
$.ajax({
type: 'GET',
        url: ajaxURLInquiryQuestionDetail + "?id=" + id,
        success: function(resultData) {
        console.log(resultData);
        if (resultData['status'] == 1) {
        $("#inquiery_questions_id").val(resultData['data']['id']);
        $("#inquiery_questions_question").val(resultData['data']['question']);
        $("#inquiery_questions_status").select2("val", "" + resultData['data']['status'] + "");
        $("#inquiery_questions_type").select2("val", "" + resultData['data']['type'] + "");
        $("#inquiery_questions_is_static").select2("val", "" + resultData['data']['is_static'] + "");
        $("#inquiery_questions_is_required").select2("val", "" + resultData['data']['is_required'] + "");
        $(".loadingcls").hide();
        $("#formInquiryQuestion .row").show();
        $("#modalInquiry .modal-footer").show();
        editModeLoading = 0;
        if (resultData['data']['type'] != 1){
        $("#sec_inquiery_questions_options").hide();
        } else{

        //create a repetor element
//        var inquiry_question_option_list = [];
//        $.each(resultData['data']['inquiry_question_option'], function(key, value) {
//        inquiry_question_option_list.push({ 'text-input': value['option']});
//                                inquiry_question_option_list.push([{ 'id': 'yogesh','val': value['option'] }]);
//                                inquiry_question_option_list.push({ 'hidden-input': value['option']});
//        });
//        $repeater.setList(inquiry_question_option_list);
        //assign value to repetor element
        $.each(resultData['data']['inquiry_question_option'], function(key, value) {
            $('.inner-dynamic').html('');
            //first time set value in default html
            if(key == 0){
                $('#question_option_1').val(value['option']); 
                $('#question_option_id_1').val(value['id']); 
                $('#question_option_1').attr("data-id",value['id']);                 
            }else{
                
                var option_row = '';
                var keyIndex = key+1;
                var nextindex = key+1;
                
                option_row += '<div class="element mb-3 row" id="option_'+nextindex+'">'
                option_row += '<div class="col-md-10 col-8">'
                option_row += '<input type="text" name="question_option[]" id="question_option_'+keyIndex+'" class="form-control" value="'+value['option']+'" data-id="'+value['id']+'"/>'
                option_row += '<input type="hidden" name="question_option_id[]" id="question_option_id_'+keyIndex+'" value="'+value['id']+'" class="form-control"/>'
                option_row += '</div>'
                option_row += '<div class="col-md-2 col-4">'
                option_row += '<div class="d-grid">'
                option_row += '<input type="button" class="btn btn-primary remove" id="remove_'+ nextindex +'" value="Delete"/>'
                option_row += '</div>'
                option_row += '</div>'
                option_row += '</div>'

                $('.inner-dynamic').append(option_row);                
            }
         });
        }
        } else {
        toastr["error"](resultData['msg']);
        }
        }
});
}

function deleteWarning(id) {
Swal.fire({
title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        confirmButtonClass: "btn btn-success mt-2",
        cancelButtonClass: "btn btn-danger ms-2 mt-2",
        loaderHtml: "<i class='bx bx-hourglass bx-spin font-size-16 align-middle me-2'></i> Loading",
        customClass: {
        confirmButton: 'btn btn-primary btn-lg',
                cancelButton: 'btn btn-danger btn-lg',
                loader: 'custom-loader'
        },
        buttonsStyling: !1,
        preConfirm: function(n) {
        return new Promise(function(t, e) {
        Swal.showLoading()
                $.ajax({
                type: 'GET',
                        url: ajaxInquiryQuestionDeleteURL + "?id=" + id,
                        success: function(resultData) {
                        if (resultData['status'] == 1) {
                        reloadTable();
                        t()
                        }
                        }
                });
        })
        },
}).then(function(t) {
if (t.value === true) {
Swal.fire({
title: "Deleted!",
        text: "Your record has been deleted.",
        icon: "success"
});
}
});
}

$("#addMoreOption").click(function () {
  // Finding total number of elements added
  var total_element = $(".element").length;
    var lastid = $(".element:last").attr("id");
    var split_id = lastid.split("_");
    var nextindex = Number(split_id[1]) + 1;
  console.log("Test1"+ nextindex);

    var option_row = '';
        option_row += '<div class="element mb-3 row" id="option_'+nextindex+'">'
        option_row += '<div class="col-md-10 col-8">'
        option_row += '<input type="text" name="question_option['+nextindex+']" class="form-control"/>'
        option_row += '<input type="hidden" name="question_option_id['+nextindex+']" id="question_option_id_'+nextindex+'" class="form-control"/>'
        option_row += '</div>'
        option_row += '<div class="col-md-2 col-4">'
        option_row += '<div class="d-grid">'
        option_row += '<input type="button" class="btn btn-primary remove" id="remove_'+ nextindex +'" value="Delete"/>'
        option_row += '</div>'
        option_row += '</div>'
        option_row += '</div>'

        $('.inner-dynamic').append(option_row);
});

//$(".remove").click(function () {


$(document).on('click','.remove',function(){
 
  var id = this.id;
  var split_id = id.split("_");
  var deleteindex = split_id[1];

  $("#option_" + deleteindex).remove();

}); 

</script>
@endsection