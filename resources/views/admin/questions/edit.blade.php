@extends('layouts.admin')
@section('content')
	<div class="admin-content__body u-background-light">
		<div class="admin-content__table-header">
			<h2 class="admin-content__table-title">
				Edit a Question
			</h2>
		</div>
        <div class="ques-info">
        <label for="text">Question Information</label>
        <p class="field-description"></p>
        </div>
		<div class="admin-content__form">
			<form method="POST" action="/partners/questions/updatequestion">
				<div class="field field-err">
					<label for="text">QUESTION TEXT</label>
					<input type="text" name="text" class="form-control" value="{{$questions->text}}">
					<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
					<input type="hidden" name="question_id" value="{{ $questions->id }}">
					@if ($errors->has('text'))
                        <span style="color: red;" class="validation_err">{{ $errors->first('text') }}</span>
                    @endif
				</div>
				<div class="ranged">
				<div class="field field__left field-err">
					<label for="text">Choose a Category</label>
					<p class="field-description">Select all topics that apply.</p>
					<select name="category_id" class="form-control">
					@foreach($debate_category as $categories)
					<option @if($questions->category_id==$categories->id) selected @endif value="{{$categories->id}}">{{$categories->name}}</option>
					@endforeach
					</select>
					@if ($errors->has('category_id'))
                        <span style="color: red;" class="validation_err">{{ $errors->first('category_id') }}</span>
                    @endif
				</div>
				<div class="field field__right">
					<label for="text">CHOOSE A PROFILE</label>
					<p class="field-description">Select the profile you’d like this question to post to</p>
					<select class="form-control" disabled>
						<option value="">Pick one</option>
					</select>
				</div>
				</div>
				<div class="ranged">
					<div class="field field__left field-err">
						<label for="text">Publish Date</label>
						<p class="field-description">Select all topics that apply.</p>
						<input type="text" name="publish_at" value="{{$questions->publish_at}}" class="form-control" @if($questions->publish_at > date('Y-m-d H:i:s')) data-calendar-start @else disabled @endif required="required">
					</div>
					<div class="field field__right field-err">
						<label for="text">Expiration Date</label>
						<p class="field-description">Select all topics that apply.</p>
						<input type="text" name="expire_at" value="{{$questions->expire_at}}" class="form-control" data-calendar-end required="required">
						@if ($errors->has('expire_at'))
                            <span style="color: red;" class="validation_err">{{ $errors->first('expire_at') }}</span>
                        @endif
					</div>
				</div>
				<div class="field-group">
					<button class="btn btn-green" type="submit" name="status" value="publish">Update Question</button>
				</div>
				
				<div class="field-group">
					<button class="btn btn-green" type="submit" name="status" value="draft">Save as Draft</button>
				</div>
			</form>
		</div>        
	</div>
          
        </div>

@endsection