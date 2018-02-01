<?php
/**
 * @var string $name
 * @var string $value
 * @var string $thumbnail
 * @var string $label
 */
$label = isset($label) ? $label : trans('Choose video');
$value = isset($value) ? $value : '';
$thumbnail = isset($thumbnail) ? $thumbnail : asset('/admin/images/no-image.png');
?>
<div class="select-media-box">
    <button type="button" class="btn blue show-add-media-popup">
        {{ $label }}
    </button>
    <div class="clearfix"></div>
    <a title="" class="show-add-media-popup" href="javascript:;">
    @if (!$value)
        <img src="{{ asset($value ?: $thumbnail) }}" alt="{{ $value }}" class="img-responsive">
    @else
        <video src="{{ asset($value ?: $thumbnail) }}" alt="{{ $value }}" class="img-responsive" controls="controls">浏览器不支持视频</video>
    @endif
    </a>
    @if (!$value)
    <a title="" class="show-add-media-popup" href="javascript:;">
        <video src="{{ asset($value ?: $thumbnail) }}" alt="{{ $value }}" class="img-responsive" controls="controls">浏览器不支持视频</video>
    </a>
    @endif
    <input type="hidden" name="{{ $name }}" value="{{ $value or '' }}" class="input-file">
    <a title="" class="remove-image" href="javascript:;">
        <span>&nbsp;</span>
    </a>
</div>
