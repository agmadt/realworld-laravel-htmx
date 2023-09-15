<div id="settings-form-message"

  @if (isset($oob_swap) && $oob_swap)
    hx-swap-oob="true"
  @endif
>
  @include('components.form-success-message')
</div>