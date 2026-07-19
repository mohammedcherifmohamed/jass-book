@extends('layouts.app')
@section('title', 'جميع الكتب – jass.books للكتب الشرعية')
@section('meta_description', 'تصفح جميع الكتب الشرعية الإسلامية المتوفرة في متجر jass.books — توصيل لجميع ولايات الجزائر. كتب ابن القيم، ابن تيمية، الشافعي.')
@section('og_title', 'جميع الكتب – jass.books')
@section('og_description', 'تصفح جميع الكتب الشرعية الإسلامية المتوفرة في متجر jass.books.')

@section('content')

<div style="background:var(--parchment);padding:48px 0 24px;">
  <div style="max-width:1280px;margin:0 auto;padding:0 24px;">
    <!-- Breadcrumbs -->
    <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:var(--warm-gray);margin-bottom:32px;">
      <a href="{{ route('home') }}" style="color:var(--warm-gray);text-decoration:none;">الرئيسية</a>
      <span style="font-size:16px;">›</span>
      <span style="color:var(--ink);font-weight:600;">جميع الكتب</span>
    </div>

    <!-- Header Title -->
    <div style="text-align:center;margin-bottom:40px;">
      <span style="display:inline-block;color:var(--crimson);font-size:13px;font-weight:700;letter-spacing:2px;margin-bottom:12px;">المكتبة الكاملة</span>
      <h1 style="font-family:'Amiri',serif;font-size:clamp(26px,3vw,40px);color:var(--ink);font-weight:700;line-height:1.35;">تصفح واكتشف الكتب الشرعية</h1>
      <div style="width:60px;height:3px;background:linear-gradient(90deg,var(--gold),var(--crimson));margin:20px auto 0;border-radius:2px;"></div>
    </div>

    <!-- Filters Panel -->
    <div class="filter-card">
      <form method="GET" action="{{ route('products.index') }}" class="filter-form">
        <!-- Category Filter -->
        <div class="filter-group">
          <label for="category">التصنيف</label>
          <div class="select-wrapper">
            <span class="select-icon-prefix"><i class="fa-solid fa-tags"></i></span>
            <select name="category" id="category">
              <option value="">كل التصنيفات</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                  {{ $cat->name }} ({{ $cat->products_count }})
                </option>
              @endforeach
            </select>
            <span class="select-icon-arrow"><i class="fa-solid fa-chevron-down"></i></span>
          </div>
        </div>

        <!-- Title Filter -->
        <div class="filter-group">
          <label for="title">اسم الكتاب</label>
          <div class="input-wrapper">
            <span class="input-icon px-5"><i class="fa-solid fa-book-open"></i></span>
            <input  type="text" name="title" id="title" placeholder="بحث بعنوان الكتاب..." value="{{ request('title') }}">
          </div>
        </div>

        <!-- Author Filter -->
        <div class="filter-group">
          <label for="author">المؤلف</label>
          <div class="input-wrapper">
            <span class="input-icon"><i class="fa-solid fa-feather-alt"></i></span>
            <input type="text" name="author" id="author" placeholder="اسم الشيخ أو المؤلف..." value="{{ request('author') }}">
          </div>
        </div>

        <!-- Actions -->
        <div class="filter-actions">
          <button type="submit" class="btn-submit">تصفية</button>
          @if(request()->anyFilled(['category', 'title', 'author']))
            <a href="{{ route('products.index') }}" class="btn-reset">إلغاء التصفية</a>
          @endif
        </div>
      </form>
    </div>
  </div>
</div>

