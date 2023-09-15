@if (isset($message) && $message)
  <div class="alert alert-warning">
    <ul>
      <li>{{ $message }}</li>
    </ul>
  </div>
@endif