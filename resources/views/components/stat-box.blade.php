<!-- Stat Box Component -->
@foreach($gridItems as $item)
<div class="card {{ $item['color_class'] }} stat-box">
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <p class="stat-label" style="{{ isset($item['label_color']) ? 'color: ' . $item['label_color'] . ';' : '' }}">{{ $item['label'] }}</p>
            <p class="stat-value" style="{{ isset($item['value_color']) ? 'color: ' . $item['value_color'] . ';' : '' }}">{{ $item['value'] }}</p>
            @if(isset($item['subtext']))
                <p style="font-size: 0.8rem; margin-top: 0.5rem; opacity: 0.7;">{{ $item['subtext'] }}</p>
            @endif
        </div>
        @if(isset($item['icon']))
        <div style="font-size: 2rem; opacity: 0.2;">
            <i class="fas fa-{{ $item['icon'] }}"></i>
        </div>
        @endif
    </div>
</div>
@endforeach