<div style="max-width:1280px;margin:0 auto;padding:48px 24px 80px;">
  <!-- Active Filter Badges -->
  @if(request()->anyFilled(['category', 'title', 'author']))
    <div style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:24px;align-items:center;">
      <span style="font-size:13px;color:var(--warm-gray);font-weight:600;">الفلاتر النشطة:</span>
      @if(request()->filled('category') && isset($categories))
        @php $activeCat = $categories->firstWhere('id', request('category')); @endphp
        @if($activeCat)
          <span class="filter-badge">التصنيف: {{ $activeCat->name }}</span>
        @endif
      @endif
      @if(request()->filled('title'))
        <span class="filter-badge">العنوان يحتوي: "{{ request('title') }}"</span>
      @endif
      @if(request()->filled('author'))
        <span class="filter-badge">المؤلف يحتوي: "{{ request('author') }}"</span>
      @endif
      <a href="{{ route('products.index') }}" style="font-size:12px;color:var(--crimson);font-weight:700;text-decoration:none;margin-right:8px;border-bottom:1px dashed var(--crimson);">مسح الكل</a>
    </div>
  @endif

  <!-- Products Grid -->
  <div class="product-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:28px;">
    @forelse($products as $product)
    <div class="book-card {{ !$product->available ? 'product-unavailable' : '' }}" style="background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(36,27,12,.08);cursor:pointer;transition:transform .3s ease,box-shadow .3s ease;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 32px rgba(36,27,12,.18)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 12px rgba(36,27,12,.08)'" onclick="window.location.href='{{ route('products.show', $product->id) }}'">
      <div style="position:relative;aspect-ratio:3/4;overflow:hidden;background:linear-gradient(135deg,var(--deep),var(--crimson));">
        @if($product->image_path)
          <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->title }}" loading="lazy" width="3" height="4" style="width:100%;height:100%;object-fit:cover;">
        @endif
        @if(!$product->available)
          <span class="unavailable-badge">غير متاح</span>
        @endif
      </div>
      <div style="padding:16px;">
        <div style="font-size:11px;color:var(--crimson);font-weight:700;margin-bottom:6px;">{{ $product->category->name ?? '' }}</div>
        <div style="font-family:'Amiri',serif;font-size:16px;font-weight:700;color:var(--ink);line-height:1.4;margin-bottom:4px;">{{ $product->title }}</div>
        @if($product->author)
        <div style="font-size:12px;color:var(--warm-gray);margin-bottom:12px;">{{ $product->author }}</div>
        @endif
        <div style="display:flex;align-items:center;justify-content:space-between;">
          <div style="font-size:16px;font-weight:700;color:var(--crimson);">{{ number_format($product->price, 0) }} دج</div>
          @if($product->available)
          <button class="btn-add" style="background:var(--crimson);color:#fff;border:none;width:32px;height:32px;border-radius:50%;font-size:18px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .2s;" onmouseover="this.style.background='var(--gold)';this.style.color='var(--ink)';this.style.transform='rotate(90deg)'" onmouseout="this.style.background='var(--crimson)';this.style.color='#fff';this.style.transform='rotate(0)'" onclick="event.stopPropagation();addToCartBtn(this, {{ $product->id }}, '{{ addslashes($product->title) }}', {{ $product->price }}, '{{ $product->image_path }}')">+</button>
          @endif
        </div>
      </div>
    </div>
    @empty
    <div style="text-align:center;padding:80px 20px;color:var(--warm-gray);grid-column:1/-1;">
      <div style="font-size:48px;color:var(--gold);margin-bottom:16px;"><i class="fa-solid fa-book-open"></i></div>
      <div style="font-size:18px;font-weight:700;color:var(--ink);margin-bottom:8px;">لا توجد كتب مطابقة لخيارات البحث</div>
      <div style="font-size:14px;color:var(--warm-gray);margin-bottom:24px;">جرب تغيير خيارات التصفية أو البحث عن كلمات أخرى.</div>
      <a href="{{ route('products.index') }}" class="btn-reset" style="display:inline-flex;text-decoration:none;padding:10px 24px;background:var(--crimson);color:#fff;border-radius:8px;font-weight:700;box-shadow:0 4px 12px rgba(128,0,32,.2);">عرض جميع الكتب</a>
    </div>
    @endforelse
  </div>

  <!-- Custom Beautiful Pagination -->
  @if ($products->hasPages())
    <div class="custom-pagination">
      {{-- Previous Page Link --}}
      @if ($products->onFirstPage())
        <span class="disabled"><i class="fa-solid fa-chevron-right"></i></span>
      @else
        <a href="{{ $products->previousPageUrl() }}"><i class="fa-solid fa-chevron-right"></i></a>
      @endif

      {{-- Pagination Elements --}}
      @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
        @if ($page == $products->currentPage())
          <span class="active">{{ $page }}</span>
        @else
          <a href="{{ $url }}">{{ $page }}</a>
        @endif
      @endforeach

      {{-- Next Page Link --}}
      @if ($products->hasMorePages())
        <a href="{{ $products->nextPageUrl() }}"><i class="fa-solid fa-chevron-left"></i></a>
      @else
        <span class="disabled"><i class="fa-solid fa-chevron-left"></i></span>
      @endif
    </div>
  @endif
</div>

