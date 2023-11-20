
<div class="row mb-3">
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'law_court';
            $field_lable = __("Select Law Court");
            $field_relation = "law_court";
            $field_placeholder = __("Select Law Court");
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, isset($$module_name_singular)?$lawcourts:'')->placeholder($field_placeholder)->class('form-control select2-law_court')->attributes(["$required"]) }}
        </div>
    </div>
    <div class=" col-4">
        <div class="form-group">
            <?php
            $field_name = 'unit';
            $field_lable = __("Select Station");
            $field_relation = "law_court";
            $field_placeholder = __("Select Court Station");
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, isset($$module_name_singular)?optional($$module_name_singular->$field_relation)->pluck('name', 'id'):'')->placeholder($field_placeholder)->class('form-control select2-unit')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'unit_division';
            $field_lable = __("Select Division");
            $field_relation = "unit_division";
            $field_placeholder = __("Select an Court Division");
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, isset($$module_name_singular)?optional($$module_name_singular->$field_relation)->pluck('name', 'id'):'')->placeholder($field_placeholder)->class('form-control select2-unit_division')->attributes(["$required"]) }}
        </div>
    </div>
</div>



<div class="row mb-3">
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'code';
            $field_lable = __("Select Case Code");
            $field_placeholder = __("Select an option");
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, isset($$module_name_singular)?optional($$module_name_singular->$field_relation)->pluck('name', 'id'):'')->placeholder($field_placeholder)->class('form-control select2-code')->attributes(["$required", "onchange='validate()'"]) }}
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'case_index';
            $field_lable = __("Select Case Index");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", "onchange='validate()'"]) }}
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'year';
            $field_lable = __("Year");
            $field_placeholder = __("Select an option");
            $required = "required";

            $year=date('Y');
            $select_options=[];
            for($i=$year; $i>0; $i--)
            {
                $select_options[$i] = $i;

                // array_push($select_options,array($i=>$i));
            }

            // $select_options = [
            //     'Article' => 'Article',
            //     'Feature' => 'Feature',
            //     'News' => 'News',
            // ];
            // dd($select_options)
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2-year')->attributes(["$required", "onchange='validate()'"]) }}
        </div>
    </div>
</div>

<div class="row mb-3 file_upload_canvas hide" style="display: none;">
    <div class="col-12"> 
        <div class="form-group">
            <label for="files[]">Select Files</label> <span class="text-danger">*</span>
            <input class="form-control" type="file" name="files[]" id="files" required="" multiple="" accept="application/pdf" data-min-file-count="1">
        </div>
    </div>
</div>


<div class='form-group'>
                                <label class='col-xs-5 control-label' for="submit"> </label>
                                <div class='col-md-12' style="text-align: center;">
                                    <button type="button" name="send_request2" id="send_request2" disabled class="btn btn-md btn-primary link_button large file_upload_button"><i class="fa fa-save"></i> Upload Files</button>
                                </div>
                            </div> 
<!-- Select2 Library -->
<x-library.select2 />

@push('after-styles')

<!-- the fileinput plugin styling CSS file -->
<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />


<style>
    .note-editor.note-frame :after {
        display: none;
    }

    .note-editor .note-toolbar .note-dropdown-menu,
    .note-popover .popover-content .note-dropdown-menu {
        min-width: 180px;
    }
</style>
@endpush

@push ('after-scripts')
<!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
<!-- link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" /-->

<!-- the jQuery Library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

<!-- buffer.min.js and filetype.min.js are necessary in the order listed for advanced mime type parsing and more correct
     preview. This is a feature available since v5.5.0 and is needed if you want to ensure file mime type is parsed 
     correctly even if the local file's extension is named incorrectly. This will ensure more correct preview of the
     selected file (note: this will involve a small processing overhead in scanning of file contents locally). If you 
     do not load these scripts then the mime type parsing will largely be derived using the extension in the filename
     and some basic file content parsing signatures. -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/buffer.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/filetype.min.js" type="text/javascript"></script>

<!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
    wish to resize images before upload. This must be loaded before fileinput.min.js -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/piexif.min.js" type="text/javascript"></script>

<!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
    This must be loaded before fileinput.min.js -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/sortable.min.js" type="text/javascript"></script>

<
<!-- the main fileinput plugin script JS file -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/fileinput.min.js"></script>

