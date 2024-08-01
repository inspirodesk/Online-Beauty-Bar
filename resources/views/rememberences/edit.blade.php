@extends('layouts.app')

@section('content')

<div class="row ">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                    <h5>Remembrance Edit</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('rememberences.update', $rememberence->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="name" class="col-form-label text-start">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $rememberence->name }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        
                       <div class="form-group col-md-4">
                            <label for="dateOfDeath" class="col-form-label text-start">Date of Death</label>
                            <input type="date" class="form-control @error('dateOfDeath') is-invalid @enderror" id="dateOfDeath" name="dateOfDeath" value="{{ $rememberence->dateOfDeath }}">
                            @if ($errors->has('dateOfDeath'))
                                <span class="text-danger">{{ $errors->first('dateOfDeath') }}</span>
                            @endif
                        </div>

                        <div class="form-group col-md-4">
                            <label for="address" class="col-form-label text-start">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ $rememberence->address }}">
                            @if ($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                        <label class="form-label">Upload Feature Image</label>
                        <input type="file" name="upload" accept="image/*" onchange="previewFeatureImage(this,'featureImagePreview')"><br>
                        <img id="featureImagePreview" src="{{ $rememberence->normal_image_url }}" alt="Feature Image" class="img-thumbnail" style="max-width: 250px">
                    </div>
                

                    <div class="form-group col-md-6">
                        <label class="form-label">Upload Frame Image</label>
                        <input type="file" name="frame_upload" accept="image/*" onchange="previewFeatureImage(this,'frameImagePreview')"><br>
                        <img id="frameImagePreview" src="{{ $rememberence->frame_image_url }}" alt="Frame Image" class="img-thumbnail" style="max-width: 250px">
                    </div>

                    {{-- <div class="form-row col-md-12">
                        <div class="form-group col-md-6">
                            <label for="commenterName" class="col-form-label text-start">Commenter Name</label>
                            <input type="text" class="form-control @error('commenterName') is-invalid @enderror" id="commenterName" name="commenterName" value="{{ $rememberence->commenterName }}">
                            @if ($errors->has('commenterName'))
                                <span class="text-danger">{{ $errors->first('commenterName') }}</span>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label for="tribute" class="col-form-label text-start">Tribute</label>
                            <input type="text" class="form-control @error('tribute') is-invalid @enderror" id="tribute" name="tribute" value="{{ $rememberence->tribute }}">
                            @if ($errors->has('tribute'))
                                <span class="text-danger">{{ $errors->first('tribute') }}</span>
                            @endif
                        </div>
                    </div>  --}}
                    
                    <div class="form-group col-md-4">
                            <label for="rememberanceDay" class="col-form-label text-start">Remembrance Day</label>
                            <input type="date" class="form-control @error('rememberanceDay') is-invalid @enderror" id="rememberanceDay" name="rememberanceDay" value="{{ $rememberence->rememberanceDay }}">
                            @if ($errors->has('rememberanceDay'))
                                <span class="text-danger">{{ $errors->first('rememberanceDay') }}</span>
                            @endif
                        </div>

                        
                       <div class="form-group col-md-4">
                            <label for="startTime" class="col-form-label text-start">Start Time</label>
                            <input type="text" class="form-control @error('startTime') is-invalid @enderror" id="startTime" name="startTime" value="{{ $rememberence->startTime }}">
                            @if ($errors->has('startTime'))
                                <span class="text-danger">{{ $errors->first('startTime') }}</span>
                            @endif
                        </div>

                        <div class="form-group col-md-4">
                            <label for="endTime" class="col-form-label text-start">End Time</label>
                            <input type="text" class="form-control @error('endTime') is-invalid @enderror" id="endTime" name="endTime" value="{{ $rememberence->endTime }}">
                            @if ($errors->has('endTime'))
                                <span class="text-danger">{{ $errors->first('endTime') }}</span>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label for="adStartDate" class="col-form-label text-start">Advertisement Start Date</label>
                            <input type="date" class="form-control @error('adStartDate') is-invalid @enderror" id="adStartDate" name="adStartDate" value="{{ $rememberence->adStartDate }}">
                            @if ($errors->has('adStartDate'))
                                <span class="text-danger">{{ $errors->first('adStartDate') }}</span>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label for="adEndDate" class="col-form-label text-start">Advertisement End Date</label>
                            <input type="date" class="form-control @error('adEndDate') is-invalid @enderror" id="adEndDate" name="adEndDate" value="{{ $rememberence->adEndDate }}">
                            @if ($errors->has('adEndDate'))
                                <span class="text-danger">{{ $errors->first('adEndDate') }}</span>
                            @endif
                        </div>


                    <div class="form-group row col-12">
                        <label for="furtherAnnouncement" class="col-12 col-form-label text-start">Further Announcement</label>
                        <div class="col-12">
                            <textarea name="furtherAnnouncement" class="form-control @error('furtherAnnouncement') is-invalid @enderror" id="classic-editor">{{ $rememberence->furtherAnnouncement }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn me-2 btn-sm btn-primary btn-block" id="addContact">Add</button>
                    </div>
                    <div id="additionalContacts" class="col-12  ">
                            @foreach ($rememberence->contactDetails as $index => $contact)
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
                                                <button type="button" class="btn btn-danger btn-block btn-sm remove-contact" >
                                                    <i class="fas fa-times"></i> Remove
                                                </button>
                                            </div>
                                       </div>
                                    </div>
                                @endforeach
                            </div>
                        
                    </div>
                   
                    <div class="form-row " style="margin-top:20px">
                            <button type="submit" style="margin-left:5px" class="btn btn-warning btn-block">Update Rememberence</button>
                     </div>               
                </form> 
            </div>
        </div>
    </div>    
</div>
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

    var contactCounter = {{ count($rememberence->contactDetails) }};
   
    // Handle click on the "Add Contact" button
    $("#addContact").click(function () {
        var newContactFields = `
            <div class="form-row ">
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
                    <div class="form-group" >
                        <button type="button" class="btn btn-block  btn-danger btn-sm remove-contact" style="margin-top: 45px">
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