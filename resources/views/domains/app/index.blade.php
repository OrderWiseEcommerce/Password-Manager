@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('app-index.filter') }}" data-table-search="#app-list-table" />
        </div>

        @if ($tags->count() > 1)
        <div class="sm:ml-4 mt-2 sm:mt-0">
            <x-select name="tag" value="code" :text="['name']" :options="$tags->toArray()" :placeholder="__('app-index.tag')" :selected="$filters['tag']" data-change-submit></x-select>
        </div>
        @endif

        @if ($teams->count() > 1)
        <div class="sm:ml-4 mt-2 sm:mt-0">
            <x-select name="team" value="code" :text="['name']" :options="$teams->toArray()" :placeholder="__('app-index.team')" :selected="$filters['team']" data-change-submit></x-select>
        </div>
        @endif

        <div class="sm:ml-4 mt-2 sm:mt-0 bg-white">
            <a href="{{ route('app.create') }}" class="btn form-control-lg">{{ __('app-index.create') }}</a>
        </div>
    </div>
</form>

@include ('domains.app.molecules.list')



@stop
