@extends ('layouts.in')

@section ('body')

<form method="post" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="_action" value="update" />
    <input type="hidden" name="type" value="{{ $type }}" />

    <div class="box p-5 mt-5">
        <div class="lg:flex">
            <div class="flex-1 p-2">
                <label for="app-name" class="form-label">{{ __('app-update.name') }}</label>
                <input type="text" name="name" class="form-control form-control-lg" id="app-name" value="{{ $REQUEST->input('name') }}" required>
            </div>
        </div>

        @if ($teams->count() > 1)
            <div class="p-2">
                <x-select name="teams[]" value="id" :text="['name']" :options="$teams->toArray()" :label="__('app-update.teams')" :selected="$row->teams->pluck('id')->toArray()" class="tom-select w-full" id="app-teams" multiple required></x-select>
            </div>
        @else
            <input type="hidden" name="teams[]" value="{{ $teams->first()->id ?? '' }}" />
        @endif

        <div class="p-2">
            <x-select name="tags[]" value="id" :text="['name']" :options="$tags->toArray()" :label="__('app-update.tags')" :selected="$row->tags->pluck('id')->toArray()" class="tom-select w-full" id="app-tags" data-create multiple></x-select>
        </div>
    </div>

    <div class="box p-5 mt-5 bg-green-50">
        @include ('domains.app.types.'.$type.'.update')

        <div class="pr-2 text-right text-gray-600 text-xs mt-0.5">{{ __('app-update.fields-encrypted') }}</div>
    </div>

    @include ('domains.app.molecules.create-update-files', ['row' => $row, 'files' => $files])

    {{-- Everything is always shared and editable--}}
    <input type="hidden" name="shared" value="1" id="app-shared">
    <input type="hidden" name="editable" value="1" id="app-editable">

    <div class="box p-5 mt-5">
        <div class="text-right">
            <a href="javascript:;" data-toggle="modal" data-target="#delete-modal" class="btn btn-outline-danger mr-5">{{ __('app-update.delete.button') }}</a>
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('app-update.save') }}</button>
        </div>
    </div>
</form>

<div id="delete-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <form action="{{ route('app.delete', $row->id) }}" method="post">
                    <input type="hidden" name="_action" value="delete" />

                    <div class="p-5 text-center">
                        @icon('x-circle', 'w-16 h-16 text-theme-24 mx-auto mt-3')
                        <div class="text-3xl mt-5">{{ __('app-update.delete.title') }}</div>
                        <div class="text-gray-600 mt-2">{{ __('app-update.delete.message') }}</div>
                    </div>

                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">{{ __('app-update.delete.cancel') }}</button>
                        <button type="submit" class="btn btn-danger w-24">{{ __('app-update.delete.delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop
