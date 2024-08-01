@extends('layouts.app')

@section('content')

<div class="row ">
    <div class="col-md-12">
        <form action="{{ route('obituaries.update', $obituary->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="card">
                <div class="card-header">
                        <h5>Obituary Details - Update</h5>
                </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="name" class="col-form-label text-start">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $obituary->name }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label for="dateOfBirth" class="col-form-label text-start">Date of Birth</label>
                                <input type="date" class="form-control @error('dateOfBirth') is-invalid @enderror" id="dateOfBirth" name="dateOfBirth" value="{{ $obituary->dateOfBirth }}">
                                @if ($errors->has('dateOfBirth'))
                                    <span class="text-danger">{{ $errors->first('dateOfBirth') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label for="dateOfDeath" class="col-form-label text-start">Date of Death</label>
                                <input type="date" class="form-control @error('dateOfDeath') is-invalid @enderror" id="dateOfDeath" name="dateOfDeath" value="{{ $obituary->dateOfDeath }}">
                                @if ($errors->has('dateOfDeath'))
                                    <span class="text-danger">{{ $errors->first('dateOfDeath') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="permanentAddress" class="col-form-label text-start">Permanent Address</label>
                                <input type="text" class="form-control @error('permanentAddress') is-invalid @enderror" id="permanentAddress" name="permanentAddress" value="{{ $obituary->permanentAddress }}">
                                @if ($errors->has('permanentAddress'))
                                    <span class="text-danger">{{ $errors->first('permanentAddress') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label for="temporaryAddress" class="col-form-label text-start">Temporary Address</label>
                                <input type="text" class="form-control @error('temporaryAddress') is-invalid @enderror" id="temporaryAddress" name="temporaryAddress" value="{{ $obituary->temporaryAddress }}">
                                @if ($errors->has('temporaryAddress'))
                                    <span class="text-danger">{{ $errors->first('temporaryAddress') }}</span>
                                @endif
                            </div>
                            {{-- <div class="form-group col-md-6 offset-md-2 align-self-center">
                                <input type="checkbox" class="form-check-input" id="sameAddressCheckbox" name="sameAddressCheckbox">
                                <label class="form-check-label" for="sameAddressCheckbox">Permanent and Temporary Address are the same</label>
                            </div> --}}
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="dateOfStartView" class="col-form-label text-start">Date Of Start View</label>
                                <input type="date" class="form-control @error('dateOfStartView') is-invalid @enderror" id="dateOfStartView" name="dateOfStartView" value="{{ $obituary->dateOfStartView }}">
                                @if ($errors->has('dateOfStartView'))
                                    <span class="text-danger">{{ $errors->first('dateOfStartView') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-3">
                                <label for="dateOfEndView" class="col-form-label text-start">Date Of End View</label>
                                <input type="date" class="form-control @error('dateOfEndView') is-invalid @enderror" id="dateOfEndView" name="dateOfEndView" value="{{ $obituary->dateOfEndView }}">
                                @if ($errors->has('dateOfEndView'))
                                    <span class="text-danger">{{ $errors->first('dateOfEndView') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-3">
                                <label for="dateOfDeathDeeds" class="col-form-label text-start">Date Of Death Deeds</label>
                                <input type="date" class="form-control @error('dateOfDeathDeeds') is-invalid @enderror" id="dateOfDeathDeeds" name="dateOfDeathDeeds" value="{{ $obituary->dateOfDeathDeeds }}">
                                @if ($errors->has('dateOfDeathDeeds'))
                                    <span class="text-danger">{{ $errors->first('dateOfDeathDeeds') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-3">
                                <label for="dateOfCremation" class="col-form-label text-start">Date Of Cremation</label>
                                <input type="date" class="form-control @error('dateOfCremation') is-invalid @enderror" id="dateOfCremation" name="dateOfCremation" value="{{ $obituary->dateOfCremation }}">
                                @if ($errors->has('dateOfCremation'))
                                    <span class="text-danger">{{ $errors->first('dateOfCremation') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="furtherAnnouncement" class="col-md-12 col-form-label text-start">Further Announcement</label>
                            <div class="col-md-12">
                                <textarea name="furtherAnnouncement" class="form-control @error('furtherAnnouncement') is-invalid @enderror" id="classic-editor">{{ $obituary->furtherAnnouncement }}</textarea>
                            </div>
                        </div>
                        <div class="form-row"> 
                            <div class="form-group col-md-6">
                                <label class="form-label">Upload Feature Image</label>
                                <input type="file" name="upload" accept="image/*" onchange="previewFeatureImage(this,'featureImagePreview')">
                                <img id="featureImagePreview" src="{{ $obituary->normal_image_url }}" alt="Feature Image" class="img-thumbnail" style="max-width:250px">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Upload Frame Image</label>
                                <input type="file" name="frame_upload" accept="image/*" onchange="previewFeatureImage(this,'frameImagePreview')">
                                <img id="frameImagePreview" src="{{ $obituary->frame_image_url }}" alt="Frame Image" class="img-thumbnail" style="max-width: 250px">
                            </div>
                            <input type="hidden" name="image_type" value="normal">
                        </div>
                        <div id="additionalContacts">
                        @foreach ($obituary->contactDetails as $index => $contact)
                            <div class="form-row">
                                    <div class="col-5">
                                        <div class="form-group margin-contact">
                                            <label class="form-label">Contact Person Name</label>
                                            <input type="text" class="form-control" name="contact_details[{{ $index }}][contact_name]" value="{{ $contact->contact_name }}">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group margin-contact">
                                            <label class="form-label">Contact Number</label>
                                            <input type="text" class="form-control" name="contact_details[{{ $index }}][contact_number]" value="{{ $contact->contact_number }}">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group" style="margin-top:45px">
                                            <button type="button" class="btn btn-block btn-danger btn-sm remove-contact">
                                                <i class="fas fa-times"></i>Remove 
                                            </button>
                                        </div>
                                    </div>
                                
                            </div>
                        @endforeach
                        </div>
                        <div class="form-group col-md-2">
                            <button type="button" class="btn btn-primary btn-block btn-sm" id="addContact">Add Contact</button>
                        </div>
                    </div>
            </div>    
                

            <div class="card">
                <div class="card-header">
                        <h5>Duration Details</h5>
                </div>
                    <div class="card-body"> 
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="adStartDate" class="col-form-label text-start">Advertisement Start Date</label>
                                <input type="date" class="form-control @error('adStartDate') is-invalid @enderror" id="adStartDate" name="adStartDate" value="{{ $obituary->adStartDate }}">
                                @if ($errors->has('adStartDate'))
                                    <span class="text-danger">{{ $errors->first('adStartDate') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="adEndDate" class="col-form-label text-start">Advertisement End Date</label>
                                <input type="date" class="form-control @error('adEndDate') is-invalid @enderror" id="adEndDate" name="adEndDate" value="{{ $obituary->adEndDate }}">
                                @if ($errors->has('adEndDate'))
                                    <span class="text-danger">{{ $errors->first('adEndDate') }}</span>
                                @endif
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary me-2">Update Obituary</button>
                            </div>
                        </div>                     
                    </div>
            </div>

        </form>
    </div>    
</div>
<script>
    // Add JavaScript logic to copy the permanent address to living address when the checkbox is checked
    document.getElementById('sameAddressCheckbox').addEventListener('change', function() {
      if (this.checked) {
        document.getElementById('temporaryAddress').value = document.getElementById('permanentAddress').value;
      }
    });
  </script>
  <script>
   
    function previewFeatureImage(input,id) {
        var preview = document.getElementById(id);
        var file = input.files[0];

        if (file) { 
            var reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
        }
    
    </script>
    <script>
   $(document).ready(function () {
    var contactCounter = {{ count($obituary->contactDetails) }};
   
    // Handle click on the "Add Contact" button
    $("#addContact").click(function () {
        var newContactFields = `
            <div class="form-row">
                <div class="col-5">
                    <div class="form-group margin-contact">
                        <label class="form-label">Contact Person Name</label>
                        <input type="text" class="form-control" name="contact_details[${contactCounter}][contact_name]" value="">
                    </div>
                </div>
                <div class="col-5">
                    <div class="form-group margin-contact">
                        <label class="form-label">Contact Number</label>
                        <input type="text" class="form-control" name="contact_details[${contactCounter}][contact_number]" value="">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group" style="margin-top: 45px">
                        <button type="button" class="btn btn-block btn-danger btn-sm remove-contact">
                            <i class="fas fa-times"></i> 
                        </button>
                    </div>
                </div>
            </div>
        `;

        $("#additionalContacts").append(newContactFields);

        contactCounter++;
    });

    // Handle click on the "Remove Contact" button
    $("#additionalContacts").on("click", ".remove-contact", function () {
        $(this).closest(".form-row").remove();
    });
});

</script>
@endsection