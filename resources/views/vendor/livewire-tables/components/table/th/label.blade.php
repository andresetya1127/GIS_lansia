@props(['columnTitle' => '', 'customLabelAttributes' => ['default' => true]])
<span {{ $customLabelAttributes->except(['default', 'default-colors', 'default-styling']) }} style="font-size: 12px;">
    {{ $columnTitle }}
</span>
