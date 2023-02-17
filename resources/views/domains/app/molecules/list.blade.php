<div class="overflow-auto md:overflow-visible header-sticky">
    <table id="app-list-table" class="table table-report sm:mt-2 font-medium whitespace-nowrap" data-table-sort data-table-pagination>
        <thead>
            <tr>
                <th>{{ __('app-index.name') }}</th>
                <th class="text-center w-1">{{ __('app-index.tags') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            <tr>
                <td class="truncate max-w-2xs">
                    <a href="{{ route('app.update', $row->id) }}">{{ $row->name }}</a>
                </td>
                <td class="text-center w-1">
                    <div class="flex justify-center space-x-2">
                        @foreach ($row->tags as $each)

                        <a href="?tag={{ $each->code }}" class="text-xs py-1 px-2 rounded-lg" style="@backgroundColor($each->color)">{{ $each->name }}</a>

                        @endforeach
                    </div>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>
