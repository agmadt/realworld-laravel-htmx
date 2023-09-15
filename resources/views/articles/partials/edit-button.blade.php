<button class="btn btn-outline-secondary btn-sm edit-button"
  hx-get="/htmx/editor/{{ $article->slug }}"
  hx-target="#app-body"
  hx-push-url="/editor/{{ $article->slug }}"
>
  <i class="ion-edit"></i>
  Edit Article
</button>