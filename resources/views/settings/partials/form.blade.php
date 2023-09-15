<form
  action="/settings"
  method="POST"
  hx-post="/htmx/settings"
  id="settings-form"
  
  @if (isset($oob_swap) && $oob_swap)
    hx-swap-oob="true"
  @endif
>
  <fieldset class="form-group">
    <input class="form-control" type="text" placeholder="URL of profile picture" value="{{ $user->image }}" name="image_url">
  </fieldset>
  <fieldset class="form-group">
    <input class="form-control form-control-lg" type="text" placeholder="Your Name" value="{{ $user->name }}" name="name">
  </fieldset>
  <fieldset class="form-group">
    <textarea class="form-control form-control-lg" rows="8" placeholder="Short bio about you" name="bio">{{ $user->bio }}</textarea>
  </fieldset>
  <fieldset class="form-group">
    <input class="form-control form-control-lg" type="email" placeholder="Email" value="{{ $user->email }}" name="email">
  </fieldset>
  <fieldset class="form-group">
    <input class="form-control form-control-lg" type="password" placeholder="Password" name="password">
  </fieldset>
  <button class="btn btn-lg btn-primary pull-xs-right" hx-post="/htmx/settings">
    Update Settings
  </button>
</form>