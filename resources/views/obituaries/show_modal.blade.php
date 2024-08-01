<div class="row ">
    <div class="col-4">
        <center>
            @if($obituary->normal_image_url)
                <img src="{{ $obituary->normal_image_url }}" alt="{{ $obituary->name }}" style="max-width: 100px; max-height: 100px;">
            @endif
        </center>
    </div>
    <div class="col-8">
        <div class="row py-1">
            <h5>Basic Details</h5>
            <div class="py-3">
                <label for="name" class="col-md-12 col-form-label"><strong>Full Name:</strong> {{ $obituary->name }}</label>
                <label for="dateOfBirth" class="col-md-12 col-form-label"><strong>Date of Birth:</strong> {{ $obituary->dateOfBirth }}</label>
                <label for="dateOfDeath" class="col-md-12 col-form-label"><strong>Date of Death:</strong> {{ $obituary->dateOfDeath }}</label>
                <label for="permanentAddress" class="col-md-12 col-form-label"><strong>Permanent Address:</strong> {{ $obituary->permanentAddress }}</label>
                <label for="temporaryAddress" class="col-md-12 col-form-label"><strong>Temporary Address:</strong> {{ $obituary->temporaryAddress }}</label>
            </div>
        </div>
        <div class="row py-1">
            <h5>Contact Details</h5>
            <div class="py-3">
                @foreach ($obituary->contactDetails as $contact)
                <label  class="col-md-12 col-form-label text-md-endtext-center"><strong>Contact Person Name:</strong> {{ $contact->contact_name }}</label>
                <label  class="col-md-12 col-form-label text-md-endtext-center"><strong>Contact Number:</strong> {{ $contact->contact_number }}</label>
                @endforeach
            </div>
        </div>
        <div class="row py-1">
            <h5>Notice Details</h5>
            <div class="py-3">
                <label for="adStartDate" class="col-md-12 col-form-label text-md-endtext-center"><strong>Notice Start Date:</strong> {{ $obituary->adStartDate }}</label>
                <label for="adEndDate" class="col-md-12 col-form-label text-md-endtext-center"><strong>Notice End Date:</strong> {{ $obituary->adEndDate }}</label>
            </div>
        </div>
    </div>
</div>
