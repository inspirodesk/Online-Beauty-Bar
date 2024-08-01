@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <!-- Basic Inputs -->
      <div class="card">
        <div class="card-header">
          <h5>Create New Remembrance</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('rememberences.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
            <div class="form-group col-md-4">
              <label class="form-label">Full Name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
              @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
              @endif
            </div>
            <div class="form-group col-md-4">
              <label class="form-label">Date of Death</label>
              <input type="date" class="form-control @error('dateOfDeath') is-invalid @enderror" id="dateOfDeath" name="dateOfDeath" value="{{ old('dateOfDeath') }}">
              @if ($errors->has('dateOfDeath'))
                <span class="text-danger">{{ $errors->first('dateOfDeath') }}</span>
              @endif
            </div>
            <div class="form-group col-md-4">
              <label class="form-label">address</label>
              <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}">
              @if ($errors->has('address'))
                <span class="text-danger">{{ $errors->first('address') }}</span>
              @endif
            </div>
            <div class="form-group col-md-6">
                <label class="form-label">Upload Feature Image</label>
                <input type="file" name="upload" accept="image/*" onchange="previewImage(this, 'featureImagePreview')">
                <img id="featureImagePreview" src="#" alt="Feature Image Preview" style="max-width: 100%; max-height: 150px; display: none;">
              </div>
              <div class="form-group col-md-6">
                <label class="form-label">Upload Frame Image</label>
                <input type="file" name="frame_upload" accept="image/*" onchange="previewImage(this, 'frameImagePreview')" >
                <img id="frameImagePreview" src="#" alt="Frame Image Preview" style="max-width: 100%; max-height: 150px; display: none;">
              </div>

              {{-- <div class="form-group col-md-6">
                <label class="form-label">Commenter Name</label>
                  <input type="text" class="form-control @error('commenterName') is-invalid @enderror" id="commenterName" name="commenterName" value="{{ old('commenterName') }}">
                    @if ($errors->has('commenterName'))
                      <span class="text-danger">{{ $errors->first('commenterName') }}</span>
                    @endif
              </div>
              <div class="form-group col-md-6">
                <label class="form-label">Tribute</label>
                  <input type="text" class="form-control @error('tribute') is-invalid @enderror" id="tribute" name="tribute" value="{{ old('tribute') }}">
                    @if ($errors->has('tribute'))
                      <span class="text-danger">{{ $errors->first('tribute') }}</span>
                    @endif
              </div> --}}

              <div class="form-group col-md-4">
              <label class="form-label">Remembrance Day</label>
              <input type="date" class="form-control @error('rememberanceDay') is-invalid @enderror" id="rememberanceDay" name="rememberanceDay" value="{{ old('rememberanceDay') }}">
              @if ($errors->has('rememberanceDay'))
                <span class="text-danger">{{ $errors->first('rememberanceDay') }}</span>
              @endif
            </div>
            <div class="form-group col-md-4">
              <label class="form-label">Start Time</label>
              <input type="text" class="form-control @error('startTime') is-invalid @enderror" id="startTime" name="startTime" value="{{ old('startTime') }}">
              @if ($errors->has('startTime'))
                <span class="text-danger">{{ $errors->first('startTime') }}</span>
              @endif
            </div>
            <div class="form-group col-md-4">
              <label class="form-label">End Time</label>
              <input type="text" class="form-control @error('endTime') is-invalid @enderror" id="endTime" name="endTime" value="{{ old('endTime') }}">
              @if ($errors->has('endTime'))
                <span class="text-danger">{{ $errors->first('endTime') }}</span>
              @endif
            </div>
            
            <div class="form-group mb-0 col-md-12">
                  <label class="form-label" >Further Announcement</label>
                  <textarea class="form-control @error('furtherAnnouncement') is-invalid @enderror" id="classic-editor"  name="furtherAnnouncement">{{ old('furtherAnnouncement') }}</textarea>
                  @if ($errors->has('furtherAnnouncement'))
                      <span class="text-danger">{{ $errors->first('furtherAnnouncement') }}</span>
                  @endif
            </div>
            <div class="col-5">
              <div class="form-group margin-contact">
                  <label class="form-label">Contact Person Name</label>
                  <input type="text" class="form-control @error('contact_details.0.contact_name') is-invalid @enderror" id="contactName" name="contact_details[0][contact_name]" value="{{ old('contact_details.0.contact_name') }}">
                  @if ($errors->has('contact_details.0.contact_name'))
                  <span class="text-danger">{{ $errors->first('contact_details.0.contact_name') }}</span>
                  @endif
              </div>
            </div>
            <div class="col-5">
              <div class="form-group margin-contact">
                  <label class="form-label">Contact Number</label>
                  <input type="text" class="form-control @error('contact_details.0.contact_number') is-invalid @enderror" id="contactNumber" name="contact_details[0][contact_number]" value="{{ old('contact_details.0.contact_number') }}">
                  @if ($errors->has('contact_details.0.contact_number'))
                      <span class="text-danger">{{ $errors->first('contact_details.0.contact_number') }}</span>
                  @endif
              </div>
            </div>
            <div class="col-2">
              <div class="form-group" style="margin-top: 45px">
                      <button type="button" class="btn btn-primary btn-block btn-sm" id="addContact">Add</button>
              </div>
            </div>
            <div id="additionalContacts" class="col-sm-12 form-group"></div>
            <div class="form-group col-md-6">
                <label class="form-label">Notice Start Date</label>
                <input type="date" class="form-control @error('adStartDate') is-invalid @enderror" id="adStartDate" name="adStartDate" value="{{ old('adStartDate') }}">
                    @if ($errors->has('adStartDate'))
                      <span class="text-danger">{{ $errors->first('adStartDate') }}</span>
                    @endif
            </div>
            <div class="form-group col-md-6">
                <label class="form-label">Notice End Date</label>
                  <input type="date" class="form-control @error('adEndDate') is-invalid @enderror" id="adEndDate" name="adEndDate" value="{{ old('adEndDate') }}">
                    @if ($errors->has('adEndDate'))
                      <span class="text-danger">{{ $errors->first('adEndDate') }}</span>
                    @endif
            </div>
            </div>                    
            
            <div class="card-footer">
              <button class="btn btn-primary me-2">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script>
    $(document).ready(function () {
    var contactCounter = 1;

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
    $("#additionalContacts").on("click", ".remove-contact", function () {
        $(this).closest(".form-row").remove();
    });
});
</script>
<script>
    function previewImage(input, previewId) {
      var preview = document.getElementById(previewId);
      var file = input.files[0];
      var reader = new FileReader();

      reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
      };

      if (file) {
        reader.readAsDataURL(file);
      }
    }
</script>
@endsection
