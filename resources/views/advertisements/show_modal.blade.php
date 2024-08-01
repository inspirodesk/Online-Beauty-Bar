<div class="row">
    <div class="col-4">
        @if($advertisement->image_url)
        <center>
            <img src="{{ $advertisement->image_url }}" alt="{{ $advertisement->title }}" style="max-width: 100px; max-height: 100px;">
        </center>
        @endif
    </div>
    <div class="col-8">
        <div class="row py-1">
            <h5>Basic Details</h5>
            <div class="py-3">
                <label for="title" class="col-md-12 col-form-label text-start"><strong>Title :</strong> {{ $advertisement->title }}</label>
                <label for="date" class="col-md-12 col-form-label text-start"><strong>Date :</strong> {{ $advertisement->date }}</label>
                @if($advertisement->ispopup !== 1)
                <label for="category" class="col-md-12 col-form-label text-start"><strong>Category:</strong> {{ $advertisement->category }}</label>
                @else
                    <p>PopUp</p><br>
                    @if($advertisement->isclosepopup !== 1)
                        <label for="category" class="col-md-12 col-form-label text-start"><strong>Advertising Time:</strong> {{ $advertisement->display_time }}</label>

                    @endif
                @endif
            </div>
        </div>
        <div class="row py-1">
            <h5>Contact Details</h5>
            <div class="py-3">
                <label for="author" class="col-md-12 col-form-label text-start"><strong>Author Name:</strong> {{ $advertisement->author }}</label>
                <label for="author" class="col-md-12 col-form-label text-start"><strong>Contact Number:</strong> {{ $advertisement->mobile }}</label>
            </div>
        </div>
    </div>
</div>

