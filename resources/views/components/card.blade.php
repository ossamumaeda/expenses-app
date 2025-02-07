@props(['title' => '','color' => '#FFF'])
<div class="p-4 space-y-4 bg-white rounded-lg shadow">
    <div class="flex items-center space-x-4 text-sm justify-between">
        <div>
            <span class="p-1.5 text-xs font-medium uppercase tracking-wider rounded-lg bg-opacity-50"
                style="background-color: {{ $color }}">
                {{ $title }}
            </span>
        </div>
        @isset($header)
            {{ $header }}
        @endisset
    </div>
    {{$slot}}
</div>