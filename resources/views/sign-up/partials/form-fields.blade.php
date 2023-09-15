@csrf
<fieldset class="form-group">
  <input id="sign-up-username" class="form-control form-control-lg" type="text" name="username" placeholder="Username" value="{{ (isset($oldUsername) ? $oldUsername : old('username')) }}">
</fieldset>
<fieldset class="form-group">
  <input id="sign-up-email" class="form-control form-control-lg" type="text" name="email" placeholder="Email" value="{{ (isset($oldEmail) ? $oldEmail : old('email')) }}">
</fieldset>
<fieldset class="form-group">
  <input id="sign-up-password" class="form-control form-control-lg" type="password" name="password" placeholder="Password">
</fieldset>
<button class="btn btn-lg btn-primary pull-xs-right">
  Sign up
</button>