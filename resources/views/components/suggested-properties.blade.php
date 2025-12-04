<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($suggestedProperties as $suggestedProperty)
            <x-properties.property-card :property="$suggestedProperty"/>
        @endforeach
</div>
