@if ($title && $action && $icon)
    <div style="display: flex;
    justify-content: center;
    padding-top: 2rem;">
        <a style="color: #00aff0;
            border-color: #00aff0;
            font-size: 2.5rem;
            padding-right: 2rem;
            padding-left: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;" 
            class="btn"
            href="tel:{{ $action }}" >
            {!! $icon !!}
            <span style="padding-left: 1rem">{{ $title }}</span>
        </a>
    </div>
@endif