<style>
/* Filters Styling */
.filter-card {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 24px rgba(36,27,12,.08);
  padding: 24px;
  margin-top: 24px;
  border: 1px solid rgba(200,168,75,.18);
}
.filter-form {
  display: grid;
  grid-template-columns: repeat(3, 1fr) auto;
  gap: 20px;
  align-items: flex-end;
}
.filter-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.filter-group label {
  font-size: 13px;
  font-weight: 700;
  color: var(--crimson);
}
.select-wrapper, .input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}
.select-wrapper select, .input-wrapper input {
  width: 100%;
  padding: 12px 16px 12px 40px; /* Pad left for prefix icon, right for chevron in RTL */
  border-radius: 8px;
  border: 1.5px solid #e0d8cc;
  background: var(--cream);
  color: var(--ink);
  font-family: 'Cairo', sans-serif;
  font-size: 14px;
  outline: none;
  transition: all 0.2s ease;
  appearance: none;
}
.select-wrapper select {
  padding-left: 36px;
  padding-right: 40px;
}
.select-wrapper select:focus, .input-wrapper input:focus {
  border-color: var(--gold);
  background: #fff;
  box-shadow: 0 0 0 3px rgba(200,168,75,.15);
}
.select-icon-prefix, .input-icon {
  position: absolute;
  right: 14px;
  font-size: 14px;
  color: var(--warm-gray);
  pointer-events: none;
}
.select-icon-arrow {
  position: absolute;
  left: 14px;
  font-size: 12px;
  color: var(--warm-gray);
  pointer-events: none;
}
.filter-actions {
  display: flex;
  gap: 12px;
  height: 48px;
}
.filter-actions .btn-submit {
  background: var(--crimson);
  color: #fff;
  border: none;
  padding: 0 32px;
  border-radius: 8px;
  font-family: 'Cairo', sans-serif;
  font-size: 14px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s;
  box-shadow: 0 4px 12px rgba(128,0,32,.15);
  height: 100%;
}
.filter-actions .btn-submit:hover {
  background: var(--deep);
  transform: translateY(-1px);
  box-shadow: 0 6px 16px rgba(90,0,22,.25);
}
.filter-actions .btn-reset {
  background: var(--parchment);
  color: var(--ink);
  border: 1px solid rgba(36,27,12,.15);
  padding: 0 20px;
  border-radius: 8px;
  font-family: 'Cairo', sans-serif;
  font-size: 14px;
  font-weight: 600;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
  height: 100%;
}
.filter-actions .btn-reset:hover {
  background: #fff;
  border-color: var(--gold);
  color: var(--crimson);
}
.filter-badge {
  background: rgba(200,168,75,0.15);
  color: var(--ink);
  border: 1px solid rgba(200,168,75,0.3);
  padding: 4px 12px;
  border-radius: 30px;
  font-size: 12px;
  font-weight: 600;
}

/* Book Cards Styling */
.book-card:hover { transform: translateY(-6px); box-shadow: 0 12px 32px rgba(36,27,12,.18); }
.product-unavailable { opacity: .55; filter: grayscale(.7); pointer-events: none; }
.product-unavailable .btn-add { display: none; }
.unavailable-badge { position: absolute; top: 10px; right: 10px; background: #666; color: #fff; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; z-index: 2; }

/* Custom Pagination Styling */
.custom-pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 8px;
  margin-top: 48px;
}
.custom-pagination a, .custom-pagination span {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 40px;
  height: 40px;
  padding: 0 6px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 700;
  text-decoration: none;
  transition: all 0.2s ease;
}
.custom-pagination a {
  background: #fff;
  color: var(--ink);
  border: 1px solid rgba(36,27,12,.1);
  box-shadow: 0 2px 6px rgba(36,27,12,.04);
}
.custom-pagination a:hover {
  background: var(--gold-light);
  color: var(--deep);
  border-color: var(--gold);
}
.custom-pagination .active {
  background: var(--crimson);
  color: #fff;
  border: 1px solid var(--crimson);
  box-shadow: 0 4px 12px rgba(128,0,32,.2);
}
.custom-pagination .disabled {
  background: rgba(36,27,12,.03);
  color: var(--warm-gray);
  opacity: 0.5;
  border: 1px solid rgba(36,27,12,.05);
  pointer-events: none;
}

/* Responsive Grid and Filters */
@media (max-width: 991px) {
  .filter-form {
    grid-template-columns: 1fr 1fr;
  }
  .filter-actions {
    grid-column: 1 / -1;
    justify-content: flex-end;
  }
}
@media (max-width: 600px) {
  .product-grid { grid-template-columns: repeat(2,1fr) !important; gap: 12px !important; }
  .filter-form {
    grid-template-columns: 1fr;
  }
  .filter-actions {
    justify-content: stretch;
  }
  .filter-actions .btn-submit, .filter-actions .btn-reset {
    flex: 1;
  }
}
</style>

@endsection
