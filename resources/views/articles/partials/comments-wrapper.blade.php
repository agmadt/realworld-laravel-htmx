<div id="article-comments-wrapper">
  @foreach ($comments as $comment)
    @include('articles.partials.comment-card', ['comment' => $comment])
  @endforeach
</div>

@if (auth()->guest())
  <div>
    <a href="/htmx/sign-in" hx-get="/htmx/sign-in" hx-target="#app-body"
      hx-push-url="/sign-in"
    >
      Sign in
    </a>
    or
    <a href="/htmx/sign-up" hx-get="/htmx/sign-up" hx-target="#app-body"
      hx-push-url="/sign-up"
    >
      sign up
    </a>
    to add comments on this article.
  </div>
@else
  @include('articles.partials.comment-form', ['article' => $article])
@endif