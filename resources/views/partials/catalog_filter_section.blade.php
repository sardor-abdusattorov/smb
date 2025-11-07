<div class="main-content">
  <div class="container">

    <div class="filter-section">
      <div class="product-categories">
        {{-- ВСЕ (категория целиком) --}}
        <a href="#"
           class="category-item {{ request()->routeIs('category.show') ? 'active' : '' }}">
          ВСЕ <span class="category-count">({{ $products->count() }})</span>
        </a>

        {{-- Подкатегории --}}
        @foreach($subcategories as $subcategory)
          @if ($subcategory->products->isEmpty())
            @continue
            
          @else
          <a href="{{ route('subcategory.show', [$subcategory->category->slug, $subcategory->slug]) }}"
             class="category-item {{ request()->is($subcategory->category->slug.'/'.$subcategory->slug) ? 'active' : '' }}">
            {{ $subcategory->name }}
            @if($subcategory->products->isNotEmpty())
              <span class="category-count">({{ $subcategory->products->count() }})</span>
            @endif
          </a>
          @endif
        @endforeach
      </div>

      <div class="filter-controls">
        <button class="filter-btn" onclick="toggleFilterModal()">
          ФИЛЬТРЫ

          <img src="/images/filter_icon.svg" alt="" class="filter-icon">

        </button>
      </div>
    </div>
  </div>
</div>

<div class="filter-modal" id="filterModal">
  <div class="filter-content">

    <div class="filter-header">
      <div class="filter-title">ФИЛЬТРЫ И СОРТИРОВКА</div>
      <button class="filter-close" onclick="toggleFilterModal()">
        <span>Закрыть</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
          <path
            d="M0.800344 9.72725L0.269531 9.19644L4.46953 4.99644L0.269531 0.796438L0.800344 0.265625L5.00034 4.46563L9.20034 0.265625L9.73116 0.796438L5.53116 4.99644L9.73116 9.19644L9.20034 9.72725L5.00034 5.52725L0.800344 9.72725Z"
            fill="#1C1B1F" />
        </svg>
      </button>
    </div>

    <div class="filter_item">
      <!-- Sort Group -->
      <div class="filter-group">
        <div class="filter-group-title">СОРТИРОВАТЬ</div>
        <div class="sort-options">
          <div class="sort-option" onclick="selectSort(this)">
            <div class="sort-radio"></div>
            <div class="sort-label">Цена по убыванию</div>
          </div>
          <div class="sort-option" onclick="selectSort(this)">
            <div class="sort-radio"></div>
            <div class="sort-label">Цена по возрастанию</div>
          </div>
          <div class="sort-option" onclick="selectSort(this)">
            <div class="sort-radio"></div>
            <div class="sort-label">По популярности</div>
          </div>
          <div class="sort-option" onclick="selectSort(this)">
            <div class="sort-radio"></div>
            <div class="sort-label">Новинки</div>
          </div>
        </div>
      </div>

      <!-- Color Group -->
      <div class="filter-group">
        <div class="filter-group-title">ЦВЕТА</div>
        <div class="color-grid">
          <div class="color_block" onclick="toggleColor(this)">
            <div class="color-option black"></div>
          </div>
          <div class="color_block" onclick="toggleColor(this)">
            <div class="color-option navy" onclick="toggleColor(this)"></div>
          </div>
          <div class="color_block" onclick="toggleColor(this)">
            <div class="color-option blue" onclick="toggleColor(this)"></div>
          </div>
          <div class="color_block" onclick="toggleColor(this)">
            <div class="color-option light-gray" onclick="toggleColor(this)"></div>
          </div>
          <div class="color_block" onclick="toggleColor(this)">
            <div class="color-option red" onclick="toggleColor(this)"></div>
          </div>
          <div class="color_block" onclick="toggleColor(this)">
            <div class="color-option green" onclick="toggleColor(this)"></div>
          </div>
          <div class="color_block" onclick="toggleColor(this)">
            <div class="color-option beige" onclick="toggleColor(this)"></div>
          </div>
        </div>
        <div class="color-grid">
          <div class="color_block" onclick="toggleColor(this)">
            <div class="color-option black"></div>
          </div>
          <div class="color_block" onclick="toggleColor(this)">
            <div class="color-option navy" onclick="toggleColor(this)"></div>
          </div>
          <div class="color_block" onclick="toggleColor(this)">
            <div class="color-option blue" onclick="toggleColor(this)"></div>
          </div>
          <div class="color_block" onclick="toggleColor(this)">
            <div class="color-option light-gray" onclick="toggleColor(this)"></div>
          </div>
          <div class="color_block" onclick="toggleColor(this)">
            <div class="color-option red" onclick="toggleColor(this)"></div>
          </div>
          <div class="color_block" onclick="toggleColor(this)">
            <div class="color-option green" onclick="toggleColor(this)"></div>
          </div>
          <div class="color_block" onclick="toggleColor(this)">
            <div class="color-option beige" onclick="toggleColor(this)"></div>
          </div>
        </div>
      </div>

      <!-- Material Group -->
      <div class="item d-flex justify-content-between">
        <div class="filter-group">
          <div class="filter-group-title">МАТЕРИАЛ</div>
          <div class="checkbox-options">
            <div class="checkbox-option" onclick="toggleCheckbox(this)">
              <div class="checkbox-input"></div>
              <div class="checkbox-label">Кожа</div>
            </div>
            <div class="checkbox-option" onclick="toggleCheckbox(this)">
              <div class="checkbox-input"></div>
              <div class="checkbox-label">Замша</div>
            </div>
            <div class="checkbox-option" onclick="toggleCheckbox(this)">
              <div class="checkbox-input"></div>
              <div class="checkbox-label">Ткань</div>
            </div>
            <div class="checkbox-option" onclick="toggleCheckbox(this)">
              <div class="checkbox-input"></div>
              <div class="checkbox-label">Ткань</div>
            </div>
          </div>
        </div>

        <!-- Model Group -->
        <div class="filter-group">
          <div class="filter-group-title">МОДЕЛЬ</div>
          <div class="checkbox-options">
            <div class="checkbox-option" onclick="toggleCheckbox(this)">
              <div class="checkbox-input"></div>
              <div class="checkbox-label">Классическая</div>
            </div>
            <div class="checkbox-option" onclick="toggleCheckbox(this)">
              <div class="checkbox-input"></div>
              <div class="checkbox-label">Спортивная</div>
            </div>
            <div class="checkbox-option" onclick="toggleCheckbox(this)">
              <div class="checkbox-input"></div>
              <div class="checkbox-label">Деловая</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Size Group -->
      <div class="filter-group">
        <div class="filter-group-title">РАЗМЕР</div>
        <div class="checkbox-options">
          <div class="checkbox-option" onclick="toggleCheckbox(this)">
            <div class="checkbox-input"></div>
            <div class="checkbox-label">40–42</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="filter-footer">
    <button class="filter-apply-btn" id="filterApplyBtn" disabled onclick="applyFilters()">
      ПОКАЗАТЬ
    </button>
  </div>
</div>

<div class="filter-overlay" id="filterOverlay" onclick="toggleFilterModal()"></div>
