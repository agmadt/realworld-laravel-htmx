@if ($errors && $errors->any())
  <div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
    </ul>
  </div>
@endif

@if (!$errors)
  <div>asdasd</div>
@endif