<ul id="navbar" class="nav navbar-nav pull-xs-right" hx-swap-oob="true">
  <li class="nav-item">
    <a id="nav-link-home"
      href="/"
      hx-get="/htmx/home"
      hx-target="#app-body"
      hx-push-url="/"
      class="nav-link @if (!isset($navbar_active) || $navbar_active == 'home') active @endif" 
    >
      Home
    </a>
  </li>

  @guest
  <li class="nav-item">
    <a id="nav-link-sign-in"
      href="/sign-in"
      hx-get="/htmx/sign-in"
      hx-target="#app-body"
      hx-push-url="/sign-in"
      class="nav-link @if (isset($navbar_active) && $navbar_active == 'sign-in') active @endif" 
    >
      Sign in
    </a>
  </li>
  <li class="nav-item">
    <a id="nav-link-sign-up"
      href="/sign-up"
      hx-get="/htmx/sign-up"
      hx-target="#app-body"
      hx-push-url="/sign-up"
      class="nav-link @if (isset($navbar_active) && $navbar_active == 'sign-up') active @endif" 
    >
      Sign up
    </a>
  </li>
  @endguest
  
  @auth
  <li class="nav-item">
    <a id="nav-link-editor"
      href="/editor"
      hx-get="/htmx/editor"
      hx-target="#app-body"
      hx-push-url="/editor"
      class="nav-link @if (isset($navbar_active) && $navbar_active == 'editor') active @endif"
    >
      <i class="ion-compose"></i>
      New Article
    </a>
  </li>
  <li class="nav-item">
    <a id="nav-link-settings"
      href="/settings"
      hx-get="/htmx/settings"
      hx-target="#app-body"
      hx-push-url="/settings"
      class="nav-link @if (isset($navbar_active) && $navbar_active == 'settings') active @endif"
    >
      Settings
    </a>
  </li>
  <li class="nav-item">
    <a id="nav-link-profile"
      href="/users/{{ auth()->user()->username }}"
      hx-get="/htmx/users/{{ auth()->user()->username }}"
      hx-target="#app-body"
      hx-push-url="/users/{{ auth()->user()->username }}"
      class="nav-link @if (isset($navbar_active) && $navbar_active == 'profile') active @endif"
    >
      <img class="user-pic" src="{{ auth()->user()->image }}">
      {{ auth()->user()->name ?? auth()->user()->username }}
    </a>
  </li>
  @endauth
</ul>