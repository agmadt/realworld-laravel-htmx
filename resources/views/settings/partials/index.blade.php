<div class="settings-page">
  <div class="container page">
    <div class="row">

      <div class="col-md-6 col-md-offset-3 col-xs-12">
        <h1 class="text-xs-center">Your Settings</h1>

        @include('settings.partials.form-message')

        @include('settings.partials.form')
      </div>

      <div class="col-md-6 col-md-offset-3">
        <hr>
        <button class="btn btn-outline-danger" hx-post="/htmx/logout">
          Or click here to logout.
        </button>
      </div>

    </div>
  </div>
</div>