<div class="editor-page">
  <div class="container page">
    <div class="row">

      <div class="col-md-10 col-md-offset-1 col-xs-12">

        <div id="form-message"></div>

        <form method="post"

          @if (isset($article))
            hx-post="/htmx/editor/{{ $article->slug }}"
          @else
            hx-post="/htmx/editor"
          @endif

          hx-target="#app-body"
        >
          <fieldset class="form-group">
            <input type="text" name="title" class="form-control form-control-lg" placeholder="Post Title"
              @if (isset($article))
                value="{{ $article->title }}"
              @endif
            >
          </fieldset>
          <fieldset class="form-group">
            <input type="text" name="description" class="form-control form-control-md" placeholder="What's this article about?"
              @if (isset($article))
                value="{{ $article->description }}"
              @endif
            >
          </fieldset>
          <fieldset class="form-group">
            <textarea rows="8" name="content" class="form-control" placeholder="Write your post (in markdown)">@if (isset($article)){{ $article->body }}@endif</textarea>
          </fieldset>
          <fieldset class="form-group">
            <input type="text" name="tags" class="form-control tagify--outside" placeholder="Enter tags"
              @if (isset($article))
                value="{{ $article->tags->pluck('name') }}"
              @endif
            >
          </fieldset>
          <button class="btn btn-lg btn-primary pull-xs-right">
            Publish Article
          </button>
        </form>
      </div>
    </div>
  </div>
</div>