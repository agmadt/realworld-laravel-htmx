<div id="popular-tag-list" class="tag-list" hx-swap-oob="true">
  @foreach ($popularTags as $tag)
    <a class="label label-pill label-default"
      href="/tag-feed/{{ str()->slug($tag->name) }}"
      hx-get="/htmx/home/tag-feed/{{ str()->slug($tag->name) }}"
      hx-target="#feed-post-preview"
      hx-push-url="/tag-feed/{{ str()->slug($tag->name) }}"
    >{{ $tag->name }}</a>
  @endforeach
</div>