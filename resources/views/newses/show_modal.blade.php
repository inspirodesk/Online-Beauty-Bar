<div class="row">
    <label for="name" class="col-md-12 col-form-label text-start"><strong>Name:</strong></label>
    <div class="col-md-12" style="line-height: 35px;">
        {!! $news->name !!}
    </div>
</div>

<div class="row">
    <label for="description" class="col-md-12 col-form-label text-start"><strong>Description:</strong></label>
    <div class="col-md-12" style="line-height: 35px;">
        {!! $news->description !!}
    </div>
</div>

@if($news->news_image_url)
<div class="row">
    <label for="newsImage" class="col-md-12 col-form-label text-start"><strong>Feature Image</strong></label>
    <img src="{{ $news->news_image_url }}" alt="{{ $news->name }}" style="max-width: 100px; max-height: 100px;">
</div>
@endif

<div class="row">
    <label for="status" class="col-md-12 col-form-label text-start"><strong>Status:</strong></label>
    <div class="col-md-12" style="line-height: 35px;">
        {!! $news->status !!}
    </div>
</div>

<div class="row">
    <label for="category" class="col-md-12 col-form-label text-start"><strong>Category:</strong></label>
    <div class="col-md-12" style="line-height: 35px;">
    @foreach($category as $cat)
            <span>{{ $cat['name'] }}</span>
            @if(!$loop->last)
                <span>, </span>
            @endif
        @endforeach
    </div>
</div>


<div class="row">
    <label for="siteSelection" class="col-md-12 col-form-label text-start"><strong>Site Selection:</strong></label>
    <div class="col-md-12" style="line-height: 35px;">
    @foreach($siteSelection as $site)
            <span>{{ $site['name'] }}</span>
            @if(!$loop->last)
                <span>, </span>
            @endif
        @endforeach
    </div>
</div>

            