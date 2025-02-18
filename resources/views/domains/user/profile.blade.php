@extends ('domains.user.profile-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="profile" />

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="user-name" class="form-label">{{ __('user-profile.name') }}</label>
            <input type="text" name="name" class="form-control form-control-lg" id="user-name" value="{{ $REQUEST->input('name') }}" required>
        </div>

        <div class="p-2">
            <label for="user-email" class="form-label">{{ __('user-profile.email') }}</label>
            <input type="email" name="email" class="form-control form-control-lg" id="user-email" value="{{ $REQUEST->input('email') }}" required>
        </div>

        <div class="p-2">
            <label for="user-password" class="form-label">{{ __('user-profile.password') }}</label>

            <div class="input-group">
                <input type="password" name="password" class="form-control form-control-lg" id="user-password">

                <button type="button" class="input-group-text input-group-text-lg tooltip" data-tippy-content="{{ __('common.copied') }}" title="{{ __('common.copy') }}" data-copy data-copy-target="#user-password" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
                <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#user-password" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
            </div>
        </div>

        <input type="hidden" name="password_enabled" value="1" />

    </div>

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="user-password_current" class="form-label">{{ __('user-profile.password_current') }}</label>
            <input type="password" name="password_current" class="form-control form-control-lg" id="user-password_current" required>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('user-profile.save') }}</button>
        </div>
    </div>
</form>

@stop
