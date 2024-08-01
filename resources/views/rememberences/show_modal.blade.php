<div class="row">
    <div class="col-4">
        @if($rememberence->normal_image_url)
            <center>
                <img src="{{ $rememberence->normal_image_url }}" alt="{{$rememberence->name }}" style="max-width: 100px; max-height: 100px;">
            </center>
        @endif
    </div>
    <div class="col-8">
        <div class="row py-1">
            <h5>Basic Details</h5>
            <div class="py-3">
                <label for="name" class="col-md-12 col-form-label text-start"><strong>Full Name:</strong> {{ $rememberence->name }}</label>
                <label for="dateOfDeath" class="col-md-12 col-form-label text-start"><strong>Date of Death:</strong> {{ $rememberence->dateOfDeath }}</label>
                <label for="rememberanceDay" class="col-md-12 col-form-label text-start"><strong>Rememberance Day:</strong> {{ $rememberence->rememberanceDay }}</label>
            </div>
        </div>
        <div class="row py-1">
            <h5>Contact Details</h5>
            <div class="py-3">
                @foreach ($rememberence->contactDetails as $contact)
                <label  class="col-md-12 col-form-label text-md-endtext-center"><strong>Contact Person Name:</strong> {{ $contact->contact_name }}</label>
                <label  class="col-md-12 col-form-label text-md-endtext-center"><strong>Contact Number:</strong> {{ $contact->contact_number }}</label>
                @endforeach
            </div>
        </div>
        <div class="row py-1">
            <h5>Notice Details</h5>
            <div class="py-3">
                <label for="adStartDate" class="col-md-12 col-form-label text-md-endtext-center"><strong>Notice Start Date:</strong> {{ $rememberence->adStartDate }}</label>
                <label for="adEndDate" class="col-md-12 col-form-label text-md-endtext-center"><strong>Notice End Date:</strong> {{ $rememberence->adEndDate }}</label>
            </div>
        </div>
    </div>
</div>
