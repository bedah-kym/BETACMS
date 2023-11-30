@extends ('ajira.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')

@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <x-backend.section-header>
            <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>

            <x-slot name="subtitle">
                Uploaded Cases
            </x-slot>
            <x-slot name="toolbar">
                @can('add_'.$module_name)
                <x-buttons.create route='{{ route("frontend.upload") }}' title="{{__('Create')}} {{ ucwords(Str::singular($module_name)) }}" >Upload Complete Case Files</x-buttons.create>
                @endcan

                <!-- @can('restore_'.$module_name)
                <div class="btn-group">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href='{{ route("backend.$module_name.trashed") }}'>
                                <i class="fas fa-eye-slash"></i> View trash
                            </a>
                        </li>
                    </ul>
                </div>
                @endcan -->
            </x-slot>
        </x-backend.section-header>

        <livewire:users-index />

    </div>
    <div class="card-footer">

    </div>
</div>

@endsection