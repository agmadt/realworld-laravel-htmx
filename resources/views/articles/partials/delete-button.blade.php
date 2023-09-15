<button class="btn btn-outline-danger btn-sm delete-button"
  hx-delete="/htmx/articles/{{ $article->slug }}"
  hx-target="#app-body"
  hx-confirm="Are you sure you wish to delete the article?"
>
  <i class="ion-trash-a"></i>
  Delete Article
</button>