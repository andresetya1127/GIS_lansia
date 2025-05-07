<div class="d-flex mb-4 justify-content-end align-items-center">
    @foreach ($toolbar as $tool)
        <x-actions.button :url="$tool['url']" :title="$tool['title']" :icon="$tool['icon']" :color="$tool['color']"/>
    @endforeach
</div>
