<div class="dashboard-item">
    <div class="debate-preview u-background-white">
        <div class="debate-preview__header">
        	<div class="debate-haeder-top">
          		<h4 class="debate-preview__category">Featured Categories</h4>
          	</div>
			<div class="category-list">
				<ul>
				@foreach($categories as $category)
					<li>
						<a href="{{ url('debates/create') }}?cid={{$category->id}}#category_container">
							<img src="{{ asset('img-dist/category') }}/{{ $category->icon_url }}" alt="" height="100px">
							<p>{{ $category->name }}</p>
						</a>
					</li>
				@endforeach
				</ul>
			</div>     
        </div>
        <div class="show-more-category">
         	<a href="{{ route('publicDebateCreate') }}#category_container" class="show-more-text"><span>Show more categories</span><span class="show-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
    	</div>
    </div>
</div>