@extends ('layouts.in')

@section ('body')

<?php
// We force all records to be of type 'text' as this best represents what we need to store
$type = 'text';
?>

<form method="post" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="_action" value="create" />
    <input type="hidden" name="type" value="{{ $type }}" />

    <div class="box p-5 mt-5">
        <div class="lg:flex">
            <div class="flex-1 p-2">
                <label for="app-name" class="form-label">{{ __('app-create.name') }}</label>
                <input type="text" name="name" class="form-control form-control-lg" id="app-name" value="{{ $REQUEST->input('name') }}" autofocus required>
            </div>
        </div>

        @if ($teams->count() > 1)

        <div class="p-2">
            <x-select name="teams[]" value="id" :text="['name']" :options="$teams->toArray()" :label="__('app-create.teams')" :selected="$REQUEST->input('teams')" class="tom-select w-full" id="app-teams" multiple required></x-select>
        </div>

        @else

        <input type="hidden" name="teams[]" value="{{ $teams->first()->id ?? '' }}" />

        @endif

        <div class="p-2">
            <x-select name="tags[]" value="id" :text="['name']" :options="$tags->toArray()" :label="__('app-create.tags')" :selected="$REQUEST->input('tags')" class="tom-select w-full" id="app-tags" data-create multiple></x-select>
        </div>
    </div>

    <div class="box p-5 mt-5 bg-green-50">
        @include ('domains.app.types.'.$type.'.create')

        <div class="pr-2 text-right text-gray-600 text-xs mt-0.5">{{ __('app-create.fields-encrypted') }}</div>
    </div>

    @include ('domains.app.molecules.create-update-files', ['files' => []])

    {{-- Everything is always shared and editable--}}
    <input type="hidden" name="shared" value="1" id="app-shared">
    <input type="hidden" name="editable" value="1" id="app-editable">

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('app-create.save') }}</button>
        </div>
    </div>
</form>

@stop
