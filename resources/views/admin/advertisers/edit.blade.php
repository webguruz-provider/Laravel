@extends('layouts.admin')
@section('content')
    <header class="admin-content__header u-bg-white">
      <div class="admin-content__header-mast u-flex-center">
        <h2 class="admin-content__header-title">Update an Advertiser</h2>
        <div class="admin-content__header-actions">
          <div class="admin-content__date-group"></div>
        </div>
      </div>
    </header>
    <div class="admin-content__body u-background-light">
      <div class="ques-info">
        <label for="text">Advertiser Information</label>
      </div>
      <div class="admin-content__form">
        <form method="POST" action="{{ route('partnerAdvertiserUpdate') }}">
          <div class="field field-err col-md-6">
            <label for="text">Company Name</label>
            <input type="text" value="{{ $advertiser->company_name }}" name="company_name" placeholder="Company Name" class="form-control">
            @if ($errors->has('company_name'))
		        		<span style="color: red;" class="validation_err">{{ $errors->first('company_name') }}</span>
		    		@endif
          </div>
          <div class="field field-err col-md-6">
            <label for="text">Contact Name</label>
            <input type="text" value="{{ $advertiser->contact_name }}" name="contact_name" placeholder="Contact Name" class="form-control">
            @if ($errors->has('contact_name'))
		        		<span style="color: red;" class="validation_err">{{ $errors->first('contact_name') }}</span>
		    		@endif
          </div>
          <div class="field field-err col-md-6">
            <label for="text">Contact Phone</label>
            <input type="text" value="{{ $advertiser->phone }}" name="phone" placeholder="Contact Phone" class="form-control">
            @if ($errors->has('phone'))
		        		<span style="color: red;" class="validation_err">{{ $errors->first('phone') }}</span>
		    		@endif
          </div>
          <div class="field field-err col-md-6">
            <label for="text">Contact Email</label>
            <input type="email" value="{{ $advertiser->email }}" name="email" placeholder="Contact Email" class="form-control">
            @if ($errors->has('email'))
		        		<span style="color: red;" class="validation_err">{{ $errors->first('email') }}</span>
		    		@endif
          </div>
          <input type="hidden" value="{{ $advertiser->id }}" name="advertiser_id">
          <div class="field field-err col-md-12">
            <label for="text">Confirmation of agreement to place ads</label>
           <input type="checkbox" name="agreement" value="1" checked="checked">
           @if ($errors->has('agreement'))
		        		<span style="color: red;" class="validation_err">{{ $errors->first('agreement') }}</span>
		    		@endif
          </div>
          <div class="field-group">
            <button type="submit" name="status" value="publish" class="btn btn-green">Update an advertiser</button>
          </div>
          <div class="field-group"></div>
        </form>
      </div>
    </div>
    @endsection