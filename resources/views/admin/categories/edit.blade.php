@extends('layouts.admin')
@section('content')
 <header class="admin-content__header u-bg-white">
        <div class="admin-content__header-mast u-flex-center">
            <h2 class="admin-content__header-title">
                {{$title}}
            </h2>
        </div>
       <!--  <div class="admin-content__header-nav">
           <div class="admin-content__header-nav">
            <a class="admin-nav__header-nav-link {{ Request::is('*partners/categories*') ? 'admin-nav__header-nav--active' : '' }}" href="{{ route('partnerCategoryIndex') }}">
                Live
            </a>
            <a class="admin-nav__header-nav-link {{ Request::is('*partners/categories/deactivate*') ? 'admin-nav__header-nav--active' : '' }}" href="{{ route('partnerCategoryDeactivate') }}">
                Deactivated
            </a>
            <a class="admin-nav__header-nav-link {{ Request::is('*partners/categories/draft*') ? 'admin-nav__header-nav--active' : '' }}" href="{{ route('partnerCategoryDraft') }}">
                Draft
            </a>
        </div>
        </div> -->
    </header>
	<div class="admin-content__body u-background-light">
        <div class="ques-info">
        <label for="text">Category Information</label>
        <p class="field-description">Create unique categories for the questions you publish.</p>
        </div>
		<div class="admin-content__form">
            <div class="row">
                <div class="col-md-6">
                    <form method="POST" enctype="multipart/form-data" action="/partners/categories/update/{{$debate_category->id}}">
                        <div class="field field-err">
                            <label for="text">CATEGORY NAME</label>
                            <p class="field-description">Create a unique name for your category</p>
                            <input type="text" name="cat_name" value="{{$debate_category->name}}" class="form-control">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            @if ($errors->has('cat_name'))
                                <span style="color: red;" class="validation_err">{{ $errors->first('cat_name') }}</span>
                            @endif
                        </div>
                        <div class="ranged cate-ranged">
                        <div class="field field__left">
                            <label for="text">ADD TAGS</label>
                            <p class="field-description">Help people find your category by adding tags</p>
                            <input disabled type="text" name="tags" class="form-control" v-model="form.tags" placeholder="Tag 1, Tag 2, Tag 3">
                            <span class="validation is-danger" v-if="form.errors.has('tags')" v-text="form.errors.get('tags')"></span>
                        </div>
                        <div class="field field__right">
                            <label for="text">CHOOSE A PARENT CATEGORY</label>
                            <p class="field-description">Unlike tags, categories can have hierarchy. This is optional.</p>
                            <select class="form-control" disabled>
                                <option value="">Pick one</option>
                            </select>
                        </div>
                        </div>
                        <div class="field upload-btn field-err">
                            <label for="text">Select Image</label>
                            <input type="file" name="avatar_url" id="avatar_url"/>
                            <input type="hidden" name="img_url" value="{{$debate_category->image_url}}">
                            <img id="img-preview" src="{{ asset('img-dist/category') . '/'.$debate_category->image_url}}" alt="" />
                            @if ($errors->has('avatar_url'))
                                    <span style="color: red;" class="validation_err">{{ $errors->first('avatar_url') }}</span>
                                @endif
                                <span style="color: red;" class="img-size-err"></span>
                            </div>
                        <div class="field-group">
                            <button class="btn btn-green" type="submit" name="status" value="live">Update Category</button>
                        </div>
                        
                        <div class="field-group">
                            <button class="btn btn-green" type="submit" name="status" value="draft">Save as Draft</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <p class="category-ads">
                        <a data-modal-id="attachAdsPopUp" href="#" class="js-open-modal white-button">
                            {{ ($debate_category) ? ($debate_category->pro_ads) ?  'Edit Ad' : 'Attach Ad' : 'Attach Ad'}}
                        </a>
                        @if(isset($debate_category) && isset($debate_category->pro_ads))
                            <a href="{{ route('romoveAdFromCategory', $debate_category->ads_id) }}" class="js-open-modal white-button">Remove Ad</a>
                        @endif
                    </p>
                    <div class="admin-content__stat stat-ad-banner cat-ban" style="background-color:#f5f5f5;"> 
                        <?php
                            if(!empty($debate_category) && !empty($debate_category->pro_ads)){ ?>
                                <img width="250" height="100" src="{{ ($debate_category) ? ($debate_category->pro_ads) ? asset('img-dist/ads/'.$debate_category->pro_ads->image_url) : asset('img/ad-banner.jpg') : asset('img/ad-banner.jpg')}}" />
                            <?php }else{ ?>
                                <h4>There is no ad attached.</h4>
                            <?php }
                        ?>
                    </div>
                </div>
            <div>
           
		</div>
	</div>

	<!-- Attached ads Popup -->
	<div class="modal-box" id="attachAdsPopUp" role="dialog">
  <header> <a href="#" class="js-modal-close close"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
    <h3>Attach Ad to this Category</h3>
  </header>

  <div class="modal-body">

    @if(count($ads))
      <p><small>Please select one of the Ads</small></p>
    @else
      <span class="no-ads"><span>There are no Ads in your account</span></span>
    @endif
    @if(count($ads))
      <form method="POST" action="{{ route('attachAdsToCategory') }}">
        <select name="attached_ads_id" id="add-change" style="width: 100%;">
          @foreach($ads as $ad)
            <?php
              $class =''; 
              if($debate_category->ads_id == $ad->id){
                $class = 'active';
              }
            ?>
            <option <?php if($debate_category->ads_id == $ad->id) { echo "selected"; }?> img-path="{{ $ad->image_url }}" value="{{$ad->id}}" class="{{ $class }}">{{$ad->name}} </option>
          @endforeach
        </select>
        <input type="hidden" name="category_id" value="{{ $debate_category->id }}">

        
          <div class="add-img-preview">
            <small>Ad preview</small>
            <img  src="#" width="500" height="200">
          </div>
          <div class="attach-submit"><input type="submit" value="Attach Ad" ></div>
      </form>
    @endif

  </div>


</div>
@endsection