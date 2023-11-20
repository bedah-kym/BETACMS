@extends ('ajira.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection


@section('content')
<x-frontend.layouts.show :data="$case">

    <x-backend.section-header>
        <i class="{{ $module_icon }}"></i> Case Files <small class="text-muted">List</small>

        <x-slot name="subtitle">
            Show all the files uploaded for the case
        </x-slot>
        <x-slot name="toolbar">
            <x-backend.buttons.return-back />
            <!-- <a href="" class="btn btn-primary m-1" data-toggle="tooltip" title="List"><i class="fas fa-list"></i> List</a> -->
            <!-- <a href="" class="btn btn-primary m-1" data-toggle="tooltip" title="Profile"><i class="fas fa-user"></i> Profile</a> -->
        </x-slot>
    </x-backend.section-header>

    <div class="row mt-4 mb-4">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th style="text-align: right">Case Number: </th>
                        <td><b>{{ $case->case_number }}</b></td>
                        <th style="text-align: right">Case Types: </th>
                        <td><b>{{ $case->category_code }}{{ $case->category_name }}</b></td>
                    </tr>

                    <tr>
                        <th style="text-align: right">Division: </th>
                        <td><b>{{ $case->division_name }}</b></td>
                
                        <th style="text-align: right">Unit: </th>
                        <td><b>{{ $case->unit_name }}</b></td>
                    </tr>

                    

                </table>
            </div>

            <div class="py-4 text-center">
            <div class="row mb-3">
                <div class="col-12"> 
                        <div class="form-group">
                            <input class="form-control" type="file" name="files[]" id="files" required="" multiple="" accept="application/pdf" data-min-file-count="1">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend.layouts.show>


@push('after-styles')
<!-- File Manager -->
<link rel="stylesheet" href="{{ asset('fileinput/css/fileinput.min.css') }}">
<!-- default icons used in the plugin are from Bootstrap 5.x icon library (which can be enabled by loading CSS below) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">



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


<!-- buffer.min.js and filetype.min.js are necessary in the order listed for advanced mime type parsing and more correct
     preview. This is a feature available since v5.5.0 and is needed if you want to ensure file mime type is parsed 
     correctly even if the local file's extension is named incorrectly. This will ensure more correct preview of the
     selected file (note: this will involve a small processing overhead in scanning of file contents locally). If you 
     do not load these scripts then the mime type parsing will largely be derived using the extension in the filename
     and some basic file content parsing signatures. -->

     <script src="{{ asset('fileinput/js/plugins/buffer.min.js') }}" crossorigin="anonymous"></script>
     <script src="{{ asset('fileinput/js/plugins/filetype.min.js') }}" crossorigin="anonymous"></script>
     <script src="{{ asset('fileinput/js/plugins/piexif.min.js') }}" crossorigin="anonymous"></script>
     <script src="{{ asset('fileinput/js/fileinput.min.js') }}" crossorigin="anonymous"></script>
     <script src="{{ asset('fileinput/js/locales/LANG.js') }}" crossorigin="anonymous"></script>


<script type="module">
    $(document).ready(function() {
        $("#files").fileinput({
            theme: 'fa5', 
            showRemove: false,
            showUpload: false,
            showZoom: true,
            showDrag: false,

            howClose: false,
            showCaption: false,
            showBrowse: false,
            showUpload:false,
            showUploadedThumbs: false,
            showPreview: true,

            initialPreviewAsData: true,

            initialPreviewShowDelete:false,
            // theme: 'fa5',
            initialPreview: [
                    @foreach($files as $f)
                        '{{ asset('public/storage/'.str_replace('public','',$f->file_path)) }}',
                    @endforeach
                ],
                initialPreviewConfig: [
                    @foreach($files as $f)
                    {
                        type: "pdf",
                        size: {{$f->size}},
                        caption: "{{$f->file_name}}",
                        // url: "{{ asset('public/storage/'.str_replace('public','',$f->file_path)) }}",
                        width: "50px",
                        downloadUrl: true,
                        // deleteUrl: false
                    },
                @endforeach

            ],

        }).on('fileuploaded', function(event, previewId, index, fileId) {
            console.log('File Uploaded', 'ID: ' + fileId + ', Thumb ID: ' + previewId);
        }).on('fileuploaderror', function(event, data, msg) {
            console.log('File Upload Error', 'ID: ' + data.fileId + ', Thumb ID: ' + data.previewId);
        }).on('filebatchuploadcomplete', function(event, preview, config, tags, extraData) {
            console.log('File Batch Uploaded', preview, config, tags, extraData);
        });
    });
</script>
@endpush

@endsection
