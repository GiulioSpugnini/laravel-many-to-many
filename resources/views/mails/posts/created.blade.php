@component('mail::message')
# Questo è il tuo post appena creato:
<h2>Titolo del post: {{ $post->title }}</h2>
<p>Data di pubblicazione: {{ $post->updated_at }}</p>
<address>Autore: {{ $post->author }}</address>
<ul>
@forelse ($post->tags as $tag)
<li>{{ $tag->label }}</li>
@empty
@endforelse
</ul>
@component('mail::button', ['url' => $url])
    Vai al post
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
