<div class="auth-page">
  <div class="container page">
    <div class="row">

      <div class="col-md-6 col-md-offset-3 col-xs-12">
        <h1 class="text-xs-center">Sign in</h1>
        <p class="text-xs-center">
          <a
            href="/sign-up"
            hx-push-url="/sign-up"
            hx-get="/htmx/sign-up"
            hx-target="#app-body"
          >
            Need an account?
          </a>
        </p>

        <div id="sign-in-form-messages"></div>

        <form method="POST" hx-post="/htmx/sign-in" hx-target="#app-body">
          @include('sign-in.partials.form-fields')
        </form>
      </div>

    </div>
  </div>
</div>