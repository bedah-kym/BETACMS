<div>
    <div class="row mt-4">
        <div class="col">
            <input type="text" class="form-control my-2" placeholder=" Search" wire:model.live="searchTerm" />

            <div class="table-responsive">
                <table class="table table-hover table-responsive-sm" wire:loading.class="table-secondary">
                    <thead>
                        <tr>
                            <th>Case Number</th>
                            <th>Station</th>
                            <th>Division</th>
                            <th>Case Type</th>
                            <th>Date</th>
                            <th>Files</th>
                            <th class="text-end">{{ __('labels.backend.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cases as $case)

                        <tr>
                            <td nowrap>
                                <strong>
                                    <a href="{{route('frontend.cases.view_files', $case->case_number)}}">
                                        {{ $case->case_number }}
                                    </a>
                                </strong>
                            </td>

                            <td>
                                {{$case->unit_name}}
                            </td>
                            <td>
                                {{$case->division_name}}
                            </td>
                            <td>
                                {{$case->category_name}}
                            </td>
                            <td nowrap>
                                {{$case->created_at}}

                            </td>
                            <td>
                                {{$case->uploaded_files}}

                            </td>



                            <td class="text-end">
                                <a href="{{route('frontend.cases.view_files', $case->case_number)}}" class="btn btn-success btn-sm mt-1" data-toggle="tooltip" title="{{__('labels.backend.show')}}"><i class="fas fa-desktop"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-7">
            <div class="float-left">
                {!! $cases->total() !!} {{ __('labels.backend.total') }}
            </div>
        </div>
        <div class="col-5">
            <div class="float-end">
                {!! $cases->links() !!}
            </div>
        </div>
    </div>
</div>