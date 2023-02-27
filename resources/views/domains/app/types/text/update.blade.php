<div class="p-2">
    <button type="button" class="tooltip mr-1" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#app-payload-text" tabindex="-1">@icon('clipboard', 'w-4 h-4')</button>

    <label for="app-payload-text" class="form-label">{{ __('app-update.payload.text') }}</label>

    <textarea name="payload[new_text]" class="form-control form-control-lg" id="app-payload-text" rows="5">{{ $REQUEST->input('payload.new_text') }}</textarea>
    <input type="hidden" name="payload[text]" value="{{ $REQUEST->input('payload.text') }}">
</div>

<div class="p-2">
    <div class="p-2">
        {!! nl2br($REQUEST->input('payload.text')) !!}
    </div>
</div>