<!-- following theme script is needed to use the Font Awesome 5.x theme (`fa5`). Uncomment if needed. -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/themes/fa5/theme.min.js"></script>
<script type="module">
    
    $("#files").fileinput({
        theme: 'fa5',
        showUpload: false,
        initialPreviewAsData: true,
    }).on('fileuploaded', function(event, previewId, index, fileId) {
        console.log('File Uploaded', 'ID: ' + fileId + ', Thumb ID: ' + previewId);
    }).on('fileuploaderror', function(event, data, msg) {
        console.log('File Upload Error', 'ID: ' + data.fileId + ', Thumb ID: ' + data.previewId);
    }).on('filebatchuploadcomplete', function(event, preview, config, tags, extraData) {
        console.log('File Batch Uploaded', preview, config, tags, extraData);
    }).on('filebatchselected', function(event, files) {
    console.log('File batch selected triggered');
    $("#send_request2").prop("disabled", false)
    }).on('filecleared', function(event) {
    console.log("filecleared");
    $("#send_request2").prop("disabled", true)

});

</script>



<script>
    function validate()
    {
        var code=$("#code").val()
        var year=$("#year").val()
        var case_index=$("#case_index").val()
        if(code!="" && case_index!="" && year!="")
        {
            // $("#send_request2").prop("disabled", false)
            $(".file_upload_canvas").css("display", 'block')
        }
        else
        {
            $("#send_request2").prop("disabled", true)
            $(".file_upload_canvas").css("display", 'none')
        }
    }
</script>
<script type="module"> 
    $(document).ready(function() {
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
            document.querySelector('.select2-container--open .select2-search__field').focus();
        });

        $('.select2-law_court').select2({
            theme: "bootstrap4",
            placeholder: '@lang("Select an option")',
            allowClear: true,
            ajax: {
                url: '{{route("frontend.cases.index_list")}}',
                dataType: 'json',
                data: function(params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });


        $('.select2-unit').select2({
            theme: "bootstrap4",
            placeholder: '@lang("Select an option")',
            // minimumInputLength: 2,
            allowClear: true,
            ajax: {
                url: '{{route("frontend.cases.index_list_unit")}}',
                dataType: 'json',
                data: function(params) {
                    return {
                        lawcourt:$('#law_court').val(),
                        q: $.trim(params.term)
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });


        $('.select2-unit_division').select2({
            theme: "bootstrap4",
            placeholder: '@lang("Select an option")',
            // minimumInputLength: 2,
            allowClear: true,
            ajax: {
                url: '{{route("frontend.cases.index_list_unit_division")}}',
                dataType: 'json',

                data: function(params) {
                    return {
                        lawcourt:$('#law_court').val(),
                        unit:$('#unit').val(),
                        q: $.trim(params.term)
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('.select2-code').select2({
            theme: "bootstrap4",
            placeholder: '@lang("Select an option")',
            // minimumInputLength: 2,
            allowClear: true,
            ajax: {
                url: '{{route("frontend.cases.index_list_code")}}',
                dataType: 'json',
                data: function(params) {
                    return {
                        unit:$('#unit').val(),
                        unit_division:$('#unit_division').val(),
                        q: $.trim(params.term)
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('.select2-year').select2({
            theme: "bootstrap4",
            placeholder: '@lang("Select an Year")',
        });

        
        
        $('.select2-law_court').on('change', function(){
            $('.select2-unit').trigger('change')
        })

        $('.select2-unit').on('change', function(){
            $('.select2-unit_division').trigger('change')
        })


        $('.select2-law_court').trigger('change')


        $('#send_request2').on('click', function(e){
            e.preventDefault();
            // var data = new FormData($('.upload-file-form'))[0];
            var data = new FormData($('.upload-file-form')[0]);
 
                    $.ajax({
                        type: "POST",
                        async: true,
                        url: '{{route("frontend.cases.upload_files")}}',
                        beforeSend: function ()
                        { 
                            $(".placeholder").removeClass('hide');
                        },
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function (data)
                        {
                            var obj = data;//JSON.parse(data);
                            $.each(obj, function (key, value)
                            {
                                if (key === 'success')
                                {
                                    window.location.href="/";
                                } else if (key === 'csrfName')
                                {
                                    $("input[name='" + obj.csrfName + "']").val(obj.csrfHash);
                                }
                                if (key === 'error')
                                {
                                    $(".case_parties_response_div").html("<center>" + value + "</center>");
                                    $(".case_parties_response_div").addClass("error");
                                } else if (key === 'validation_error')
                                {
                                    $.each(value, function (key1, value1)
                                    {
                                        $("#" + key1).addClass("ErrorField");
                                        $("#" + key1 + "-error").html(value1);
                                    });
                                }
                            });
                        }, //
                        error: function (xhr)
                        {                          //
                            ok = false; //
                        },
                        complete: function ()
                        {
                            $(".placeholder").addClass('hide');
                        }
                    });
        })
        validate();

    });
</script>
@endpush